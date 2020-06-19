<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use kartik\mpdf\Pdf;

/**
 * CertificadoController.
 */
class CertificadoController extends Controller
{


    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Se muestran los botones para general la vista previa del documento PDF.
     *
     * @return mixed
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * A partir de los datos enviados por GET se recolecta la información necesario
     * para general el certificado y se general la vista previa del archivo pdf.
     * @return mixed
     */
    public function actionPreview()
    {

        //Datos del evento.
        $data = Yii::$app->request->get()[1];
        $eventQuery = (new \yii\db\Query())
                ->select(['nombreEvento', 'descripcionCategoria', 'lugar','fechaInicioEvento', 'fechaFinEvento'])
                ->from('evento')
                ->innerJoin('categoria_evento', 'categoria_evento.idCategoriaEvento = evento.idCategoriaEvento')
                ->where(['idEvento' => $data['id']]);
        $eventData = $eventQuery->all();
        //Datos del usuario de la sesion
        $userQuery= (new \yii\db\Query())
                ->select(['nombre', 'apellido', 'dni'])
                ->from('usuario')
                ->where(['idUsuario' => Yii::$app->user->identity->id]);
        $userData = $userQuery->all();
        //Regenera el modelo del pdf con los datos y el estilo deseado.
        $content = $this->renderPartial('model', [
          'event' => $eventData,
          'isOficial' => $data['type'],
          'timeCount' => base64_decode($data['count']),
          'certificateType' => base64_decode($data['typeC']),
          'user' => $userData,
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
                'SetHeader' => ['Certificado Digital - Juntar'],
                'SetFooter' => ['Facultad de Informática - UNIVERSIDAD NACIONAL DEL COMAHUE'],
                'SetTitle' => ['Certificado Juntar'],
                'SetAuthor' => ['Facultad de Informática - UNComa'],
             ]
        ]);
        return $pdf->render();
    }

}
?>
