<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\models\RolSearch;
use backend\models\Rol;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class RolController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        $behaviors['access'] = [
            //utilizamos el filtro AccessControl
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'actions' => [
                        'login',
                    ],
                    'roles' => ['?'], // <----- guest
                ],
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
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lists all Permiso models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new RolSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Permiso model.
     * @param string $name
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionVerRol($name) {
        return $this->render('verRol', [
                    'model' => $this->findModel($name),
        ]);
    }

    /**
     * Metodo createPermiso --> Permite crear un nuevo permiso. Utiliza una funcion que busca todas
     * las vistas del proyecto y genera un array de permisos faltantes en base a ellas.
     *
     * @return view
     */
    public function actionCreateRol() {
        //creamos un modelo dinamico para representar los campos del permiso
        $model = new Rol();

        //verifica si fue enviada informacion por POST
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //verifica que el permiso no exista
            if (Yii::$app->authManager->getRole($model->name) == null) {
                //creamos el permiso y definimos sus atributos
                $nuevoRol = Yii::$app->authManager->createRole($model->name);
                $nuevoRol->description = $model->description;

                //procede a agregar el permiso
                if (Yii::$app->authManager->add($nuevoRol)) {
                    Yii::$app->session->setFlash('success', '<p> El Rol: ' . $model->name . ' fue creado exitosamente. </p>');
                } else {
                    Yii::$app->session->setFlash('error', '<p> Ha ocurrido un error ): </p>');
                }
            } else {
                Yii::$app->session->setFlash('error', '<p> El Rol ingresado ya existe. </p>');
            }
        }

        return $this->render('createRol', [
                    'model' => $model,
        ]);
    }

    /**
     * Elimina un Rol|Permiso|Regla
     *
     * @return string
     */
    public function actionRemoveRol() {
        $model = new Rol();
        if (Yii::$app->request->get('name') != null) {
            $nombreRol = Yii::$app->request->get('name');
            $model = $this->findModel($nombreRol);
        }
//        $model = $this->findModel($name);

        //verifica si fue enviada informacion por POST
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //consideramos como resultado el peor de los casos
            $result = false;
            //comprobamos si existe el permiso
            if (yii::$app->authManager->getRole($model->name) != null) {
                //si existe obtenemos el resultado de remover el registro del permiso
                $result = yii::$app->authManager->remove($model->name);
            }
            //generamos un mensaje en base al resultado
            if ($result) {
                Yii::$app->session->setFlash('success', '<p> Se eliminó el rol <strong>' . $model->name . '</strong> </p>');
                return $this->redirect(['remove-rol']);
            } else {
                Yii::$app->session->setFlash('error', '<p> No es posible eliminar el rol <strong>' . $model->name . '</strong> </p>');
            }
        }

        $roles = ArrayHelper::map(Yii::$app->AuthManager->getRoles(), 'name', 'name');
        return $this->render('removeRol', [
                    'model' => $model,
                    'item' => $roles,
        ]);
    }

    /**
     * Finds the Permiso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Permiso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Rol::findOne(['name' => $id, 'type' => 1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('El rol buscado no existe.');
    }

}
