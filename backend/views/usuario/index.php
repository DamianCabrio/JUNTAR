<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-index">

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <h1 class="card-header text-center darkish_bg text-white"> <?= Html::encode($this->title) ?> </h1>
                <p class="m-3">
                    <?= Html::a('Crear Usuario', ['/usuario/crear-usuario'], ['class' => 'btn btn-pink col-md-2 col-sm-12']) ?>
                </p>

                <div class="card-body">
                    <div class="table-responsive">
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
//        'options' => ['style' => 'width:100%;'],
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'nombre',
                                    'label' => 'Nombre',
                                    'value' => function($model) {
                                        return $model->nombre . " " . $model->apellido;
                                    },
                                ],
                                'dni',
                                'pais',
                                'provincia',
                                'localidad',
                                [
                                    'attribute' => 'email',
                                    'label' => 'Email',
                                    'value' => 'email',
                                ],
                                [
                                    'attribute' => 'status',
                                    'label' => 'Estado',
                                    'value' => function($model) {
                                        $estado = "";
                                        switch ($model->status) {
                                            case 0:
                                                $estado = "Deshabilitado";
                                                break;
                                            case 9:
                                                $estado = "Desactivado";
                                                break;
                                            case 10:
                                                $estado = "Activo";
                                                break;
                                            default:
                                                break;
                                        }
                                        return $estado;
                                    },
                                ],
                                [
                                    'attribute' => 'created_at',
                                    'label' => 'Fecha Registro',
                                    'value' => function($dataProvider) {
//                                        echo
                                        return date("d-m-Y H:i:s", $dataProvider->created_at);
                                    },
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
                                            return Html::a('<img class="filter-white" src="' . Yii::getAlias('@web/iconos/trash.svg') . '" alt="Borrar" width="20" height="20" title="Borrar" role="img">', ['/usuario/deshabilitar', 'id' => $model->idUsuario], ['class' => 'btn btn-pink']);
                                        }
                                    ]
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

