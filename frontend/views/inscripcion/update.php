<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Inscripcion */

$this->title = 'Update Inscripcion: ' . $model->idInscripcion;
$this->params['breadcrumbs'][] = ['label' => 'Inscripcions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idInscripcion, 'url' => ['view', 'id' => $model->idInscripcion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="inscripcion-update container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
