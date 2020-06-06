<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\PresentacionExpositor */

$this->title = 'Update Presentacion Expositor: ' . $model->idPresentacion;
$this->params['breadcrumbs'][] = ['label' => 'Presentacion Expositors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idPresentacion, 'url' => ['view', 'idPresentacion' => $model->idPresentacion, 'idExpositor' => $model->idExpositor]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="presentacion-expositor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
