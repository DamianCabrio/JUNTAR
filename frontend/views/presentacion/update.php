<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */

$this->title = 'Update Presentacion: ' . $model->idPresentacion;
$this->params['breadcrumbs'][] = ['label' => 'Presentacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idPresentacion, 'url' => ['view', 'id' => $model->idPresentacion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="presentacion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
