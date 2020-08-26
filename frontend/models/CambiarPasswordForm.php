<?php

namespace frontend\models;

use common\models\User;
use yii;
use yii\base\Model;

/**
 * Password reset form
 */
class CambiarPasswordForm extends Model
{

    public $actualPassword;
    public $newPassword;
    public $repeatNewPassword;
    public $showpw;

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
            ['newPassword', 'match', 'pattern' => '/\d/', 'message' => 'La contraseña debe tener al menos un número.'],
            ['newPassword', 'match', 'pattern' => '/\w*[A-Z]/', 'message' => 'La contraseña debe tener al menos una mayúscula.'],
            ['newPassword', 'string', 'min' => 6, 'max' => 20, 'message' => 'La contraseña ingresada no es válida.',
                'tooShort' => 'La contraseña debe tener como mínimo 6 caracteres.', //comentario para minlenght
                'tooLong' => 'La contraseña debe tener como máximo 20 caracteres.'], //comentario para maxlenght
            ['repeatNewPassword', 'required', 'message' => 'Debe repetir la contraseña.'],
            ['repeatNewPassword', 'compare', 'compareAttribute' => 'newPassword', 'skipOnEmpty' => false, 'message' => "Las contraseñas no coinciden."],
            ['actualPassword', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->actualPassword)) {
                $this->addError($attribute, 'Incorrect password.');
            }
        }
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function cambiarPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->newPassword);
//        $user->removePasswordResetToken();

        return $user->save(false);
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
//            $this->_user = User::findByUsername($this->username);
            $this->_user = User::findIdentity(Yii::$app->user->identity->idUsuario);
        }

        return $this->_user;
    }

}
