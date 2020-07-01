<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidArgumentException;
use frontend\models\SolicitudAvalEvento;
use frontend\models\Evento;
use common\models\User;
/**
 * Solicitud Aval
 */
class SolicitudAvalEvento extends Model {

  private $event;

  public function __construct($event){
    $this->event = $event;
    if ($event != null && $this->event->eventoToken == null) {
      $this->generateEventToken();
    }
  }
  /**
  * Buscar Evento por token
  */
  public static function findByEventToken($token)
  {
    $request = New SolicitudAvalEvento(Evento::findOne(['eventoToken' => $token]));
    return $request;
  }
  /**
  * Verificar token y validar Solicitud
  */
  public function verifyByToken($token)
  {
    if (empty($token) || !is_string($token)) {
      throw new InvalidArgumentException('El token es inválido.');
    }
    if ($this->event != null) {
      $this->event->eventoToken = null;
      $this->event->avalado = 1;
      $this->event->save();
      return true;
    }else {
      return false;
    }
  }
  /**
  * Generar y actualizar token en el modelo Evento
  */
  public function generateEventToken()
  {
    $this->event->eventoToken = Yii::$app->security->generateRandomString() . '_' . time();
    $this->event->avalado = Yii::$app->formatter->asTimestamp('now');
    if ($this->event->validate()) {
      $this->event->save();
    }
  }
  /**
  * Devuelve el nombre corto del Evento
  */
  public function getEventShortName()
  {
    return $this->event->nombreCortoEvento;
  }
  /**
  * Envió de correo con la solicitud a los usuarios con el rol Verificador.
  */
  public function sendEmail()
  {
    $idUsers = Yii::$app->authManager->getUserIdsByRole('Validador');
    $usersEmails = [];
    foreach ($idUsers as $key => $id) {
      $user = User::findOne(['idUsuario' => $id]);
      array_push($usersEmails, $user->email);
    }
    $organizer = User::findOne(['idUsuario' => $this->event->idUsuario]);

    return Yii::$app->mailer
      ->compose(
        ['html' => 'solicitudAval-html', 'text' => 'solicitudAval-text'],
        ['event' => $this->event, 'organizer' => $organizer],
      )
      ->setFrom([Yii::$app->params['supportEmail'] => 'No-reply @ ' . Yii::$app->name])
      ->setTo($usersEmails)
      ->setSubject('Aprobación del Evento: ' . $this->event->nombreEvento)
      ->send();
  }
}
?>
