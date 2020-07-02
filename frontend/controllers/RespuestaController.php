<?php

namespace frontend\controllers;

use frontend\models\Evento;
use frontend\models\Inscripcion;
use frontend\models\Pregunta;
use frontend\models\Respuesta;

use frontend\models\RespuestaCorta;
use frontend\models\RespuestaFile;
use frontend\models\RespuestaLarga;
use frontend\models\RespuestaSearch;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * RespuestaController implements the CRUD actions for Respuesta model.
 */
class RespuestaController extends Controller
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

    public function actionVer($slug, $id){

        $evento = Evento::findOne(["nombreCortoEvento" => $slug]);
        if($this->verificarDueño($evento->idEvento)) {
            $preguntas = Pregunta::find()->where(["idEvento" => $evento->idEvento])->all();

            if($preguntas != null){
                $respuestas = [];
                foreach ($preguntas as $pregunta){
                    $respuesta = RespuestaSearch::find()->where(["idpregunta" => $pregunta->id, "idinscripcion" => $id])->one();
                    if($respuesta == null){
                        array_push($respuestas, null);
                    }else{
                        array_push($respuestas, $respuesta);
                    }
                }
            }

            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('ver', [
                    'preguntas' => $preguntas,
                    "respuestas" => $respuestas,
                    "esAjax" => true,
                ]);
            } else {
                return $this->render('ver', [
                    'preguntas' => $preguntas,
                    "respuestas" => $respuestas,
                    "esAjax" => false,
                ]);
            }
        }else{
            return $this->goHome();
        }
    }

//    /**
//     * Creates a new Respuesta model.
//     * If creation is successful, the browser will be redirected to the 'view' page.
//     * @return mixed
//     */
//    public function actionCreate($id, $id2)
//    {
//        $inscripcionAEvento = Inscripcion::find()->where(["idInscripcion" => $id2])
//            ->andWhere(["<>", "estado", 1])
//            ->andWhere(["<>", "estado", 2])->one();
//
//        if(Yii::$app->user->identity->idUsuario == $inscripcionAEvento->idUsuario0->idUsuario){
//            if($inscripcionAEvento != null){
//                $pregunta = Pregunta::find()->where(["id" => $id])->one();
//                if ($pregunta == null) {
//                    throw new NotFoundHttpException('La página solicitada no existe.');
//                }
//
//                if ($pregunta->tipo == 1) {
//                    $model = new RespuestaCorta;
//                } elseif ($pregunta->tipo == 2) {
//                    $model = new RespuestaLarga();
//                } else {
//                    $model = new RespuestaFile;
//                }
//
//                $model->idpregunta = $id;
//                $model->idinscripcion = $id2;
//
//                if($pregunta->tipo == 3){
//                    if (Yii::$app->request->isPost) {
//                        $model->file = UploadedFile::getInstance($model, 'file');
//                        if ($model->upload()) {
//                            $model->respuesta = "../../../eventos/formularios/archivos/" . $model->file->baseName . '.' . $model->file->extension;
//                            $model->save(false);
//                            return $this->redirect(Yii::$app->request->referrer);
//                        }
//                    }
//                }else{
//                    if ($model->load(Yii::$app->request->post()) && $model->save()) {
//                        return $this->redirect(Yii::$app->request->referrer);
//                    }
//                }
//
//                if (Yii::$app->request->isAjax) {
//                    return $this->renderAjax('create', [
//                        'model' => $model,
//                        "pregunta" => $pregunta,
//                        "inscripcion" => $inscripcionAEvento,
//                        "volverAtras" => false,
//                    ]);
//                } else {
//                    return $this->render('create', [
//                        'model' => $model,
//                        "pregunta" => $pregunta,
//                        "inscripcion" => $inscripcionAEvento,
//                        "volverAtras" => true,
//                    ]);
//                }
//            }else{
//                throw new NotFoundHttpException('La página solicitada no existe.');
//            }
//        }else{
//            throw new NotFoundHttpException('La página solicitada no existe.');
//        }
//    }

    public function verificarDueño($id) {

        $evento = Evento::find()->where(["idEvento" => $id])->one();

        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario == $evento->idUsuario0->idUsuario) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Finds the Respuesta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RespuestaFile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RespuestaFile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
