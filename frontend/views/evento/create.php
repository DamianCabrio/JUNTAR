<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Evento */

$this->title = 'Create Evento';
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
