<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Inscripcion;

/**
 * InscripcionSearch represents the model behind the search form of `common\models\Inscripcion`.
 */
class InscripcionSearch extends Inscripcion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idInscripcion', 'idUsuario', 'idEvento', 'estado', 'acreditacion'], 'integer'],
            [['fecha_preinscripcion', 'fecha_inscripcion', 'certificado'], 'safe'],
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
        $query = Inscripcion::find();

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
            'idInscripcion' => $this->idInscripcion,
            'idUsuario' => $this->idUsuario,
            'idEvento' => $this->idEvento,
            'estado' => $this->estado,
            'fecha_preinscripcion' => $this->fecha_preinscripcion,
            'fecha_inscripcion' => $this->fecha_inscripcion,
            'acreditacion' => $this->acreditacion,
        ]);

        $query->andFilterWhere(['like', 'certificado', $this->certificado]);

        return $dataProvider;
    }
}
