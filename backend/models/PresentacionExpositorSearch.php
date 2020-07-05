<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PresentacionExpositor;

/**
 * PresentacionExpositorSearch represents the model behind the search form of `app\models\PresentacionExpositor`.
 */
class PresentacionExpositorSearch extends PresentacionExpositor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idExpositor', 'idPresentacion'], 'integer'],
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
        $query = PresentacionExpositor::find();

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
        $query->andFilterWhere([
            'idExpositor' => $this->idExpositor,
            'idPresentacion' => $this->idPresentacion,
        ]);

        return $dataProvider;
    }
}
