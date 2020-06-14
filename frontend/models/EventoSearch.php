<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Evento;

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
            [['idEvento', 'idUsuario', 'idCategoriaEvento', 'idEstadoEvento', 'idModalidadEvento', 'capacidad', 'preInscripcion'], 'integer'],
            [['nombreEvento', 'nombreCortoEvento', 'descripcionEvento', 'lugar', 'fechaInicioEvento', 'fechaFinEvento', 'imgFlyer', 'imgLogo', 'fechaLimiteInscripcion', 'codigoAcreditacion', 'fechaCreacionEvento'], 'safe'],
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
            'idCategoriaEvento' => $this->idCategoriaEvento,
            'idEstadoEvento' => $this->idEstadoEvento,
            'idModalidadEvento' => $this->idModalidadEvento,
            'fechaInicioEvento' => $this->fechaInicioEvento,
            'fechaFinEvento' => $this->fechaFinEvento,
            'capacidad' => $this->capacidad,
            'preInscripcion' => $this->preInscripcion,
            'fechaLimiteInscripcion' => $this->fechaLimiteInscripcion,
            'fechaCreacionEvento' => $this->fechaCreacionEvento,
        ]);

        $query->andFilterWhere(['like', 'nombreEvento', $this->nombreEvento])
            ->andFilterWhere(['like', 'nombreCortoEvento', $this->nombreCortoEvento])
            ->andFilterWhere(['like', 'descripcionEvento', $this->descripcionEvento])
            ->andFilterWhere(['like', 'lugar', $this->lugar])
            ->andFilterWhere(['like', 'imgFlyer', $this->imgFlyer])
            ->andFilterWhere(['like', 'imgLogo', $this->imgLogo])
            ->andFilterWhere(['like', 'codigoAcreditacion', $this->codigoAcreditacion]);

        return $dataProvider;
    }
}
