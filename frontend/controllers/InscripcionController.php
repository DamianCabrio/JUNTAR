<?php

namespace frontend\controllers;

use frontend\models\Pregunta;
use yii\filters\AccessControl;
use \yii\helpers\Url;
use Yii;
use frontend\models\Inscripcion;
use frontend\models\Evento;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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

    public function verificarDueño($idEvento) {

        $evento = Evento::find()->where(["idEvento" => $idEvento])->one();

        if($evento != null){
            if (!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario == $evento->idUsuario0->idUsuario) {
                return true;
            } else {
                return false;
            }
        }
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

    public function actionAnularInscripcion($idUsuario, $idEvento){
        $esDueño = $this->verificarDueño($idEvento);

        if($esDueño){
            $inscripcion = Inscripcion::find()->where(["idEvento" => $idEvento, "idUsuario" => $idUsuario])->one();
            $inscripcion->estado = 0;
            $inscripcion->save();

            return $this->redirect(Yii::$app->request->referrer);
        }else{
            return $this->goHome();
        }
    }

    public function actionInscribirAUsuario($idUsuario, $idEvento){

        $esDueño = $this->verificarDueño($idEvento);

        if($esDueño) {
            $inscripcion = Inscripcion::find()->where(["idEvento" => $idEvento, "idUsuario" => $idUsuario])->one();
            $inscripcion->estado = 1;
            $inscripcion->save();
            return $this->redirect(Yii::$app->request->referrer);
        }else{
                return $this->goHome();
            }
    }

    public function actionPreinscripcion()
    {
        if (Yii::$app->user->isGuest) {
            Url::remember();
            return Yii::$app->getResponse()->redirect(Url::to(['site/login'], 302));
        }

        //Guardo el parametro que llega por get (id del evento)
        $request = Yii::$app->request;
        $slug = $request->get('slug');


        //Busco en el campo preinscripcion en el evento
        $evento = Evento::find()->where(["nombreCortoEvento" => $slug])->one();
        $cupos = $this->calcularCupos($evento);

        if ($cupos != 0 || $cupos == null) {
            //Busco si ya existe una inscripcion anulada
            $inscripcion = Inscripcion::find()
                ->where(["idUsuario" => Yii::$app->user->identity->id, "idEvento" => $evento->idEvento])
                ->one();


            if($inscripcion != null){
                if($inscripcion->estado == 1 || $inscripcion->estado == 0) {
                    Yii::$app->session->setFlash('error', '<h2> Error </h2>'
                        . '<p> Ya se encuentra inscripto a este evento </p>');
                    return $this->redirect(['eventos/ver-evento/' . $slug]);
                }
            }else {
                //Si no existe creo un nueva instancia de inscripcion
                $inscripcion = new Inscripcion();
                $inscripcion->idUsuario = Yii::$app->user->identity->id;
                $inscripcion->idEvento = $evento->idEvento;
                $inscripcion->acreditacion = 0;
            }

            //Si requiere preinscripcion es true sino false
            $esPreInscripcion = $evento->preInscripcion == 1 ? true : false;


            if ($esPreInscripcion) {
                $inscripcion->estado = 0; //es una preinscripcion
                $inscripcion->fechaPreInscripcion = date("Y-m-d");
            } else {
                $inscripcion->estado = 1; // es una inscripcion directa
                $inscripcion->fechaPreInscripcion = date("Y-m-d");
                $inscripcion->fechaInscripcion = date("Y-m-d");
            }
            $seGuardo = $inscripcion->save();
            if ($seGuardo) {
                $texto = $esPreInscripcion ? "Se ha pre-inscripto con éxito" : "Se ha inscripto con éxito";
                Yii::$app->session->setFlash('success', '<h2>' . $texto . '</h2>'
                    . '<p> Buena suerte </p>');

                $preguntas = Pregunta::find()->where(["idEvento" => $evento->idEvento])->asArray()->all();
                if(count($preguntas) != 0){
                    return $this->redirect(['eventos/responder-formulario/' . $slug]);
                }else{
                    return $this->redirect(['eventos/ver-evento/' . $slug]);
                }
            } else {
                Yii::$app->session->setFlash('error', '<h2> Ocurrió un error </h2>'
                    . '<p> Por favor vuelva a intentar </p>');
                return $this->redirect(['eventos/ver-evento/' . $slug]);
            }
        }else{
            Yii::$app->session->setFlash('error', '<h2> No hay mas cupos </h2>'
                . '<p> Lo sentimos, no hay mas cupos. Intente con otro evento </p>');
            return $this->redirect(['eventos/ver-evento/' . $slug]);
        }
    }

    public function actionEliminarInscripcion(){
        if ( Yii::$app->user->isGuest ){
            $request = Yii::$app->request;
            $slug = $request->get('slug');
            return Yii::$app->getResponse()->redirect(Url::to(['evento/verEvento' . $slug],302));
        }

        $request = Yii::$app->request;
        $slug = $request->get('slug');
        $evento = Evento::find()->where(["nombreCortoEvento" => $slug])->one();

        $inscripcion = Inscripcion::find()
                        ->where(["idUsuario" => Yii::$app->user->identity->idUsuario, "idEvento" => $evento->idEvento])
                        ->one();

        if($inscripcion == null || $inscripcion->estado == 2){
            Yii::$app->session->setFlash('error', '<h2> Error</h2>'
                . '<p> Usted no esta inscripto en este evento </p>');
            return $this->redirect(['eventos/ver-evento/' . $slug]);
        }

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
