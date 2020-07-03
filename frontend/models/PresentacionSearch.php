<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PresentacionSearch represents the model behind the search form of `frontend\models\Presentacion`.
 */
class PresentacionSearch extends Presentacion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idPresentacion', 'idEvento'], 'integer'],
            [['tituloPresentacion', 'descripcionPresentacion', 'diaPresentacion', 'horaInicioPresentacion', 'horaFinPresentacion', 'linkARecursos'], 'safe'],
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
        $query = Presentacion::find();

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
            'idPresentacion' => $this->idPresentacion,
            'idEvento' => $this->idEvento,
            'diaPresentacion' => $this->diaPresentacion,
            'horaInicioPresentacion' => $this->horaInicioPresentacion,
            'horaFinPresentacion' => $this->horaFinPresentacion,
        ]);

        $query->andFilterWhere(['like', 'tituloPresentacion', $this->tituloPresentacion])
            ->andFilterWhere(['like', 'descripcionPresentacion', $this->descripcionPresentacion])
            ->andFilterWhere(['like', 'linkARecursos', $this->linkARecursos]);

        return $dataProvider;
    }
}
