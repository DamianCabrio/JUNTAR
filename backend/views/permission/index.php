<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PermisoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Permisos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permiso-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Nuevo Permiso', ['create-permiso'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'type',
            'description:ntext',
            'rule_name',
            'data',
            //'created_at',
            //'updated_at',
            ['class' => 'yii\grid\ActionColumn',
                'urlCreator' => function($action, $model, $key, $index ) {
                    if ($action == "view") {
                        return Url::to(['ver-permiso', 'name' => $key]);
                    }
//                    if ($action == "update") {
//                        return Url::to(['update-permiso', 'name' => $key]);
//                    }
                    if ($action == "delete") {
                        return Url::to(['remove-permiso', 'name' => $key]);
                    }
                },
                'buttons' => [
                    'view' => function($url, $model) {
                        return Html::a('<img src="' . Yii::getAlias('@web/iconos/eye.svg') . '" alt="Visualizar" width="20" height="20" title="Visualizar" role="img">', $url, ['class' => 'btn']);
                    },
//                    'update' => function($url, $model) {
//                        return Html::a('<img src="' . Yii::getAlias('@web/icons/pencil.svg') . '" alt="Editar" width="20" height="20" title="Editar" role="img">', $url, ['class' => 'btn']);
//                    },
                    'delete' => function($url, $model) {
                        return Html::a('<img src="' . Yii::getAlias('@web/iconos/trash.svg') . '" alt="Borrar" width="20" height="20" title="Borrar" role="img">', $url, ['class' => 'btn']);
                    }
                ]
            ],
        ],
    ]);
    ?>


</div>
