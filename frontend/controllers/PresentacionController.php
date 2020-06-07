<?php

namespace frontend\controllers;

use frontend\models\Expositor;
use backend\models\Usuario;
use frontend\models\Evento;
use Yii;
use frontend\models\Presentacion;
use frontend\models\PresentacionExpositor;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


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

    public function actionCantidadPresentacion()
    {
        return $this->render('cargarPresentacion');
    }
    public function actionHola($id, $idExpo, $idEvento)
    {
        $objExpo = Expositor::findOne($idExpo);
        $objEvento = Evento::findOne($idEvento);
        $objUsuario = Usuario::findOne($objExpo->idUsuario);
        return $this->render('mostrarPresentacion', [
            'model' => $this->findModel($id),
            'expo' => $objUsuario,
            'evento' => $objEvento
        ]);
    }
    public function actionCargarPresentacion()
    {
        $model = new Presentacion();
        $preExpo = new PresentacionExpositor();
        $expo = new Expositor();

        if ($model->load(Yii::$app->request->post()) && $expo->load(Yii::$app->request->post())) {
            if ($model->save() && $expo->save()) {
                $preExpo->idExpositor = $expo->idExpositor;
                $preExpo->idPresentacion = $model->idPresentacion;
                $preExpo->save();
                return $this->redirect(['hola', 'id' => $model->idPresentacion, 'idExpo' => $expo->idExpositor, 'idEvento' => $model->idEvento]);
            }
        }

        return $this->render('cargarPresentacion', [
            'model' => $model,
            'expo' => $expo
        ]);
    }
}
