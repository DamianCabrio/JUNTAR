<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Evento;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Presentacion;
use frontend\models\PresentacionExpositor;
use frontend\models\Expositor;
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
     * Lists all Evento models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Evento::find(),
        ]);

        return $this->render('index', [
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Evento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Evento();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idEvento]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Evento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idEvento]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Evento model.
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

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Accion para la carga de un nuevo envento a traves de un formulario.
     * Una ves cargado el evento, se visualiza los datos que se han cargado desde una vista.
     */
    public function actionCargarEvento()
    {

        $model = new Evento();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['mostrar-evento', 'idEvento' => $model->idEvento]);
        }
        return $this->render('cargarEvento', ['model' => $model]);
    }

    public function actionMostrarEvento($idEvento)
    {

        return $this->render('eventoCargado', [
            'model' => $this->findModel($idEvento),
        ]);
    }

    /**
     * Accion para obtener una lista de todos los eventos perteneciente al usuario.
     * 
     */
    public function actionListarEventos()
    {

        $idUsuario = Yii::$app->user->identity->idUsuario;
        $listaEventos = Evento::find()->where(['idUsuario' => $idUsuario])->orderBy('idEvento')->all();
        return $this->render('listarEventos', ['model' => $listaEventos]);
    }
    public function actionInformacionEvento($idEvento)
    {
        $evento= Evento::findOne($idEvento);
        $presentaciones = Presentacion::find()->where(['idEvento' => $idEvento])->orderBy('idPresentacion')->all();
        
        return $this->render('informacionEvento', [
            'evento'=>$evento,
            'presentacion' => $presentaciones
        ]);
    }
    public function actionCargarExpositor($idPresentacion)
    {
        $preExpo = new PresentacionExpositor();
        $model = new Expositor();
        $objPresentacion = Presentacion::findOne($idPresentacion);
        $objEvento=Evento::findOne($objPresentacion->idEvento);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $preExpo->idExpositor = $model->idExpositor;
            $preExpo->idPresentacion = $idPresentacion;
            $preExpo->save();
            return $this->redirect(['informacion-evento', 'idEvento' => $objEvento->idEvento]);
        }

        return $this->render('cargarExpositor', [
            'model' => $model
        ]);
    }
}
