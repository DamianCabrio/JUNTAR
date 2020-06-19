<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Inscripcion;
use frontend\models\Presentacion;
use frontend\models\PresentacionExpositor;
use frontend\models\Evento;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\components\validateEmail;
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
        $behaviors['access'] = [
            //utilizamos el filtro AccessControl
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'actions' => [
                        "ver-evento"
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

    public function calcularCupos($evento){
        if(!is_null($evento->capacidad)){
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
        }else {
            return null;
        }
    }

    public function obtenerEstadoEventoNoLogin($cupos, $evento){
        if ($cupos !== 0 || is_null($cupos)){
            return $evento->preInscripcion == 0 ? "puedeInscripcion" : "puedePreinscripcion";
        }else{
            return "sinCupos";
        }
    }

    public function obtenerEstadoEvento($evento, $yaInscripto = false, $yaAcreditado = false, $cupos, $tipoInscripcion){

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
            if ($cupos === 0 && !is_null($cupos)){
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

    public function verificarDueño($model){
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario == $model->idUsuario0->idUsuario){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Finds the Evento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Evento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id = "", $slug = "")
    {

        if($id == ""){
            if (($model = Evento::findOne(["nombreCortoEvento" => $slug])) !== null) {
                return $model;
            }
        }elseif($slug == ""){
            if (($model = Evento::findOne(["idEvento" => $id])) !== null) {
                return $model;
            }
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

    /**
     * Se visualiza un formulario para la carga de un nuevo evento desde la vista cargarEvento. Una vez cargado el formulario, se determina si
     * estan cargado los atributos de las instancias modelLogo y modelFlyer para setear ruta y nombre de las imagenes sobre el formulario.
     * Una ves cargado, se visualiza un mensaje de exito desde una vista.
     */
    public function actionCargarEvento()
    {

        $model = new Evento();
        $modelLogo = new UploadFormLogo();
        $modelFlyer = new UploadFormFlyer();        

        $rutaLogo = (Yii::getAlias("@rutaLogo"));
        $rutaFlyer = (Yii::getAlias("@rutaFlyer"));

        if ($model->load(Yii::$app->request->post()) ) {
            $model->idEstadoEvento = 4; //FLag - Por defecto los eventos quedan en estado "Borrador"

            $modelLogo->imageLogo = UploadedFile::getInstance($modelLogo, 'imageLogo');
            $modelFlyer->imageFlyer = UploadedFile::getInstance($modelFlyer, 'imageFlyer');

            if($modelLogo->imageLogo != null){
                if($modelLogo->upload()){
                    $model->imgLogo = $rutaLogo . '/' . $modelLogo->imageLogo->baseName . '.' . $modelLogo->imageLogo->extension;
                }
            }    
            if($modelFlyer->imageFlyer != null){
                if($modelFlyer->upload()){
                    $model->imgFlyer = $rutaFlyer . '/' . $modelFlyer->imageFlyer->baseName . '.' . $modelFlyer->imageFlyer->extension;
                 }
            }
            $model->save();
            return $this->redirect(['eventos/evento-cargado/'. $model->nombreCortoEvento]);
  
        }
        return $this->render('cargarEvento', ['model' => $model, 'modelLogo' => $modelLogo, 'modelFlyer' => $modelFlyer]);
    }


    public function actionEventoCargado($slug)
    {
        return $this->render('eventoCargado', [
            'model' => $this->findModel("",$slug),
        ]);
    }

    /**
     * Recibe por parámetro un id, se busca esa instancia del event y se obtienen todos las presentaciones que pertenecen a ese evento.
     * Se envia la instancia del evento junto con todas la presentaciones sobre un arreglo.
     */
    public function actionVerEvento($slug)
    {

        $evento = $this->findModel("",$slug);
        $presentaciones = Presentacion::find()->where(['idEvento' => $evento->idEvento])->orderBy('idPresentacion')->all();

        if($evento == null){
            return $this->goHome();
        }

        $cupos = $this->calcularCupos($evento);

        $yaInscripto = false;
        $yaAcreditado = false;

        if (!Yii::$app->user->getIsGuest()){

            $inscripcion = Inscripcion::find()
                ->where(["idUsuario" => Yii::$app->user->identity->idUsuario, "idEvento" => $evento->idEvento])
                ->andWhere(["!=", "estado", 2])->one();

            if($inscripcion != null) {
                $yaInscripto = true;
                $tipoInscripcion = $inscripcion->estado == 0 ? "preinscripcion" : "inscripcion";
                $yaAcreditado = $inscripcion->acreditacion == 1;
                $estadoEvento = $this->obtenerEstadoEvento($evento,$yaInscripto,$yaAcreditado, $cupos, $tipoInscripcion);
            }else{
                $estadoEvento = $this->obtenerEstadoEventoNoLogin($cupos,$evento);
            }

        }else{
            $estadoEvento = $this->obtenerEstadoEventoNoLogin($cupos,$evento);
        }

        $validarEmail = new validateEmail();
        $esFai = $validarEmail->validate_by_domain($evento->idUsuario0->email);
        $esDueño = $this->verificarDueño($evento);

        return $this->render('verEvento', [
            "evento" => $evento,
            'presentacion' => $presentaciones,
            "estadoEventoInscripcion" => $estadoEvento,
            'cupos' => $cupos,
            "esFai" => $esFai,
            "esDueño" => $esDueño,
        ]);
    }
    
     /**
     * Recibe por parámetro un id de evento, se buscar y se obtiene la instancia del evento, se visualiza un formulario 
     * cargado con los datos del evento permitiendo cambiar esos datos.
     * Una vez reallizado con cambios, se visualiza un mensaje de exito sobre una vista.
     */
     public function actionEditarEvento($slug){

        $model = $this->findModel("",$slug);
        $esDueño = $this->verificarDueño($model);

             if ($esDueño) {

             $modelLogo = new UploadFormLogo();
             $modelFlyer = new UploadFormFlyer();

             $rutaLogo = (Yii::getAlias("@rutaLogo"));
             $rutaFlyer = (Yii::getAlias("@rutaFlyer"));

             if ($model->load(Yii::$app->request->post())) {
                 $modelLogo->imageLogo = UploadedFile::getInstance($modelLogo, 'imageLogo');
                 $modelFlyer->imageFlyer = UploadedFile::getInstance($modelFlyer, 'imageFlyer');

                 if ($modelLogo->imageLogo != null) {
                     if ($modelLogo->upload()) {
                         $model->imgLogo = $rutaLogo . '/' . $modelLogo->imageLogo->baseName . '.' . $modelLogo->imageLogo->extension;
                     }
                 }
                 if ($modelFlyer->imageFlyer != null) {
                     if ($modelFlyer->upload()) {
                         $model->imgFlyer = $rutaFlyer . '/' . $modelFlyer->imageFlyer->baseName . '.' . $modelFlyer->imageFlyer->extension;
                     }
                 }
                 $model->save();
                 return $this->redirect(['eventos/ver-evento/' . $model->nombreCortoEvento]);
             }

             return $this->render('editarEvento', [
                 'model' => $model,
                 'modelLogo' => $modelLogo,
                 'modelFlyer' => $modelFlyer
             ]);
         }else{
                 throw new NotFoundHttpException('La página solicitada no existe.');
             }
     }

   
     /**
      * Recibe por parametro un id de un evento, buscar ese evento y setea en la instancia $model.
      * Cambia en el atributo fechaCreacionEvento y guarda la fecha del dia de hoy, y en el
      * atributo idEstadoEvento por el valor 1.
      */
     public function actionPublicarEvento($slug){
        $model = $this->findModel("",$slug);
       
        $model->fechaCreacionEvento = date('Y-m-d');    
        $model->idEstadoEvento = 1;  //FLag - Estado de evento activo

        $model->save();
        return $this->render('eventoPublicado', [
            'model' => $model,
            ]);
     }   

     /**
      * Recibe por parametro un id de un evento, buscar ese evento y setea en la instancia $model.
      * Cambia en el atributo fechaCreacionEvento por null, y en el
      * atributo idEstadoEvento por el valor 4.
      */
     public function actionDespublicarEvento($slug){
        $model = $this->findModel("", $slug);
       
        $model->fechaCreacionEvento = null;   
        $model->idEstadoEvento = 4;  //Flag  - Estado de evento borrador

        $model->save();
        return $this->render('eventoDespublicado', [
            'model' => $model,
            ]);
     }   
     
     public function actionCargarExpositor($idPresentacion)
    {
        $model = new PresentacionExpositor();
        $objPresentacion = Presentacion::findOne($idPresentacion);
        $objEvento = Evento::findOne($objPresentacion->idEvento);

        if ($model->load(Yii::$app->request->post())) {
            $model->idPresentacion = $idPresentacion;
            $model->save();
            return $this->redirect(['ver-evento', 'idEvento' => $objEvento->idEvento]);
        }

        return $this->render('cargarExpositor', [
            'model' => $model
        ]);
    }

}
