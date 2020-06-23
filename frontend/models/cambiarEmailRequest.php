<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Password reset request form
 */
class CambiarEmailRequest extends Model {

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function solicitarCambioEmail() {
        /* @var $user User */
        $user = Yii::$app->user->identity;

        if (!$user) {
            return false;
        } else {
            $user->generateCambiarEmailToken();
        }

        return Yii::$app
                        ->mailer
                        ->compose(
                                ['html' => 'cambiarEmail-html', 'text' => 'cambiarEmail-text'],
                                ['user' => $user]
                        )
                        ->setFrom([Yii::$app->params['supportEmail'] => 'No-reply @ ' . Yii::$app->name])
                        ->setTo($user->email)
                        ->setSubject('Cambiar tu Email en ' . Yii::$app->name)
                        ->send();
    }

}
