<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Usuario */

$this->title = 'Update Usuario: ' . $model->idUsuario;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idUsuario, 'url' => ['view', 'id' => $model->idUsuario]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usuario-update">


    <div class="card">
        <div class="card-header darkish_bg text-white">
            <h1><?= Html::encode($this->title) ?></h1>  
        </div>
        <div class="card-body">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>