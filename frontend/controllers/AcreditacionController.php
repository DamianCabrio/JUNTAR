<?php

namespace frontend\controllers;

use common\components\funciones;
use frontend\models\AcreditacionForm;
use frontend\models\Evento;
use frontend\models\Inscripcion;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * EventoController implements the CRUD actions for Evento model.
 */
class AcreditacionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors['access'] = [
            //Utilizamos el filtro AccessControl
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        //Guardamos la accion (vista) que se intenta acceder
                        $action = Yii::$app->controller->action->id;
                        //Guardamos el controlador del cual se consulta
                        $controller = Yii::$app->controller->id;
                        //Generamos la ruta que se busca acceder
                        $route = "$controller/$action";
                        //preguntamos si el usuario tiene los permisos para visitar el sitio
                        if (Yii::$app->user->can($route)) {
                            return true;
                        }
                    }
                ],
            ],
        ];

        return $behaviors;
    }


    public function actionAcreditacion($slug)
    {
        //Se utiliza el slug del url para encontrar el evento al que se quiere acreditar
        $evento = Evento::find()->where(["nombreCortoEvento" => $slug])->one();

        //Se verifica que el usuario no se haya inscripto ya
        $inscripcion = funciones::getEstaInscripto(Yii::$app->user->identity->idUsuario, $evento->idEvento);
        if (($inscripcion == null || $inscripcion->acreditacion == 1) && $evento->fechaInicioEvento <= date("Y-m-d")) {
            Yii::$app->session->setFlash('error', '<h2> Error </h2>'
                . '<p> Usted no se puede acreditar. </p>');
            return $this->redirect(['eventos/ver-evento/' . $slug]);
        } else {
            //Si la acreditacion se realiza por codigo qr se obtiene el codigo de acreditacion del url
            if ($codigo = Yii::$app->request->get('codigoAcreditacion')) {
                //Se verifica que el codigo de acreditacion ingresado sea el correcto
                $seVerifico = $this->verificarCodigo($codigo, $evento, $inscripcion);
                //Si la verificacion fue correcta se vuelve al usuario a la pagina del evento con un mensaje de éxito
                if ($seVerifico) {
                    return $this->redirect(['eventos/ver-evento/' . $slug]);
                }
                //Si la verificacion no fue correcta la pagina se actualizara con un mensaje de error
                return $this->refresh();
            }

            //Se crea el modelo del formulario de acreditacion
            $model = new AcreditacionForm();

            //Si la acreditacion se realiza escribiendo el codigo
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                //Se verifica que el codigo de acreditacion ingresado sea el correcto
                $seVerifico = $this->verificarCodigo($model->codigoAcreditacion, $evento, $inscripcion);
                //Si la verificacion fue correcta se vuelve al usuario a la pagina del evento con un mensaje de éxito
                if ($seVerifico) {
                    return $this->redirect(['eventos/ver-evento/' . $slug]);
                }
                //Si la verificacion no fue correcta la pagina se actualizara con un mensaje de error
                return $this->refresh();
            } else {
                //Se muestra la pagina para acreditar
                return $this->render('acreditacion', [
                    'model' => $model,
                    'evento' => $evento,
                ]);
            }
        }
    }

    private function verificarCodigo($codigoUsuario, $evento, $inscripcion)
    {
        //Se verifica que el codigo de acreditacion ingresado sea el correcto
        if ($evento->codigoAcreditacion == $codigoUsuario) {
            //Se guarda el resultado de acreditar en una variable
            $seAcredito = $this->acreditar($inscripcion);

            //Se verifica que el resultado de acreditacion sea "true", de lo contrario se muestra un error
            if ($seAcredito) {
                return true;
            } else {
                Yii::$app->session->setFlash('error', '<h2> Ocurrio un error </h2> '
                    . '<p> Por favor vuelva a intentar </p>');
            }
        } else {
            Yii::$app->session->setFlash('error', '<h2> El codigo ingresado es invalido </h2> '
                . '<p> Por favor vuelva a intentar </p>');
        }
        return false;
    }

    private function acreditar($inscripcion)
    {
        //El usuario es acreditado
        Yii::$app->session->setFlash('success', '<h2> Acreditado. </h2>'
            . '<p> Usted se acredito. </p>');
        $inscripcion->acreditacion = 1;
        $seGuardo = $inscripcion->save();

        return $seGuardo ? true : false;
    }

}
