<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Fecha */

$this->title = 'Update Fecha: ' . $model->idFecha;
$this->params['breadcrumbs'][] = ['label' => 'Fechas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idFecha, 'url' => ['view', 'id' => $model->idFecha]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fecha-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
