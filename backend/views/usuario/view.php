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
<div class="row usuario-view">

    <div class="col-8">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Actualizar', ['/usuario/update', 'id' => $model->idUsuario], ['class' => 'btn btn-primary']) ?>
            <?php
            if ($model->status == 10) {
                echo Html::a('Deshabilitar', ['/usuario/deshabilitar', 'id' => $model->idUsuario], [
                    'class' => 'btn btn-danger',
                    'data' => ['confirm' => '¿Está seguro de querer deshabilitar este usuario?',],]);
            } else {
                if ($model->status == 0) {
                    echo Html::a('Habilitar', ['/usuario/habilitar', 'id' => $model->idUsuario], [
                        'class' => 'btn btn-danger',
                        'data' => ['confirm' => '¿Está seguro de querer habilitar este usuario?',],]);
                }
            }
            ?>
        </p>

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
    <div class="col-4">
        <h3>Roles</h3>
        <ul class="list-group">
            <?php foreach ($roles as $rol): ?>
                <?php $assigned = yii::$app->authManager->getAssignment($rol->name, $model->idUsuario); ?>
                <li class="list-group-item list-group-flush">
                    <h4><?= $rol->name ?>
                        <?=
                        Html::a($assigned ? "Quitar" : "Agregar",
                                ['usuario/assign', 'id' => $model->idUsuario, 'rol' => $rol->name],
                                ['class' => $assigned ? "btn btn-sm btn-danger " : "btn btn-sm btn-primary"])
                        ?>
                        <small>
                            <p><?= $rol->description ?></p>
                        </small>
                    </h4>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</div>
