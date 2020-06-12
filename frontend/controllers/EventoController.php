<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Presentacion;
use frontend\models\PresentacionExpositor;
use frontend\models\Evento;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use frontend\models\UploadFormLogo;     //Para contener la instacion de la imagen logo 
use frontend\models\UploadFormFlyer;    //Para contener la instacion de la imagen flyer
use yii\web\UploadedFile;


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
     * Una ves cargado el evento, se visualizaun mensaje de exito desde una vista.
     */
    public function actionCargarEvento()
    {

        $model = new Evento();
        $modelLogo = new UploadFormLogo();
        $modelFlyer = new UploadFormFlyer();        

        if ($model->load(Yii::$app->request->post()) ) {
            $model->idEstadoEvento = 4; //FLag - Por defecto los eventos quedan en estado "Borrador"

            $modelLogo->imageLogo = UploadedFile::getInstance($modelLogo, 'imageLogo');
            $modelFlyer->imageFlyer = UploadedFile::getInstance($modelFlyer, 'imageFlyer');

            if($modelLogo->imageLogo != null){
                if($modelLogo->upload()){
                    $model->imgLogo =  'web/emanuel-mauro/frontend/web/eventos/images/logos/' . $modelLogo->imageLogo->baseName . '.' . $modelLogo->imageLogo->extension;
                }
            }    
            if($modelFlyer->imageFlyer != null){
                if($modelFlyer->upload()){
                    $model->imgFlyer =  'web/emanuel-mauro/frontend/web/eventos/images/flyers/' . $modelFlyer->imageFlyer->baseName . '.' . $modelFlyer->imageFlyer->extension;
                 }
            }
            if($model->save()){
            return $this->redirect(['evento-cargado', 'idEvento' => $model->idEvento]);
            }
            else{
                return $this->render('errorEvento');
            }    
        }
        return $this->render('cargarEvento', ['model' => $model, 'modelLogo' => $modelLogo, 'modelFlyer' => $modelFlyer]);
    }


    public function actionEventoCargado($idEvento)
    {
        return $this->render('eventoCargado', [
            'model' => $this->findModel($idEvento),
        ]);
    }

    /**
     * Muestra la informacion cargada de un evento.
     */
    public function actionVerEvento($idEvento)
    {
        $evento = Evento::findOne($idEvento);
        $presentaciones = Presentacion::find()->where(['idEvento' => $idEvento])->orderBy('idPresentacion')->all();
        return $this->render('verEvento', [
            'model'=>$evento,
            'presentacion' => $presentaciones
        ]);
    }


    /**
     * Lista todos los eventos creador por el usuario 
     */
    public function actionListarEventos()
    {
        $idUsuario = Yii::$app->user->identity->idUsuario;
        $listaEventos = Evento::find()->where(['idUsuario' => $idUsuario])->orderBy('idEvento')->all();
        return $this->render('listarEventos', ['model' => $listaEventos]);
    }


 

     public function actionEditarEvento($idEvento){

        $model = $this->findModel($idEvento);

        $modelLogo = new UploadFormLogo();
        $modelFlyer = new UploadFormFlyer();

        $rutaLogos = ( Yii::getAlias("@frontend/web/eventos/images/logos/"));
        $rutaFlyer = ( Yii::getAlias("@frontend/web/eventos/images/flyers/"));

        if($model->load(Yii::$app->request->post())) {
            $modelLogo->imageLogo = UploadedFile::getInstance($modelLogo, 'imageLogo'); // 'web/emanuel-mauro/frontend/web/eventos/images/logos/'
            $modelFlyer->imageFlyer = UploadedFile::getInstance($modelFlyer, 'imageFlyer'); // 'web/emanuel-mauro/frontend/web/eventos/images/flyers/'

            if($modelLogo->imageLogo != null){
                if($modelLogo->upload()){
                    $model->imgLogo =  $rutaLogos . $modelLogo->imageLogo->baseName . '.' . $modelLogo->imageLogo->extension;
                }
            }    
            if($modelFlyer->imageFlyer != null){
                if($modelFlyer->upload()){
                    $model->imgFlyer =  $rutaFlyer . $modelFlyer->imageFlyer->baseName . '.' . $modelFlyer->imageFlyer->extension;
                 }
            }
            $model->save();
            return $this->redirect(['ver-evento', 'idEvento' => $model->idEvento]);
        }

        return $this->render('editarEvento', [
            'model' => $model,
            'modelLogo' => $modelLogo, 
            'modelFlyer' => $modelFlyer
        ]);
     }

   
     public function actionPublicarEvento($idEvento){
        $model = $this->findModel($idEvento);
       
        $model->fechaCreacionEvento = date('Y-m-d');    
        $model->idEstadoEvento = 1;

        $model->save();
        return $this->render('eventoPublicado');

     }   

     public function actionDespublicarEvento($idEvento){
        $model = $this->findModel($idEvento);
       
        $model->fechaCreacionEvento = null;   
        $model->idEstadoEvento = 4;

        $model->save();
        return $this->render('eventoDespublicado');

     }   

}
