<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Evento */

$this->title = 'Actualizar Evento: ' . $model->nombreCortoEvento;
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idEvento, 'url' => ['view', 'id' => $model->idEvento]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="evento-update">
    <div class="col-12 mb-4 p-0">
        <div class="card">
            <h1 class="card-header text-center darkish_bg text-white"><?= Html::encode($this->title) ?></h1>
            <div class="card-body">
                <?=
                $this->render('_form', [
                    'model' => $model,
                ])
                ?>

            </div>
        </div>
    </div>
</div>
