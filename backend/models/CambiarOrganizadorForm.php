<?php

namespace backend\models;

use yii;
use yii\base\Model;

//use common\models\User;
//use yii\base\InvalidArgumentException;
use backend\models\Evento;
use backend\models\Usuario;

/**
 * Password reset form
 */
class CambiarOrganizadorForm extends Model
{

    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //Reglas password
//            ['email', 'trim'],
            ['email', 'email'],
//            ['email', 'string', 'max' => 255],
//            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
        ];
    }

    public function cambiarOrganizadorEvento($idEvento)
    {
        $user = Usuario::findOne(['email' => $this->email]);

        $resultado = false;
        if ($user != null) {
            $evento = Evento::findOne(['idEvento' => $idEvento]);
            $evento->idUsuario = $user->idUsuario;
            $evento->save(false);
            $resultado = true;
        }
        return $resultado;
    }

}
