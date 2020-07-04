<?php

namespace frontend\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pregunta".
 *
 * @property int $id
 * @property int $idevento
 * @property string $tipo
 * @property string $descripcion
 *
 * @property Evento $idevento0
 * @property RespuestaFile[] $respuestas
 */
class Pregunta extends ActiveRecord
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
            [['idevento', 'descripcion'], 'unique', 'targetAttribute' => ['idevento', 'descripcion']],
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
     * @return ActiveQuery
     */
    public function getIdevento0()
    {
        return $this->hasOne(Evento::className(), ['idEvento' => 'idevento']);
    }

    /**
     * Gets query for [[Respuestas]].
     *
     * @return ActiveQuery
     */
    public function getRespuestas()
    {
        return $this->hasMany(RespuestaFile::className(), ['idpregunta' => 'id']);
    }
}
