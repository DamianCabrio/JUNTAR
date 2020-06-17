<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use \yii\helpers\Url;
use Yii;
use frontend\models\Inscripcion;
use frontend\models\InscripcionSearch;
use frontend\models\Evento;
use frontend\models\EventoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InscripcionController implements the CRUD actions for Inscripcion model.
 */
class InscripcionController extends Controller
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
     * Lists all Inscripcion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InscripcionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Inscripcion model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Inscripcion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Inscripcion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idInscripcion]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionPreinscripcion()
    {
        if ( Yii::$app->user->isGuest ){
            Url::remember();
            return Yii::$app->getResponse()->redirect(Url::to(['site/login'],302));
        }

        //Guardo el parametro que llega por get (id del evento)
        $request = Yii::$app->request;
        $idEvento = $request->get('id');
        $slug = $request->get('slug');

        //Busco si ya existe una inscripcion anulada
        $inscripcion = Inscripcion::find()
                        ->where(["idUsuario" => Yii::$app->user->identity->id, "idEvento" => $idEvento])
                        ->one();
        
        //Si no existe creo un nueva instancia de inscripcion
        if ($inscripcion == Null){
            $inscripcion = new Inscripcion();
            $inscripcion->idUsuario = Yii::$app->user->identity->id;
            $inscripcion->idEvento = $idEvento;
            $inscripcion->acreditacion = 0;    
        }
        
        //Busco en el campo preinscripcion en el evento 
        $evento = Evento::find($idEvento)->select('preInscripcion')->one();
        //Si requiere preinscripcion es true sino false
        $esPreInscripcion = $evento->preInscripcion == 1 ? true : false;


        if ($esPreInscripcion) {
            $inscripcion->estado = 0; //es una preinscripcion
            $inscripcion->fechaPreInscripcion = date("Y-m-d");
        }
        else{
            $inscripcion->estado = 1; // es una inscripcion directa
            $inscripcion->fechaPreInscripcion = date("Y-m-d");
            $inscripcion->fechaInscripcion = date("Y-m-d");
        }
        $seGuardo = $inscripcion->save();

        if($seGuardo){
            $texto = $esPreInscripcion ? "Se ha pre-inscripto con éxito" : "Se ha inscripto con éxito";
            Yii::$app->session->setFlash('success', '<h2>'. $texto .'</h2>'
                . '<p> Buena suerte </p>');
            return $this->redirect(['eventos/ver-evento/' . $slug]);
        }else{
            Yii::$app->session->setFlash('error', '<h2> Ocurrió un error </h2>'
                . '<p> Por favor vuelva a intentar </p>');
            return $this->redirect(['eventos/ver-evento/' . $slug]);
        }
    }

    public function actionEliminarInscripcion(){
        if ( Yii::$app->user->isGuest ){
            $request = Yii::$app->request;
            $idEvento = $request->get('id');
            return Yii::$app->getResponse()->redirect(Url::to(['evento/view', "id" => $idEvento],302));
        }

        $request = Yii::$app->request;
        $idEvento = $request->get('id');
        $slug = $request->get('slug');

        $inscripcion = Inscripcion::find()
                        ->where(["idUsuario" => Yii::$app->user->identity->id, "idEvento" => $idEvento])
                        ->one();
        //Cambio el estado a 2 = anulado
        $inscripcion->estado = 2;
        $seElimino = $inscripcion->save();

        $esPreInscripcion = $inscripcion->estado == 1 ? true : false;

        if($seElimino){
            $texto = $esPreInscripcion ? "Se ha anulado su pre-inscripto con éxito" : "Se ha anulado su inscripción con éxito";
            Yii::$app->session->setFlash('success', '<h2>'. $texto .'</h2>'
                . '<p> Vuelva otro día </p>');
            return $this->redirect(['eventos/ver-evento/' . $slug]);
        }else{
            Yii::$app->session->setFlash('error', '<h2> Ocurrió un error </h2>'
                . '<p> Por favor vuelva a intentar </p>');
            return $this->redirect(['eventos/ver-evento/' . $slug]);
        }
    }

    /**
     * Updates an existing Inscripcion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idInscripcion]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Inscripcion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Inscripcion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Inscripcion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inscripcion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La pagina no existe.');
    }
}
