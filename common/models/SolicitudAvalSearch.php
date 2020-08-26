<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SolicitudAvalSearch represents the model behind the search form of `common\models\SolicitudAval`.
 */
class SolicitudAvalSearch extends SolicitudAval
{

    public $nombreEvento;
    public $validador;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['idSolicitudAval', 'idEvento', 'avalado', 'validador'], 'integer'],
            [['fechaSolicitud', 'fechaRevision'], 'safe'],
            [['nombreEvento', 'validador'], 'safe'],
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
//    public function search($querySearchModel, $params) {
    public function search($estadoSolicitudes, $params)
    {
        switch ($estadoSolicitudes) {
            case "activas":
                //activas
                $querySearchModel = SolicitudAval::find()->where(['not', ['tokenSolicitud' => null]])->andWhere(['is', 'avalado', null]);
                break;
            case "denegadas":
//                $querySearchModel = $searchModel::find()->where(['is', 'tokenSolicitud', null])->andWhere(['avalado' => 0]);
                $querySearchModel = SolicitudAval::find()->where(['avalado' => 0]);
                break;
            case "aprobadas":
//                $querySearchModel = $searchModel::find()->where(['is', 'tokenSolicitud', null])->andWhere(['avalado' => 1]);
                $querySearchModel = SolicitudAval::find()->where(['avalado' => 1]);
                break;
            default:
                //activas
                $querySearchModel = SolicitudAval::find()->where(['not', ['tokenSolicitud' => null]])->andWhere(['is', 'avalado', null]);
                break;
        }
//        if()
//        $query = SolicitudAval::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $querySearchModel,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        //sorter
        $dataProvider->setSort([
            'attributes' => [
                'fechaSolicitud',
                'fechaRevision',
                'nombreEvento' => [
                    'asc' => ['evento.nombreEvento' => SORT_ASC],
                    'desc' => ['evento.nombreEvento' => SORT_DESC],
                ],
                'validador' => [
                    'asc' => ['usuario.nombre' => SORT_ASC],
                    'desc' => ['usuario.nombre' => SORT_DESC],
                ],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        //join a tablas
        if ($this->nombreEvento != null && $this->nombreEvento != '') {
            $querySearchModel->joinWith(['idEvento0']);
        }
        $querySearchModel->joinWith(['validador0']);

        //buscar parecido a nombre evento o nombre corto evento
        if ($this->nombreEvento != null && $this->nombreEvento != '') {
            $querySearchModel->andFilterWhere(['or',
                ['like', 'evento.nombreEvento', $this->nombreEvento],
                ['like', 'evento.nombreCortoEvento', $this->nombreEvento],
            ]);
        }

        //busca fecha solicitud aval
        if ($this->fechaSolicitud != null && $this->fechaSolicitud != '') {
            $querySearchModel->andFilterWhere([
                'DATE(fechaSolicitud)' => date("Y-m-d", strtotime($this->fechaSolicitud)),
            ]);
        }

        //busca fecha revision aval
        if ($this->fechaRevision != null && $this->fechaRevision != '') {
            $querySearchModel->andFilterWhere([
                'DATE(fechaRevision)' => date("Y-m-d", strtotime($this->fechaRevision)),
            ]);
        }

        //busca nombre organizador
        if ($this->validador != null && $this->validador != '') {
            $querySearchModel->andFilterWhere(['like', 'CONCAT(usuario.nombre," ",usuario.apellido)', $this->validador]);
        }

        return $dataProvider;
    }

}
