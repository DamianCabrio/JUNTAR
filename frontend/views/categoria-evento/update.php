<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CategoriaEvento */

$this->title = 'Update Categoria Evento: ' . $model->idCategoriaEvento;
$this->params['breadcrumbs'][] = ['label' => 'Categoria Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idCategoriaEvento, 'url' => ['view', 'id' => $model->idCategoriaEvento]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="categoria-evento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
