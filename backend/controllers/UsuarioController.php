<?php

namespace backend\controllers;

use Yii;
use backend\models\Usuario;
use common\models\SignupForm;
use backend\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller {

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
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UsuarioSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

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
    public function actionView($id) {
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
    public function actionAssign($id, $rol) {
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
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Usuario();

        if ($model->load(Yii::$app->request->post()) && $model->save() && $model->validate()) {
            return $this->redirect(['view', 'id' => $model->idUsuario]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }
    
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        //obtiene datos paises
        $dataCountry = file_get_contents("../../common/json/paises.json");
        $paises = json_decode($dataCountry, true);
        //Conversión de datos
        $paises = ArrayHelper::map($paises['countries'], 'id', 'name');
        $paises = $this->conversionAutocomplete($paises);
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->signup()) {
            Yii::$app->session->setFlash('success', '<h2> ¡Sólo queda confirmar tu correo! </h2>'
                    . '<p> Muchas gracias por registrarte en la plataforma Juntar. Por favor, revisa tu dirección de correo para confirmar tu cuenta. </p>');
            return $this->goBack(Url::previous());
        }

        return $this->render('signup', [
                    'model' => $model,
                    'paises' => $paises,
        ]);
    }

    public function actionSearchProvincias() {
        $provincias = null;
        if (Yii::$app->request->post('pais') != null) {

            //almacena el parámetro esperado
            $pais = Yii::$app->request->post('pais');

            //define el tipo de respuesta del metodo
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            //obtiene la data de las provincias del json
            $dataProvincias = file_get_contents("../../common/json/provincias.json");
            $provincias = json_decode($dataProvincias, true);

            //busca el indice del pais
            $indexPais = null;
            foreach ($provincias as $index => $unPais) {
                if (array_search($pais, $unPais)) {
                    $indexPais = $index;
                }
            }
            // Conversión de datos para obtener las provincias
            $provincias = ArrayHelper::map($provincias[$indexPais]['provincias'], 'id', 'nombre');
            $provincias = $this->conversionAutocomplete($provincias);
        }
        return $provincias;
    }

    public function actionSearchLocalidades() {
        $localidades = null;
        if (Yii::$app->request->post('provincia') != null) {

            //almacena el parámetro esperado
            $provincia = Yii::$app->request->post('provincia');

            //define el tipo de respuesta del metodo
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            //obtiene la data de las localidades del json
            $dataLocalidades = file_get_contents("../../common/json/localidades.json");
            $localidades = json_decode($dataLocalidades, true);

            //busca el indice de la provincia
            $indexProvincia = null;
            foreach ($localidades as $index => $unaProvincia) {
                if (array_search($provincia, $unaProvincia)) {
                    $indexProvincia = $index;
                }
            }
            //Conversión de datos para obtener las localidades 
            $localidades = ArrayHelper::map($localidades[$indexProvincia]['ciudades'], 'id', 'nombre');
            $localidades = $this->conversionAutocomplete($localidades);
        }
        return $localidades;
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save() && $model->validate()) {
            return $this->redirect(['view', 'id' => $model->idUsuario]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeshabilitar($id) {
        $this->findModel($id)->deshabilitar();

        return $this->redirect(['index']);
    }
    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionHabilitar($id) {
        $this->findModel($id)->habilitar();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}
