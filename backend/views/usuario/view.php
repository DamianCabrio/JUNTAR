<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Usuario */

$this->title = "Usuario: " . $model->nombre . " " . $model->apellido;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuario-view">

    
    <div class="row">
        <div class="col-12 mb-4">
            <h1 class="card-header text-center darkish_bg text-white"> <?= Html::encode($this->title) ?> </h1>
        </div>
    </div>
    <p>
        <?= Html::a('Actualizar', ['/usuario/update', 'id' => $model->idUsuario], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Deshabilitar', ['/usuario/delete', 'id' => $model->idUsuario], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de querer deshabilitar este usuario?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>
    <div class="card">
        <div class="card-body">
        <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idUsuario',
            'nombre',
            'apellido',
            'dni',
            'pais',
            'provincia',
            'localidad',
            'email:email',
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
                'label' => 'Fecha Creación',
                'value' => date("Y-m-d H:i:s", $model->created_at), //valor referenciado
            ],
            [
                'attribute' => 'updated_at',
                'label' => 'Fecha Actualización',
                'value' => date("Y-m-d H:i:s", $model->updated_at), //valor referenciado
            ],
            'auth_key',
            'password_hash',
            'password_reset_token',
            'verification_token',
        ],
    ])
    ?>
        </div>
    </div>


</div>
