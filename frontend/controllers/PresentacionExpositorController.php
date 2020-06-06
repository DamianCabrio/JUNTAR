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
     * @param integer $idPresentacion
     * @param integer $idExpositor
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idPresentacion, $idExpositor)
    {
        return $this->render('view', [
            'model' => $this->findModel($idPresentacion, $idExpositor),
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
            return $this->redirect(['view', 'idPresentacion' => $model->idPresentacion, 'idExpositor' => $model->idExpositor]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PresentacionExpositor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idPresentacion
     * @param integer $idExpositor
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idPresentacion, $idExpositor)
    {
        $model = $this->findModel($idPresentacion, $idExpositor);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idPresentacion' => $model->idPresentacion, 'idExpositor' => $model->idExpositor]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PresentacionExpositor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $idPresentacion
     * @param integer $idExpositor
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idPresentacion, $idExpositor)
    {
        $this->findModel($idPresentacion, $idExpositor)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PresentacionExpositor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $idPresentacion
     * @param integer $idExpositor
     * @return PresentacionExpositor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idPresentacion, $idExpositor)
    {
        if (($model = PresentacionExpositor::findOne(['idPresentacion' => $idPresentacion, 'idExpositor' => $idExpositor])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
