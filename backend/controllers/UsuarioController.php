<?php

namespace backend\controllers;

use Yii;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
//use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
        $behaviors['access'] = [
            //utilizamos el filtro AccessControl
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['login', 'error'],
                    'roles' => ['?'], // <----- guest 
                ],
                [
                    'allow' => true,
                    'actions' => ['logout', 'error'],
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

                        $post = Yii::$app->request->post();
                        //preguntamos si el usuario tiene los permisos para visitar el sitio
                        if (Yii::$app->user->can($route, ['post' => $post])) {
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
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
      // Se obtiene todos los roles que estan creados y es enviado a la vista de usuario.
      $roles = yii::$app->authManager->getRoles();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'roles' => $roles,
        ]);
    }

    /**
     * Assign rol to user.
     * Metodo para asignar un rol a un usuario a partir del ID
     */
    public function actionAssign($id, $rol)
    {
      $auth = Yii::$app->authManager;
      $authRol = yii::$app->authManager->getRole($rol);
      if ($auth->getAssignment($rol, $id)) {
        $auth->revoke($authRol, $id);
      } else {
        $auth->assign($authRol, $id);
      }
      return $this->redirect(['usuario/view', 'id' => $id]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuario();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idUsuario]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idUsuario]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuario model.
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
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
