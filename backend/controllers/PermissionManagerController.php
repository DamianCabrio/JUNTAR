<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Inflector;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;
use yii\web\response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class PermissionManagerController extends Controller {

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
                    'actions' => ['login', 'signup', 'error', 'request-password-reset', 'PasswordReset', 'resend-verification-email'],
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        // Se obtiene todos los roles que estan creados.
        $roles = yii::$app->authManager->getRoles();
        $permisos = yii::$app->authManager->getPermissions();
        return $this->render('index', [
                    'roles' => $roles,
                    'permisos' => $permisos,
        ]);
    }

    /**
     * Asignar permisos a roles.
     *
     * @return string
     */
    public function actionAssingPermission($rol, $permission) {
        $auth = Yii::$app->authManager;
        $authRol = yii::$app->authManager->getRole($rol);
        $authPermission = yii::$app->authManager->getPermission($permission);
        if ($auth->hasChild($authRol, $authPermission)) {
            $auth->removeChild($authRol, $authPermission);
        } else {
            $auth->addChild($authRol, $authPermission);
        }
        return $this->redirect(['permission-manager/index']);
    }

    /**
     * Alta de Rol
     *
     * @return string
     */
    public function actionCreateRol() {
        $model = new \yii\base\DynamicModel([
            'name', 'description',
        ]);
        $model->addRule(['name', 'description'], 'required')
                ->addRule(['name', 'description'], 'string');
        $model->setAttributeLabels([
            'name' => 'Nombre del Rol',
            'description' => 'Descripción del Rol',
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (yii::$app->authManager->getRole($model->name) == null) {
                $rol = yii::$app->authManager->createRole($model->name);
                $rol->description = $model->description;
                if (yii::$app->authManager->add($rol)) {
                    Yii::$app->session->setFlash('success', '<p>Se creó el rol: ' . $model->name . '</p>');
                } else {
                    Yii::$app->session->setFlash('error', '<p>Ha ocurrido un error</p>');
                }
            } else {
                Yii::$app->session->setFlash('error', '<p>El Rol ya esta creado.</p>');
            }
        }
        return $this->render('create-rol', [
                    'model' => $model,
        ]);
    }

    /**
     * Alta de Permiso
     *
     * @return string
     */
    public function actionCreatePermission() {
        $model = new \yii\base\DynamicModel([
            'name', 'description',
        ]);
        $model->addRule(['name', 'description'], 'required')
                ->addRule(['name', 'description'], 'string');

        $model->setAttributeLabels([
            'name' => 'Permiso a Establecer (controlador/acción)',
            'description' => 'Descripción del Permiso',
        ]);

        //obtenemos las vistas de todo el sitio
        $permisosSitio = [];
        $permisosSitio = $this->actionListMissingPermissions('backend', $permisosSitio);
        $permisosSitio = $this->actionListMissingPermissions('frontend', $permisosSitio);

        $permisosDB = $this->actionListSignedPermissions();

        //filtramos que los arreglos no existan en la DB
        $permisosNotSigned = array_diff($permisosSitio, $permisosDB);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (yii::$app->authManager->getRole($model->name) == null) {
                $permission = yii::$app->authManager->createPermission($model->name);
                $permission->description = $model->description;
                if (yii::$app->authManager->add($permission)) {
                    Yii::$app->session->setFlash('success', '<p>Se creó el rol: ' . $model->name . '</p>');
                } else {
                    Yii::$app->session->setFlash('error', '<p>Ha ocurrido un error</p>');
                }
            } else {
                Yii::$app->session->setFlash('error', '<p>El Rol ya esta creado.</p>');
            }
        }
//        return $this->render('createPermission', [
        return $this->render('create-permission', [
                    'model' => $model,
                    'permisos' => $permisosNotSigned,
        ]);
    }

    /**
     * Metodo getControllerList --> Permite retornar el nombre de todos los controladores del sitio.
     * Utiliza el alias del camino a consultar (frontend-backend).
     * 
     * @param String $path
     * @return array/null
     */
