<?php

namespace frontend\controllers;

use Yii;
use frontend\models\PresentacionExpositor;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PresentacionExpositorController implements the CRUD actions for PresentacionExpositor model.
 */
class PresentacionExpositorController extends Controller
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
     * Lists all PresentacionExpositor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PresentacionExpositor::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PresentacionExpositor model.
     * @param integer $idExpositor
     * @param integer $idPresentacion
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idExpositor, $idPresentacion)
    {
        return $this->render('view', [
            'model' => $this->findModel($idExpositor, $idPresentacion),
        ]);
    }

    /**
     * Creates a new PresentacionExpositor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PresentacionExpositor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idExpositor' => $model->idExpositor, 'idPresentacion' => $model->idPresentacion]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PresentacionExpositor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idExpositor
     * @param integer $idPresentacion
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idExpositor, $idPresentacion)
    {
        $model = $this->findModel($idExpositor, $idPresentacion);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idExpositor' => $model->idExpositor, 'idPresentacion' => $model->idPresentacion]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PresentacionExpositor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $idExpositor
     * @param integer $idPresentacion
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idExpositor, $idPresentacion)
    {
        $this->findModel($idExpositor, $idPresentacion)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PresentacionExpositor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $idExpositor
     * @param integer $idPresentacion
     * @return PresentacionExpositor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idExpositor, $idPresentacion)
    {
        if (($model = PresentacionExpositor::findOne(['idExpositor' => $idExpositor, 'idPresentacion' => $idPresentacion])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
