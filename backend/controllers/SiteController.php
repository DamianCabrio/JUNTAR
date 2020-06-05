<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
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
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
     public function actionLogin()
     {
         if (!Yii::$app->user->isGuest) {
             return $this->goHome();
         }
         $model = new LoginForm();
         if ($model->load(Yii::$app->request->post()) && $model->login()) {
           if (!Yii::$app->user->can('Administrador')) {
               Yii::$app->user->logout();
               Yii::$app->session->setFlash('error', '<p>Acceso Denegado</p>');
               return $this->goHome();
           }
           return $this->goBack();
         } else {
           $model->password = '';
           return $this->render('login', [
             'model' => $model,
           ]);
         }

     }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
