<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\PresentacionExpositor */

$this->title = 'Create Presentacion Expositor';
$this->params['breadcrumbs'][] = ['label' => 'Presentacion Expositors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="presentacion-expositor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
