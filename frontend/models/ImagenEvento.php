<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "imagen_evento".
 *
 * @property int $idImagenEvento
 * @property int $idEvento
 * @property int $categoriaImagen
 * @property string $rutaArchivoImagen
 * @property string $fechaCreacionImagen
 *
 * @property Evento $idEvento0
 */
class ImagenEvento extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'imagen_evento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['idEvento', 'categoriaImagen', 'rutaArchivoImagen', 'fechaCreacionImagen'], 'required'],
            [['idEvento', 'categoriaImagen'], 'integer'],
            [['fechaCreacionImagen'], 'safe'],
            [['rutaArchivoImagen'], 'string', 'max' => 200],
            [['idEvento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::className(), 'targetAttribute' => ['idEvento' => 'idEvento']],
        ];
    }

    public function guardarImagen($path, $tipo, $idEvento){
        $this->idEvento = $idEvento;
        $this->categoriaImagen = $tipo;
        $this->fechaCreacionImagen = date("Y/m/d h:i:s");
        $this->rutaArchivoImagen = $path;
        return $this->save(false);
    }
    
    public function updateImagen($path){
        $this->fechaCreacionImagen = date("Y/m/d h:i:s");
        $this->rutaArchivoImagen = $path;
        return $this->save(false);
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'idImagenEvento' => 'Id Imagen Evento',
            'idEvento' => 'Id Evento',
            'categoriaImagen' => 'Funcionalidad Imagen',
            'rutaArchivoImagen' => 'Ruta Archivo Imagen',
            'fechaCreacionImagen' => 'Fecha Creacion Imagen',
        ];
    }

    /**
     * Gets query for [[IdEvento0]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getIdEvento0() {
        return $this->hasOne(Evento::className(), ['idEvento' => 'idEvento']);
    }

    /**
     * {@inheritdoc}
     * @return ImagenEventoQuery the active query used by this AR class.
     */
    public static function find() {
        return new ImagenEventoQuery(get_called_class());
    }

}
