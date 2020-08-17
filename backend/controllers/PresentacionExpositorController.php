<?php

namespace backend\controllers;

use Yii;
use backend\models\PresentacionExpositor;
use backend\models\PresentacionExpositorSearch;
use backend\models\Usuario;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

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
    public function actionIndex()
    {
        $searchModel = new PresentacionExpositorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
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
    public function actionCreate($id)
    {
        $model = new PresentacionExpositor();

        $usersQuery = Usuario::find()->select(['idUsuario', 'email'])->all();
        $users = ArrayHelper::map($usersQuery, 'idUsuario', 'email');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/presentacion/view', 'id' => $model->idPresentacion]);
        }

        return $this->render('create', [
            'model' => $model,
            'idPresentation' => $id,
            'users' => $users,
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

        $usersQuery = Usuario::find()->select(['idUsuario', 'email'])->all();
        $users = ArrayHelper::map($usersQuery, 'idUsuario', 'email');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/presentacion/view', 'id' => $model->idPresentacion]);
        }

        return $this->render('update', [
            'model' => $model,
            'users' => $users,
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

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
