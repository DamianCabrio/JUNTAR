<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RespuestaFile */

$this->title = 'Update RespuestaFile: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Respuestas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="respuesta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
