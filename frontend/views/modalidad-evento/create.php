<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ModalidadEvento */

$this->title = 'Create Modalidad Evento';
$this->params['breadcrumbs'][] = ['label' => 'Modalidad Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modalidad-evento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
