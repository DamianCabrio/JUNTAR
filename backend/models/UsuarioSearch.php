<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Usuario;

/**
 * UsuarioSearch represents the model behind the search form of `backend\models\Usuario`.
 */
class UsuarioSearch extends Usuario {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
//            [['idUsuario', 'dni', 'status', 'created_at', 'updated_at'], 'integer'],
            [['nombre', 'apellido', 'dni', 'pais', 'provincia', 'localidad', 'email', 'status'], 'safe'],
//            ['created_at', 'safe'],
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
        $query = Usuario::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

//        $this->load($params);
//
//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // grid filtering conditions
//        $query->andFilterWhere([
//            'idUsuario' => $this->idUsuario,
//            'dni' => $this->dni,
//            'status' => $this->status,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//        ]);
        //busca dni usuario
        if ($this->dni != null && $this->dni != '') {
            $query->andFilterWhere([
                'dni' => $this->dni,
            ]);
        }
        if ($this->status != null && $this->status != '') {
            switch (strtolower($this->status)) {
                case "activo":
                    $this->status = 10;
                    break;
                case "desactivado":
                    $this->status = 9;
                    break;
                case "deshabilitado":
                    $this->status = 0;
                    break;
                default:
                    break;
            }
            $query->andFilterWhere([
                'status' => $this->status,
            ]);
        }
        //busca fecha creacion
        if ($this->created_at != null && $this->created_at != '') {
//            $query->andFilterWhere(['like', 'created_at', strtotime(date("Y-m-d", strtotime($this->created_at)) ) ]);
//            $query->andFilterWhere(['like', 'FROM_UNIXTIME(UNIX_TIMESTAMP(), "%d-%-m-%Y");', strtotime(date("Y-m-d", strtotime($this->created_at)) ) ]);
//            $query->andFilterWhere(['like', 'FROM_UNIXTIME(UNIX_TIMESTAMP(), "%d-%-m-%Y");', strtotime($this->created_at)]);
            $query->andFilterWhere(['FROM_UNIXTIME(UNIX_TIMESTAMP(), "%d-%-m-%Y");' => strtotime($this->created_at)]);
        }
        //busca nombre usuario
        if ($this->nombre != null && $this->nombre != '') {
            $query->andFilterWhere(['like', 'concat(nombre," ",apellido)', $this->nombre]);
        }
        //busca por pais
        if ($this->pais != null && $this->pais != '') {
            $query->andFilterWhere(['like', 'pais', $this->pais]);
        }
        //busca por provincia
        if ($this->provincia != null && $this->provincia != '') {
            $query->andFilterWhere(['like', 'provincia', $this->provincia]);
        }
        //busca por localidad
        if ($this->localidad != null && $this->localidad != '') {
            $query->andFilterWhere(['like', 'localidad', $this->localidad]);
        }
        //busca por email
        if ($this->email != null && $this->email != '') {
            $query->andFilterWhere(['like', 'email', $this->email]);
        }


        return $dataProvider;
    }

}
