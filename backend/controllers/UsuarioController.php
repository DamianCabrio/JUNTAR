<?php

namespace backend\controllers;

use backend\models\CambiarPasswordForm;
use backend\models\RegistrarUsuarioForm;
use backend\models\Usuario;
use backend\models\UsuarioSearch;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
        $behaviors['access'] = [
            //utilizamos el filtro AccessControl
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        //$module = Yii::$app->controller->module->id;
                        $action = Yii::$app->controller->action->id;        //guardamos la accion (vista) que se intenta acceder
                        $controller = Yii::$app->controller->id;            //guardamos el controlador del cual se consulta
                        // $route = "$module/$controller/$action";
                        $route = "$controller/$action";                     //generamos la ruta que se busca acceder
                        //$post = Yii::$app->request->post();
                        //preguntamos si el usuario tiene los permisos para visitar el sitio
                        //if (Yii::$app->user->can($route, ['post' => $post])) {
                        if (Yii::$app->user->can($route)) {
                            //return $this->goHome();
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
     * Signs user up.
     *
     * @return mixed
     */
    public function actionCrearUsuario()
    {
        //obtiene datos paises
        $model = new RegistrarUsuarioForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->registrar()) {
            Yii::$app->session->setFlash('success', '<h2> Usuario creado con éxito </h2>');
            return $this->redirect(['view', 'id' => $model->obtenerIdInsercion()]);
        }

        return $this->render('crearUsuario', [
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
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idUsuario]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionCambiarPassword($id)
    {
        $modelCambiarPw = new CambiarPasswordForm();
        if ($modelCambiarPw->load(Yii::$app->request->post()) && $modelCambiarPw->cambiarPassword($id)) {
            Yii::$app->session->setFlash('success', '<h2> Contraseña modificada con éxito </h2>');
            return $this->redirect(['update', 'id' => $id]);
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('cambiarPassword', [
                'modelCambiarPw' => $modelCambiarPw,
            ]);
        } else {
            return $this->render('cambiarPassword', [
                'modelCambiarPw' => $modelCambiarPw,
            ]);
        }
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeshabilitar($id)
    {
        $this->findModel($id)->deshabilitar();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionHabilitar($id)
    {
        $this->findModel($id)->habilitar();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Recibe por parámetro el Id del usuario y se envía un correo con el token
     * para cambiar la contraseña del mismo.
     *
     */
    public function actionRestorePassword($id)
    {
        $user = User::findOne(['idUsuario' => $id]);
        if ($user->sendEmailRestorePassword()) {
            Yii::$app->session->setFlash('success', 'Correo enviardo');
        } else {
            Yii::$app->session->setFlash('error', 'Se ha producido un error, intente nuevamente.');
        }
        return $this->redirect(Yii::$app->request->referrer);
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

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}
