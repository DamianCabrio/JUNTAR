<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PermisoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permiso-index">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <h1 class="card-header text-center darkish_bg text-white"> <?= Html::encode($this->title) ?> </h1>


                <?= Html::a('Nuevo Rol', ['create-rol'], ['class' => 'btn btn-primary ml-3 mt-3 col-2']) ?>
                <div class="card-body">
                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'name',
                                    'label' => 'Permiso',
                                    'value' => 'name', //valor referenciado
                                ],
                                [
                                    'attribute' => 'type',
                                    'label' => 'Tipo',
                                    'value' => function ($dataProvider) {
                                        return (($dataProvider->type == 2) ? "Permiso" : "Rol");
                                    },
                                ],
                                [
                                    'attribute' => 'description',
                                    'label' => 'Descripción',
                                    'value' => 'description', //valor referenciado
                                ],
                                [
                                    'attribute' => 'created_at',
                                    'label' => 'Fecha Creación',
                                    'value' => function ($dataProvider) {
                                        return date("Y-m-d H:i:s", $dataProvider->created_at);
                                    },
                                ],
                                [
                                    'attribute' => 'updated_at',
                                    'label' => 'Fecha Updated',
                                    'value' => function ($dataProvider) {
                                        return date("Y-m-d H:i:s", $dataProvider->updated_at);
                                    },
                                ],
                                //'created_at',
                                //'updated_at',
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action == "view") {
                                            return Url::to(['/rol/ver-rol', 'name' => $key]);
                                        }
                                        //                    if ($action == "update") {
                                        //                        return Url::to(['update-rol', 'name' => $key]);
                                        //                    }
                                        if ($action == "delete") {
                                            return Url::to(['/rol/remove-rol', 'name' => $key]);
                                        }
                                    },
                                    'buttons' => [
                                        'view' => function ($url, $model) {
                                            return Html::a('<img src="' . Yii::getAlias('@web/iconos/eye.svg') . '" alt="Visualizar" width="20" height="20" title="Visualizar" role="img">', $url, ['class' => 'btn']);
                                        },
                                        //                    'update' => function($url, $model) {
                                        //                        return Html::a('<img src="' . Yii::getAlias('@web/icons/pencil.svg') . '" alt="Editar" width="20" height="20" title="Editar" role="img">', $url, ['class' => 'btn']);
                                        //                    },
                                        'delete' => function ($url, $model) {
                                            return Html::a('<img src="' . Yii::getAlias('@web/iconos/trash.svg') . '" alt="Borrar" width="20" height="20" title="Borrar" role="img">', $url, [
                                                        'class' => 'btn',
                                                        'data' => [
                                                            'confirm' => '¿Está seguro de querer eliminar este Rol?',
                                                            'method' => 'post',
                                                        ],
                                            ]);
                                        },
                                    ],
                                    'header' => 'Acciones',
                                ],
                            ],
                            'pager' => [
                                'class' => '\yii\widgets\LinkPager',
                                // Css for each options. Links
                                'linkOptions' => ['class' => 'btn btn-light pageLink'],
                                'disabledPageCssClass' => 'btn disabled',
                                'options' => ['class' => 'pagination d-flex justify-content-center'],
                                'prevPageLabel' => 'Anterior',
                                'nextPageLabel' => 'Siguiente',
                                //                            Current Active option value
                                'activePageCssClass' => 'activePage',
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>