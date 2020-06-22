<?php

namespace frontend\controllers;

use Yii;
use frontend\models\PresentacionExpositor;
use yii\data\ActiveDataProvider;
use frontend\models\Presentacion;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Evento;
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
     * Lists all PresentacionExpositor models.
     * @return mixed
     */
    public function actionIndex($idPresentacion)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PresentacionExpositor::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionVerExpositores($idPresentacion)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PresentacionExpositor::find()->where(['idPresentacion' => $idPresentacion]),
        ]);
        $model = Presentacion::find()->where(['idPresentacion' => $idPresentacion])->one();
        $evento = Evento::find()->where(['idEvento' => $model->$idEvento])->one();
        
        return $this->render('verExpositores', [
            'dataProvider' => $dataProvider,
			'idPresentacion' => $idPresentacion,
            'model' => $model,
            'evento' => $evento,
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
        $objPresentacion = Presentacion::findOne($idPresentacion);
        $objEvento = Evento::findOne($objPresentacion->idEvento);

        return $this->redirect(['eventos/ver-evento/'. $objEvento->nombreCortoEvento]);
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
