<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\components\ProvinceValidator;
use common\components\LocationValidator;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $nombre;
    public $apellido;
    public $dni;
//    public $telefono;
    public $pais;
    public $provincia;
    public $localidad;
//    public $fecha_nacimiento;
    public $email;
    public $password;
    public $showpw;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            //Obligatorio
            [['nombre', 'apellido', 'email', 'pais', 'provincia', 'localidad', 'dni', 'password'], 'required'],

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
                    return ($('#signupform-pais').val() === 'Argentina');
                }"
            ],

            //Reglas Provincia
            ['provincia', 'match', 'pattern' => '/^[a-zA-Z ]/', 'message' => 'El campo contiene caracteres inválidos'],
            //validamos con la api de provincias argentinas solo si el pais es argentina
            ['provincia', 'common\components\ProvinceValidator', 'when' => function ($model) {
                return ($model->pais == 'Argentina');
                }, 'whenClient' => "function (attribute, value) {
                    return ($('#signupform-pais').val() === 'Argentina');
                }"
            ],

            //Reglas DNI
            ['dni', 'integer', 'min' => 10000000, 'max' => 100000000],

            //Reglas Email
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'La dirección de correo electrónico que ha ingresado ya está registrada.'],

            //Reglas password
            ['password', 'match', 'pattern' => '/\d/', 'message' => 'La contraseña debe tener al menos un número.'],
            ['password', 'match', 'pattern' => '/\w*[A-Z]/', 'message' => 'La contraseña debe tener al menos una mayúscula.'],
            ['password', 'string', 'min' => 6, 'max' => 50, 'message' => 'La contraseña ingresada no es válida.',
                'tooShort' => 'La contraseña debe tener como mínimo 8 caracteres.', //comentario para minlenght
                'tooLong' => 'La contraseña debe tener como máximo 20 caracteres.'], //comentario para maxlenght
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup() {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->nombre = $this->nombre;
        $user->apellido = $this->apellido;
        $user->dni = $this->dni;
//        $user->telefono = $this->telefono;
        $user->pais = $this->pais;
        $user->provincia = $this->provincia;
        $user->localidad = $this->localidad;
//        $user->fecha_nacimiento = $this->fecha_nacimiento;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        return $user->save() && $this->sendEmail($user);
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user) {
        return Yii::$app

                        ->mailer
                        ->compose(
                                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                                ['user' => $user]
                        )
                        ->setFrom([Yii::$app->params['supportEmail'] => 'No-reply @ ' . Yii::$app->name])
                        ->setTo($this->email)
                        ->setSubject('Registro de cuenta en ' . Yii::$app->name)
                        ->send();
    }

}

