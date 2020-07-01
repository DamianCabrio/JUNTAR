<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ModalidadEventoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Modalidades de los Eventos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modalidad-evento-index container">
    <div class="row">
        <div class="col-12 mb-4 p-0">
            <div class="card">
                <h1 class="card-header text-center darkish_bg text-white"> <?= Html::encode($this->title) ?> </h1>

                <p class="m-3">
                    <?= Html::a('Crear Modalidad', ['create'], ['class' => 'btn btn-pink col-md-2 col-sm-12']) ?>
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
                                    'attribute' => 'descripcionModalidad',
                                    'options' => ['class' => 'col-2']
                                ],
                                ['class' => 'yii\grid\ActionColumn',
                                    'buttons' => [
                                        'update' => function($url, $model) {
                                            return Html::a('<img class="filter-white" src="' . Yii::getAlias('@web/iconos/pencil.svg') . '" alt="Editar" width="20" height="20" title="Editar" role="img">', $url, ['class' => 'btn btn-pink']);
                                        },
                                        'view' => function($url, $model) {
                                            return Html::a('<img class="filter-white" src="' . Yii::getAlias('@web/iconos/eye.svg') . '" alt="Visualizar" width="20" height="20" title="Visualizar" role="img">', $url, ['class' => 'btn btn-pink']);
                                        },
                                        'delete' => function($url, $model) {
                                            return Html::a('<img class="filter-white" src="' . Yii::getAlias('@web/iconos/trash.svg') . '" alt="Borrar" width="20" height="20" title="Borrar" role="img">', $url, ['class' => 'btn btn-pink']);
                                        }
                                    ]
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
