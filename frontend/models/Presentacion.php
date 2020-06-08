<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "presentacion".
 *
 * @property int $idPresentacion
 * @property int $idEvento
 * @property string $tituloPresentacion
 * @property string $descripcionPresentacion
 * @property string $horaInicioPresentacion
 * @property string $horaFinPresentacion
 *
 * @property Evento $idEvento0
 * @property PresentacionExpositor[] $presentacionExpositors
 */
class Presentacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'presentacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idEvento', 'tituloPresentacion', 'descripcionPresentacion', 'horaInicioPresentacion', 'horaFinPresentacion'], 'required'],
            [['idEvento'], 'integer'],
            [['horaInicioPresentacion', 'horaFinPresentacion'], 'safe'],
            [['tituloPresentacion'], 'string', 'max' => 100],
            [['descripcionPresentacion'], 'string', 'max' => 2000],
            [['idEvento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::className(), 'targetAttribute' => ['idEvento' => 'idEvento']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idPresentacion' => 'Id Presentacion',
            'idEvento' => 'Id Evento',
            'tituloPresentacion' => 'Titulo Presentacion',
            'descripcionPresentacion' => 'Descripcion Presentacion',
            'horaInicioPresentacion' => 'Hora Inicio Presentacion',
            'horaFinPresentacion' => 'Hora Fin Presentacion',
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

    /**
     * Gets query for [[PresentacionExpositors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPresentacionExpositors()
    {
        return $this->hasMany(PresentacionExpositor::className(), ['idPresentacion' => 'idPresentacion']);
    }
}
