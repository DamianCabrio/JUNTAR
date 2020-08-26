<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PermisoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Permisos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permiso-index">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <h1 class="card-header text-center darkish_bg text-white"> <?= Html::encode($this->title) ?> </h1>

                <p class="m-3">
                    <?php echo Html::a('Nuevo Permiso', ['create-permiso'], ['class' => 'btn btn-pink col-md-2 col-sm-12']) ?>
                </p>

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
                                    'value' => 'name',
                                ],
                                [
                                    'attribute' => 'description',
                                    'label' => 'Descripción',
                                    'value' => 'description',
                                ],
                                [
                                    'attribute' => 'created_at',
                                    'label' => 'Fecha Creación',
                                    'value' => function ($dataProvider) {
                                        return date("Y-m-d H:i:s", $dataProvider->created_at);
                                    },
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action == "view") {
                                            return Url::to(['/permission/ver-permiso', 'name' => $key]);
                                        }
                                        if ($action == "delete") {
                                            return Url::to(['/permission/remove-permiso', 'name' => $key]);
                                        }
                                    },
                                    'buttons' => [
                                        'view' => function ($url, $model) {
                                            return Html::a('<img class="filter-white" src="' . Yii::getAlias('@web/iconos/eye.svg') . '" alt="Visualizar" width="20" height="20" title="Visualizar" role="img">', $url, ['class' => 'btn btn-pink']);
                                        },
                                        'delete' => function ($url, $model) {
                                            return Html::a('<img class="filter-white" src="' . Yii::getAlias('@web/iconos/trash.svg') . '" alt="Borrar" width="20" height="20" title="Borrar" role="img">', $url, ['class' => 'btn btn-pink']);
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
                                //Current Active option value
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