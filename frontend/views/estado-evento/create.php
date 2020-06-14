<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\EstadoEvento */

$this->title = 'Create Estado Evento';
$this->params['breadcrumbs'][] = ['label' => 'Estado Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estado-evento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
