<?php

namespace frontend\controllers;

use \yii\helpers\Url;
use Yii;
use common\models\Inscripcion;
use common\models\InscripcionSearch;
use common\models\Evento;
use common\models\EventoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
     * Lists all Inscripcion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InscripcionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Inscripcion model.
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
     * Creates a new Inscripcion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Inscripcion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idInscripcion]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionPreinscripcion()
    {
        if ( Yii::$app->user->isGuest ){
            Url::remember();
            return Yii::$app->getResponse()->redirect(Url::to(['site/login'],302));
        }

        $request = Yii::$app->request;
        $idEvento = $request->get('id');

        $inscripcion = new Inscripcion();
        $inscripcion->idUsuario = Yii::$app->user->identity->idUsuario;
        $inscripcion->idEvento = $idEvento;
        $inscripcion->acreditacion = 0;

        $evento = Evento::find($idEvento)->select('preInscripcion')->one();
        $esPreInscripcion = $evento->preInscripcion == 1 ? true : false;

        if ($esPreInscripcion) {
            $inscripcion->estado = 0;
            $inscripcion->fechaPreInscripcion = date("Y-m-d");
        }
        else{
            $inscripcion->estado = 1;
            $inscripcion->fechaPreInscripcion = date("Y-m-d");
            $inscripcion->fechaInscripcion = date("Y-m-d");
        }
        $seGuardo = $inscripcion->save();
        return $this->render('resultadoInscripcion', [
            'esPreInscripcion' => $esPreInscripcion,
            'seGuardo' => $seGuardo,
        ]);
    }

    public function actionEliminarInscripcion(){
        if ( Yii::$app->user->isGuest ){
            Url::remember();
            return Yii::$app->getResponse()->redirect(Url::to(['site/login'],302));
        }
        $request = Yii::$app->request;
        $idEvento = $request->get('id');

        $inscripcion = Inscripcion::find()->where(["idUsuario" => Yii::$app->user->identity->id, "idEvento" => $idEvento])->one();
        $seElimino = $inscripcion->delete();

        return $this->render('resultadoDesinscripcion', [
            'seElimino' => $seElimino,
        ]);
    }

    /**
     * Updates an existing Inscripcion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idInscripcion]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Inscripcion model.
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