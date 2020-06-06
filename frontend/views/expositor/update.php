<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Expositor */

$this->title = 'Update Expositor: ' . $model->idExpositor;
$this->params['breadcrumbs'][] = ['label' => 'Expositors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idExpositor, 'url' => ['view', 'id' => $model->idExpositor]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="expositor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
