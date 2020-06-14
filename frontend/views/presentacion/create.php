<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */

$this->title = 'Create Presentacion';
$this->params['breadcrumbs'][] = ['label' => 'Presentacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="presentacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
