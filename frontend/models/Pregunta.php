<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pregunta".
 *
 * @property int $id
 * @property int $idevento
 * @property string $tipo
 * @property string $descripcion
 *
 * @property Evento $idevento0
 * @property Respuesta[] $respuestas
 */
class Pregunta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pregunta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idevento', 'tipo', 'descripcion'], 'required'],
            [['idevento'], 'integer'],
            [['tipo'], 'string'],
            [['descripcion'], 'string', 'max' => 250],
            [['idevento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::className(), 'targetAttribute' => ['idevento' => 'idEvento']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idevento' => 'Idevento',
            'tipo' => 'Tipo',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * Gets query for [[Idevento0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdevento0()
    {
        return $this->hasOne(Evento::className(), ['idEvento' => 'idevento']);
    }

    /**
     * Gets query for [[Respuestas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRespuestas()
    {
        return $this->hasMany(Respuesta::className(), ['idpregunta' => 'id']);
    }
}
