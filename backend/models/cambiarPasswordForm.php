<?php

namespace backend\models;

use yii;
use yii\base\Model;
use common\models\User;

/**
 * Password reset form
 */
class CambiarPasswordForm extends Model {

    public $newPassword;
    public $repeatNewPassword;
//    public $showpw;

    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            //Reglas password
            ['newPassword', 'required', 'message' => 'Debe ingresar una contraseña'],
//            ['newPassword', 'match', 'pattern' => '/\d/', 'message' => 'La contraseña debe tener al menos un número.'],
//            ['newPassword', 'match', 'pattern' => '/\w*[A-Z]/', 'message' => 'La contraseña debe tener al menos una mayúscula.'],
//            ['newPassword', 'string', 'min' => 6, 'max' => 20, 'message' => 'La contraseña ingresada no es válida.',
//                'tooShort' => 'La contraseña debe tener como mínimo 6 caracteres.', //comentario para minlenght
//                'tooLong' => 'La contraseña debe tener como máximo 20 caracteres.'], //comentario para maxlenght
            ['repeatNewPassword', 'required', 'message' => 'Debe repetir la contraseña.'],
            ['repeatNewPassword', 'compare', 'compareAttribute' => 'newPassword', 'skipOnEmpty' => false, 'message' => "Las contraseñas no coinciden."],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
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
    public function cambiarPassword($idUsuario) {
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
    protected function getUser($idUsuario) {
        if ($this->_user === null) {
            $this->_user = User::findIdentity($idUsuario);
        }
        return $this->_user;
    }

}
