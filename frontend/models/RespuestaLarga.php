<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "respuesta".
 *
 * @property int $id
 * @property int $idpregunta
 * @property int $idinscripcion
 * @property string $respuesta
 *
 * @property Inscripcion $idinscripcion0
 * @property Pregunta $idpregunta0
 */
class RespuestaLarga extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'respuesta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idpregunta', 'idinscripcion', "respuesta"], 'required', "message" => "Esta campo es obligatorio"],
            [['idpregunta', 'idinscripcion'], 'integer'],
            [['respuesta'], 'string', 'max' => 500 , "message" => "Esta campo no debe tener mas de 500 caracteres"],
            [['idpregunta'], 'exist', 'skipOnError' => true, 'targetClass' => Pregunta::className(), 'targetAttribute' => ['idpregunta' => 'id']],
            [['idinscripcion'], 'exist', 'skipOnError' => true, 'targetClass' => Inscripcion::className(), 'targetAttribute' => ['idinscripcion' => 'idInscripcion']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idpregunta' => 'Idpregunta',
            'idinscripcion' => 'Idinscripcion',
            'respuesta' => 'Respuesta',
        ];
    }

    /**
     * Gets query for [[Idinscripcion0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdinscripcion0()
    {
        return $this->hasOne(Inscripcion::className(), ['idInscripcion' => 'idinscripcion']);
    }

    /**
     * Gets query for [[Idpregunta0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdpregunta0()
    {
        return $this->hasOne(Pregunta::className(), ['id' => 'idpregunta']);
    }
}
