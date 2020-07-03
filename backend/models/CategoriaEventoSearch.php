<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CategoriaEvento;

/**
 * CategoriaEventoSearch represents the model behind the search form of `backend\models\CategoriaEvento`.
 */
class CategoriaEventoSearch extends CategoriaEvento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['idCategoriaEvento'], 'integer'],
            [['descripcionCategoria'], 'safe'],
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
        $query = CategoriaEvento::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
//        $query->andFilterWhere([
//            'idCategoriaEvento' => $this->idCategoriaEvento,
//        ]);

        $query->andFilterWhere(['like', 'descripcionCategoria', $this->descripcionCategoria]);

        return $dataProvider;
    }
}