//    private function actionListControllers($path) {
//        $controllersList = null;
//        $files = FileHelper::findFiles(Yii::getAlias("@$path/controllers"), ["fileTypes" => ["php"]]);
//
//        $controllersList = [];
//        foreach ($files as $controllerFile) {
//            //utiliza Inflector para capturar el nombre del controlador
//            $controllersList[] = Inflector::camel2id(substr(basename($controllerFile), 0, -14));
//        }
////        }
//        echo json_encode($controllersList, null, 2);
////        return $controllersList;
//    }
//
//    /**
//     * Metodo getControllerList --> Permite retornar el nombre de todas las vistas del controlador consultado.
//     * Utiliza el alias del camino a consultar (frontend-backend) y el nombre del controlador deseado.
//     * 
//     * @param String $path
//     * @param String $controllerName
//     * @return array/null
//     */
//    private function actionListActions($path, $controllerName) {
//        $actions = null;
//        $files = FileHelper::findFiles(Yii::getAlias("@$path/controllers"), ['only' => ["$controllerName" . "Controller.php"]]);
//
//        if ($files != null) {
//            //Captura el unico archivo que deberia matchear al nombre
//            $controllerFile = array_shift($files);
//
//            //carga el contenido del archivo en una variable para trabajarla
//            $contents = file_get_contents($controllerFile);
//
//            //captura el nombre de todas las acciones(vistas) en el array $actions
//            preg_match_all('/public function action(\w+?)\(/', $contents, $display);
//            $actions = [];
//            foreach ($display[1] as $oneAction) {
//                if (strlen($oneAction) > 2) {
//                    $actions [] = strtolower(preg_replace("/[A-Z]/", "-$0", lcfirst($oneAction)));
//                }
//            }
//        }
//        return $actions;
//    }

    /**
     * Metodo actionListMissingPermissions --> Permite retornar un array conteniendo todos los permisos del
     * server side especificado por parámetro. Utiliza el alias del camino a consultar (frontend-backend) 
     * y lo asigna al arreglo $actions recibido por parámetro.
     * 
     * @param String $path
     * @param Array $actions
     * @return array/null
     */
    private function actionListMissingPermissions($path, $actions) {
        $files = FileHelper::findFiles(Yii::getAlias("@$path/controllers"), ["fileTypes" => ["php"]]);

//        $actions = [];
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

    private function actionListSignedPermissions() {
        //obtenemos los permisos asignados en la DB
        $queryPermisos = (new \yii\db\Query())
                //campos seleccionados
                ->select(['name'])
                //tabla
                ->from('permiso')
                //condicion
                ->where(['type' => 2]);
        $permisos = $queryPermisos->all();

        foreach ($permisos as $key => $unPermiso) {
            $permisos[$key] = array_shift($unPermiso);
        }
        return $permisos;
    }

    /**
     * Actualiza un Rol definido
     *
     * @return string
     */
    public function actionUpdateRol() {
        $model = new \yii\base\DynamicModel([
            'name', 'description', 'new_name'
        ]);
        $model->addRule(['name', 'description', 'new_name'], 'required')
                ->addRule(['name', 'description', 'new_name'], 'string');
        $model->setAttributeLabels([
            'name' => 'Nombre del Rol',
            'description' => 'Descripción del Rol',
            'new_name' => 'Nuevo Nombre',
        ]);
        
        $roles = ArrayHelper::map(yii::$app->AuthManager->getRoles(), 'name', 'name');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $update_rol = yii::$app->authManager->createRole($model->new_name);
            $update_rol->description = $model->description;
            if (yii::$app->authManager->update($model->name, $update_rol)) {
                Yii::$app->session->setFlash('success', '<p>Se actulizó el rol: ' . $model->name . '</p>');
                return $this->redirect(['update-rol']);
            } else {
                Yii::$app->session->setFlash('error', '<p>Ha ocurrido un error</p>');
            }
        }

        return $this->render('update-rol', [
                    'model' => $model,
                    'roles' => $roles,
        ]);
    }

    /**
     * Actualiza un Permiso definido
     *
     * @return string
     */
    public function actionUpdatePermission() {
        $model = new \yii\base\DynamicModel([
            'name', 'description', 'new_name'
        ]);
        $model->addRule(['name', 'description', 'new_name'], 'required')
                ->addRule(['name', 'description', 'new_name'], 'string');
        $model->setAttributeLabels([
            'name' => 'Nombre del Permiso',
            'description' => 'Descripción del Rol',
            'new_name' => 'Nuevo Nombre',
        ]);
        $permissions = ArrayHelper::map(yii::$app->AuthManager->getPermissions(), 'name', 'name');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $update_permission = yii::$app->authManager->createPermission($model->new_name);
            $update_permission->description = $model->description;
            if (yii::$app->authManager->update($model->name, $update_permission)) {
                Yii::$app->session->setFlash('success', '<p>Se actulizó el Permiso: ' . $model->name . '</p>');
                return $this->redirect(['update-permission']);
            } else {
                Yii::$app->session->setFlash('error', '<p>Ha ocurrido un error</p>');
            }
        }
        return $this->render('update-permission', [
                    'model' => $model,
                    'permission' => $permissions,
        ]);
    }

    /**
     * Elimina un Rol|Permiso|Regla
     *
     * @return string
     */
    public function actionRemove() {
        $model = new \yii\base\DynamicModel(['name']);
        $model->addRule(['name'], 'required');
        $model->setAttributeLabels(['name' => 'Nombre del Permiso']);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $delete = null;
            if (yii::$app->authManager->getRole($model->name) != null) {
                $delete = yii::$app->authManager->getRole($model->name);
            }
            if (yii::$app->authManager->getPermission($model->name) != null) {
                $delete = yii::$app->authManager->getPermission($model->name);
            }
            if (yii::$app->authManager->remove($delete)) {
                Yii::$app->session->setFlash('success', '<p>Se Eliminó <b>' . $model->name . '</b></p>');
                return $this->redirect(['remove']);
            } else {
                Yii::$app->session->setFlash('error', '<p>No es posible eliminar  <b>' . $model->name . '</b></p>');
            }
        }
        $permisions = yii::$app->AuthManager->getRoles();
        $rol = yii::$app->AuthManager->getPermissions();
        $remove = ArrayHelper::map(array_merge($permisions, $rol), 'name', 'name');
        return $this->render('remove', [
                    'model' => $model,
                    'item' => $remove,
        ]);
    }

}
