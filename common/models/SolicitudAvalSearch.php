<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SolicitudAvalSearch represents the model behind the search form of `common\models\SolicitudAval`.
 */
class SolicitudAvalSearch extends SolicitudAval
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idSolicitudAval', 'idEvento', 'avalado', 'validador'], 'integer'],
            [['fechaSolicitud', 'tokenSolicitud', 'fechaRevision'], 'safe'],
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
        $query = SolicitudAval::find();

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
            'idSolicitudAval' => $this->idSolicitudAval,
            'idEvento' => $this->idEvento,
            'fechaSolicitud' => $this->fechaSolicitud,
            'fechaRevision' => $this->fechaRevision,
            'avalado' => $this->avalado,
            'validador' => $this->validador,
        ]);

        $query->andFilterWhere(['like', 'tokenSolicitud', $this->tokenSolicitud]);

        return $dataProvider;
    }
}
