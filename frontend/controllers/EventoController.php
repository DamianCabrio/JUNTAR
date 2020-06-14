<?php

namespace frontend\controllers;

use Yii;
use common\models\Evento;
use common\models\EventoSearch;
use common\models\Inscripcion;
use common\models\Fecha;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        /*
   En caso que se agregue a la tabla Evento el campo 'estado' modificar la consulta Evento::find()..
   en Where filtrar por 'estado' activo.
*/
        $evento = $this->findModel($id);

        if($evento == null){
            return $this->goHome();
        }

        $cupos = $this->calcularCupos($evento);

        $yaInscripto = false;
        $yaAcreditado = false;

        if (!Yii::$app->user->getIsGuest()){
            $inscripcion = Inscripcion::find()
                ->where(["idUsuario" => Yii::$app->user->identity->idUsuario, "idEvento" => $id])
                ->andWhere(["!=", "estado", 2])->one();

            if ($inscripcion != null) {
                $yaInscripto = true;
                $tipoInscripcion = $inscripcion->estado == 0 ? "preinscripcion" : "inscripcion";
                $yaAcreditado = $inscripcion->acreditacion == 1;

                $estadoEvento = $this->obtenerEstadoEvento($evento,$yaInscripto,$yaAcreditado, $cupos, $tipoInscripcion);
            }
            }else{
            if ($cupos != 0){
                $estadoEvento = $evento->preInscripcion == 0 ? "puedeInscripcion" : "puedePreinscripcion";
            }else{
                $estadoEvento = "sinCupos";
            }
        }
            return $this->render('view', [
                "evento" => $evento,
                "estadoEvento" => $estadoEvento,
                'cupos' => $cupos,
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

    public function calcularCupos($evento){
        //Cantidad de inscriptos al evento
        $cantInscriptos = Inscripcion::find()
            ->where(["idEvento" => $evento->idEvento, 'estado'=>1])
            ->count();

        $cupoMaximo = $evento->capacidad;

        if ($cantInscriptos >= $cupoMaximo) {
            $cupos = 0;
        } else {
            $cupos = $cupoMaximo - $cantInscriptos;
        }

        return $cupos;
    }

    public function obtenerEstadoEvento($evento, $yaInscripto, $yaAcreditado, $cupos, $tipoInscripcion){

        // ¿Ya esta inscripto o no? - Si
        if($yaInscripto){
            // ¿El evento ya inicio? - Si
            if($evento->fechaInicioEvento <= date("Y-m-d")){
                // ¿El evento tiene codigo de acreditacion? - Si
                if($evento->codigoAcreditacion != null){
                    // ¿El usuario ya se acredito en el evento? - Si
                    if($yaAcreditado != 1){
                        return "puedeAcreditarse";
                        // El usuario no esta acreditado
                    }else{
                        return "yaAcreditado";
                    }
                    // El evento no tiene codigo de autentifacion y inicio
                }else{
                    return "inscriptoYEventoIniciado";
                }
            // El evento no inicio todavia y el usuario esta inscripto
            }else{
                // Tipo de inscripcion
                if($tipoInscripcion == "preinscripcion"){
                    return "yaPreinscripto";
                }else{
                    return "yaInscripto";
                }
            }
            // El usuario no esta incripto en el evento
        }else{
            // ¿Hay cupos en el evento? - No
            if ($cupos == 0){
                return "sinCupos";
                // Hay cupos en el evento
            }else{
                // ¿La fecha actual es menor a la fecha limite de inscripcion? - Si
                if($evento->fechaLimiteInscripcion >= date("Y-m-d")){
                    // ¿El evento tiene pre inscripcion activada? - Si
                    if($evento->preInscripcion == 1){
                        return "puedePreinscripcion";
                        // El evento no tiene pre inscripcion
                    }else{
                        return "puedeInscripcion";
                    }
                }else{
                    return "noInscriptoYFechaLimiteInscripcionPasada";
                }
            }
        }
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