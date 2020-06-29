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
            <h1 class="card-header text-center darkish_bg text-white"> <?= Html::encode($this->title) ?> </h1>
        </div>
    </div>
    <p>
        <?= Html::a('Crear Usuario', ['/usuario/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
//        'options' => ['style' => 'width:100%;'],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'idUsuario',
            [
                'attribute' => 'nombre',
                'label' => 'Nombre',
                'value' => function($model) {
                    return $model->nombre . " " . $model->apellido;
                },
            ],
//            'nombre',
//            'apellido',
            'dni',
            'pais',
            'provincia',
            'localidad',
//            'email',
            [
                'attribute' => 'email',
                'label' => 'Email',
                'value' => 'email',
            ],
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
//            'status',
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
                    return date("Y-m-d H:i:s", $dataProvider->created_at);
                },
            ],
            //'created_at',
            //'updated_at',
            //'verification_token',
            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function($url, $model) {
                        return Html::a('<img src="' . Yii::getAlias('@web/iconos/pencil.svg') . '" alt="Editar" width="20" height="20" title="Editar" role="img">', $url, ['class' => 'btn']);
                    },
                    'view' => function($url, $model) {
                        return Html::a('<img src="' . Yii::getAlias('@web/iconos/eye.svg') . '" alt="Visualizar" width="20" height="20" title="Visualizar" role="img">', $url, ['class' => 'btn']);
                    },
                    'delete' => function($url, $model) {
                        return Html::a('<img src="' . Yii::getAlias('@web/iconos/trash.svg') . '" alt="Borrar" width="20" height="20" title="Borrar" role="img">', $url, ['class' => 'btn']);
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

