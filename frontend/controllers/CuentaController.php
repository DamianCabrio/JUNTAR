<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\CambiarEmailForm;
use frontend\models\CambiarEmailRequest;
use frontend\models\CambiarPasswordForm;
use frontend\models\EventoSearch;
use frontend\models\ImagenPerfil;
use frontend\models\InscripcionSearch;
use frontend\models\UploadProfileImage;
use frontend\models\Usuario;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class CuentaController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors['access'] = [
            //Utilizamos el filtro AccessControl
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        //Guardamos la accion (vista) que se intenta acceder
                        $action = Yii::$app->controller->action->id;
                        //Guardamos el controlador del cual se consulta
                        $controller = Yii::$app->controller->id;
                        //Generamos la ruta que se busca acceder
                        $route = "$controller/$action";
                        //preguntamos si el usuario tiene los permisos para visitar el sitio
                        if (Yii::$app->user->can($route)) {
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

    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $profileImageRoute = Url::base(true) . "/iconos/person-bounding-box.svg";

        $model = Usuario::find()
            //campos buscados
            ->select(['nombre, apellido, password_hash, dni, pais, provincia, localidad, email, (usuario_rol.item_name) as rol'])
            //tabla
            ->from('usuario')
            //relacion entre tablas
            ->innerJoin('usuario_rol', 'usuario_rol.user_id = usuario.idUsuario')
            //condicion
            ->where(['usuario.idUsuario' => Yii::$app->user->identity->id]);
        //obtenemos el unico usuario
        $userData = $model->one();

        //buscamos los datos de la imagen del perfil en los registros
        $modelImagenPerfil = ImagenPerfil::findOne(['idUsuario' => Yii::$app->user->identity->id]);

        if ($modelImagenPerfil != null) {
            //utilizamos el control de operador en caso que no exista el archivo en la ruta guardada
            if (@getimagesize(Url::base(true) . $modelImagenPerfil->rutaImagenPerfil)) {
                $profileImageRoute = Url::base(true) . $modelImagenPerfil['rutaImagenPerfil'];
            }
        }

        return $this->render('profile', [
            'dataUser' => $userData,
            'profileImage' => $profileImageRoute,
        ]);
    }

    /**
     * Permite actualizar la información del perfil
     *
     * @return mixed
     */
    public function actionEditprofile()
    {

        //Siempre que quieras editar data, asegurate que el modelo defina reglas de validación para todos los campos afectados
        $model = $this->findModel(Yii::$app->user->identity->id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->validate()) {
                $viejoNombreUsuario = Yii::$app->user->identity->nombre;
                $cambioImagen = false;
                if ($model->nombre != $viejoNombreUsuario) {
                    $rutaImagenPerfil = "profile/images/" . (Yii::$app->user->identity->idUsuario . '-' . $viejoNombreUsuario . '.jpg');
                    if (file_exists($rutaImagenPerfil)) {
                        $nuevaRutaImagen = "profile/images/" . (Yii::$app->user->identity->idUsuario . '-' . $model->nombre . '.jpg');
                        if (rename($rutaImagenPerfil, $nuevaRutaImagen)) {
                            $imageModel = ImagenPerfil::findOne(['idUsuario' => Yii::$app->user->identity->idUsuario]);
                            $imageModel->rutaImagenPerfil = "/" . $nuevaRutaImagen;

                            $imageModel->update();
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
    public function actionUploadProfileImage()
    {
        //Siempre que quieras editar data, asegurate que el modelo defina reglas de validación para todos los campos afectados
        $model = new UploadProfileImage();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->profileImage = UploadedFile::getInstance($model, 'profileImage');

            if ($model->profileImage != null) {
                if ($model->upload()) {
                    Yii::$app->session->setFlash('success', '<h2> Datos Actualizados </h2>'
                        . '<p> ¡Tu perfil ha sido actualizado correctamente! </p>');
                } else {
                    Yii::$app->session->setFlash('error', '<h2> Algo salió mal ): </h2>'
                        . '<p> No pudimos actualizar tu imagen de perfil. </p>');
                }
            } else {
                Yii::$app->session->setFlash('error', '<h2> Campo vacío </h2>'
                    . '<p> No ingresó ninguna imagen. </p>');
            }

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

    /**
     *
     * @return mixed
     */
    public function actionDesactivarCuenta()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (Yii::$app->request->post()) {
            $model = User::findIdentity(Yii::$app->user->identity->idUsuario);
            $model->setInactive();
            Yii::$app->user->logout();
            return $this->goHome();
        }
        return $this->render('desactivarCuenta');
    }

    /**
     *
     * @return mixed
     */
    public function actionMisEventosGestionados()
    {
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
     *
     * @return mixed
     */
    public function actionMisInscripcionesAEventos()
    {
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
     * Resets password.
     *
     * @param string $token
     * @return mixed
     */
    public function actionCambiarPassword()
    {

        $model = new CambiarPasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->cambiarPassword()) {
                Yii::$app->session->setFlash('success', '<h2> Contraseña actualizada </h2>'
                    . '<p> La nueva contraseña fue guardada. </p>');
            } else {
                Yii::$app->session->setFlash('error', '<h2> Algo salió mal </h2>'
                    . '<p> Es probable que haya escrito mal su contraseña actual. </p>');
            }

            return $this->redirect(['/cuenta/profile']);
        }

        return $this->render('cambiarPassword', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La pagina que busca esta en otro castillo.');
    }

    /**
     * Habilitar ser gestor de eventos.
     * @param int $id identificador del usuario.
     * @return mixed
     */
    private function actionChangeRol($id)
    {
        $organizateRol = yii::$app->authManager->getRole('Organizador');
        if (yii::$app->authManager->getAssignment('Organizador', $id) == null) {
            yii::$app->authManager->assign($organizateRol, $id);
            Yii::$app->session->setFlash('success', '<small>Ahora es un gestor de evento</small>');
        }
        return $this->redirect(['/cuenta/profile']);
    }

}
