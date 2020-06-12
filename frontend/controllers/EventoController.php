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
        $evento = Evento::find()->where(["idEvento" => $id])->one();
        $cantInscriptos = Inscripcion::find()->where(["idEvento" => $id])->count();

        $cupoMaximo = $evento->capacidad;

        $noHayCupos = false;
        if ($cantInscriptos >= $cupoMaximo) {
            $cupos = "No hay mas cupos";
            $noHayCupos = true;
        } else {
            $cupos = $cupoMaximo - $cantInscriptos;
        }

        if (!Yii::$app->user->getIsGuest()) {
            $inscripcion = Inscripcion::find()->where(["idUsuario" => Yii::$app->user->identity->idUsuario, "idEvento" => $id])->asArray()->all();

            $yaInscripto = false;
            $yaAcreditado = 0;
            if (count($inscripcion) == 1) {
                $yaInscripto = true;
                $yaAcreditado = $inscripcion[0]["acreditacion"];
            }

            return $this->render('view', [
                'model' => $this->findModel($id),
                "evento" => $evento,
                "yaInscripto" => $yaInscripto,
                "acreditacion" => $yaAcreditado,
                'cupos' => $cupos,
                "noHayCupos" => $noHayCupos,
            ]);
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
                "evento" => $evento,
                "yaInscripto" => false,
                "acreditacion" => false,
                'cupos' => $cupos,
                "noHayCupos" => $noHayCupos,
            ]);
        }
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
}