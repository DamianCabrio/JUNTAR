<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Evento;

/**
 * EventoSearch represents the model behind the search form of `common\models\Evento`.
 */
class EventoSearch extends Evento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idEvento', 'idUsuario', 'capacidad', 'preInscripcion'], 'integer'],
            [['nombreEvento', 'descripcionEvento', 'lugar', 'modalidad', 'linkPresentaciones', 'linkFlyer', 'linkLogo', 'fechaLimiteInscripcion', 'fechaDeCreacion', 'codigoAcreditacion'], 'safe'],
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
        $query = Evento::find();

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
            'idEvento' => $this->idEvento,
            'idUsuario' => $this->idUsuario,
            'capacidad' => $this->capacidad,
            'preInscripcion' => $this->preInscripcion,
            'fechaLimiteInscripcion' => $this->fechaLimiteInscripcion,
            'fechaDeCreacion' => $this->fechaDeCreacion,
        ]);

        $query->andFilterWhere(['like', 'nombreEvento', $this->nombreEvento])
            ->andFilterWhere(['like', 'descripcionEvento', $this->descripcionEvento])
            ->andFilterWhere(['like', 'lugar', $this->lugar])
            ->andFilterWhere(['like', 'modalidad', $this->modalidad])
            ->andFilterWhere(['like', 'linkPresentaciones', $this->linkPresentaciones])
            ->andFilterWhere(['like', 'linkFlyer', $this->linkFlyer])
            ->andFilterWhere(['like', 'linkLogo', $this->linkLogo])
            ->andFilterWhere(['like', 'codigoAcreditacion', $this->codigoAcreditacion]);

        return $dataProvider;
    }
}
