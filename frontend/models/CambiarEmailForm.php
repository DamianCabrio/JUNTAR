<?php

namespace frontend\models;

use common\models\User;
use yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;

/**
 * Password reset form
 */
class CambiarEmailForm extends Model
{

    public $email;
    public $repeatNewEmail;

    /**
     * @var User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }

        if (Yii::$app->user->identity->getNewEmailToken() == $token) {
            $this->_user = Yii::$app->user->identity;
        } else {
            throw new InvalidArgumentException('Wrong password reset token. Actual token: ' . Yii::$app->user->identity->getNewEmailToken() . ", Token received: " . $token);
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //Reglas password
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['repeatNewEmail', 'required', 'message' => 'Debe repetir la contraseña.'],
            ['repeatNewEmail', 'compare', 'compareAttribute' => 'email', 'skipOnEmpty' => false, 'message' => "Las contraseñas no coinciden."],
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function cambiarEmail()
    {
        if (!$this->validate()) {
            return null;
        } else {
            $user = $this->_user;
            $user->email = $this->email;
            $user->removeNewEmailToken();
        }
        return $user->save(false);
    }

}
