<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Presentacion;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\models\PresentacionExpositor;
use frontend\models\Evento;
use yii\data\ActiveDataProvider;
use backend\models\Usuario;

/**
 * PresentacionController implements the CRUD actions for Presentacion model.
 */
class PresentacionController extends Controller {

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
                    'actions' => [
                        "view",
                    ],
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
     * Lists all Presentacion models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Presentacion::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Presentacion model.
     * @param integer $presentacion
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($presentacion) {
        return $this->render('view', [
                    'model' => $this->findModel($presentacion),
        ]);
    }
    public function actionBorrar($presentacion) { //Ventana de confirmacion modal
        $idPresentacion = Presentacion::findOne($presentacion);
        $evento =  Evento::findOne($idPresentacion->idEvento);
        return $this->render('borrar', [
                    'model' => $this->findModel($presentacion),
                    'evento' => $evento,
        ]);
    }

    /**
     * Creates a new Presentacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Presentacion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idPresentacion]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Presentacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $presentacion
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($presentacion) {
        //busca la presentacion
        $model = $this->findModel($presentacion);
        $evento = Evento::findOne(["idEvento" => $model->idEvento]);

        $horaInicioSinSeg =  date('H:i', strtotime($model->horaInicioPresentacion));
        $horaFinSinSeg = date('H:i', strtotime($model->horaFinPresentacion));

        $model->horaInicioPresentacion = $horaInicioSinSeg;
        $model->horaFinPresentacion = $horaFinSinSeg;
        
        //si tiene datos cargados los almacena
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //volvemos a la pagina de la que vinimos
            return $this->redirect(Yii::$app->request->referrer);
        }

        If(Yii::$app->request->isAjax){
			//retorna renderizado para llamado en ajax
			return $this->renderAjax('editarPresentacion', [
				'model' => $model,
				'evento' => $evento,
        ]);
			}else{
				 return $this->render('editarPresentacion', [
				'model' => $model,
				'evento' => $evento,
			]);
		}
    }

    /**
     * Deletes an existing Presentacion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $presentacion
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($presentacion) {
        $id = $presentacion;
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Presentacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Presentacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Presentacion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Carga una nueva presentacion al evento 
     */
    public function actionCargarPresentacion($slug) {
        
        $idUsuario = Yii::$app->user->identity->idUsuario;
        $evento = Evento::findOne(["nombreCortoEvento" => $slug]);

        $model = new Presentacion();
        $preExpositor = new PresentacionExpositor();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                //$preExpositor->idExpositor = $preExpositor->idExpositor ;  
               
                return $this->redirect(['eventos/ver-evento/'. $evento->nombreCortoEvento]);
            }
        }
        if ($evento == null) {
            throw new NotFoundHttpException('El evento no fue encontrado.');
        }
            $item = Evento::find()     //buscar los eventos del usuario
                ->select(['nombreEvento'])
                ->indexBy('idEvento')
                ->where(['idUsuario' => $idUsuario, 'idEvento' => $evento->idEvento])
                ->column();

            $data = Usuario::find() //arreglo de usuarios para autocomplete
                ->select(["CONCAT(nombre,' ',apellido) as value", "CONCAT(nombre,' ',apellido)  as  label", "idUsuario as idUsuario"])
                ->asArray()
                ->all();

        If(Yii::$app->request->isAjax){
			//retorna renderizado para llamado en ajax
			return $this->renderAjax('cargarPresentacion', [
            'model' => $model,
            'item' => $item,
            "evento" => $evento,
            'preExpositor' => $preExpositor,
            'arrUsuario' => $data
        ]);
			}else{
				 return $this->render('cargarPresentacion', [
				'model' => $model,
				'item' => $item,
				"evento" => $evento,
				'preExpositor' => $preExpositor,
				'arrUsuario' => $data
			]);
		}
    }

   
}
