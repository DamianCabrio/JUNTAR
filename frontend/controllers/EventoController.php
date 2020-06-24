<?php

namespace frontend\controllers;

use Da\QrCode\QrCode;
use frontend\models\InscripcionSearch;
use frontend\models\Pregunta;
use frontend\models\PreguntaSearch;
use frontend\models\RespuestaFile;
use frontend\models\RespuestaSearch;
use yii\helpers\Url;
use Yii;
use frontend\models\Inscripcion;
use frontend\models\Presentacion;
use frontend\models\Usuario;
use frontend\models\PresentacionSearch;
use frontend\models\PresentacionExpositor;
use frontend\models\Evento;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\components\validateEmail;
use yii\data\Pagination;
use frontend\models\ModalidadEvento;
use frontend\models\CategoriaEvento;

use frontend\models\UploadFormLogo;     //Para contener la instacion de la imagen logo 
use frontend\models\UploadFormFlyer;    //Para contener la instacion de la imagen flyer
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use UI\Controls\Label;
use frontend\models\FormularioForm;

/**
 * EventoController implements the CRUD actions for Evento model.
 */
class EventoController extends Controller {

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
                        "ver-evento",
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

    public function calcularCupos($evento) {
        if (!is_null($evento->capacidad)) {
            //Cantidad de inscriptos al evento
            $cantInscriptos = Inscripcion::find()
                    ->where(["idEvento" => $evento->idEvento, 'estado' => 1])
                    ->count();

            $cupoMaximo = $evento->capacidad;

            if ($cantInscriptos >= $cupoMaximo) {
                $cupos = 0;
            } else {
                $cupos = $cupoMaximo - $cantInscriptos;
            }
            return $cupos;
        } else {
            return null;
        }
    }

    public function obtenerEstadoEventoNoLogin($cupos, $evento) {
        if($evento->fechaLimiteInscripcion >= date("Y-m-d")){
            if ($cupos !== 0 || is_null($cupos)) {
                return $evento->preInscripcion == 0 ? "puedeInscripcion" : "puedePreinscripcion";
            } else {
                return "sinCupos";
            }
        }elseif ($evento->fechaInicioEvento >= date("Y-m-d") && $evento->fechaLimiteInscripcion == null){
            if ($cupos !== 0 || is_null($cupos)) {
                return $evento->preInscripcion == 0 ? "puedeInscripcion" : "puedePreinscripcion";
            } else {
                return "sinCupos";
            }
        }
        else{
            return "noInscriptoYFechaLimiteInscripcionPasada";
        }
    }

    public function obtenerEstadoEvento($evento, $yaInscripto = false, $yaAcreditado = false, $cupos, $tipoInscripcion) {

        // ¿Ya esta inscripto o no? - Si
        if ($yaInscripto) {
            // ¿El evento ya inicio? - Si
            if ($evento->fechaInicioEvento >= date("Y-m-d")) {
                // ¿El evento tiene codigo de acreditacion? - Si
                if ($evento->codigoAcreditacion != null) {
                    // ¿El usuario ya se acredito en el evento? - Si
                    if ($yaAcreditado != 1) {
                        return "puedeAcreditarse";
                        // El usuario no esta acreditado
                    } else {
                        return "yaAcreditado";
                    }
                    // El evento no tiene codigo de autentifacion y inicio
                } else {
                    return "inscriptoYEventoIniciado";
                }
                // El evento no inicio todavia y el usuario esta inscripto
            } else {
                // Tipo de inscripcion
                if ($tipoInscripcion == "preinscripcion") {
                    return "yaPreinscripto";
                } else {
                    return "yaInscripto";
                }
            }
            // El usuario no esta incripto en el evento
        } else {
            // ¿Hay cupos en el evento? - No
            if ($cupos === 0 && !is_null($cupos)) {
                return "sinCupos";
                // Hay cupos en el evento
            } else {
                // ¿La fecha actual es menor a la fecha limite de inscripcion? - Si
                    // ¿El evento tiene pre inscripcion activada? - Si
                    if ($evento->preInscripcion == 1) {
                        if($evento->fechaLimiteInscripcion== null || $evento->fechaLimiteInscripcion== '1969-12-31'){
                            if($evento->fechaInicioEvento >= date("Y-m-d")){
                                return "puedeInscripcion";
                            }else{
                                return "noInscriptoYFechaLimiteInscripcionPasada";
                            }
                        }else {
                            if($evento->fechaLimiteInscripcion >= date("Y-m-d")){
                                return "puedePreinscripcion";
                            }else{
                                return "noInscriptoYFechaLimiteInscripcionPasada";
                            }
                        }
                        // El evento no tiene pre inscripcion
                    } else {
                        if($evento->fechaInicioEvento >= date("Y-m-d")){
                            return "puedeInscripcion";
                        }else{
                            return "noInscriptoYFechaLimiteInscripcionPasada";
                        }
                    }
                }
            }
        }

