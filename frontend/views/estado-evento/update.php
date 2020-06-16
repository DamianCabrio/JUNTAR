<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\EstadoEvento */

$this->title = 'Update Estado Evento: ' . $model->idEstadoEvento;
$this->params['breadcrumbs'][] = ['label' => 'Estado Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idEstadoEvento, 'url' => ['view', 'id' => $model->idEstadoEvento]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="estado-evento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
