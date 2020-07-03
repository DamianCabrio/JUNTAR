<?php

namespace frontend\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
class RespuestaFile extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $file;

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
            [["respuesta"], 'required'],
            [['idpregunta', 'idinscripcion'], 'integer'],
            [['respuesta'], 'string', 'max' => 500],
            [['file'], "file", "extensions" => ["zip", "rar", "pdf"], 'skipOnEmpty' => false, 'maxSize' => 5000000, 'tooBig' => 'El limite de archivo son de 5 mb'],
            [['idpregunta'], 'exist', 'skipOnError' => true, 'targetClass' => Pregunta::className(), 'targetAttribute' => ['idpregunta' => 'id']],
            [['idinscripcion'], 'exist', 'skipOnError' => true, 'targetClass' => Inscripcion::className(), 'targetAttribute' => ['idinscripcion' => 'idInscripcion']],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->file->saveAs("../web/eventos/formularios/archivos/" . $this->file->baseName . '.' . $this->file->extension);
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
            'respuesta' => 'Respuesta',
        ];
    }

    /**
     * Gets query for [[Idinscripcion0]].
     *
     * @return ActiveQuery
     */
    public function getIdinscripcion0()
    {
        return $this->hasOne(Inscripcion::className(), ['idInscripcion' => 'idinscripcion']);
    }

    /**
     * Gets query for [[Idpregunta0]].
     *
     * @return ActiveQuery
     */
    public function getIdpregunta0()
    {
        return $this->hasOne(Pregunta::className(), ['id' => 'idpregunta']);
    }
}
