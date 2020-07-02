<?php

namespace frontend\controllers;

use frontend\models\Evento;
use frontend\models\Pregunta;
use frontend\models\RespuestaSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PreguntaController implements the CRUD actions for Pregunta model.
 */
class PreguntaController extends Controller
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
                    'actions' => [
                        "ver-expositores",
                    ],
                    'roles' => ['?'], // <----- guest
                ],
                [
                    'allow' => true,
                    'actions' => [
                        "ver-expositores",
                        "delete"
                    ],
                    'roles' => ['@'], // <----- guest
                ],
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
     * Creates a new Pregunta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($slug)
    {
        $evento = Evento::findOne(["nombreCortoEvento" => $slug]);
        if($this->verificarDueño($evento->idEvento)) {
            $model = new Pregunta();

            $model->idevento = $evento->idEvento;
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->save();
                return $this->redirect(Yii::$app->request->referrer);
            }

            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('create', [
                    'model' => $model,
                    "esAjax" => true,
                ]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    "esAjax" => false,
                ]);
            }
        }else{
            return $this->goHome();
        }
    }

    /**
     * Updates an existing Pregunta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($slug,$id)
    {
        $evento = Evento::findOne(["nombreCortoEvento" => $slug]);
        if($this->verificarDueño($evento->idEvento)) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(Yii::$app->request->referrer);
            }

            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('update', [
                    'model' => $model,
                    "esAjax" => true,
                ]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    "esAjax" => false,
                ]);
            }
        }else{
            return $this->goHome();
        }
    }

    /**
     * Deletes an existing Pregunta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($slug,$id)
    {
        $evento = Evento::findOne(["nombreCortoEvento" => $slug]);
        if($this->verificarDueño($evento->idEvento)) {
            $pregunta = $this->findModel($id);
            $respuestasAPregunta = RespuestaSearch::find()->where(["idpregunta" => $id])->all();

            if(count($respuestasAPregunta) != 0){
                foreach ($respuestasAPregunta as $respuestaAPregunta){
                    if($pregunta->tipo == 3){
                        $ruta = str_replace("../../../", "../web/", $respuestaAPregunta->respuesta);
                        unlink($ruta);
                    }

                    $respuestaAPregunta->delete();
                }
            }

            $pregunta->delete();

            return $this->redirect(Yii::$app->request->referrer);
        }else{
            return $this->goHome();
        }
    }

    public function verificarDueño($id) {

            $evento = Evento::find()->where(["idEvento" => $id])->one();

            if (!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario == $evento->idUsuario0->idUsuario) {
                return true;
            } else {
                return false;
            }
        }

    /**
     * Finds the Pregunta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pregunta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pregunta::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
