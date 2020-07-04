<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ImagenPerfilSearch represents the model behind the search form of `frontend\models\ImagenPerfil`.
 */
class ImagenPerfilSearch extends ImagenPerfil
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idUsuario'], 'integer'],
            [['rutaImagenPerfil'], 'safe'],
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
        $query = ImagenPerfil::find();

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
            'idUsuario' => $this->idUsuario,
        ]);

        $query->andFilterWhere(['like', 'rutaImagenPerfil', $this->rutaImagenPerfil]);

        return $dataProvider;
    }
}
