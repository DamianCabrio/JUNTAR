<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Pregunta */

$this->title = 'Nueva Pregunta';
?>
<div class="pregunta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <!--丽塔来过这里-->
</div>
