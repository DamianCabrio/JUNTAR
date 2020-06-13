<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\PresentacionExpositor */

$this->title = 'Update Presentacion Expositor: ' . $model->idExpositor;
$this->params['breadcrumbs'][] = ['label' => 'Presentacion Expositors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idExpositor, 'url' => ['view', 'idExpositor' => $model->idExpositor, 'idPresentacion' => $model->idPresentacion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="presentacion-expositor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
