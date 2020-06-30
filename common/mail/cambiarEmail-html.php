<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/cuenta/cambiar-email/', 'token' => $user->getNewEmailToken()]);
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

<div class="password-reset" style="
            text-align: center;
            padding-top: 30px;
            padding-bottom: 30px;
            padding-right: 5px;
            padding-left:5px;
            border: 3px;
            background-color: #050714;
            color: #fff;
            border-color: #FE1355">

    <p><b> Hola <?= Html::encode($user->nombre." ". $user->apellido) ?>.<b><p>  <br>
    <p> Hemos recibido una solicitud para cambiar tu dirección de correo en <?= Html::encode(Yii::$app->name) ?>. </p>
    <p> Si tu no pediste el cambio de email y crees que hubo un error, por favor, ignora este correo y contactanos lo antes posible. </p>
    
    <p style="margin-bottom: 50px"> Para cambiar tu email, clickea sobre el botón "Cambiar dirección de correo" </p>

    <!-- Botón -->
    <p style="margin-top: 15px;"> <a href="<?= Html::encode($resetLink) ?>" style="border: 1px solid #ccc;
            margin-top: 20px;
            padding: 12px 12px;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 0.3rem;
            text-decoration: none;

            color: #fff;
            background-color: #FE1355;
            border-color: #FE1355;"> Cambiar dirección de correo </a> </p>

    <div style="margin-top: 15px;">
        <small><i>(Correo Generado Automáticamente)<i></small>
    </div>

</div>
