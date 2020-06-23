<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Evento */

$this->title = 'Actualizar Evento: ' . $model->idEvento;
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idEvento, 'url' => ['view', 'id' => $model->idEvento]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="evento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
