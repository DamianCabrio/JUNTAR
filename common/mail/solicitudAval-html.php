<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $event common\models\Evento */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/evento/verificar-solicitud/', 'token' => $token]);
$viewLink = Yii::$app->urlManager->createAbsoluteUrl(['/evento/ver-evento/', 'slug' => $event->nombreCortoEvento ,'token' => $token]);
?>

<div class="request">
    <small> Correo Generado Automáticamente </small>
    <p>El usuario <b><?= $organizer->apellido." ".$organizer->nombre ?></b> organizador del Evento <b><?= $event->nombreEvento?></b>
    solicita la aprobación para que sea un evento avalado por la Facultad de Informática - UNComa. </p>
    <div class="" style="width: 50%; background-color: #212529; border-radius: 15px; padding: 5px; padding-bottom: 60px;">
      <ul style="list-style: none;">
        <li style="background-color: #DDDDDD; border-radius: 6px; margin: 7px; padding: 5px;">
          <b>Organizador:</b> <?= $organizer->apellido." ".$organizer->nombre ?></li>
        <li style="background-color: #DDDDDD; border-radius: 6px; margin: 7px; padding: 5px;">
          <b>Dirección de Correo:</b> <?= $organizer->email ?></li>
        <li style="background-color: #DDDDDD; border-radius: 6px; margin: 7px; padding: 5px;">
          <b>Fecha de Inicio:</b> <?= Yii::$app->formatter->asDateTime($event->fechaInicioEvento, "php:d-m-Y") ?></li>
        <li style="background-color: #DDDDDD; border-radius: 6px; margin: 7px; padding: 5px;">
          <b>Fecha de Finalización:</b> <?= Yii::$app->formatter->asDateTime($event->fechaFinEvento, "php:d-m-Y") ?></li>
        <li style="background-color: #DDDDDD; border-radius: 6px; margin: 7px; padding: 5px;">
          <b>Lugar:</b> <?= $event->lugar ?></li>
        <li><p> <a href="<?= Html::encode($confirmLink) ?>"
            style="border: 1px solid #ccc;
                   padding: 6px 12px;
                   text-align: center;
                   cursor: pointer;
                   background-image: none;
                   border: 1px solid transparent;
                   border-radius: 4px;
                   text-decoration: none;
                   float: left;
                   margin: 5px;
                   color: #fff;
                   background-color: #FE1355;
                   border-color: #FE1355;"> Confirmar Solicitud </a></p>
            <p> <a href="<?= Html::encode($viewLink) ?>"
            style="border: 1px solid #ccc;
                   padding: 6px 12px;
                   text-align: center;
                   cursor: pointer;
                   background-image: none;
                   float: left;
                   margin: 5px;
                   border: 1px solid transparent;
                   border-radius: 4px;
                   text-decoration: none;
                   color: #fff;
                   background-color: #FE1355;
                   border-color: #FE1355;"> Ver el Evento </a> </p>
          </li>
      </ul>
    </div>
</div>
