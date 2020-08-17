<?php

namespace backend\controllers;

use backend\models\Evento;
use backend\models\Usuario;
use backend\models\EventoSearch;
use backend\models\CategoriaEvento;
use backend\models\ModalidadEvento;
use backend\models\CambiarOrganizadorForm;
use common\models\SolicitudAval;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

//use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * EventoController implements the CRUD actions for Evento model.
 */
class EventoController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
     * Lists all Evento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Evento model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $aval = SolicitudAval::findOne(['idEvento' => $id]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'aval' => $aval,
        ]);
    }

    /**
     * Creates a new Evento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate() {
//        $model = new Evento();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->idEvento]);
//        }
//
//        return $this->render('create', [
//                    'model' => $model,
//        ]);
//    }




    public function actionEditarEvento($id)
    {
//        $model = new Evento($id);
        $model = Evento::findOne(['idEvento' => $id]);

        $model->idEstadoEvento = 4; //FLag - Por defecto los eventos quedan en estado "Borrador"
        $model->fechaCreacionEvento = date('Y-m-d'); // Fecha de hoy

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //necesita variables, porque sino hace referencia al objeto model y la referencia pierde el valor si crea una nueva instancia
//            if ($model->codigoAcreditacion != null) {
//                $nombreCortoEvento = $model->nombreCortoEvento;
//                $codAcre = $model->codigoAcreditacion;
////                $this->actionGenerarQRAcreditacion($codAcre, $nombreCortoEvento);
//            }
            $model->save();
            return $this->redirect(['/evento/view/', 'id' => $id]);
        }

        $categoriasEventos = CategoriaEvento::find()
            ->select(['descripcionCategoria'])
            ->indexBy('idCategoriaEvento')
            ->column();

        $modalidadEvento = modalidadEvento::find()
            ->select(['descripcionModalidad'])
            ->indexBy('idModalidadEvento')
            ->column();
        return $this->render('editarEvento', [
            'model' => $model,
            'categoriasEventos' => $categoriasEventos,
            'modalidadEvento' => $modalidadEvento,

        ]);
    }

    /**
     * Updates an existing Evento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

//    public function actionUpdate($id) {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->idEvento]);
//        }
//
//        return $this->render('update', [
//                    'model' => $model,
//        ]);
//    }
    public function actionModificarOrganizador($idEvento)
    {
        $model = new CambiarOrganizadorForm();
        $usersQuery = Usuario::find()->select(['idUsuario', 'email'])->all();
        $users = ArrayHelper::map($usersQuery, 'idUsuario', 'email');
        $users = $this->conversionAutocomplete($users);
        $alert = Yii::$app->request->post();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->cambiarOrganizadorEvento($idEvento)) {
                return $this->redirect(['/evento/view/', 'id' => $idEvento]);
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('modificarOrganizador', [
                'model' => $model,
                'usuarios' => $users,
                'alert' => $alert
            ]);
        } else {
            return $this->render('modificarOrganizador', [
                'model' => $model,
                'usuarios' => $users,
                'alert' => $alert
            ]);
        }
    }

    /**
     * Conversion del datos para autocompletar en campos
     *
     * @return mixed
     */
    public function conversionAutocomplete($array)
    {
        $autocomplete = array();
        foreach ($array as $id => $nombre) {
            array_push($autocomplete, ['value' => $nombre, 'label' => $nombre]);
        }
        return $autocomplete;
    }

    /**
     * Deletes an existing Evento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeshabilitar($id)
    {
        $this->findModel($id)->deshabilitar();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Deletes an existing Evento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionHabilitar($id)
    {
        $this->findModel($id)->habilitar();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Evento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Evento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Evento::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}
