<?php

namespace common\models;

use frontend\models\Evento;
use frontend\models\Usuario;
use Yii;

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
class SolicitudAval extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'solicitud_aval';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['idEvento', 'fechaSolicitud', 'tokenSolicitud'], 'required'],
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
    public function attributeLabels() {
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

    public function denegar() {
        $this->avalado = 0;
        $this->fechaRevision = date("Y/m/d h:i:s");
        $this->validador = Yii::$app->user->identity->idUsuario;
//        $this->quitarToken();
        $this->save(false);
    }

    public function aprobar() {
        $this->avalado = 1;
        $this->fechaRevision = date("Y/m/d h:i:s");
        $this->validador = Yii::$app->user->identity->idUsuario;
//        $this->quitarToken();
        $this->save(false);
    }

    private function quitarToken() {
        $this->tokenSolicitud = null;
    }

    /**
     * Gets query for [[IdEvento0]].
     *
     * @return \yii\db\ActiveQuery|EventoQuery
     */
    public function getIdEvento0() {
        return $this->hasOne(Evento::className(), ['idEvento' => 'idEvento']);
    }

    /**
     * Gets query for [[Validador0]].
     *
     * @return \yii\db\ActiveQuery|UsuarioQuery
     */
    public function getValidador0() {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'validador']);
    }

    /**
     * {@inheritdoc}
     * @return SolicitudAvalQuery the active query used by this AR class.
     */
    public static function find() {
        return new SolicitudAvalQuery(get_called_class());
    }

}
