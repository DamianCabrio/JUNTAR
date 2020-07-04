<?php

namespace common\models;

use frontend\models\Evento;
use frontend\models\Usuario;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "solicitud_aval".
 *
 * @property int $idSolicitudAval
 * @property int $idEvento
 * @property string $fechaSolicitud
 * @property string $tokenSolicitud
 * @property string|null $fechaRevision
 * @property int|null $avalado
 * @property int|null $validador
 *
 * @property Evento $idEvento0
 * @property Usuario $validador0
 */
class SolicitudAval extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'solicitud_aval';
    }

    /**
     * {@inheritdoc}
     * @return SolicitudAvalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SolicitudAvalQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idEvento', 'fechaSolicitud'], 'required'],
            [['idEvento', 'avalado', 'validador'], 'integer'],
            [['fechaSolicitud', 'fechaRevision'], 'safe'],
            [['tokenSolicitud'], 'string', 'max' => 200],
            [['idEvento'], 'unique'],
            [['idEvento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::className(), 'targetAttribute' => ['idEvento' => 'idEvento']],
            [['validador'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['validador' => 'idUsuario']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idSolicitudAval' => 'Id Solicitud Aval',
            'idEvento' => 'Id Evento',
            'fechaSolicitud' => 'Fecha Solicitud',
            'tokenSolicitud' => 'Token Solicitud',
            'fechaRevision' => 'Fecha Revision',
            'avalado' => 'Avalado',
            'validador' => 'Validador',
        ];
    }

    public function denegar()
    {
        $this->avalado = 0;
        $this->fechaRevision = date("Y/m/d h:i:s");
        $this->validador = Yii::$app->user->identity->idUsuario;
        $this->quitarToken();
        $this->save(false);
    }

    public function aprobar()
    {
        $this->avalado = 1;
        $this->fechaRevision = date("Y/m/d h:i:s");
        $this->validador = Yii::$app->user->identity->idUsuario;
        $this->quitarToken();
        $this->save(false);
    }

    /**
     * Generar y actualizar token en el modelo Evento
     */
    public function generateRequestToken()
    {
        $this->tokenSolicitud = Yii::$app->security->generateRandomString() . '_' . time();
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
        $event = Evento::findOne(['idEvento' => $this->idEvento]);
        $organizer = User::findOne(['idUsuario' => $event->idUsuario]);


        return Yii::$app->mailer
            ->compose(
                ['html' => 'solicitudAval-html', 'text' => 'solicitudAval-text'],
                ['event' => $event, 'organizer' => $organizer, 'token' => $this->tokenSolicitud]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'No-reply @ ' . Yii::$app->name])
            ->setTo($usersEmails)
            ->setSubject('Aprobación del Evento: ' . $event->nombreEvento)
            ->send();
    }

    /**
     * Gets query for [[IdEvento0]].
     *
     * @return ActiveQuery|EventoQuery
     */
    public function getIdEvento0()
    {
        return $this->hasOne(Evento::className(), ['idEvento' => 'idEvento']);
    }

    /**
     * Gets query for [[Validador0]].
     *
     * @return ActiveQuery|UsuarioQuery
     */
    public function getValidador0()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'validador']);
    }

    private function quitarToken()
    {
        $this->tokenSolicitud = null;
    }

}
