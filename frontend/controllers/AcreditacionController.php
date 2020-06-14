<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Evento;
use frontend\models\EventoSearch;
use frontend\models\Inscripcion;
use frontend\models\AcreditacionForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionAcreditacion(){
        $model = new AcreditacionForm();

        $request = Yii::$app->request;
        $idEvento = $request->get('id');
        $evento = Evento::find()->where(["idEvento" => $idEvento])->one();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($evento->codigoAcreditacion == $model->codigoAcreditacion) {
                $inscripcion = Inscripcion::find()->where(["idUsuario" => Yii::$app->user->identity->idUsuario, "idEvento" => $idEvento])->one();
                $inscripcion->acreditacion = 1;
                $inscripcion->save();
                Yii::$app->session->setFlash('success', '<h2> Acreditado. </h2>'
                    . '<p> Usted se acredito. </p>');
            } else {
                Yii::$app->session->setFlash('error', '<h2> Algo salió mal.. </h2> '
                    . '<p> El codigo que ingreso es erroneo, vuelva a intentar. </p>');
            }

            return $this->refresh();
        } else {
            return $this->render('acreditacion', [
                'model' => $model,
                'evento' => $evento,
            ]);
        }
    }
}
