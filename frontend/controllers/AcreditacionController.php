<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Evento;
use frontend\models\Inscripcion;
use frontend\models\AcreditacionForm;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * EventoController implements the CRUD actions for Evento model.
 */
class AcreditacionController extends Controller
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

    public function acreditar($evento){
        $inscripcion = Inscripcion::find()->where(["idUsuario" => Yii::$app->user->identity->idUsuario, "idEvento" => $evento->idEvento])->one();
        if($inscripcion == null || $inscripcion->acreditacion == 1){
            Yii::$app->session->setFlash('error', '<h2> Error </h2>'
                . '<p> Usted no se puede acreditar. </p>');
            return false;
        }

        Yii::$app->session->setFlash('success', '<h2> Acreditado. </h2>'
            . '<p> Usted se acredito. </p>');
        $inscripcion->acreditacion = 1;
        $inscripcion->save();
        return true;
    }

    public function actionAcreditacion(){
        $model = new AcreditacionForm();

        $request = Yii::$app->request;
        $slug = $request->get("slug");
        $evento = Evento::find()->where(["nombreCortoEvento" => $slug])->one();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if(!is_object(json_decode($evento->codigoAcreditacion))) {
                if ($evento->codigoAcreditacion == $model->codigoAcreditacion) {
                    $this->acreditar($evento);
                    return $this->redirect(['eventos/ver-evento/' . $slug]);
                } else {
                    Yii::$app->session->setFlash('error', '<h2> El codigo ingresado es invalido </h2> '
                        . '<p> Por favor vuelva a intentar </p>');
                }
            }else{
                $respuestaEnBase = json_decode($evento->codigoAcreditacion)->respuesta;
                if($respuestaEnBase == $model->codigoAcreditacion){
                    $this->acreditar($evento);
                    return $this->redirect(['eventos/ver-evento/' . $slug]);
                }else {
                    Yii::$app->session->setFlash('error', '<h2> La respuesta ingresada es incorrecta </h2> '
                        . '<p> Por favor vuelva a intentar </p>');
                }
            }

            return $this->refresh();
        } else {
            if(!is_object(json_decode($evento->codigoAcreditacion))){
                $acrPreg = false;
            }else{
                $acrPreg = json_decode($evento->codigoAcreditacion);
            }
            return $this->render('acreditacion', [
                'model' => $model,
                'evento' => $evento,
                "acrPreg" => $acrPreg,
            ]);
        }
    }
}
