<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Fecha */

$this->title = 'Create Fecha';
$this->params['breadcrumbs'][] = ['label' => 'Fechas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fecha-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
