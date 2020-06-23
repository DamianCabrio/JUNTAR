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
class RespuestaFile extends \yii\db\ActiveRecord
{

    public $respuesta;

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
            [['idpregunta', 'idinscripcion', "respuesta"], 'required'],
            [['idpregunta', 'idinscripcion'], 'integer'],
            [['respuesta'], "file",'skipOnEmpty' => true, "maxSize" => 2000000, "tooBig" => "El archivo puede pesar como maximo 2mb"],
            [['idpregunta'], 'exist', 'skipOnError' => true, 'targetClass' => Pregunta::className(), 'targetAttribute' => ['idpregunta' => 'id']],
            [['idinscripcion'], 'exist', 'skipOnError' => true, 'targetClass' => Inscripcion::className(), 'targetAttribute' => ['idinscripcion' => 'idInscripcion']],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->respuesta->saveAs('../web/eventos/formularios/archivos/' . $this->respuesta->baseName . '.' . $this->respuesta->extension);
            return true;
        } else {
            return false;
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
            'respuesta' => 'RespuestaFile',
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
