<?php

namespace frontend\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
class Presentacion extends ActiveRecord
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
            [['diaPresentacion', 'horaInicioPresentacion', 'horaFinPresentacion'], 'safe'],
            [['tituloPresentacion'], 'string', 'max' => 200],
            [['descripcionPresentacion'], 'string', 'max' => 2000],
            [['linkARecursos'], 'string', 'max' => 300],
            [['idEvento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::className(), 'targetAttribute' => ['idEvento' => 'idEvento']],
            ['horaFinPresentacion', 'compare', 'compareAttribute' => 'horaInicioPresentacion', 'operator' => '>'],
            ['diaPresentacion', 'required'],
            [['tituloPresentacion'], 'unique', 'targetAttribute' => ['tituloPresentacion', 'idEvento'], 'message' => 'El nombre de la presentación ya fue registrado.'],

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
            'tituloPresentacion' => 'Título',
            'descripcionPresentacion' => 'Descripción',
            'diaPresentacion' => 'Día',
            'horaInicioPresentacion' => 'Hora inicio',
            'horaFinPresentacion' => 'Hora fin',
            'linkARecursos' => 'Link a recursos',
        ];
    }

    /**
     * Gets query for [[IdEvento0]].
     *
     * @return ActiveQuery
     */
    public function getIdEvento0()
    {
        return $this->hasOne(Evento::className(), ['idEvento' => 'idEvento']);
    }

    /**
     * Gets query for [[IdExpositors]].
     *
     * @return ActiveQuery
     */
    public function getIdExpositors()
    {
        return $this->hasMany(Usuario::className(), ['idUsuario' => 'idExpositor'])->viaTable('presentacion_expositor', ['idPresentacion' => 'idPresentacion']);
    }

    /**
     * Gets query for [[PresentacionExpositors]].
     *
     * @return ActiveQuery
     */
    public function getPresentacionExpositors()
    {
        return $this->hasMany(PresentacionExpositor::className(), ['idPresentacion' => 'idPresentacion']);
    }
}
