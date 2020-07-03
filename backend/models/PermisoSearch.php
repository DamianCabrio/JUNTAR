<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Permiso;

/**
 * PermisoSearch represents the model behind the search form of `backend\models\Permiso`.
 */
class PermisoSearch extends Permiso
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'safe'],
//            [['type', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Permiso::find()->where(['type' => 2]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        //busca nombre permiso
        if ($this->name != null && $this->name != '') {
            $query->andFilterWhere(['like', 'name', $this->name]);
        }
        
        //busca descripcion permiso
        if ($this->description != null && $this->description != '') {
            $query->andFilterWhere(['like', 'description', $this->description]);
        }

        return $dataProvider;
    }
}
