
<?php

    $usersEmails = [];

    foreach ($listaInscriptos as $unInscripto) {
      array_push($usersEmails, $unInscripto['user_email']);
    }

    $organizer ="Pepe";
    $usersEmails = ['marcos_benitez80@hotmail.com'];

    return Yii::$app->mailer
      ->compose(
        ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
        ['event' => 'dd', 'organizer' => $organizer],
      )
      ->setFrom([Yii::$app->params['supportEmail'] => 'No-reply @ ' . Yii::$app->name])
      ->setTo($usersEmails)
      ->setSubject('Inscripción al evento: ' . "Flisol")
      ->send();