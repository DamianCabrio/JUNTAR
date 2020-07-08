<?php

namespace frontend\controllers;

use common\models\SolicitudAval;
use Da\QrCode\QrCode;
use frontend\models\CategoriaEvento;
use frontend\models\Evento;
use frontend\models\FormularioForm;
use frontend\models\Inscripcion;
use frontend\models\InscripcionSearch;
use frontend\models\ModalidadEvento;
use frontend\models\Pregunta;
use frontend\models\PreguntaSearch;
use frontend\models\Presentacion;
use frontend\models\PresentacionExpositor;
use frontend\models\PresentacionSearch;
use frontend\models\RespuestaCorta;
use frontend\models\RespuestaFile;
use frontend\models\RespuestaLarga;
use frontend\models\RespuestaSearch;
use frontend\models\RespuestaTest;
use frontend\models\UploadFormFlyer;
use frontend\models\UploadFormLogo;
use frontend\models\Usuario;
use frontend\models\ImagenQR;
use frontend\models\ImagenEvento;
use frontend\models\ImagenEventoSearch;
use UI\Controls\Label;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

//Para contener la instacion de la imagen logo
//Para contener la instacion de la imagen flyer

/**
 * EventoController implements the CRUD actions for Evento model.
 */
class EventoController extends Controller {

