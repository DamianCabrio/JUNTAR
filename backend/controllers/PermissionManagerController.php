<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class PermissionManagerController extends Controller
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
     * {@inheritdoc}
     */
    public function actions()
    {
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
    public function actionIndex()
    {
      // Se obtiene todos los roles que estan creados.
      $roles = yii::$app->authManager->getRoles();
      $permissions = yii::$app->authManager->getPermissions();
        return $this->render('index',[
          'roles' => $roles,
          'permissions' => $permissions,
        ]);
    }
    /**
     * Asignar permisos a roles.
     *
     * @return string
     */
    public function actionAssingPermission($rol, $permission)
    {
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
    public function actionCreateRol()
    {
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
                Yii::$app->session->setFlash('success', '<p>Se creó el rol: '.$model->name.'</p>');
              } else {
                Yii::$app->session->setFlash('error', '<p>Ha ocurrido un error</p>');
              }
          } else {
            Yii::$app->session->setFlash('error', '<p>El Rol ya esta creado.</p>');
          }
        }
        return $this->render('create-rol', [
          'model'=>$model,
        ]);
    }
    /**
     * Alta de Permiso
     *
     * @return string
     */
    public function actionCreatePermission()
    {
      $model = new \yii\base\DynamicModel([
        'name', 'description',
      ]);
      $model->addRule(['name', 'description'], 'required')
            ->addRule(['name', 'description'], 'string');

      $model->setAttributeLabels([
        'name' => 'Permiso a Establecer (controlador/acción)',
        'description' => 'Descripción del Permiso',
      ]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
          if (yii::$app->authManager->getRole($model->name) == null) {
            $permission = yii::$app->authManager->createPermission($model->name);
            $permission->description = $model->description;
              if (yii::$app->authManager->add($permission)) {
                Yii::$app->session->setFlash('success', '<p>Se creó el rol: '.$model->name.'</p>');
              } else {
                Yii::$app->session->setFlash('error', '<p>Ha ocurrido un error</p>');
              }
          } else {
            Yii::$app->session->setFlash('error', '<p>El Rol ya esta creado.</p>');
          }
        }
        return $this->render('create-permission', [
          'model'=>$model,
        ]);
    }

}
