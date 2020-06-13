<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<style>
    .link-button {
        border: 1px solid #ccc;
        padding: 6px 12px;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        cursor: pointer;
        background-image: none;
        border: 1px solid transparent;
        border-radius: 4px;
        text-decoration: none;

        color: #fff;
        background-color: #337ab7;
        border-color: #2e6da4;
    }

    .link-button:hover {
        color: #fff;
        background-color: #204d74;
        border-color: #122b40;
    }
</style>

<div class="password-reset">
    <p> Hola <?= Html::encode($user->nombre." ". $user->apellido) ?>.</p>
    <p> Hemos recibido una solicitud para reestablecer tu contraseña en la plataforma <?= Html::encode(Yii::$app->name) ?>. </p>
    <p> Si tu no pediste el cambio de contraseña y crees que fue un error, por favor, ignora este correo y contactanos lo antes posible. </p>
    
    <p> Para reestablecer tu contraseña, clickea sobre "Reestablecer contraseña" </p>

    <p> <a href="<?= Html::encode($resetLink) ?>" class="link-button"> Reestablecer contraseña </a> </p>
</div>