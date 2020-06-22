<?php
namespace frontend\controllers;

use Yii;
use frontend\models\Inscripcion;
use frontend\models\Presentacion;
use frontend\models\PresentacionExpositor;
use frontend\models\Evento;
use yii\web\Controller;
use yii\web\response;
use yii\bootstrap4\ActiveForm;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use frontend\components\validateEmail;
/**
 * CertificadoController.
 */
class CertificadoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors['access'] = [
            //utilizamos el filtro AccessControl
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        //                        $module = Yii::$app->controller->module->id;
                        $action = Yii::$app->controller->action->id;        //guardamos la accion (vista) que se intenta acceder
                        $controller = Yii::$app->controller->id;            //guardamos el controlador del cual se consulta
                        //                        $route = "$module/$controller/$action";
                        $route = "$controller/$action";                     //generamos la ruta que se busca acceder
                        //                        $post = Yii::$app->request->post();
                        //preguntamos si el usuario tiene los permisos para visitar el sitio
                        //                        if (Yii::$app->user->can($route, ['post' => $post])) {
                        if (Yii::$app->user->can($route)) {
                            //                            return $this->goHome();
                            return true;
                        }
                    }
                ],
            ],
        ];

        return $behaviors;
    }
    /**
     * Se muestran los botones para general la vista previa del documento PDF.
     *
     * @return mixed
     */
    public function actionIndex($id) {

        $isAccredited = false;
        $isExhibitor = false;
        $isOrganizer= false;

        $inscription = Inscripcion::find()
          ->where(['idEvento' => $id])
          ->andWhere(['idUsuario' => Yii::$app->user->identity->id])
          ->andWhere(['acreditacion' => 1])
          ->all();

        $presentation = (new \yii\db\Query())
          ->select(['*'])
          ->from('presentacion')
          ->innerJoin('presentacion_expositor', 'presentacion_expositor.idPresentacion = presentacion.idPresentacion')
          ->where(['idEvento' => $id])
          ->andWhere(['idExpositor' => Yii::$app->user->identity->id])
          ->all();
        $event = Evento::find()
          ->where(['idEvento' => $id])
          ->andWhere(['idUsuario' => Yii::$app->user->identity->id])
          ->all();
        //Verificación de estados

        if ($inscription) {
          $isAccredited = true;
        }
        if ($presentation) {
          $isExhibitor = true;
        }
        if ($event) {
          $isOrganizer = true;
        }

        //Modelo y respuesta en el caso de que haya sido expositor de varias presentaciones
        $model = new \yii\base\DynamicModel([
            'idPresentacion',
        ]);
        $model->addRule(['idPresentacion'], 'required')
          ->addRule(['idPresentacion'], 'integer');

        $presentations = ArrayHelper::map($presentation, 'idPresentacion', 'tituloPresentacion');

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
          Yii::$app->response->format = Response::FORMAT_JSON;
          return ActiveForm::validate($model);
        }
        if (Yii::$app->request->post()) {
          if ($model->validate()) {
            $filePDF = $this->commonData($id, 'expositor', $model['idPresentacion']);
            return $filePDF->render();
          }
        }
        return $this->render('index', [
            'idEvent' => $id,
            'model' => $model,
            'attendanceCertificate' => $isAccredited,
            'exhibitorCertificate' => $isExhibitor,
            'organizerCertificate' => $isOrganizer,
            'presentations' => $presentations,
          ]);
    }
    /**
     * Método que devuelve un objeto mpdf con los datos y estilo del certificado
     * para ser visualizado en el navegador
     *
     * @return object
     */
    private function commonData($id, $type, $idPresentation = null)
    {
      //Datos del evento.
      $eventQuery = (new \yii\db\Query())
              ->select(['email','nombreEvento', 'descripcionCategoria', 'lugar','fechaInicioEvento', 'imgLogo'])
              ->from('evento')
              ->innerJoin('categoria_evento', 'categoria_evento.idCategoriaEvento = evento.idCategoriaEvento')
              ->innerJoin('usuario', 'usuario.idUsuario = evento.idUsuario')
              ->where(['idEvento' => $id]);
      $eventData = $eventQuery->all();
      //Datos del usuario de la sesion
      $userQuery= (new \yii\db\Query())
              ->select(['nombre', 'apellido', 'dni'])
              ->from('usuario')
              ->where(['idUsuario' => Yii::$app->user->identity->id]);
      $userData = $userQuery->all();
      //Datos de las Presentaciones
      if ($idPresentation != null) {
        $presentationData = Presentacion::find()
          ->select(['tituloPresentacion','diaPresentacion','horaInicioPresentacion', 'horaFinPresentacion'])
          ->where(['idEvento' => $id])
          ->andWhere(['idPresentacion' => $idPresentation])
          ->all();
      } else {
        $presentationData = Presentacion::find()
          ->select(['diaPresentacion','horaInicioPresentacion', 'horaFinPresentacion'])
          ->where(['idEvento' => $id])
          ->all();
      }
      $validateEmail= new validateEmail();
      $isOficial = $validateEmail->validate_by_domain($eventData[0]['email']);
      //Regenera el modelo del pdf con los datos y el estilo deseado.
      $content = $this->renderPartial('model', [
        'event' => $eventData,
        'user' => $userData,
        'certificateType' => $type,
        'isOficial' => $isOficial,
        'presentations' => $presentationData,
      ]);

      $pdf = new Pdf([
          'mode' => Pdf::MODE_CORE,
          'format' => Pdf::FORMAT_A4,
          'orientation' => Pdf::ORIENT_LANDSCAPE,
          'destination' => Pdf::DEST_BROWSER,
          'content' => $content,
          'cssFile' => 'css/certificate.css',
          'cssInline' => '.kv-heading-1{font-size:18px}',
          'options' => ['title' => 'Certificado'],
          'methods' => [
              'SetHeader' => ['Certificado Digital <img src=images/juntar-logo/png/juntar-logo-k.png style=width:65px;>'],
              'SetFooter' => ['Facultad de Informática - UNComa'],
              'SetTitle' => ['Certificado Juntar'],
              'SetAuthor' => ['Facultad de Informática - UNComa'],
           ]
      ]);

      return $pdf;

    }
	  /**
     * Método para validar asistencia
     *
     * @return boolean
     */
    private function verifyAccreditation($event, $user)
    {
      $inscription = Inscripcion::find()
        ->where(['idEvento' => $event])
        ->andWhere(['idUsuario' => $user])
        ->andWhere(['acreditacion' => 1])
        ->all();

      if ($inscription) {
        return true;
      } else {
        return false;
      }
    }
    /**
     * Método para validar Organizador
     *
     * @return boolean
     */
    private function verifyOrganizer($event, $user)
    {
      $event = Evento::find()
        ->where(['idEvento' => $event])
        ->andWhere(['idUsuario' => $user])
        ->all();

      if ($event) {
        return true;
      } else {
        return false;
      }
    }
    /**
     * Método para visualizar un certificado de Asistencia
     *
     * @return mixed
     */
    public function actionPreviewAttendance($id)
    {
      if ($this->verifyAccreditation($id, Yii::$app->user->identity->id)) {
        $filePDF = $this->commonData($id, 'asistencia');
        return $filePDF->render();
      } else {
        return $this->render('/site/error', [
          'name' => 'Certificado',
          'message' => 'Se ha provocado un error en la solicitud del certificado.'
        ]);
      }

    }
    /**
     * Método para visualizar un certificado de Organizador
     *
     * @return mixed
     */
    public function actionPreviewOrganizer($id)
    {
      if ($this->verifyOrganizer($id, Yii::$app->user->identity->id)) {
        $filePDF = $this->commonData($id, 'organizador');
        return $filePDF->render();
      } else {
        return $this->render('/site/error', [
          'name' => 'Certificado',
          'message' => 'Se ha provocado un error en la solicitud del certificado.'
        ]);
      }
    }

}
?>
