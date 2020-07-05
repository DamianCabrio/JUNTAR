<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
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
        background-color: #FE1355;
        border-color: #FE1355;
    }

    .link-button:hover {
        color: #fff;
        background-color: #204d74;
        border-color: #122b40;
    }
</style>

<div class="verify-email" style="
            text-align: center;
            padding-top: 30px;
            padding-bottom: 30px;
            padding-right: 5px;
            padding-left:5px;
            border: 3px;
            background-color: #050714;
            color: #fff;
            border-color: #FE1355">

    <!-- <img src="images/juntar-logo/svg/juntar-logo-w.svg" alt="Logo Juntar" height="200px" width="300px"> -->
    <!-- <img src="<?php //Yii::$app->getAlias('@frontend/web/images/juntar-logo/png/juntar-icon-b.png') ?>" alt="Logo Juntar"> -->

    <p><b> Hola <?= Html::encode($user->nombre . " " . $user->apellido) ?>.<b>
    <p><br>

    <p> ¡Gracias por registrarte en la plataforma <?= Html::encode(Yii::$app->name) ?>!</p>
    <p style="margin-bottom: 50px"> Para finalizar el proceso de registro, clickea sobre el botón "Confirmar Email" </p>

    <p style="margin-top: 15px;"><a href="<?= Html::encode($verifyLink) ?>" style="border: 1px solid #ccc;
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
            border-color: #FE1355;"> Confirmar Email </a></p>

    <div style="margin-top: 15px;">
        <small><i>(Correo Generado Automáticamente)<i></small>
    </div>
</div>


</body>
</html>

