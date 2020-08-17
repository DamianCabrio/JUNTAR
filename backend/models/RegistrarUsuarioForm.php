<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class RegistrarUsuarioForm extends Model
{

    public $nombre;
    public $apellido;
    public $pais;
//    public $dni;
//    public $telefono;
    public $email;
//    public $provincia;
//    public $localidad;
//    public $fecha_nacimiento;
    private $idUsuario;

//    public $password;
//    public $showpw;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //Obligatorio
            [['nombre', 'apellido', 'email', 'pais'], 'required'],
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
            //Reglas Email
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'La dirección de correo electrónico que ha ingresado ya está registrada.'],
            //Reglas password
//            ['password', 'match', 'pattern' => '/\d/', 'message' => 'La contraseña debe tener al menos un número.'],
//            ['password', 'match', 'pattern' => '/\w*[A-Z]/', 'message' => 'La contraseña debe tener al menos una mayúscula.'],
//            ['password', 'string', 'min' => 6, 'max' => 50, 'message' => 'La contraseña ingresada no es válida.',
//                'tooShort' => 'La contraseña debe tener como mínimo 8 caracteres.', //comentario para minlenght
//                'tooLong' => 'La contraseña debe tener como máximo 20 caracteres.'], //comentario para maxlenght
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function registrar()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->nombre = $this->nombre;
        $user->apellido = $this->apellido;
        $user->pais = $this->pais;
        $user->email = $this->email;
        $user->setPassword("Juntar1234");


        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $resultado = $user->save() && $this->sendEmail($user);
        if ($resultado) {
            $this->idUsuario = $user->getId();
            if ($this->idUsuario != null || is_numeric($this->idUsuario)) {
                //iniciamos authManager
                $auth = Yii::$app->authManager;
                //indicamos el rol que deseamos asignarle al usuario
                $usuarioRegistrado = $auth->createRole('Organizador');
                // Asignamos el rol al usuario registrado
                $auth->assign($usuarioRegistrado, ($this->idUsuario));
                //destruimos la referencha al authManager
                $auth = null;
            }
            $user->status = 10;
            $user->update();
        }
        return $resultado;
    }

    public function obtenerIdInsercion()
    {
        return $this->idUsuario;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerifyBackend-html', 'text' => 'emailVerifyBackend-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'No-reply @ ' . Yii::$app->name])
            ->setTo($this->email)
            ->setSubject('Te han registrado en ' . Yii::$app->name)
            ->send();
    }

}
