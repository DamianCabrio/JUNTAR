<?php

namespace frontend\models;

use common\models\Usuario;
use Yii;

/**
 * This is the model class for table "inscripcion".
 *
 * @property int $idInscripcion
 * @property int $idUsuario
 * @property int $idEvento
 * @property int $estado
 * @property string $fechaPreInscripcion
 * @property string|null $fechaInscripcion
 * @property int|null $acreditacion
 * @property string|null $certificado
 *
 * @property Evento $idEvento0
 * @property Usuario $idUsuario0
 */
class Inscripcion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inscripcion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idUsuario', 'idEvento', 'estado', 'fechaPreInscripcion'], 'required'],
            [['idUsuario', 'idEvento', 'estado', 'acreditacion'], 'integer'],
            [['fechaPreInscripcion', 'fechaInscripcion'], 'safe'],
            [['certificado'], 'string', 'max' => 200],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idUsuario' => 'idUsuario']],
            [['idEvento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::className(), 'targetAttribute' => ['idEvento' => 'idEvento']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idInscripcion' => 'Id Inscripcion',
            'idUsuario' => 'Id Usuario',
            'idEvento' => 'Id Evento',
            'estado' => 'Estado',
            'fechaPreInscripcion' => 'Fecha Pre Inscripcion',
            'fechaInscripcion' => 'Fecha Inscripcion',
            'acreditacion' => 'Acreditacion',
            'certificado' => 'Certificado',
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
     * Gets query for [[IdUsuario0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idUsuario']);
    }
}
