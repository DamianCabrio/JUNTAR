<?php
namespace frontend\models;

use yii\base\InvalidArgumentException;
use yii\base\Model;
use common\models\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $showpw;

    /**
     * @var \common\models\User
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
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong password reset token.');
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
            ['password', 'required'],
            ['password', 'match', 'pattern' => '/\d/', 'message' => 'La contraseña debe tener al menos un número.'],
            ['password', 'match', 'pattern' => '/\w*[A-Z]/', 'message' => 'La contraseña debe tener al menos una mayúscula.'],
            ['password', 'string', 'min' => 8, 'max' => 50, 'message' => 'La contraseña ingresada no es válida.',
                'tooShort' => 'La contraseña debe tener como mínimo 8 caracteres.', //comentario para minlenght
                'tooLong' => 'La contraseña debe tener como máximo 20 caracteres.'], //comentario para maxlenght
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
