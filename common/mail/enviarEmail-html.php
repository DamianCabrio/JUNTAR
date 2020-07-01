<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */


$nombreEvento = $evento->nombreEvento;
$inicio = date('d-m-Y', strtotime($evento->fechaInicioEvento));
$fin = date('d-m-Y', strtotime($evento->fechaFinEvento));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>


    <div class="verify-email" style="text-align: center; padding-top: 30px; padding-bottom: 30px; padding-right: 5px; padding-left:5px;">
 
            <p> ¡Gracias por Inscribirse al evento <b><?= $evento->nombreEvento ?></b>!</p>
            <p> Te recordamos que la fecha de inicio es <?=  $inicio ?> y de finalización  <?= $fin ?></p>

           <div style="margin-top: 15px;">
                <small><i>(Correo Generado Automáticamente)<i></small>
           </div>
    </div>

    
</body>
</html>

