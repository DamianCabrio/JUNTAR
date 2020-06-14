<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CategoriaEvento */

$this->title = 'Create Categoria Evento';
$this->params['breadcrumbs'][] = ['label' => 'Categoria Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-evento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
