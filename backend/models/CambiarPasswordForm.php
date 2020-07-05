<?php

namespace backend\models;

use common\models\User;
use yii\base\Model;

/**
 * Password reset form
 */
class CambiarPasswordForm extends Model
{

    public $newPassword;
    public $repeatNewPassword;
//    public $showpw;

    /**
     * @var User
     */
    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //Reglas password
            ['newPassword', 'required', 'message' => 'Debe ingresar una contraseña'],
            ['repeatNewPassword', 'required', 'message' => 'Debe repetir la contraseña.'],
            ['repeatNewPassword', 'compare', 'compareAttribute' => 'newPassword', 'skipOnEmpty' => false, 'message' => "Las contraseñas no coinciden."],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'newPassword' => 'Nueva contraseña',
            'repeatNewPassword' => 'Repita nueva contraseña',
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function cambiarPassword($idUsuario)
    {
        if ($this->validate()) {
            $user = $this->getUser($idUsuario);
            $user->setPassword($this->newPassword);
            $respuesta = $user->save(false);
        } else {
            $respuesta = false;
        }
//        $user->removePasswordResetToken();

        return $respuesta;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    protected function getUser($idUsuario)
    {
        if ($this->_user === null) {
            $this->_user = User::findIdentity($idUsuario);
        }
        return $this->_user;
    }

}
