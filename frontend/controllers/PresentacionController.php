<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Presentacion;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\models\PresentacionExpositor;
use frontend\models\Evento;

/**
 * PresentacionController implements the CRUD actions for Presentacion model.
 */
class PresentacionController extends Controller
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
     * Finds the Presentacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Presentacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Presentacion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * Carga una nueva presentacion al evento 
     */
    public function actionCargarPresentacion($slug)
    {
        $model = new Presentacion();
        $preExpositor = new PresentacionExpositor(); 

        if ($model->load(Yii::$app->request->post()) && $preExpositor->load(Yii::$app->request->post())) {
            if ($model->save()) {
                //$preExpositor->idExpositor = $preExpositor->idExpositor ;  
                $preExpositor->idPresentacion = $model->idPresentacion;
                $preExpositor->save();
                return $this->redirect(['mostrar-presentacion', 'idPresentacion' => $model->idPresentacion, 'idEvento' => $model->idEvento]);
            }
        }

        $idUsuario = Yii::$app->user->identity->idUsuario;
        $evento = Evento::findOne(["nombreCortoEvento" => $slug]);

        if($evento == null){
            throw new NotFoundHttpException('El evento no fue encontrado.');
        }
        $item = Evento::find()     //buscar los eventos del usuario
        ->select(['nombreEvento'])
            ->indexBy('idEvento')
            ->where(['idUsuario' => $idUsuario, 'idEvento' => $evento->idEvento])
            ->column();

        return $this->render('cargarPresentacion', [
            'model' => $model,
            'item'=> $item,
            "evento" => $evento,
            'preExpositor' => $preExpositor
        ]);
    }



    public function actionMostrarPresentacion($idPresentacion,  $idEvento)
    {
       
        $objEvento = Evento::findOne($idEvento);
        $preExpositor = PresentacionExpositor::findOne($idPresentacion);
        
        return $this->render('mostrarPresentacion', [
            'model' => $this->findModel($idPresentacion),
            'preExpositor' =>  $preExpositor,
            'evento' => $objEvento
        ]);
    }



}   