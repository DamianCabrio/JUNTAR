<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Inflector;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use backend\models\PermisoSearch;
use backend\models\Permiso;


/**
 * Site controller
 */
class PermissionController extends Controller {

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
        $searchModel = new PermisoSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex3() {
        // Se obtiene todos los roles que estan creados.
        $roles = yii::$app->authManager->getRoles();
        $permisos = yii::$app->authManager->getPermissions();
        return $this->render('index3', [
                    'roles' => $roles,
                    'permisos' => $permisos,
        ]);
    }

    /**
     * Displays a single Permiso model.
     * @param string $name
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionVerPermiso($name) {
        return $this->render('verPermiso', [
                    'model' => $this->findModel($name),
        ]);
    }

    /**
     * Metodo AsignarPermisos --> Genera un menú en el cual se pueden seleccionar roles y asignarles 
     * los permisos registrados. Se pueden tambien se pueden asignar roles para que herede todos los 
     * permisos de este.
     *
     * @return view
     */
    public function actionAsignarPermisos2() {
        //busca los roles que estan creados.
        $dataRoles = $this->actionGetRoles();
        //opcion usando authManager
//        $dataRoles = ArrayHelper::toArray(Yii::$app->AuthManager->getRoles(), [
//                    'yii\rbac\Role' => ['name'],
//        ]);
        //busca los permisos registrados
        $dataPermisos = $this->actionGetPermisos();
        //opcion usando authManager
//        $dataPermisos = ArrayHelper::toArray(Yii::$app->AuthManager->getPermissions(), [
//                    'yii\rbac\Permission' => ['name', 'description'],
//        ]);

        return $this->render('asignarPermisos2', [
                    'roles' => $dataRoles,
                    'permisos' => $dataPermisos
        ]);
    }
    
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionAsignarPermisos() {
        // Se obtiene todos los roles que estan creados.
        $dataRoles = $this->actionGetroles();
        $searchModel = new PermisoSearch();

        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel::find()->where(['type' => 2]),
//            'pagination' => [
//                'pageSize' => 10,
//            ],
            'pagination' => false,
            'sort' => ['attributes' => ['name', 'description']]
        ]);
        
        return $this->render('asignarPermisos', [
                    'roles' => $dataRoles,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Metodo createPermiso --> Permite crear un nuevo permiso. Utiliza una funcion que busca todas
     * las vistas del proyecto y genera un array de permisos faltantes en base a ellas.
     *
     * @return view
     */
    public function actionCreatePermiso() {
        //creamos un modelo dinamico para representar los campos del permiso
//        $model = new \yii\base\DynamicModel([
//            'name', 'description',
//        ]);
//        //agregamos reglas para los campos del modelo
//        $model->addRule(['name', 'description'], 'required')
//                ->addRule(['name', 'description'], 'string');
//        //seteamos las etiquetas de los campos
//        $model->setAttributeLabels([
//            'name' => 'Permiso',
//            'description' => 'Descripción del Permiso',
//        ]);
        $model = new Permiso();

        //verifica si fue enviada informacion por POST
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //verifica que el permiso no exista
            if (Yii::$app->authManager->getPermission($model->name) == null) {
                //creamos el permiso y definimos sus atributos
                $permission = Yii::$app->authManager->createPermission($model->name);
                $permission->description = $model->description;

                //procede a agregar el permiso
                if (Yii::$app->authManager->add($permission)) {
                    Yii::$app->session->setFlash('success', '<p> Se creó el Permiso: ' . $model->name . ' </p>');
                } else {
                    Yii::$app->session->setFlash('error', '<p> Ha ocurrido un error </p>');
                }
            } else {
                Yii::$app->session->setFlash('error', '<p>El Rol ya esta creado.</p>');
            }
        }

        //obtenemos las vistas de todo el sitio
        $permisosSitio = [];
        $permisosSitio = $this->actionListControllerPermissions('backend', $permisosSitio);
        $permisosSitio = $this->actionListControllerPermissions('frontend', $permisosSitio);
//        $this->actionListControllerPermissions('backend', $permisosSitio);
//        $this->actionListControllerPermissions('frontend', $permisosSitio);
        //obtenemos los permisos registrados
        $permisosRegistrados = ArrayHelper::map(yii::$app->AuthManager->getPermissions(), 'name', 'name');

        //generamos un array que contiene solo los permisos no hayan sido registrados
        $permisosFaltantes = array_diff($permisosSitio, $permisosRegistrados);

        return $this->render('createPermiso', [
                    'model' => $model,
                    'permisos' => $permisosFaltantes,
        ]);
    }

    /**
     * Metodo updatePermiso --> Permite actualizar el nombre de un permiso registrado.
     *
     * @return string
     */
    public function actionUpdatePermiso() {
        //creamos un modelo dinamico para representar los campos del permiso agregando el nuevo nombre
        $model = new \yii\base\DynamicModel([
            'name', 'description', 'new_name'
        ]);
        //agregamos reglas para los campos del modelo
        $model->addRule(['name', 'description', 'new_name'], 'required')
                ->addRule(['name', 'description', 'new_name'], 'string');
        //seteamos las etiquetas de los campos
        $model->setAttributeLabels([
            'name' => 'Nombre del Permiso',
            'description' => 'Descripción del Rol',
            'new_name' => 'Nuevo Nombre',
        ]);
        
//        $model->load($model1->attributes());
//        $model->save();

        //verifica si fue enviada informacion por POST
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //genera el modelo del permiso con los nuevos valores
            $permisoActualizado = Yii::$app->authManager->createPermission($model->name);
            $permisoActualizado->description = $model->description;
            //verifica si pudo realizarse la actualizacion
            if (Yii::$app->authManager->update($model->name, $permisoActualizado)) {
                Yii::$app->session->setFlash('success', '<p> Se actulizó el Permiso: ' . $model->name . '</p>');
                return $this->redirect(['update']);
            } else {
                Yii::$app->session->setFlash('error', '<p> Ha ocurrido un error </p>');
            }
        }

        //obtenemos los permisos registrados
        $permissions = ArrayHelper::map(yii::$app->AuthManager->getPermissions(), 'name', 'name');

        return $this->render('updatePermiso', [
                    'model' => $model,
                    'permission' => $permissions,
        ]);
    }

    /**
     * Elimina un Rol|Permiso|Regla
     *
     * @return string
     */
    public function actionRemovePermiso($name) {
        //creamos un modelo dinamico para representar los campos del permiso
//        $model = new \yii\base\DynamicModel(['name']);
//        //agregamos reglas para los campos del modelo
//        $model->addRule(['name'], 'required');
//        //seteamos las etiquetas de los campos
//        $model->setAttributeLabels(['name' => 'Nombre del Permiso']);
        $model = $this->findModel($name);
        
        
        //verifica si fue enviada informacion por POST
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //consideramos como resultado el peor de los casos
            $result = false;
            //comprobamos si existe el permiso
            if (yii::$app->authManager->getPermission($model->name) != null) {
                //si existe obtenemos el resultado de remover el registro del permiso
                $result = yii::$app->authManager->remove($model->name);
            }
            //generamos un mensaje en base al resultado
            if ($result) {
                Yii::$app->session->setFlash('success', '<p>Se Eliminó <strong>' . $model->name . '</strong> </p>');
                return $this->redirect(['removePermiso']);
            } else {
                Yii::$app->session->setFlash('error', '<p> No es posible eliminar el permiso <strong>' . $model->name . '</strong> </p>');
            }
        }

        $permissionList = ArrayHelper::map(Yii::$app->AuthManager->getPermissions(), 'name', 'name');
        return $this->render('removePermiso', [
                    'model' => $model,
                    'item' => $permissionList,
        ]);
    }

    /**
     * Metodo getRoles --> Retorna un array con todos los registros de roles.
     * 
     * @return array
     */
    private function actionGetRoles() {
        $roles = null;
        if (Yii::$app->user->can('Administrador')) {
            $rolesQuery = (new \yii\db\Query())
                    //campos a buscar
                    ->select(['name'])
                    //tabla
                    ->from('permiso')
                    //Condicion (rol = 1)
                    ->where(['type' => 1]);

            $roles = $rolesQuery->all();
        }
        return $roles;
    }

    /**
     * Metodo getPermisos --> Retorna un array con todos los registros de permisos.
     * 
     * @return array
     */
    private function actionGetPermisos() {
        $permisos = null;
        if (Yii::$app->user->can('Administrador')) {
            $permisosQuery = (new \yii\db\Query())
                    //campos a buscar
                    ->select(['name', 'description'])
                    //tabla
                    ->from('permiso')
                    //Condicion (permiso = 2)
                    ->where(['type' => 2]);

            $permisos = $permisosQuery->all();
        }
        return $permisos;
    }

    /**
     * Metodo getPermisosByRol --> Retorna un array con todos los registros de permisos que
     * fueron asignados a un rol recibido por parametro.
     * 
     * @return array
     */
    public function actionGetPermisosByRol() {
        $permissionsRole = null;
        if (Yii::$app->user->can('Administrador')) {
            if (Yii::$app->request->post('unRol') != null) {
                if (Yii::$app->request->post('search') != null) {
                    //define el tipo de respuesta del metodo
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                }

                //captura el rol recibido por POST
                $unRol = Yii::$app->request->post('unRol');

                //genera la query para buscar los permisos asignados al rol
                $permissionsRoleQuery = (new \yii\db\Query())
                        //campos a buscar
                        ->select(['parent', 'name', 'description', 'type'])
                        //distict
                        ->distinct('name')
                        //tabla
                        ->from('permiso')
                        //relacion tabla permiso_rol
                        ->innerJoin('permiso_rol', "permiso_rol.child = permiso.name")
                        //Condicion permisos asignados
                        ->where(['permiso_rol.parent' => $unRol]);

                $permissionsRole = $permissionsRoleQuery->all();
            }
        }
        return $permissionsRole;
    }

    /**
     * Metodo asignarPermiso --> Permite asignar o quitar un permiso a un rol, ambos datos recibidos 
     * por parámetro en POST. Devuelve un array si pudo realizar la operacion, false en caso
     * contrario.
     *
     * @return boolean/array
     */
    public function actionAsignarPermisoARol() {
        $respuesta = false;
        if (Yii::$app->user->can('Administrador')) {
            if (Yii::$app->request->post('unRol') != null && Yii::$app->request->post('unPermiso') != null) {
                if (Yii::$app->request->post('search') != null) {
                    //define el tipo de respuesta del metodo
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                }

                //captura el rol y el permiso recibido por POST
                $rol = Yii::$app->request->post('unRol');
                $permiso = Yii::$app->request->post('unPermiso');

                //genera el rol y el permiso haciendo uso de authManager
                $auth = Yii::$app->authManager;
                $unPermiso = $auth->createPermission($permiso);
                $unRol = $auth->createRole($rol);

                //verifica si el rol ya tiene asignado el permiso
                if ($auth->hasChild($unRol, $unPermiso)) {
                    //si lo tiene asignado, lo remueve y retorna removido
                    $auth->removeChild($unRol, $unPermiso);
                    $respuesta['success'] = "Removed";
                } else {
                    //si no lo tiene asignado, lo agrega y retorna agregado
                    $auth->addChild($unRol, $unPermiso);
                    $respuesta['success'] = "Added";
                }
                $auth = null;
            }
        }
        return $respuesta;
    }

    /**
     * Metodo listControllerPermissions --> Retorna un array que contiene todos los permisos del
     * server side especificado por parámetro. Utiliza el alias del camino a consultar (frontend-backend)
     * y lo asigna al arreglo $actions recibido por parámetro.
     *
     * @param String $path
     * @param Array $actions
     * @return array/null
     */
    private function actionListControllerPermissions($path, $actions) {
        $files = FileHelper::findFiles(Yii::getAlias("@$path/controllers"), ["fileTypes" => ["php"]]);

        foreach ($files as $controllerFile) {
            //carga el contenido del archivo en una variable para trabajarla
            $contents = file_get_contents($controllerFile);

            $controllerName = Inflector::camel2id(substr(basename($controllerFile), 0, -14));

            //captura el nombre de todas las acciones(vistas) en el array $actions
            preg_match_all('/public function action(\w+?)\(/', $contents, $display);
            foreach ($display[1] as $oneAction) {
                if (strlen($oneAction) > 2) {
                    $actions [] = $controllerName . '/' . strtolower(preg_replace("/[A-Z]/", "-$0", lcfirst($oneAction)));
                }
            }
        }
        return $actions;
    }
    
    /**
     * Finds the Permiso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Permiso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Permiso::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}