    public function verificarDueño($model) {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario == $model->idUsuario0->idUsuario) {
            return true;
        } else {
            return false;
        }
    }

    public function verificarAdministrador($model) {

        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario ) {
        $query=new \yii\db\Query(); 
        $rows= $query->from('usuario_rol')
            ->andWhere(['user_id'=>Yii::$app->user->identity->idUsuario])
            ->andWhere(['item_name'=>'Administrador'])->all(); 


        if (count($rows)==0) {
            return false ;
         } else {
             return true;
         }
     }else{
        return false ;
     }
        
   }

    /**
     * Finds the Evento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Evento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id = "", $slug = "") {

        if ($id == "") {
            if (($model = Evento::findOne(["nombreCortoEvento" => $slug])) !== null) {
                return $model;
            }
        } elseif ($slug == "") {
            if (($model = Evento::findOne(["idEvento" => $id])) !== null) {
                return $model;
            }
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

    public function actionRespuestasFormulario($slug){
        $evento = $this->findModel("", $slug);

        if($this->verificarDueño($evento)){
        $usuariosInscriptosSearchModel = new InscripcionSearch();
        $usuariosInscriptosDataProvider = new ActiveDataProvider([
            'query' => $usuariosInscriptosSearchModel::find()->where(["idEvento" => $evento->idEvento])->andWhere(["estado" => 0]),
            'pagination' => false,
            'sort' => ['attributes' => ['name', 'description']]
        ]);
            return $this->render('respuestasFormulario',
                ["inscriptos" => $usuariosInscriptosDataProvider,
                    "evento" => $evento]);
        }else {
            throw new NotFoundHttpException('La página solicitada no existe.');
}

    }

    /**
     * Se visualiza un formulario para la carga de un nuevo evento desde la vista cargarEvento. Una vez cargado el formulario, se determina si
     * estan cargado los atributos de las instancias modelLogo y modelFlyer para setear ruta y nombre de las imagenes sobre el formulario.
     * Una ves cargado, se visualiza un mensaje de exito desde una vista.
     */
    public function actionCargarEvento() {

        $model = new Evento();
        $modelLogo = new UploadFormLogo();
        $modelFlyer = new UploadFormFlyer();

        $rutaLogo = (Yii::getAlias("@rutaLogo"));
        $rutaFlyer = (Yii::getAlias("@rutaFlyer"));

        if ($model->load(Yii::$app->request->post())) {
            $model->idEstadoEvento = 4; //FLag - Por defecto los eventos quedan en estado "Borrador"

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
            //necesita variables, porque sino hace referencia al objeto model y la referencia pierde el valor si crea una nueva instancia
            $nombreCortoEvento = $model->nombreCortoEvento;
            if ($model->codigoAcreditacion != null) {
                $codAcre = $model->codigoAcreditacion;
                $this->actionGenerarQRAcreditacion($codAcre, $nombreCortoEvento);
            }
            $model->save();
            return $this->redirect(['eventos/ver-evento/' . $model->nombreCortoEvento]);
        }
        $categoriasEventos = CategoriaEvento::find()
            ->select(['descripcionCategoria'])
            ->indexBy('idCategoriaEvento')
            ->column();

            $modalidadEvento = modalidadEvento::find()
            ->select(['descripcionModalidad'])
            ->indexBy('idModalidadEvento')
            ->column();
        return $this->render('cargarEvento', ['model' => $model, 'modelLogo' => $modelLogo, 'modelFlyer' => $modelFlyer, 'categoriasEventos' => $categoriasEventos, 'modalidadEvento' => $modalidadEvento]);
    }
    

    private function actionGenerarQRAcreditacion($codigoAcreditacion, $slug) {
//        $label = (new Label($slug))
        $label = ($slug);
//                ->setFont(__DIR__ . '/../resources/fonts/monsterrat.otf')
//                ->setFontSize(14);

        $qrCode = (new QrCode(Url::to(['/acreditacion/acreditacion']) . $codigoAcreditacion))
                ->useLogo("../web/images/juntar-logo/png/juntar-avatar-bg-b.png")
//                ->useForegroundColor(51, 153, 255)
//                ->useBackgroundColor(200, 220, 210)
//                //white and black (se ve horrendo
//                ->useForegroundColor(255,255,255)
//                ->useBackgroundColor(0,0,0)
                ->useEncoding('UTF-8')
//                ->setErrorCorrectionLevel(ErrorCorrectionLevelInterface::HIGH)
                ->setLogoWidth(80)
                ->setSize(400)
                ->setMargin(5)
                ->setLabel($label);

        $qrCode->writeFile('../web/eventos/images/qrcodes/' . $slug . '.png');
    }

    public function actionCrearFormularioDinamico($slug){

        $evento = $this->findModel("", $slug);

        $esDueño = $this->verificarDueño($evento);


        if ($esDueño) {
            $preguntasSearchModel = new PreguntaSearch();
            $preguntasDataProvider = new ActiveDataProvider([
                'query' => $preguntasSearchModel::find()->where(['idEvento' => $evento->idEvento]),
                'pagination' => false,
                'sort' => ['attributes' => ['name', 'description']]
            ]);

            return $this->render('crearFormularioDinamico',
                ["preguntas" => $preguntasDataProvider,
                    "evento" => $evento]);
        }else {
                throw new NotFoundHttpException('La página solicitada no existe.');
            }
    }

    public function actionResponderFormulario($slug){

        $evento = $this->findModel("", $slug);
        $inscripcion = Inscripcion::find()->where(["idEvento" => $evento->idEvento, "idUsuario" => Yii::$app->user->identity->idUsuario])->one();

        if($inscripcion != null){
            $preguntas = Pregunta::find()->where(["idEvento" => $evento->idEvento])->all();

            $respuestaYaHechas = [];
            foreach ($preguntas as $pregunta){
                $respuesta = RespuestaSearch::find()->where(["idpregunta" => $pregunta->id])->one();
                if($respuesta == null){
                    array_push($respuestaYaHechas, false);
                }else{
                    array_push($respuestaYaHechas, true);
                }
            }

            return $this->render('responderFormulario',
                ["preguntas" => $preguntas,
                    "evento" => $evento,
                    "idInscripcion" => $inscripcion->idInscripcion,
                    "respuestaYaHechas" => $respuestaYaHechas]);
        }else{
            return $this->goHome();
        }
    }

    /**
     * Recibe por parámetro un id, se busca esa instancia del event y se obtienen todos las presentaciones que pertenecen a ese evento.
     * Se envia la instancia del evento junto con todas la presentaciones sobre un arreglo.
     */
    public function actionVerEvento($slug) {

        $evento = $this->findModel("", $slug);

        $cantidadPreguntas = Pregunta::find()->where(["idevento" => $evento->idEvento])->count();

        $presentacionSearchModel = new PresentacionSearch();

        $presentacionDataProvider = new ActiveDataProvider([
            'query' => $presentacionSearchModel::find()->where(['idEvento' => $evento->idEvento])->orderBy('idPresentacion'),
            'pagination' => false,
            'sort' => ['attributes' => ['name', 'description']]
        ]);
        $presentaciones = Presentacion::find()->where(['idEvento' => $evento->idEvento])->orderBy('idPresentacion')->all();

        if ($evento == null) {
            return $this->goHome();
        }

        $cupos = $this->calcularCupos($evento);

        $yaInscripto = false;
        $yaAcreditado = false;

        if (!Yii::$app->user->getIsGuest()) {

            $inscripcion = Inscripcion::find()
                            ->where(["idUsuario" => Yii::$app->user->identity->idUsuario, "idEvento" => $evento->idEvento])
                            ->andWhere(["!=", "estado", 2])->one();

            if ($inscripcion != null) {
                $yaInscripto = true;
                $tipoInscripcion = $inscripcion->estado == 0 ? "preinscripcion" : "inscripcion";
                $yaAcreditado = $inscripcion->acreditacion == 1;
                $estadoEvento = $this->obtenerEstadoEvento($evento, $yaInscripto, $yaAcreditado, $cupos, $tipoInscripcion);
            } else {
                $estadoEvento = $this->obtenerEstadoEventoNoLogin($cupos, $evento);
            }
        } else {
            $estadoEvento = $this->obtenerEstadoEventoNoLogin($cupos, $evento);
        }

        $validarEmail = new validateEmail();
        $esFai = $validarEmail->validate_by_domain($evento->idUsuario0->email);
        $esDueño = $this->verificarDueño($evento);
        $esAdministrador = $this->verificarAdministrador($evento);


        return $this->render('verEvento', [
                    "evento" => $evento,
                    'presentacion' => $presentaciones,
                    'presentacionSearchModel' => $presentacionSearchModel,
                    'presentacionDataProvider' => $presentacionDataProvider,
                    "estadoEventoInscripcion" => $estadoEvento,
                    'cupos' => $cupos,
                    "esFai" => $esFai,
                    "esDueño" => $esDueño,
                    "esAdministrador" => $esAdministrador,
                    "cantidadPreguntas" => $cantidadPreguntas,
        ]);
    }

    /**
     * Recibe por parámetro un id de evento, se buscar y se obtiene la instancia del evento, se visualiza un formulario 
     * cargado con los datos del evento permitiendo cambiar esos datos.
     * Una vez reallizado con cambios, se visualiza un mensaje de exito sobre una vista.
     */
    public function actionEditarEvento($slug)
    {

        $model = $this->findModel("", $slug);

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
            $categoriasEventos = CategoriaEvento::find()
            ->select(['descripcionCategoria'])
            ->indexBy('idCategoriaEvento')
            ->column();

        $modalidadEvento = modalidadEvento::find()
            ->select(['descripcionModalidad'])
            ->indexBy('idModalidadEvento')
            ->column();

         return $this->render('editarEvento', ['model' => $model, 'modelLogo' => $modelLogo, 'modelFlyer' => $modelFlyer, 'categoriasEventos' => $categoriasEventos, 'modalidadEvento' => $modalidadEvento]);
        }

    /**
     * Recibe por parametro un id de un evento, buscar ese evento y setea en la instancia $model.
     * Cambia en el atributo fechaCreacionEvento y guarda la fecha del dia de hoy, y en el
     * atributo idEstadoEvento por el valor 1.
     */
    public function actionPublicarEvento($slug){
        $model = $this->findModel("", $slug);
       
        $model->fechaCreacionEvento = date('Y-m-d');    
        $model->idEstadoEvento = 1;  //FLag - Estado de evento activo
        $model->save();

        return $this->redirect(['eventos/ver-evento/'. $model->nombreCortoEvento]);
     }   

    /**
     * Recibe por parametro un id de un evento, buscar ese evento y setea en la instancia $model.
     * Cambia en el atributo fechaCreacionEvento por null, y en el
     * atributo idEstadoEvento por el valor 4.
     */
    public function actionSuspenderEvento($slug){
        $model = $this->findModel("", $slug);
        
        $model->fechaCreacionEvento = null;   
        $model->idEstadoEvento = 4;  //Flag  - Estado de evento borrador
        $model->save();

        return $this->redirect(['eventos/ver-evento/'. $model->nombreCortoEvento]);
     } 


    public function actionCargarExpositor($idPresentacion) {
        $model = new PresentacionExpositor();
        $objPresentacion = Presentacion::findOne($idPresentacion);
        $objEvento = Evento::findOne($objPresentacion->idEvento);

        if ($model->load(Yii::$app->request->post())) {
            $model->idPresentacion = $idPresentacion;
            $model->save();
            return $this->redirect(['eventos/ver-evento/'. $objEvento->nombreCortoEvento]);
        }

        $usuarios = Usuario::find()
                            ->select(["CONCAT(nombre,' ',apellido) as value", "CONCAT(nombre,' ',apellido)  as  label", "idUsuario as idUsuario"])
                            ->asArray()
                            ->all();
         
        If(Yii::$app->request->isAjax){
			//retorna renderizado para llamado en ajax
			return $this->renderAjax('cargarExpositor', [
            'model' => $model,
            'objetoEvento' => $objEvento,
            'usuarios' => $usuarios,
        ]);
			}else{
				 return $this->render('cargarExpositor', [
				'model' => $model,
				'objetoEvento' => $objEvento,
				'usuarios' => $usuarios,
			]);
		}
    }


    public function actionInscriptosExcel()
    {
        $request = Yii::$app->request;
        $idEvento  = $request->get('idEvento');

        $evento = Evento::findOne($idEvento);

        $arrayEvento['idEvento'] =   $idEvento;
        $arrayEvento['organizador'] = $evento->idUsuario0->nombre." ".$evento->idUsuario0->apellido;
        $arrayEvento['inicio'] = $evento->fechaInicioEvento;
        $arrayEvento['fin'] =  $evento->fechaFinEvento;
        $arrayEvento['nombre'] = $evento->nombreEvento;
        $arrayEvento['capacidad']  = $evento->capacidad ;
        $arrayEvento['lugar']= $evento->lugar;
        $arrayEvento['modalidad'] = $evento->idModalidadEvento0->descripcionModalidad;;
        
        $base = Inscripcion::find();
        $base->innerJoin('usuario', 'usuario.idUsuario=inscripcion.idUsuario');
        $base->select(['user_apellido'=>'usuario.apellido',
                      'user_nombre'=> 'usuario.nombre',
                      'user_dni'=>'usuario.dni',
                      'user_pais'=>'usuario.pais',
                      'user_provincia'=>'usuario.provincia',
                      'user_localidad'=>'usuario.localidad',
                      'user_email'=>'usuario.email',
                      'user_idInscripcion'=>'inscripcion.idInscripcion',
                      'user_fechaPreInscripcion'=>'inscripcion.fechaPreInscripcion',
                      'user_fechaInscripcion'=>'inscripcion.fechaInscripcion']);

        /// 1: preinscripto    2: inscripto     3: anulado    4: acreditado

        $preinscriptos = $base ->where(['inscripcion.idEvento' => $idEvento,'inscripcion.estado' => 1 ])
                               ->orderBy('usuario.apellido ASC')->asArray()->all();

        $inscriptos  = $base ->where(['inscripcion.idEvento' => $idEvento,'inscripcion.estado' => 2 ])
                             ->orderBy('usuario.apellido ASC')->asArray()->all();
    
        $anulados  = $base ->where(['inscripcion.idEvento' => $idEvento,'inscripcion.estado' => 3 ])
                           ->orderBy('usuario.apellido ASC')->asArray()->all();
    
        $acreditados  = $base ->where(['inscripcion.idEvento' => $idEvento,'inscripcion.estado' => 4 ])
                              ->orderBy('usuario.apellido ASC')->asArray()->all();



        $listados[]= ['index'=>0, 'titulo'=>'Preinscriptos', 'lista'=>$preinscriptos ];
        $listados[]= ['index'=>1, 'titulo'=>'Inscriptos', 'lista'=>$inscriptos];
        $listados[]= ['index'=>2, 'titulo'=>'Anulados', 'lista'=> $anulados ];
        $listados[]= ['index'=>3, 'titulo'=>'Acreditados', 'lista'=> $acreditados ];

       return $this->renderPartial('inscriptosExcel',
             ['listados' => $listados ,'arrayEvento' => $arrayEvento ]);
    }
    
    public function actionOrganizarEventos()
    {
        $idUsuario = Yii::$app->user->identity->idUsuario;

        $request = Yii::$app->request;
        $busqueda = $request->get("s", "");
        $estadoEvento = $request->get("estadoEvento", "");

        if($estadoEvento != ""){
           if($estadoEvento == 0){
               $estado = 1; // activo 
           }   
           if($estadoEvento == 1){
            $estado = 4; // suspendido
           }
           if($estadoEvento == 2){
            $estado = 3; // finalizado
           }  
        }        

        if ($estadoEvento != "") {
            $eventos = Evento::find()
                ->where(["idUsuario" => $idUsuario])
                ->andwhere(["like", "idEstadoEvento", $estado]);     
        }
        elseif($busqueda != ""){
            $eventos = Evento::find()
                ->where(["idUsuario" => $idUsuario])
                ->andwhere(["like", "nombreEvento", $busqueda]); 
        }
        else{
            $eventos = Evento::find()->where(["idUsuario" => $idUsuario])->andwhere(["idEstadoEvento" => 1]); // por defecto mostrar los eventos propios que son activos
        }

         //Paginación para 6 eventos por pagina
        $countQuery = clone $eventos;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->pageSize=6;
        //$pages->applyLimit = $countQuery->count();
        $models = $eventos->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

        return $this->render('organizarEventos', ["eventos" =>  $models, 'pages' => $pages,]);
    }
}
