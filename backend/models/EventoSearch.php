<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Evento;

/**
 * EventoSearch represents the model behind the search form of `backend\models\Evento`.
 */
class EventoSearch extends Evento {

    public $nombreUsuario;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
//            [['idEvento', 'idUsuario', 'idCategoriaEvento', 'idEstadoEvento', 'idModalidadEvento', 'capacidad', 'preInscripcion'], 'integer'],
            [['nombreEvento', 'lugar', 'fechaInicioEvento', 'fechaFinEvento', 'fechaCreacionEvento'], 'safe'],
            [['nombreUsuario'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Evento::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'nombreEvento',
                'nombreCortoEvento',
                'lugar',
                'fechaCreacionEvento',
                'fechaInicioEvento',
                'fechaFinEvento',
                'capacidad',
                'avalado',
                'preInscripcion',
                'nombreUsuario' => [
                    'asc' => ['usuario.nombre' => SORT_ASC],
                    'desc' => ['usuario.nombre' => SORT_DESC],
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        if ($this->nombreUsuario != null && $this->nombreUsuario != '') {
            $query->joinWith(['idUsuario0']);
        }

        $query->joinWith(['idAval0']);

        //busca capacidad evento
        if ($this->capacidad != null && $this->capacidad != '') {
            $query->andFilterWhere([
                'capacidad' => $this->capacidad,
            ]);
        }
        //busca fecha inicio evento
        if ($this->fechaInicioEvento != null && $this->fechaInicioEvento != '') {
            $query->andFilterWhere([
                'fechaInicioEvento' => date("Y-m-d", strtotime($this->fechaInicioEvento)),
            ]);
        }
        //busca fecha fin evento
        if ($this->fechaFinEvento != null && $this->fechaFinEvento != '') {
            $query->andFilterWhere([
                'fechaFinEvento' => date("Y-m-d", strtotime($this->fechaFinEvento)),
            ]);
        }
        //busca fecha creacion evento
        if ($this->fechaCreacionEvento != null && $this->fechaCreacionEvento != '') {
            $query->andFilterWhere([
                'fechaCreacionEvento' => date("Y-m-d", strtotime($this->fechaCreacionEvento)),
            ]);
        }
        //busca nombre evento
        if ($this->nombreEvento != null && $this->nombreEvento != '') {
            $query->andFilterWhere(['like', 'nombreEvento', $this->nombreEvento]);
        }
        //busca lugar evento
        if ($this->lugar != null && $this->lugar != '') {
            $query->andFilterWhere(['like', 'lugar', $this->lugar]);
        }
        //busca nombre organizador
        if ($this->nombreUsuario != null && $this->nombreUsuario != '') {
            $query->andFilterWhere(['like', 'CONCAT(usuario.nombre," ",usuario.apellido)', $this->nombreUsuario]);
        }

        return $dataProvider;
    }

}
