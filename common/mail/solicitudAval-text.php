<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $event common\models\Evento */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/evento/verificar-solicitud/', 'token' => $token ]);
$viewLink = Yii::$app->urlManager->createAbsoluteUrl(['/evento/ver-evento/', 'slug' => $event->nombreCortoEvento ,'token' => $token]);

?>

    Correo Generado Automáticamente
    El usuario <?= $organizer->apellido." ".$organizer->nombre ?> organizador del Evento <?= $event->nombreEvento?>
    solicita la aprobación para que sea un evento avalado por la Falculta de Informática - UNComa.

       Organizador:  <?= $organizer->apellido." ".$organizer->nombre ?>

       Dirección de Correo:  <?= $organizer->email ?>

       Fecha de Inicio:  <?= Yii::$app->formatter->asDateTime($event->fechaInicioEvento, "php:d-m-Y") ?>

       Fecha de Finalización:  <?= Yii::$app->formatter->asDateTime($event->fechaFinEvento, "php:d-m-Y") ?>

       Lugar:  <?= $event->lugar ?>

    <?= $confirmLink ?>
    <?= $viewLink ?>
