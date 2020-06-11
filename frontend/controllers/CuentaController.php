<?php

namespace frontend\controllers;

use common\models\User;
//use frontend\models\PasswordResetRequestForm;
//use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
//use frontend\models\ContactForm;
//use frontend\models\ResendVerificationEmailForm;
//use frontend\models\VerifyEmailForm;
use Yii;
//use yii\base\InvalidArgumentException;
//use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;

//use yii\captcha\CaptchaAction;
//use yii\filters\VerbFilter;
/**
 * Site controller
 */
class CuentaController extends Controller {

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
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
//            'captcha' => [
//                'class' => 'yii\captcha\CaptchaAction',
//                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
//            ],
        ];
    }

    public function actionProfile() {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new User();
        $queryUser = (new \yii\db\Query())
                ->select(['nombre, apellido, dni, fecha_nacimiento, telefono, localidad, email, (usuario_rol.item_name) as rol'])          //parametros seleccionados
                //                    ->distinct('jugador.posicion')
                ->from('usuario')                                                                   //tabla
                ->innerJoin('usuario_rol', 'usuario_rol.user_id = usuario.idUsuario')               //relacion entre tablas
                ->where(['idUsuario' => Yii::$app->user->identity->id]);                                //condicion: 
        //                    ->groupBy(['jugador.posicion']);                    //agrupamiento
        //obtenemos el array asociativo a partir de la query
        $userData = $queryUser->all();

        return $this->render('profile', [
                    'data' => $userData,
//                    'data' => $queryUser,
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', '<h2> ¡Sólo queda confirmar tu correo! </h2>'
                    . '<p> Muchas gracias por registrarte en la plataforma Juntar. Por favor, revisa tu dirección de correo para confirmar tu cuenta. </p>');
            return $this->goHome();
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    /**
     * Permite actualizar la información del perfil
     *
     * @return mixed
     */
    public function actionEditprofile() {

        //Siempre que quieras editar data, asegurate que el modelo defina reglas de validación para todos los campos afectados
        $model = $this->findModel(Yii::$app->user->identity->id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '<h2> Datos Actualizados </h2>'
                    . '<p> ¡Tu perfil ha sido actualizado correctamente! </p>');
            return $this->redirect(['profile']);
        }

        return $this->render('editprofile', [
                    'model' => $model,
        ]);
    }

    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
