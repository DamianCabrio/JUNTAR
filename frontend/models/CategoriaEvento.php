<?php

namespace frontend\models;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "categoria_evento".
 *
 * @property int $idCategoriaEvento
 * @property string $descripcionCategoria
 *
 * @property Evento[] $eventos
 */
class CategoriaEvento extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categoria_evento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcionCategoria'], 'required'],
            [['descripcionCategoria'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idCategoriaEvento' => 'Id Categoria Evento',
            'descripcionCategoria' => 'Descripcion Categoria',
        ];
    }

    /**
     * Gets query for [[Eventos]].
     *
     * @return ActiveQuery
     */
    public function getEventos()
    {
        return $this->hasMany(Evento::className(), ['idCategoriaEvento' => 'idCategoriaEvento']);
    }
}
