<?php
use yii\base\Model;
use yii\base\InvalidArgumentException;

use frontend\models\Evento;
use common\models\User;

  

$emails = [];
$emails =['marcos_benitez80@hotmail.com','marcos.benitez@est.fi.uncoma.edu.ar'];




 return Yii::$app->mailer
 
      ->compose(
        ['html' => 'confirmacionDeInscripcion-html'],
        ['evento' => $evento],
      )
      ->setFrom([Yii::$app->params['supportEmail'] => 'No-reply @ ' . Yii::$app->name])
      ->setTo($emails)
      ->setSubject('Inscripción el Evento: ' .  $evento->nombreEvento)
      ->send();
