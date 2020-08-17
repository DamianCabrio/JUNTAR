<?php

namespace backend\controllers;

use common\models\SolicitudAval;
use common\models\SolicitudAvalSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SolicitudAvalController implements the CRUD actions for SolicitudAval model.
 */
class SolicitudAvalController extends Controller
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
                        //$module = Yii::$app->controller->module->id;
                        $action = Yii::$app->controller->action->id;        //guardamos la accion (vista) que se intenta acceder
                        $controller = Yii::$app->controller->id;            //guardamos el controlador del cual se consulta
                        // $route = "$module/$controller/$action";
                        $route = "$controller/$action";                     //generamos la ruta que se busca acceder
                        //$post = Yii::$app->request->post();
                        //preguntamos si el usuario tiene los permisos para visitar el sitio
                        //if (Yii::$app->user->can($route, ['post' => $post])) {
                        if (Yii::$app->user->can($route)) {
                            //return $this->goHome();
                            return true;
                        }
                    }
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * Lists all SolicitudAval models.
     * @return mixed
     */

    public function actionSolicitudesDeAval()
    {
        $estadoSolicitudes = "activas";
        $searchModel = new SolicitudAvalSearch();
        if (Yii::$app->request->get('estado') != null && Yii::$app->request->get('estado') != '') {
            $estadoSolicitudes = Yii::$app->request->get('estado');
        }
//        switch ($estadoSolicitudes){
//            case "activas":
//                //activas
//                $querySearchModel = $searchModel::find()->where(['not', ['tokenSolicitud' => null]])->andWhere(['is', 'avalado', null]);
//                break;
//            case "denegadas":
////                $querySearchModel = $searchModel::find()->where(['is', 'tokenSolicitud', null])->andWhere(['avalado' => 0]);
//                $querySearchModel = $searchModel::find()->where(['avalado' => 0]);
//                break;
//            case "aprobadas":
////                $querySearchModel = $searchModel::find()->where(['is', 'tokenSolicitud', null])->andWhere(['avalado' => 1]);
//                $querySearchModel = $searchModel::find()->where(['avalado' => 1]);
//                break;
//            default:
//                //activas
//                $querySearchModel = $searchModel::find()->where(['not', ['tokenSolicitud' => null]])->andWhere(['is', 'avalado', null]);
//                break;
//        }
//        $dataProvider = new ActiveDataProvider([
//            'query' => $querySearchModel,
//            'pagination' => [
//                'pageSize' => 20,
//            ],
//        ]);


        $dataProvider = $searchModel->search($estadoSolicitudes, Yii::$app->request->queryParams);

        return $this->render('solicitudesDeAval', [

            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'selected' => $estadoSolicitudes

        ]);
    }

    /**
     * Displays a single SolicitudAval model.
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

    public function actionConcederAval($id)
    {
        $this->findModel($id)->aprobar();
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDenegarAval($id)
    {
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
    protected function findModel($id)
    {
        if (($model = SolicitudAval::findOne(['idEvento' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }

}
