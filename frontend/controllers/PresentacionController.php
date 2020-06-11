<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Presentacion;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use frontend\models\PresentacionExpositor;
use backend\models\Usuario;
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
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Presentacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Presentacion::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Presentacion model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Presentacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Presentacion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idPresentacion]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Presentacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idPresentacion]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Presentacion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
    public function actionCargarPresentacion($idEvento)
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
        return $this->render('cargarPresentacion', [
            'model' => $model,
            'idEvento'=> $idEvento,
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