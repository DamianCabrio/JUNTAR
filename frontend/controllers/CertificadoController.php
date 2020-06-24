<?php
namespace frontend\controllers;

use Yii;
use frontend\models\Inscripcion;
use frontend\models\Presentacion;
use frontend\models\PresentacionExpositor;
use frontend\models\CategoriaEvento;
use frontend\models\ModalidadEvento;
use frontend\models\Evento;
use frontend\models\Certificado;
use frontend\models\Usuario;
use frontend\components\validateEmail;
use yii\web\Controller;
use yii\web\response;
use yii\bootstrap4\ActiveForm;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;

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

        $certificate = $this->loadCertificateData($id, Yii::$app->user->identity->id );

        //Modelo y respuesta en el caso de que haya sido expositor de varias presentaciones
        $model = new \yii\base\DynamicModel([
            'idPresentacion',
        ]);
        $model->addRule(['idPresentacion'], 'required')
          ->addRule(['idPresentacion'], 'integer');

        $presentations = ArrayHelper::map($certificate->presentations, 'idPresentacion', 'tituloPresentacion');

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
          Yii::$app->response->format = Response::FORMAT_JSON;
          return ActiveForm::validate($model);
        }
        if (Yii::$app->request->post()) {
          if ($model->validate()) {
            $filePDF = $this->commonData($id, 'expositor', $certificate, $model['idPresentacion']);
            return $filePDF->render();
          }
        }

        $isAccredited = $certificate->verifyAccreditation();
        $isExhibitor = $certificate->verifyExhibitor(Yii::$app->user->identity->id);
        $isOrganizer = $certificate->verifyOrganizer(Yii::$app->user->identity->id);

        return $this->render('index', [
            'idEvent' => $id,
            'model' => $model,
            'attendanceCertificate' => $isAccredited,
            'exhibitorCertificate' => $isExhibitor,
            'organizerCertificate' => $isOrganizer,
            'presentations' => $presentations,
          ]);
    }

    private function loadCertificateData($event, $user)
    {

      $inscription = Inscripcion::find()
        ->where(['idEvento' => $event])
        ->andWhere(['idUsuario' => $user])
        ->all();

      $presentation = (new \yii\db\Query())
        ->select('*')
        ->from('presentacion')
        ->innerJoin('presentacion_expositor', 'presentacion_expositor.idPresentacion = presentacion.idPresentacion')
        ->where(['idEvento' => $event])
        ->all();

      $event = Evento::find()
        ->where(['idEvento' => $event])
        ->all();

      $certificate = New Certificado();
      $certificate->event = $event;
      $certificate->presentations = $presentation;
      $certificate->inscription = $inscription;

      return $certificate;
    }
    /**
     * Método que devuelve un objeto mpdf con los datos y estilo del certificado
     * para ser visualizado en el navegador
     *
     * @return object
     */
    private function commonData($id, $type, $certificate, $idPresentation = null)
    {
      $organizer = Usuario::findOne($certificate->event[0]->idUsuario);
      $userData = Usuario::findOne(Yii::$app->user->identity->id);
      $eventData = $certificate->event;

      $validateEmail= new validateEmail();
      $isOficial = $validateEmail->validate_by_domain($organizer->email);

      if ($idPresentation != null) {
        $presentationData = Presentacion::findOne($idPresentation);
      } else {
        $presentationData = $certificate->presentations;
      }

      $category = CategoriaEvento::findOne($certificate->event[0]->idCategoriaEvento);
      $modality = ModalidadEvento::findOne($certificate->event[0]->idModalidadEvento);
      //Regenera el modelo del pdf con los datos y el estilo deseado.
      $content = $this->renderPartial('model', [
        'event' => $eventData,
        'user' => $userData,
        'modality' => $modality,
        'category' => $category,
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
     * Método para visualizar un certificado de Asistencia
     *
     * @return mixed
     */
    public function actionPreviewAttendance($id)
    {
      $dataPdf = $this->loadCertificateData($id, Yii::$app->user->identity->id);
      if ($dataPdf->verifyAccreditation()) {
        $filePDF = $this->commonData($id, 'asistencia', $dataPdf);
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
      $dataPdf = $this->loadCertificateData($id, Yii::$app->user->identity->id);
      if ($dataPdf->verifyOrganizer(Yii::$app->user->identity->id)) {
        $filePDF = $this->commonData($id, 'organizador', $dataPdf);
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
