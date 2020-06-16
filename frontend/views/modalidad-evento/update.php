<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ModalidadEvento */

$this->title = 'Update Modalidad Evento: ' . $model->idModalidadEvento;
$this->params['breadcrumbs'][] = ['label' => 'Modalidad Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idModalidadEvento, 'url' => ['view', 'id' => $model->idModalidadEvento]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="modalidad-evento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
