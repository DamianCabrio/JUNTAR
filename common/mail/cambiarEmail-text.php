<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/cuenta/cambiar-email/', 'token' => $user->getNewEmailToken()]);
?>

Correo Generado Automáticamente
Hola <?= $user->nombre . " " . $user->apellido ?>.
Hemos recibido una solicitud para cambiar tu dirección de correo en <?= Yii::$app->name ?>.
Si tu no pediste el cambio de email y crees que hubo un error, por favor, ignora este correo y contactanos lo antes posible.

Para cambiar tu email, clickea sobre "Cambiar dirección de correo"

<?= $resetLink ?> Cambiar dirección de correo
