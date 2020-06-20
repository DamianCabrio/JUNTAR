<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\models\User;
use frontend\models\Usuario;
use frontend\models\UploadProfileImage;
use frontend\models\EventoSearch;
use frontend\models\InscripcionSearch;

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
        $profileImageRoute = Url::base(true) . "/iconos/person-bounding-box.svg";
        $rutaImagenPerfil = Url::base(true) . "/profile/images/" . (Yii::$app->user->identity->idUsuario . '-' . Yii::$app->user->identity->nombre . '.jpg');

        if (@GetImageSize($rutaImagenPerfil)) {
            $profileImageRoute = $rutaImagenPerfil;
        }
//        $model = new Usuario();
        $queryUser = (new \yii\db\Query())
                //campos buscados
                ->select(['nombre, apellido, dni, pais, provincia, localidad, email, (usuario_rol.item_name) as rol'])
                //distintos en
                //->distinct('jugador.posicion')
                //tabla
                ->from('usuario')
                //relacion entre tablas
                ->innerJoin('usuario_rol', 'usuario_rol.user_id = usuario.idUsuario')
                //condicion
                ->where(['idUsuario' => Yii::$app->user->identity->id]);
        //Agrupamiento
        //->groupBy(['jugador.posicion']);
        //obtenemos el array asociativo a partir de la query
        $userData = $queryUser->all();

        return $this->render('profile', [
                    'data' => $userData,
                    'profileImage' => $profileImageRoute,
                    'route' => $rutaImagenPerfil
//                    'data' => $queryUser,
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

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $viejoNombreUsuario = Yii::$app->user->identity->nombre;
                $cambioImagen = false;
                if ($model->nombre != $viejoNombreUsuario) {
                    $rutaImagenPerfil = "profile/images/" . (Yii::$app->user->identity->idUsuario . '-' . $viejoNombreUsuario . '.jpg');
                    if (file_exists($rutaImagenPerfil)) {
                        $nuevaRutaImagen = "profile/images/" . (Yii::$app->user->identity->idUsuario . '-' . $model->nombre . '.jpg');
                        if (rename($rutaImagenPerfil, $nuevaRutaImagen)) {
                            $cambioImagen = true;
                        }
                    }
                }
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', '<h2> Datos Actualizados </h2>'
                            . '<p> ¡Tu perfil ha sido actualizado correctamente! </p>');
                } else {
                    Yii::$app->session->setFlash('error', '<h2> Ha ocurrido un error ): </h2>'
                            . '<p> Tu perfil no pudo ser actualizado </p>');
                }
            } else {
                Yii::$app->session->setFlash('error', '<h2> Ha ocurrido un error ): </h2>'
                        . '<p> Ingreso de datos no permitido </p>');
            }
            return $this->redirect(['/cuenta/profile']);
        }
//        if (Yii::$app->request->post('search') != null) {
//            //define el tipo de respuesta del metodo
//            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('editprofile', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('editprofile', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Permite actualizar la información del perfil
     *
     * @return mixed
     */
    public function actionUploadProfileImage() {
        //Siempre que quieras editar data, asegurate que el modelo defina reglas de validación para todos los campos afectados
        $model = new UploadProfileImage();

        if ($model->load(Yii::$app->request->post())) {
            $model->profileImage = UploadedFile::getInstance($model, 'profileImage');

            if ($model->profileImage != null) {
                if ($model->upload()) {
                    $model->profileImage = (Yii::getAlias("@web/profile/images/")) . $model->profileImage->baseName . '.' . $model->profileImage->extension;
                }
            }
            Yii::$app->session->setFlash('success', '<h2> Datos Actualizados </h2>'
                    . '<p> ¡Tu perfil ha sido actualizado correctamente! </p>');
            return $this->redirect(['profile']);
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('uploadProfileImage', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('uploadProfileImage', [
                        'model' => $model,
            ]);
        }
    }

    protected function findModel($id) {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Habilitar ser gestor de eventos.
     * @param int $id identificador del usuario.
     * @return mixed
     */
    public function actionDesactivarCuenta() {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = User::findIdentity(Yii::$app->user->identity->idUsuario);
        if (Yii::$app->request->post()) {
            $model->setInactive();
            Yii::$app->user->logout();
            return $this->goHome();
        }
        return $this->render('desactivarCuenta');
    }

    /**
     * Habilitar ser gestor de eventos.
     * @param int $id identificador del usuario.
     * @return mixed
     */
    public function actionMisEventosGestionados() {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $usuario = Yii::$app->user->identity->idUsuario;
//        $searchModel = new Evento();
        $searchModel = new EventoSearch();

        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel::find()->where(['idUsuario' => $usuario]),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => ['attributes' => ['fechaCreacionEvento']]
        ]);

        return $this->render('misEventosGestionados', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Habilitar ser gestor de eventos.
     * @param int $id identificador del usuario.
     * @return mixed
     */
    public function actionMisInscripcionesAEventos() {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $usuario = Yii::$app->user->identity->idUsuario;
//        $searchModel = new Evento();
        $searchModel = new InscripcionSearch();

        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel::find()->where(['idUsuario' => $usuario]),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => ['attributes' => ['fechaPreInscripcion']]
        ]);

        return $this->render('misInscripciones', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Habilitar ser gestor de eventos.
     * @param int $id identificador del usuario.
     * @return mixed
     */
    public function actionChangeRol($id) {
        $organizateRol = yii::$app->authManager->getRole('Organizador');
        if (yii::$app->authManager->getAssignment('Organizador', $id) == null) {
            yii::$app->authManager->assign($organizateRol, $id);
            Yii::$app->session->setFlash('success', '<small>Ahora es un gestor de evento</small>');
        }
        return $this->redirect(['profile']);
    }

}
