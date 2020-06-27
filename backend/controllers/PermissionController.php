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
use backend\models\PermisoQuery;
use backend\models\Permiso;
use yii\web\NotFoundHttpException;

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
        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel::find()->where(['type' => 2]),
            'pagination' => [
                'pageSize' => 20,
            ],
//            'sort' => ['attributes' => ['name']]
        ]);
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
    public function actionAsignarPermisos() {
        $rolSeleccionado = null;
        //captura la seleccion de un rol
        if (Yii::$app->request->get('unRol') != null) {
            $rolSeleccionado = Yii::$app->request->get('unRol');
        }
        //si recibe asignarPermiso procede a asignar el permiso al rol seleccionado
        if (Yii::$app->request->get('asignarPermiso') != null && $rolSeleccionado != null) {
            $this->asignarPermisoARol($rolSeleccionado, Yii::$app->request->get('asignarPermiso'));
            return $this->redirect(Yii::$app->request->referrer);
        }

        //generamos los arreglos de permisos y roles
        $permisosAsignadosRolSeleccionado = [];
        $rolesAsignadosARolSeleccionado = [];
        if (Yii::$app->request->get('unRol') != null) {
            $rolSeleccionado = Yii::$app->request->get('unRol');
            //obtenemos los permisos del rol
            $permisosAsignadosRolSeleccionado = $this->getPermisosAsignados($rolSeleccionado, $permisosAsignadosRolSeleccionado);
            //obtenemos los roles asignados al rol
            $rolesAsignadosARolSeleccionado = $this->getRolesAsignados($rolSeleccionado);
            foreach ($rolesAsignadosARolSeleccionado as $key => $unPermiso) {
                //buscamos los permisos de cada rol asignado al rol seleccionado
                $permisosAsignadosRolSeleccionado = $this->getPermisosAsignados($unPermiso['name'], $permisosAsignadosRolSeleccionado);
            }
        }
        // Se obtiene todos los roles del sistema.
        $dataRoles = $this->actionGetroles();

        $searchModel = new PermisoSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel::find()->where(['type' => 2]),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => ['attributes' => ['name']]
        ]);

        return $this->render('asignarPermisos', [
                    'roles' => $dataRoles,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'rolSeleccionado' => $rolSeleccionado,
                    'permisosAsignados' => $permisosAsignadosRolSeleccionado,
                    'rolesAsignados' => $rolesAsignadosARolSeleccionado,
        ]);
    }

    /**
     * Metodo getRoles --> Retorna un array con todos los registros de roles en el sistema.
     * 
     * @return array
     */
    private function actionGetRoles() {
        $roles = null;
        if (Yii::$app->user->can('Administrador')) {
            $rolesQuery = (new \yii\db\Query())
                    //campos a buscar
                    ->select(['name', 'description'])
                    //tabla
                    ->from('permiso')
                    //Condicion (rol = 1)
                    ->where(['type' => 1]);

            $roles = $rolesQuery->all();
        }
        return $roles;
    }

    /**
     * Metodo getPermisosAsignados --> Busca la información necesaria sobre los permisos asignados a un rol.
     * Retorna un arreglo conteniendo todos los permisos que el rol posee.
     * 
     * @param String $unRol
     * @param Array $permisosAsignados
     * @return Array
     */
    private function getPermisosAsignados($unRol, $permisosAsignados) {
        if (Yii::$app->user->can('Administrador')) {
            //genera la query para buscar los permisos asignados al rol
            $permissionsRoleQuery = (new \yii\db\Query())
                    //campos a buscar
                    ->select(['parent', 'name', 'description'])
                    //distict
                    ->distinct('name')
                    //tabla
                    ->from('permiso')
                    //relacion tabla permiso_rol
                    ->innerJoin('permiso_rol', "permiso_rol.child = permiso.name")
                    //Condicion permisos asignados
                    ->where(['permiso_rol.parent' => $unRol])
                    ->andWhere(['type' => 2]);
            //Order
//                    ->orderBy("permiso_rol.parent");

            $permisosAsignados[$unRol] = $permissionsRoleQuery->all();
        }
        return $permisosAsignados;
    }

    /**
     * Metodo getRolesAsignados --> Busca la información necesaria sobre los roles asignados a un rol.
     * Retorna un arreglo conteniendo todos los roles que el rol posee.
     * 
     * @param String $unRol
     * @return Array
     */
    private function getRolesAsignados($unRol) {
        $rolesAsignados = null;
        if (Yii::$app->user->can('Administrador')) {
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
                    ->where(['permiso_rol.parent' => $unRol])
                    ->andWhere(['type' => 1]);
            //Order
//                    ->orderBy("permiso_rol.parent");

            $rolesAsignados = $permissionsRoleQuery->all();
        }
        return $rolesAsignados;
    }

    /**
     * Metodo asignarPermisoARol --> Permite asignar o quitar un permiso a un rol, ambos datos recibidos 
     * por parámetro. Devuelve un array si pudo realizar la operacion, false en caso contrario.
     *
     * @return boolean/array
     */
    private function asignarPermisoARol($unRol, $unItemPermiso) {
        $respuesta = false;
        if (Yii::$app->user->can('Administrador')) {
            $rol = $unRol;
            $permiso = $unItemPermiso;

            $auth = Yii::$app->authManager;

            $unPermiso = $auth->createPermission($permiso);
            $unRol = $auth->createRole($rol);
            if (!$auth->hasChild($unPermiso, $unRol)) {
                if ($auth->hasChild($unRol, $unPermiso)) {
                    $auth->removeChild($unRol, $unPermiso);
                    $respuesta['success'] = "Removed";
                } else {
                    $auth->addChild($unRol, $unPermiso);
                    $respuesta['success'] = "Added";
                }
            } else {
                $respuesta['error'] = "noAgregado";
            }
        }
        return $respuesta;
    }

    /**
     * Metodo createPermiso --> Permite crear un nuevo permiso. Utiliza una funcion que busca todas
     * las vistas del proyecto y genera un array de permisos faltantes en base a ellas.
     *
     * @return view
     */
    public function actionCreatePermiso() {
        $model = new Permiso();

        //captura la seleccion de un rol
        $entornoSeleccionado = "todos";
        if (Yii::$app->request->get('entorno') != null) {
            $entornoSeleccionado = Yii::$app->request->get('entorno');
        }

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
        if ($entornoSeleccionado == "todos") {
            $permisosSitio = $this->listarPermisosDeControladores('backend', $permisosSitio);
            $permisosSitio = $this->listarPermisosDeControladores('frontend', $permisosSitio);
            //asignar más entornos donde existan controllers a futuro
        } else {
            $permisosSitio = $this->listarPermisosDeControladores($entornoSeleccionado, $permisosSitio);
        }

        //obtenemos los permisos registrados
        $permisosRegistrados = ArrayHelper::map(yii::$app->AuthManager->getPermissions(), 'name', 'name');

        //generamos un array que contiene solo los permisos no hayan sido registrados
        $permisosFaltantes = array_diff($permisosSitio, $permisosRegistrados);

        return $this->render('createPermiso', [
                    'model' => $model,
                    'permisos' => $permisosFaltantes,
                    'entorno' => $entornoSeleccionado
        ]);
    }

    /**
     * Metodo listarPermisosDeControladores --> Retorna un array que contiene todos los permisos del
     * server side especificado por parámetro. Utiliza el alias del camino a consultar (frontend-backend)
     * y lo asigna al arreglo $actions recibido por parámetro.
     *
     * @param String $path
     * @param Array $actions
     * @return array/null
     */
    private function listarPermisosDeControladores($path, $actions) {
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
     * Elimina un Rol|Permiso|Regla
     *
     * @return string
     */
    public function actionRemovePermiso() {
        $model = new Permiso();
        if (Yii::$app->request->get('name') != null) {
            $nombrePermiso = Yii::$app->request->get('name');
            $model = $this->findModel($nombrePermiso);
        }

        //verifica si fue enviada informacion por POST
        if ($model->load(Yii::$app->request->post())) {
            //consideramos como resultado el peor de los casos
            $result = false;
            //comprobamos si existe el permiso
            if (yii::$app->authManager->getPermission($model->name) != null) {
                //si existe obtenemos el resultado de remover el registro del permiso
                $permission = Yii::$app->authManager->createPermission($model->name);
                $result = Yii::$app->authManager->remove($permission);
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
     * Finds the Permiso model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Permiso the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Permiso::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('El permiso que estás intentando acceder no existe.');
    }

}
