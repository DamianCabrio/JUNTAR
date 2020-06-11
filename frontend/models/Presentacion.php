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
 * @property string $diaPresentacion
 * @property string $horaInicioPresentacion
 * @property string $horaFinPresentacion
 * @property string|null $linkARecursos
 *
 * @property Evento $idEvento0
 * @property Usuario[] $idExpositors
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
            [['idEvento', 'tituloPresentacion', 'descripcionPresentacion', 'diaPresentacion', 'horaInicioPresentacion', 'horaFinPresentacion'], 'required'],
            [['idEvento'], 'integer'],
            [['diaPresentacion', 'horaInicioPresentacion', 'horaFinPresentacion'], 'safe'],
            [['tituloPresentacion'], 'string', 'max' => 200],
            [['descripcionPresentacion'], 'string', 'max' => 800],
            [['linkARecursos'], 'string', 'max' => 300],
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
            'diaPresentacion' => 'Dia Presentacion',
            'horaInicioPresentacion' => 'Hora Inicio Presentacion',
            'horaFinPresentacion' => 'Hora Fin Presentacion',
            'linkARecursos' => 'Link A Recursos',
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
     * Gets query for [[IdExpositors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdExpositors()
    {
        return $this->hasMany(Usuario::className(), ['idUsuario' => 'idExpositor'])->viaTable('presentacion_expositor', ['idPresentacion' => 'idPresentacion']);
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
