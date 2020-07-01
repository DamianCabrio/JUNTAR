<?php

namespace backend\controllers;

use Yii;
use common\models\SolicitudAval;
use common\models\SolicitudAvalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * SolicitudAvalController implements the CRUD actions for SolicitudAval model.
 */
class SolicitudAvalController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
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
     * Lists all SolicitudAval models.
     * @return mixed
     */
    public function actionSolicitudesDeAval() {
        $seleccionado = "activas";
        $searchModel = new SolicitudAvalSearch();
        if(Yii::$app->request->get('selected') != null && Yii::$app->request->get('selected') != ''){
            $seleccionado = Yii::$app->request->get('selected');
        }
        switch ($seleccionado){
            case "denegadas":
//                $querySearchModel = $searchModel::find()->where(['is', 'tokenSolicitud', null])->andWhere(['avalado' => 0]);
                $querySearchModel = $searchModel::find()->where(['avalado' => 0]);
                break;
            case "aprobadas":
//                $querySearchModel = $searchModel::find()->where(['is', 'tokenSolicitud', null])->andWhere(['avalado' => 1]);
                $querySearchModel = $searchModel::find()->where(['avalado' => 1]);
                break;
            default:
                //activas
                $querySearchModel = $searchModel::find()->where(['not', ['tokenSolicitud' => null]])->andWhere(['is', 'avalado', null]);
                break;
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $querySearchModel,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('solicitudesDeAval', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'selected' => $seleccionado
        ]);
    }

    /**
     * Displays a single SolicitudAval model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }
    
    /**
     * Finds the Evento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Evento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
//    protected function findModelAval($id) {
//        if (($model = SolicitudAval::findOne(['idEvento' => $id])) !== null) {
//            return $model;
//        }
//
//        throw new NotFoundHttpException('El aval no existe.');
//    }
    
    public function actionConcederAval($id) {
        $this->findModel($id)->aprobar();
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionQuitarAval($id) {
        $this->findModel($id)->denegar();
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    

    /**
     * Finds the SolicitudAval model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SolicitudAval the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = SolicitudAval::findOne(['idEvento' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}