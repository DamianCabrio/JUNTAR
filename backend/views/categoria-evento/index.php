<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategoriaEventoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categoria Eventos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-evento-index">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <h1 class="card-header text-center darkish_bg text-white"><?= Html::encode($this->title) ?></h1>

                <p class="m-3">
                    <?= Html::a('Crear nueva Categoria', ['create'], ['class' => 'btn btn-pink']) ?>
                </p>

                <div class="card-body">
                    <div class="table-responsive">
                        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
//                                'idCategoriaEvento',
                                [
                                    'attribute' => 'descripcionCategoria',
                                    'label' => 'Categoria',
                                    'value' => 'descripcionCategoria',
                                    'options' => ['class' => 'col-2']
                                ],
//                                'descripcionCategoria',
                                ['class' => 'yii\grid\ActionColumn',
                                    'buttons' => [
                                        'view' => function($url, $model) {
                                            return Html::a('<img class="filter-white" src="' . Yii::getAlias('@web/iconos/eye.svg') . '" alt="Visualizar" width="20" height="20" title="Visualizar" role="img">', $url, ['class' => 'btn btn-pink']);
                                        },
                                        'update' => function($url, $model) {
                                            return Html::a('<img class="filter-white" src="' . Yii::getAlias('@web/iconos/pencil.svg') . '" alt="Editar" width="20" height="20" title="Editar" role="img">', $url, ['class' => 'btn btn-pink']);
                                        },
                                        'delete' => function($url, $model) {
                                            return Html::a('<img class="filter-white" src="' . Yii::getAlias('@web/iconos/trash.svg') . '" alt="Borrar" width="20" height="20" title="Borrar" role="img">', $url, ['class' => 'btn btn-pink']);
                                        }
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
