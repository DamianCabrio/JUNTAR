<?php

namespace common\controllers;

use Yii;
<<<<<<< HEAD
use common\models\Evento;
use common\models\EventoSearch;
=======
use common\models\evento;
use common\models\eventoSearch;
>>>>>>> c0503ad64a517a0a11aecb6b2fd47fe90b2ea636
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
<<<<<<< HEAD
 * EventoController implements the CRUD actions for Evento model.
=======
 * EventoController implements the CRUD actions for evento model.
>>>>>>> c0503ad64a517a0a11aecb6b2fd47fe90b2ea636
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
<<<<<<< HEAD
     * Lists all Evento models.
=======
     * Lists all evento models.
>>>>>>> c0503ad64a517a0a11aecb6b2fd47fe90b2ea636
     * @return mixed
     */
    public function actionIndex()
    {
<<<<<<< HEAD
        $searchModel = new EventoSearch();
=======
        $searchModel = new eventoSearch();
>>>>>>> c0503ad64a517a0a11aecb6b2fd47fe90b2ea636
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
<<<<<<< HEAD
     * Displays a single Evento model.
=======
     * Displays a single evento model.
>>>>>>> c0503ad64a517a0a11aecb6b2fd47fe90b2ea636
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
<<<<<<< HEAD
     * Creates a new Evento model.
=======
     * Creates a new evento model.
>>>>>>> c0503ad64a517a0a11aecb6b2fd47fe90b2ea636
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
<<<<<<< HEAD
        $model = new Evento();
=======
        $model = new evento();
>>>>>>> c0503ad64a517a0a11aecb6b2fd47fe90b2ea636

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idEvento]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
<<<<<<< HEAD
     * Updates an existing Evento model.
=======
     * Updates an existing evento model.
>>>>>>> c0503ad64a517a0a11aecb6b2fd47fe90b2ea636
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
<<<<<<< HEAD
     * Deletes an existing Evento model.
=======
     * Deletes an existing evento model.
>>>>>>> c0503ad64a517a0a11aecb6b2fd47fe90b2ea636
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
<<<<<<< HEAD
     * Finds the Evento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Evento the loaded model
=======
     * Finds the evento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return evento the loaded model
>>>>>>> c0503ad64a517a0a11aecb6b2fd47fe90b2ea636
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
<<<<<<< HEAD
        if (($model = Evento::findOne($id)) !== null) {
=======
        if (($model = evento::findOne($id)) !== null) {
>>>>>>> c0503ad64a517a0a11aecb6b2fd47fe90b2ea636
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