    /**
     * {@inheritdoc}
     */
    //Funcion automatica para detectar los permisos
    public function behaviors() {
        $behaviors['access'] = [
            //utilizamos el filtro AccessControl
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'actions' => [
                        "ver-evento",
                        'verificar-solicitud',
                        'confirmar-solicitud',
                        'denegar-solicitud',
                        'mostrar-qr-evento',
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

    //Funcion para verificar si la persona que ingresa a un url es dueño del evento que quiere ver
    public function verificarDueño($model) {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario == $model->idUsuario0->idUsuario) {
            return true;
        } else {
            return false;
        }
    }

    //Funcion para mostrar las respuestas de un formulario de un evento
    public function actionRespuestasFormulario($slug) {
        //Se busca el evento
        $evento = $this->findModel("", $slug);

        //Se verifica si la persona ingresando a esta pagina es el dueño del evento cuyas respuestas quiere ver
        if ($this->verificarDueño($evento)) {

            //Se busca la tantidad de preguntas para verificar si hay preguntas para mostrar, si no hay preguntas la funcionalidad se desactiva
            $cantidadPreguntas = Pregunta::find()->where(["idEvento" => $evento->idEvento])->count();
            //Se busca la cantidad de inscriptos al evento para verificar si se muestra boton para enviar mail avisando de su inscripcion a esos inscriptos
            $cantidadInscriptos = Inscripcion::find()->where(["idEvento" => $evento->idEvento])
                            ->andWhere(["=", "estado", 1])
                            ->andWhere(["=", "acreditacion", 0])->count();

            //Seteo de variable que muestra si hay preguntas en el evento
            $hayPreguntas = false;
            if ($cantidadPreguntas != 0) {
                $hayPreguntas = true;
            }

            //Se crea el searchModel de los usuarios preinscriptos
            $usuariosSearchModel = new InscripcionSearch();
            $usuariosPreinscriptosDataProvider = new ActiveDataProvider([
                'query' => $usuariosSearchModel::find()->where(["idEvento" => $evento->idEvento, "estado" => 0])->andWhere(["<>", "acreditacion", 1]),
                'pagination' => false,
                'sort' => ['attributes' => ['name', 'description']]
            ]);

            //Se crea el searchModel de los usuarios inscriptos
            $usuariosInscriptosDataProvider = new ActiveDataProvider([
                'query' => $usuariosSearchModel::find()->where(["idEvento" => $evento->idEvento, "estado" => 1])->andWhere(["<>", "acreditacion", 1]),
                'pagination' => false,
                'sort' => ['attributes' => ['name', 'description']]
            ]);
            //Se retorna los datos a la vista
            return $this->render('respuestasFormulario',
                            ["preinscriptos" => $usuariosPreinscriptosDataProvider,
                                "inscriptos" => $usuariosInscriptosDataProvider,
                                "evento" => $evento, 'cantidadInscriptos' => $cantidadInscriptos,
                                "hayPreguntas" => $hayPreguntas]);
        } else {
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

        $model->idEstadoEvento = 4; //FLag - Por defecto los eventos quedan en estado "Borrador"
//        $model->avalado = 0; // Flag - Por defecto
        $model->fechaCreacionEvento = date('Y-m-d'); // Fecha de hoy

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

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

            if ($model->save()) {
                $nombreCortoEvento = $model->nombreCortoEvento;
                $idEvento = $model->idEvento;
                //generamos el codigo QR para visualizar el evento
                $QrEvento = new ImagenQR();
                $QrEvento->generarQREvento($nombreCortoEvento, $idEvento);
                //si se ingreso codigo de acreditación, se genera el correspondiente codigo qr para acreditarse
                if ($model->codigoAcreditacion != null) {
                    $codAcre = $model->codigoAcreditacion;
                    $QrAcreditacion = new ImagenQR();
                    $QrAcreditacion->generarQRAcreditacion($codAcre, $nombreCortoEvento, $idEvento);
                }
            }
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

    public function actionMostrarQrEvento() {
        if (Yii::$app->request->get('slug')) {
            //captura el slug
            $slug = Yii::$app->request->get('slug');
            $rutaImagenEventoQR = "";
            //busca el qr del evento
            $eventoQR = ImagenEvento::find()
                            ->innerJoin('evento', 'evento.idEvento=imagen_evento.idEvento')
                            ->where(['nombreCortoEvento' => $slug])
                            ->andWhere(['categoriaImagen' => 3])->one();
            //genera el enlace
            if ($eventoQR != null) {
                $rutaImagenEventoQR = Url::base(true) . "/" . $eventoQR->rutaArchivoImagen;
            }

            //setea nulo el enlace de acreditacion
            $rutaImagenAcreditacionEventoQR = "";
            $algoFeo = Evento::findOne(['nombreCortoEvento' => $slug]);
            if ($algoFeo != null) {
                if (!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario == $algoFeo->idUsuario) {
                    //si es el dueño del evento busca el qr de acreditacion
                    $eventoQR = ImagenEvento::find()
                                    ->innerJoin('evento', 'evento.idEvento=imagen_evento.idEvento')
                                    ->where(['nombreCortoEvento' => $slug])
                                    ->andWhere(['categoriaImagen' => 4])->one();
                    //genera la ruta del enlace al qr de acreditacion
                    if ($eventoQR != null) {
                        $rutaImagenAcreditacionEventoQR = Url::base(true) . "/" . $eventoQR->rutaArchivoImagen;
                    }
                }
            }
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('mostrarQrEvento', [
                            'imageEventoQR' => $rutaImagenEventoQR,
                            'imageAcreditacionEventoQR' => $rutaImagenAcreditacionEventoQR,
                            'slug' => $slug,
                ]);
            } else {
                return $this->render('mostrarQrEvento', [
                            'imageEventoQR' => $rutaImagenEventoQR,
                            'imageAcreditacionEventoQR' => $rutaImagenAcreditacionEventoQR,
                            'slug' => $slug,
                ]);
            }
        } else {
            return $this->goHome();
        }
    }

    public function actionNoJs() {
        return $this->render("noJs");
    }

    public function actionCrearFormularioDinamico($slug) {

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
        } else {
            throw new NotFoundHttpException('La página solicitada no existe.');
        }
    }

    public function actionResponderFormulario($slug) {
        $evento = $this->findModel("", $slug);
        $inscripcion = Inscripcion::find()->where(["idEvento" => $evento->idEvento, "idUsuario" => Yii::$app->user->identity->idUsuario])
                ->andWhere(["<>", "estado", 1])
                ->andWhere(["<>", "estado", 2])
                ->one();

        if ($inscripcion != null) {
            $preguntas = Pregunta::find()->where(["idEvento" => $evento->idEvento])->all();

            $respuestaYaHechas = [];
            $todasRespuestasHechas = true;
            foreach ($preguntas as $pregunta) {
                $respuesta = RespuestaSearch::find()->where(["idpregunta" => $pregunta->id, "idinscripcion" => $inscripcion->idInscripcion])->one();
                if ($respuesta == null) {
                    $todasRespuestasHechas = false;
                    array_push($respuestaYaHechas, false);
                } else {
                    array_push($respuestaYaHechas, $respuesta);
                }
            }

            $model = new RespuestaTest();
            if ($model->load(Yii::$app->request->post())) {
                foreach ($respuestaYaHechas as $i => $respuestaYaHecha) {
                    if ($respuestaYaHecha == false) {
                        if ($preguntas[$i]->tipo == 1) {
                            $modeloRespuesta = new RespuestaCorta();
                            $modeloRespuesta->respuesta = $model->respuestaCorta[$i];
                        } else if ($preguntas[$i]->tipo == 2) {
                            $modeloRespuesta = new RespuestaLarga();
                            $modeloRespuesta->respuesta = $model->respuesta[$i];
                        } else if ($preguntas[$i]->tipo == 3) {
                            $modeloRespuesta = new RespuestaFile();
                            $modeloRespuesta->file = UploadedFile::getInstance($model, "file[$i]");
                            $modeloRespuesta->respuesta = "/eventos/formularios/archivos/" . $modeloRespuesta->file->baseName . '.' . $modeloRespuesta->file->extension;
                            $modeloRespuesta->upload();
                        }
                        $modeloRespuesta->idinscripcion = $inscripcion->idInscripcion;
                        $modeloRespuesta->idpregunta = $preguntas[$i]->id;

                        if ($preguntas[$i]->tipo == 3) {
                            $modeloRespuesta->save(false);
                        } else {
                            if ($modeloRespuesta->validate()) {
                                $modeloRespuesta->save();
                            } else {
                                return "Errores:" . print_r($modeloRespuesta->errors);
                            }
                        }
                    }
                }
                Yii::$app->session->setFlash('success', '<h2> Se han enviado sus respuestas </h2>'
                        . '<p> ¡Mucha suerte!. </p>');
                return $this->redirect(Url::toRoute(["eventos/ver-evento/" . $evento->nombreCortoEvento]));
            }

            return $this->render('responderFormulario',
                            ["preguntas" => $preguntas,
                                "evento" => $evento,
                                "idInscripcion" => $inscripcion->idInscripcion,
                                "respuestaYaHechas" => $respuestaYaHechas,
                                "todasRespuestasHechas" => $todasRespuestasHechas,
                                "model" => $model,]);
        } else {
            return $this->goHome();
        }
    }

    /**
     * Recibe por parámetro un id, se busca esa instancia del event y se obtienen todos las presentaciones que pertenecen a ese evento.
     * Se envia la instancia del evento junto con todas la presentaciones sobre un arreglo.
     */
    public function actionVerEvento($slug, $token = null) {

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

        $inscripcion = null;
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

        //$validarEmail = new validateEmail();
        if (isset($evento->solicitudAval['avalado'])) {
            $esFai = $evento->solicitudAval['avalado'] == null ? false : true;
        } else {
            $esFai = false;
        }
        $esDueño = $this->verificarDueño($evento);
        $esAdministrador = $this->verificarAdministrador($evento);

        if ($token != null) {
            if (SolicitudAval::findOne(['tokenSolicitud' => $token]) != null) {
                $solicitud = $token;
            } else {
                $solicitud = false;
            }
        } else {
            $solicitud = false;
        }
        $solicitudAval = SolicitudAval::findOne(['idEvento' => $evento->idEvento]);
        if ($solicitudAval != null) {
            $estadoAval = $solicitudAval;
        } else {
            $estadoAval = 'no solicitado';
        }

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
                    'verificacionSolicitud' => $solicitud,
                    'estadoAval' => $estadoAval,
                    "inscripcion" => $inscripcion,
        ]);
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

    public function obtenerEstadoEvento($evento, $yaInscripto = false, $yaAcreditado = false, $cupos, $tipoInscripcion) {

        // ¿Ya esta inscripto o no? - Si
        if ($yaInscripto) {
            // ¿El evento ya inicio? - Si
            if ($evento->fechaInicioEvento <= date("Y-m-d") || $evento->idEstadoEvento == 3) {
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
            if ($cupos == 0 && !is_null($cupos)) {
                return "sinCupos";
                // Hay cupos en el evento
            } else {
                // ¿La fecha actual es menor a la fecha limite de inscripcion? - Si
                // ¿El evento tiene pre inscripcion activada? - Si
                if ($evento->preInscripcion == 1) {
                    if ($evento->fechaLimiteInscripcion == null || $evento->fechaLimiteInscripcion == '1969-12-31') {
                        if ($evento->fechaInicioEvento >= date("Y-m-d")) {
                            return "puedeInscripcion";
                        } else {
                            return "noInscriptoYFechaLimiteInscripcionPasada";
                        }
                        // El evento no tiene pre inscripcion
                    } else {
                        if ($evento->fechaInicioEvento >= date("Y-m-d")) {
                            return "puedeInscripcion";
                        } else {
                            return "noInscriptoYFechaLimiteInscripcionPasada";
                        }
                        // El evento no tiene pre inscripcion
                    }
                }
            }
        }
    }

    public function obtenerEstadoEventoNoLogin($cupos, $evento) {
        if (($evento->fechaLimiteInscripcion != null && $evento->fechaLimiteInscripcion >= date("Y-m-d"))) {
            if ($cupos !== 0 || is_null($cupos)) {
                return $evento->preInscripcion == 0 ? "puedeInscripcion" : "puedePreinscripcion";
            } else {
                return "sinCupos";
            }
        } elseif ($evento->fechaLimiteInscripcion == null && $evento->fechaInicioEvento >= date("Y-m-d")) {
            return $evento->preInscripcion == 0 ? "puedeInscripcion" : "puedePreinscripcion";
        } else {
            return "noInscriptoYFechaLimiteInscripcionPasada";
        }
    }

    public function verificarAdministrador($model) {


        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario) {
            $query = new Query();
            $rows = $query->from('usuario_rol')
                            ->andWhere(['user_id' => Yii::$app->user->identity->idUsuario])
                            ->andWhere(['item_name' => 'Administrador'])->all();


            if (count($rows) == 0) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Recibe por parámetro un id de evento, se buscar y se obtiene la instancia del evento, se visualiza un formulario
     * cargado con los datos del evento permitiendo cambiar esos datos.
     * Una vez reallizado con cambios, se visualiza un mensaje de exito sobre una vista.
     */
    public function actionEditarEvento($slug) {

        $model = $this->findModel("", $slug);

        $modelLogo = new UploadFormLogo();
        $modelFlyer = new UploadFormFlyer();

        $rutaLogo = (Yii::getAlias("@rutaLogo"));
        $rutaFlyer = (Yii::getAlias("@rutaFlyer"));
        $codigoAcredInicial = $model->codigoAcreditacion;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
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

            if ($model->save()) {
                //asignamos el nombreCorto para enviar un valor al metodo
                $nombreCortoEvento = $slug;
                $idEvento = $model->idEvento;
                if ($model->nombreCortoEvento != $slug) {
                    //si el nombreCorto cargado en el model es disinto al slug que teniamos, se asigna el nuevo nombreCorto
                    $nombreCortoEvento = $model->nombreCortoEvento;
                    //generamos el codigo QR para visualizar el evento
                    $QrEvento = new ImagenQR();
                    $QrEvento->updateQREvento($nombreCortoEvento, $idEvento);

                    $codAcre = $model->codigoAcreditacion;
                    $QrAcreditacion = new ImagenQR();
                    $QrAcreditacion->updateQRAcreditacion($codAcre, $nombreCortoEvento, $idEvento);
                }
//                $this->actionGenerarQREvento($nombreCortoEvento);
                if ($model->codigoAcreditacion != null && $codigoAcredInicial != $model->codigoAcreditacion) {
                    //si se ingreso codigo de acreditación, se genera el correspondiente codigo qr para acreditarse
                    $codAcre = $model->codigoAcreditacion;
                    $QrAcreditacion = new ImagenQR();
                    $QrAcreditacion->updateQRAcreditacion($codAcre, $nombreCortoEvento, $idEvento);
                }
            }
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
    public function actionPublicarEvento($slug) {
        $model = $this->findModel("", $slug);
        $model->idEstadoEvento = 1;  //FLag - Estado de evento activo
        $model->save();


        return $this->redirect(['eventos/ver-evento/' . $model->nombreCortoEvento]);
    }

    /**
     * Recibe por parametro un id de un evento, buscar ese evento y setea en la instancia $model.
     * Cambia en el atributo fechaCreacionEvento por null, y en el
     * atributo idEstadoEvento por el valor 4.
     */
    public function actionSuspenderEvento($slug) {
        $model = $this->findModel("", $slug);
        $model->idEstadoEvento = 4;  //Flag  - Estado de evento borrador
        $model->save();


        return $this->redirect(['eventos/ver-evento/' . $model->nombreCortoEvento]);
    }

    public function actionFinalizarEvento($slug) {
        $model = $this->findModel("", $slug);
        $model->idEstadoEvento = 3;  //Flag  - Estado de evento finalizado
        $model->save();

        return $this->redirect(['eventos/ver-evento/' . $model->nombreCortoEvento]);
    }

    public function actionCargarExpositor($idPresentacion) {
        $model = new PresentacionExpositor();
        $objPresentacion = Presentacion::findOne($idPresentacion);
        $objEvento = Evento::findOne($objPresentacion->idEvento);

        if ($model->load(Yii::$app->request->post())) {
            $model->idPresentacion = $idPresentacion;
            $model->save();
            return $this->redirect(['eventos/ver-evento/' . $objEvento->nombreCortoEvento]);
        }

        $usuarios = Usuario::find()
                ->select(["CONCAT(nombre,' ',apellido) as value", "CONCAT(nombre,' ',apellido)  as  label", "idUsuario as idUsuario"])
                ->asArray()
                ->all();

        if (Yii::$app->request->isAjax) {
            //retorna renderizado para llamado en ajax
            return $this->renderAjax('cargarExpositor', [
                        'model' => $model,
                        'objetoEvento' => $objEvento,
                        'usuarios' => $usuarios,
            ]);
        } else {
            return $this->render('cargarExpositor', [
                        'model' => $model,
                        'objetoEvento' => $objEvento,
                        'usuarios' => $usuarios,
            ]);
        }
    }

    public function actionListaParticipantes() {
        $request = Yii::$app->request;
        $idEvento = $request->get('idEvento');
        $extension = $request->get('extension');

        $evento = Evento::findOne($idEvento);

        $datosDelEvento['idEvento'] = $idEvento;
        $datosDelEvento['organizador'] = $evento->idUsuario0->nombre . " " . $evento->idUsuario0->apellido;
        $datosDelEvento['inicio'] = $evento->fechaInicioEvento;
        $datosDelEvento['fin'] = $evento->fechaFinEvento;
        $datosDelEvento['nombre'] = $evento->nombreEvento;
        $datosDelEvento['capacidad'] = $evento->capacidad;
        $datosDelEvento['lugar'] = $evento->lugar;
        $datosDelEvento['modalidad'] = $evento->idModalidadEvento0->descripcionModalidad;

        $base = Inscripcion::find();
        $base->innerJoin('usuario', 'usuario.idUsuario=inscripcion.idUsuario');
        $base->select(['user_estado' => 'inscripcion.estado',
            'user_acreditacion' => 'inscripcion.acreditacion',
            'user_idInscripcion' => 'inscripcion.idInscripcion',
            'user_apellido' => 'usuario.apellido',
            'user_nombre' => 'usuario.nombre',
            'user_dni' => 'usuario.dni',
            'user_pais' => 'usuario.pais',
            'user_provincia' => 'usuario.provincia',
            'user_localidad' => 'usuario.localidad',
            'user_email' => 'usuario.email',
            'user_fechaPreInscripcion' => 'inscripcion.fechaPreInscripcion',
            'user_fechaInscripcion' => 'inscripcion.fechaInscripcion']);


        $participantes = $base->where(['inscripcion.idEvento' => $idEvento])->orderBy('usuario.apellido ASC')->asArray()->all();
        $preguntas = Pregunta::find()->where(['idevento' => $idEvento])->asArray()->all();


        $listaRepuesta = "";

        $listaRepuesta = array();

        foreach ($participantes as $unParticipante) {

            $base = RespuestaFile::find();
            $base->innerJoin('pregunta', 'respuesta.idpregunta=pregunta.id');
            $base->select(['pregunta_tipo' => 'pregunta.tipo', 'respuesta_user' => 'respuesta']);
            $respuestas = $base->where(['respuesta.idinscripcion' => $unParticipante['user_idInscripcion']])->asArray()->all();

            $listaRepuesta[] = ['unParticipante' => $unParticipante, 'respuestas' => $respuestas];
        }


        return $this->renderPartial('listaParticipantes',
                        ['datosDelEvento' => $datosDelEvento,
                            'preguntas' => $preguntas, 'listaRepuesta' => $listaRepuesta, 'extension' => $extension]);
    }

    public function actionEnviarEmailInscriptos() {
        $request = Yii::$app->request;
        $idEvento = $request->get('idEvento');

        $evento = Evento::findOne(['idEvento' => $idEvento]);

///        $base->select(['user_email'=>'usuario.email','user_apellido'=>'usuario.apellido','user_nombre'=>'usuario.nombre']);

        $base = Inscripcion::find();
        $base->innerJoin('usuario', 'usuario.idUsuario=inscripcion.idUsuario');
        $base->select(['user_email' => 'usuario.email', 'user_apellido' => 'usuario.apellido', 'user_nombre' => 'usuario.nombre']);
        $listaInscriptos = $base->andWhere(["=", "inscripcion.estado", 1])
                        ->andWhere(["=", "inscripcion.acreditacion", 0])
                        ->andWhere(["=", "inscripcion.idEvento", $idEvento])
                        ->asArray()->all();

        $emails = array();

        foreach ($listaInscriptos as $unInscripto) {
            $emails[] = $unInscripto['user_email'];
        }

        Yii::$app->mailer
                ->compose(
                        ['html' => 'confirmacionDeInscripcion-html'],
                        ['evento' => $evento]
                )
                ->setFrom([Yii::$app->params['supportEmail'] => 'No-reply @ ' . Yii::$app->name])
                ->setBcc($emails)
                ->setSubject('Inscripción el Evento: ' . $evento->nombreEvento)
                ->send();

        Yii::$app->session->setFlash('success', '<h3> ¡Se han enviado los correos a los inscriptos! </h3>');

        return $this->redirect(Url::toRoute(["eventos/respuestas-formulario/" . $evento->nombreCortoEvento]));
    }

    public function actionCrearEmail($slug) {
        $participantes = [1 => 'Pre-inscriptos', 2 => 'Inscriptos', 3 => 'Expositores', 4 => 'Todos'];
        $evento = Evento::findOne(['nombreCortoEvento' => $slug]);
        $idEvento = $evento->idEvento;

        return $this->render('crearEmail', ['idEvento' => $idEvento, 'participantes' => $participantes]);
    }

    public function actionEnviarEmail() {

        $request = Yii::$app->request;

        $idEvento = $request->post('idEvento');
        $evento = Evento::findOne(['idEvento' => $idEvento]);

        $asunto = $request->post('asunto');
        $para = $request->post('para');
        $mensaje = $request->post('mensaje');
        $grupo = "";


        switch ($para) {

            case 1: ///  1: preinscripto
                $participantes = $this->actionObtenerPrinscriptos($idEvento);
                if (count($participantes) >= 1) {
                    $this->actionEventoEmail($participantes, $asunto, $mensaje, 'enviarEmail-html');
                    $grupo = "Pre-inscriptos";
                }
                break;

            case 2: //  2: inscripto  
                $participantes = $this->actionObtenerInscriptos($idEvento);
                if (count($participantes) >= 1) {
                    $this->actionEventoEmail($participantes, $asunto, $mensaje, 'enviarEmail-html');
                    $grupo = "Inscriptos";
                }
                break;

            case 3: //  3:'Expositores' 
                $participantes = $this->actionObtenerExpositores($idEvento);
                if (count($participantes) >= 1) {
                    $this->actionEventoEmail($participantes, $asunto, $mensaje, 'enviarEmail-html');
                    $grupo = "Expositores";
                }

                break;

            case 4: //   4:'Todos',     
                $prinscriptos = $this->actionObtenerPrinscriptos($idEvento);
                if (count($prinscriptos) >= 1) {
                    $this->actionEventoEmail($prinscriptos, $asunto, $mensaje, 'enviarEmail-html');
                }

                $inscriptos = $this->actionObtenerInscriptos($idEvento);
                if (count($inscriptos) >= 1) {
                    $this->actionEventoEmail($inscriptos, $asunto, $mensaje, 'enviarEmail-html');
                }

                $expositores = $this->actionObtenerExpositores($idEvento);
                if (count($inscriptos) >= 1) {
                    $this->actionEventoEmail($expositores, $asunto, $mensaje, 'enviarEmail-html');
                }
                $grupo = "Todos";

                break;
        }


        Yii::$app->session->setFlash('success', '<h3> ¡Se ha enviado el correo a ' . $grupo . '</h3>');

        return $this->redirect(Url::toRoute(["eventos/crear-email/" . $evento->nombreCortoEvento]));
    }

    public function actionObtenerPrinscriptos($idEvento) {
        $base = Inscripcion::find()->innerJoin('usuario', 'usuario.idUsuario=inscripcion.idUsuario');
        $base->select(['user_email' => 'usuario.email']);
        $base->andWhere(["=", "inscripcion.estado", 0])
                ->andWhere(["=", "inscripcion.idEvento", $idEvento])->asArray()->all();
        $participantes = $base->asArray()->all();
        return $participantes;
    }

    public function actionEventoEmail($participantes, $asunto, $mensaje, $plantilla) {
        $emailsTo = [];
        foreach ($participantes as $unParticipante) {
            array_push($emailsTo, $unParticipante['user_email']);
        }

        Yii::$app->mailer
                ->compose(['html' => $plantilla], ['mensaje' => $mensaje])
                ->setFrom([Yii::$app->params['supportEmail'] => 'No-reply @ ' . Yii::$app->name])
                ->setBcc($emailsTo)
                ->setSubject($asunto)
                ->send();
    }

    public function actionObtenerInscriptos($idEvento) {
        $base = Inscripcion::find()->innerJoin('usuario', 'usuario.idUsuario=inscripcion.idUsuario');
        $base->select(['user_email' => 'usuario.email']);
        $base->andWhere(["=", "inscripcion.estado", 1])
                ->andWhere(["=", "inscripcion.acreditacion", 0])
                ->andWhere(["=", "inscripcion.idEvento", $idEvento]);
        $participantes = $base->asArray()->all();
        return $participantes;
    }

    public function actionObtenerExpositores($idEvento) {
        $base = Inscripcion::find()->where(["idEvento" => $idEvento]);
        $base->innerJoin('presentacion_expositor', 'presentacion_expositor.idExpositor=inscripcion.idUsuario');
        $base->innerJoin('usuario', 'usuario.idUsuario=inscripcion.idUsuario');

        $base->select(['user_email' => 'usuario.email']);
        $participantes = $base->andWhere(["=", "inscripcion.estado", 1])->asArray()->all();
        return $participantes;
    }

    public function actionOrganizarEventos() {
        $idUsuario = Yii::$app->user->identity->idUsuario;

        $request = Yii::$app->request;
        $busqueda = $request->get("s", "");
        $estadoEvento = $request->get("estadoEvento", "");


        if ($estadoEvento != "") {
            if ($estadoEvento == 0) {
                $estado = 1; // activo
            }
            if ($estadoEvento == 1) {
                $estado = 4; // suspendido
            }
            if ($estadoEvento == 2) {
                $estado = 3; // finalizado
            }
        }

        if ($estadoEvento != "") {
            $eventos = Evento::find()
                    ->where(["idUsuario" => $idUsuario])
                    ->andwhere(["like", "idEstadoEvento", $estado]);
            if ($busqueda != "") {
                $eventos = Evento::find()
                        ->where(["idUsuario" => $idUsuario])
                        ->andwhere(["like", "nombreEvento", $busqueda]);
            }
        } else {
            $eventos = Evento::find()->where(["idUsuario" => $idUsuario])->andwhere(["idEstadoEvento" => 1]); // por defecto mostrar los eventos propios que son activos
        }

        //Paginación para 6 eventos por pagina
        $countQuery = clone $eventos;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->pageSize = 6;
        //$pages->applyLimit = $countQuery->count();
        $models = $eventos->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

        return $this->render('organizarEventos', ["eventos" => $models, 'pages' => $pages,]);
    }

    /**
     * Recibe por parámetro un token, carga el Evento buscando el token y verificar sin necesidad
     * loguearse el usuario.
     */
    public function actionVerificarSolicitud($token) {
        $solicitud = SolicitudAval::findOne(['tokenSolicitud' => $token]);
        if ($solicitud != null) {
            $solicitud->avalado = 1;
            $solicitud->fechaRevision = Yii::$app->formatter->asDatetime('now', 'yyyy-MM-dd H:m');
            $solicitud->tokenSolicitud = null;
            $evento = Evento::findOne(['idEvento' => $solicitud->idEvento]);
            if ($solicitud->validate()) {
                $solicitud->save();
                Yii::$app->session->setFlash('success', '<small>Evento Confirmado</small>');
                return $this->redirect('/eventos/ver-evento/' . $evento->nombreCortoEvento);
            } else {
                Yii::$app->session->setFlash('error', '<small>Se ha producido un error a al confirmar</small>');
                return $this->redirect('/eventos/ver-evento/' . $evento->nombreCortoEvento);
            }
        }
    }

    /**
     * Recibe por parametro el id de un evento y envio del Correo para la confirmacion a los validadores.
     */
    public function actionEnviarSolicitudEvento($id) {
        $solicitud = new SolicitudAval();
        $solicitud->idEvento = $id;
        $solicitud->fechaSolicitud = Yii::$app->formatter->asDatetime('now', 'yyyy-MM-dd H:m');
        $solicitud->generateRequestToken();
        if ($solicitud->validate()) {
            $solicitud->save();
            $solicitud->sendEmail();
            Yii::$app->session->setFlash('success', '<small>Solicitud Enviada</small>');
            return $this->goBack(Yii::$app->request->referrer);
        }
    }

    /**
     * Recibe por parametro el id un evento o el token único, buscar ese evento y setea en la instancia $solicitud.
     * Cambia el estado de avalado a 1 y null al atributo tokenSolicitud.
     */
    public function actionConfirmarSolicitud($token = null, $id = null) {
        if ($id != null) {
            $solicitud = SolicitudAval::findOne(['idEvento' => $id]);
            if ($solicitud != null) {
                $evento = $this->confirmarAval($solicitud);
                return $this->redirect('/eventos/ver-evento/' . $evento->nombreCortoEvento);
            }
        }
        if ($token != null) {
            $solicitud = SolicitudAval::findOne(['tokenSolicitud' => $token]);
            if ($solicitud != null) {
                $evento = $this->confirmarAval($solicitud);
                return $this->redirect('/eventos/ver-evento/' . $evento->nombreCortoEvento);
            }
        } else {
            return $this->goHome();
        }
    }

    private function confirmarAval($solicitud) {
        $solicitud->avalado = 1;
        $solicitud->fechaRevision = Yii::$app->formatter->asDatetime('now', 'yyyy-MM-dd H:m');
        if (Yii::$app->user->can('Validador')) {
            $solicitud->validador = Yii::$app->user->identity->id;
        } else {
            $solicitud->validador = null;
        }
        $solicitud->tokenSolicitud = null;
        $evento = Evento::findOne(['idEvento' => $solicitud->idEvento]);
        if ($solicitud->validate()) {
            $solicitud->save();
            Yii::$app->session->setFlash('success', '<small>Evento Confirmado</small>');
            return $evento;
        } else {
            Yii::$app->session->setFlash('error', '<small>Se ha producido un error a al confirmar</small>');
            return $evento;
        }
    }

    /**
     * Recibe por parametro el id un evento o el token único, buscar ese evento y setea en la instancia $solicitud.
     * Cambia el estado de avalado a 0 y null al atributo tokenSolicitud.
     */
    public function actionDenegarSolicitud($token = null, $id = null) {
        if ($id != null) {
            $solicitud = SolicitudAval::findOne(['idEvento' => $id]);
            if ($solicitud != null) {
                $evento = $this->denegarAval($solicitud);
                return $this->redirect('/eventos/ver-evento/' . $evento->nombreCortoEvento);
            }
        }
        if ($token != null) {
            $solicitud = SolicitudAval::findOne(['tokenSolicitud' => $token]);
            if ($solicitud != null) {
                $evento = $this->denegarAval($solicitud);
                return $this->redirect('/eventos/ver-evento/' . $evento->nombreCortoEvento);
            }
        } else {
            return $this->goHome();
        }
    }

    private function denegarAval($solicitud) {
        $solicitud->avalado = 0;
        $solicitud->fechaRevision = Yii::$app->formatter->asDatetime('now', 'yyyy-MM-dd H:m');
        if (Yii::$app->user->can('Validador')) {
            $solicitud->validador = Yii::$app->user->identity->id;
        } else {
            $solicitud->validador = null;
        }
        $solicitud->tokenSolicitud = null;
        $evento = Evento::findOne(['idEvento' => $solicitud->idEvento]);
        if ($solicitud->validate()) {
            $solicitud->save();
            Yii::$app->session->setFlash('success', '<small>Evento Denegado</small>');
            return $evento;
        } else {
            Yii::$app->session->setFlash('error', '<small>Se ha producido un error a al confirmar</small>');
            return $evento;
        }
    }

}
