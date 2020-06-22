<?php

namespace frontend\models;

use Yii;
use frontend\models\Evento;
use frontend\models\Expositor;

/**
 * This is the model class for table "usuario".
 *
 * @property int $idUsuario
 * @property string $nombre
 * @property string $apellido
 * @property int|null $dni
 * @property string|null $pais
 * @property string|null $provincia
 * @property string|null $localidad
 *
 * @property Evento[] $eventos
 * @property Expositor[] $expositors
 * @property Inscripcion[] $inscripcions
 * @property UsuarioRol[] $usuarioRols
 */
class Usuario extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            //Obligatorio
            [['nombre', 'apellido', 'pais', 'provincia', 'localidad', 'dni', 'password'], 'required'],

            //Reglas nombre
            ['nombre', 'match', 'pattern' => '/^[a-zA-Z ]+$/', 'message' => 'El campo contiene caracteres inválidos'],
            ['nombre', 'string', 'min' => 2, 'max' => 14,
                //comentario para minlenght
                'tooShort' => 'El nombre debe tener como mínimo 2 caracteres.',
                //comentario para maxLenght
                'tooLong' => 'El nombre puede tener como máximo 14 caracteres. Si considera que esto un error, por favor, contacte un administrador'],

            //Reglas apellido
            ['apellido', 'match', 'pattern' => '/^[a-zA-Z ]+$/', 'message' => 'El campo contiene caracteres inválidos'],
            ['apellido', 'string', 'min' => 2, 'max' => 14,
                //comentario para minlenght
                'tooShort' => 'El apellido debe tener como mínimo 2 caracteres.',
                //comentario para maxLenght
                'tooLong' => 'El apellido puede tener como máximo 14 caracteres. Si considera que esto un error, por favor, contacte un administrador'],

            //Reglas localidad
            ['localidad', 'match', 'pattern' => '/^[a-zA-Z ]/', 'message' => 'El campo contiene caracteres inválidos'],
            //validamos con la api de localidades argentinas solo si el pais es argentina
            ['localidad', 'common\components\LocationValidator', 'when' => function ($model) { 
                return ($model->pais == 'Argentina');
                }, 'whenClient' => "function (attribute, value) {
                    return $('#signupform-pais').val() == 'Argentina';
                }"
            ],

            //Reglas Provincia
            ['provincia', 'match', 'pattern' => '/^[a-zA-Z ]/', 'message' => 'El campo contiene caracteres inválidos'],
            //validamos con la api de provincias argentinas solo si el pais es argentina
            ['provincia', 'common\components\ProvinceValidator', 'when' => function ($model) {
                return ($model->pais == 'Argentina');
                }, 'whenClient' => "function (attribute, value) {
                    return $('#signupform-pais').val() == 'Argentina';
                }"
            ],

            //Reglas DNI
            ['dni', 'integer', 'min' => 10000000, 'max' => 100000000]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'idUsuario' => 'Id Usuario',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'dni' => 'Dni',
            'pais' => 'País',
            'provincia' => 'Provincia',
            'localidad' => 'Localidad',
        ];
    }

    /**
     * Gets query for [[Eventos]].
     *
     * @return \yii\db\ActiveQuery|EventoQuery
     */
    public function getEventos() {
        return $this->hasMany(Evento::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * Gets query for [[Expositors]].
     *
     * @return \yii\db\ActiveQuery|ExpositorQuery
     */
    public function getExpositors() {
        return $this->hasMany(Expositor::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * Gets query for [[Inscripcions]].
     *
     * @return \yii\db\ActiveQuery|InscripcionQuery
     */
    public function getInscripcions() {
        return $this->hasMany(Inscripcion::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * Gets query for [[UsuarioRols]].
     *
     * @return \yii\db\ActiveQuery|UsuarioRolQuery
     */
    public function getUsuarioRols() {
        return $this->hasMany(UsuarioRol::className(), ['user_id' => 'idUsuario']);
    }

    /**
     * {@inheritdoc}
     * @return UsuarioQuery the active query used by this AR class.
     */
    public static function find() {
        return new UsuarioQuery(get_called_class());
    }

}
