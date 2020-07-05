<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ImagenEvento;

/**
 * ImagenEventoSearch represents the model behind the search form of `frontend\models\ImagenEvento`.
 */
class ImagenEventoSearch extends ImagenEvento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idImagenEvento', 'idEvento', 'funcionalidadImagen'], 'integer'],
            [['rutaArchivoImagen', 'fechaCreacionImagen'], 'safe'],
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
        $query = ImagenEvento::find();

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
            'idImagenEvento' => $this->idImagenEvento,
            'idEvento' => $this->idEvento,
            'funcionalidadImagen' => $this->funcionalidadImagen,
            'fechaCreacionImagen' => $this->fechaCreacionImagen,
        ]);

        $query->andFilterWhere(['like', 'rutaArchivoImagen', $this->rutaArchivoImagen]);

        return $dataProvider;
    }
}
