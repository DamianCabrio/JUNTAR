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
class Respuesta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'respuesta';
    }

    public $respuesta = [];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idpregunta', 'idinscripcion'], 'required'],
            ["respuesta", "validateRespuesta"],
            [['idpregunta', 'idinscripcion'], 'integer'],
            [['respuesta'], 'string', 'max' => 500],
            [['idpregunta'], 'exist', 'skipOnError' => true, 'targetClass' => Pregunta::className(), 'targetAttribute' => ['idpregunta' => 'id']],
            [['idinscripcion'], 'exist', 'skipOnError' => true, 'targetClass' => Inscripcion::className(), 'targetAttribute' => ['idinscripcion' => 'idInscripcion']],
        ];
    }

    public function validateRespuesta($attribute){
        $respuestas = Yii::$app->request->post($this::formName());

        if(is_array($posts)){

        }
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
