<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
Buenas <?= $user->nombre . " " . $user->apellido ?>, gracias por registrarte en la plataforma <?= Yii::$app->name; ?>

Para finalizar el proceso de registro, clickea sobre el siguiente enlace:

<?= $verifyLink ?>
