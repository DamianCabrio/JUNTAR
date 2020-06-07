<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fecha".
 *
 * @property int $idFecha
 * @property int $idEvento
 * @property string $fecha
 *
 * @property Evento $idEvento0
 */
class Fecha extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fecha';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idEvento', 'fecha'], 'required'],
            [['idEvento'], 'integer'],
            [['fecha'], 'safe'],
            [['idEvento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::className(), 'targetAttribute' => ['idEvento' => 'idEvento']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idFecha' => 'Id Fecha',
            'idEvento' => 'Id Evento',
            'fecha' => 'Fecha',
        ];
    }

    /**
     * Gets query for [[IdEvento0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdEvento0()
    {
        return $this->hasOne(Evento::className(), ['idEvento' => 'idEvento']);
    }
}
