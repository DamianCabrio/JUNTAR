<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model {

    public $nombre;
    public $apellido;
    public $dni;
    public $telefono;
    public $localidad;
    public $fecha_nacimiento;
    public $email;
    public $password;
    public $showpw;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            //Obligatorio
            [['nombre', 'apellido', 'email', 'localidad', 'dni', 'password'], 'required'],
            
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
            ['localidad', 'match', 'pattern' => '/^[a-zA-Z ]+$/', 'message' => 'El campo contiene caracteres inválidos'],
            ['localidad', 'string', 'min' => 2, 'max' => 25,
                //comentario para minlenght
                'tooShort' => 'El apellido debe tener como mínimo 2 caracteres.',
                //comentario para maxLenght
                'tooLong' => 'El apellido puede tener como máximo 25 caracteres. Si considera que esto un error, por favor, contacte un administrador'],
            
            //Reglas DNI
            ['dni', 'integer', 'min' => 10000000, 'max' => 100000000],
            
            //Reglas Email
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            
            //Reglas password
            ['password', 'match', 'pattern' => '/\d/', 'message' => 'La contraseña debe tener al menos un número.'],
            ['password', 'match', 'pattern' => '/\w*[A-Z]/', 'message' => 'La contraseña debe tener al menos una mayúscula.'],
            ['password', 'string', 'min' => 8, 'max' => 50, 'message' => 'La contraseña ingresada no es válida.',
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
        $user->telefono = $this->telefono;
        $user->localidad = $this->localidad;
        $user->fecha_nacimiento = $this->fecha_nacimiento;
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
                        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                        ->setTo($this->email)
                        ->setSubject('Registro de cuenta en ' . Yii::$app->name)
                        ->send();
    }

}
