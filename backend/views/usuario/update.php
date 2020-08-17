<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $model backend\models\Usuario */

$this->title = 'Actualizar datos de ' . $model->nombre . ' ' . $model->apellido;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre . ' ' . $model->apellido, 'url' => ['view', 'id' => $model->idUsuario]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usuario-update">

    <div class="card">
        <div class="card-header darkish_bg text-white text-center">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="row">
            <div class="col-md-8 col-sm-12 m-auto">
                <div class="card">
                    <div class="card-header darkish_bg text-white text-center mt-3">
                        <h4> Datos Usuario</h4>
                    </div>
                    <div class="card-body">
                        <?=
                        $this->render('_form', [
                            'model' => $model,
                        ])
                        ?>
                        <?php
                        Modal::begin([
                            'id' => 'modalChangePassword',
                            'size' => 'modal-lg',
                        ]);
                        Modal::end();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
