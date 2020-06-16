<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Evento;
use frontend\models\EventoSearch;
use frontend\models\Inscripcion;
use frontend\models\AcreditacionForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

    public function actionAcreditacion(){
        $model = new AcreditacionForm();

        $request = Yii::$app->request;
        $idEvento = $request->get('id');
        $slug = $request->get("slug");
        $evento = Evento::find()->where(["idEvento" => $idEvento])->one();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($evento->codigoAcreditacion == $model->codigoAcreditacion) {
                $inscripcion = Inscripcion::find()->where(["idUsuario" => Yii::$app->user->identity->idUsuario, "idEvento" => $idEvento])->one();
                $inscripcion->acreditacion = 1;
                $inscripcion->save();
                Yii::$app->session->setFlash('success', '<h2> Acreditado. </h2>'
                    . '<p> Usted se acredito. </p>');

                return $this->redirect(['eventos/ver-evento/' . $slug]);
            } else {
                Yii::$app->session->setFlash('error', '<h2> El codigo ingresado es invalido </h2> '
                    . '<p> Por favor vuelva a intentar </p>');
            }

            return $this->refresh();
        } else {
            return $this->render('acreditacion', [
                'model' => $model,
                'evento' => $evento,
            ]);
        }
    }
}
