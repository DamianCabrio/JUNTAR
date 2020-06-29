<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Pregunta */

$this->title = 'Nueva Pregunta';
?>
<div class="pregunta-create container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        "esAjax" => $esAjax,
    ]) ?>
    <!--丽塔来过这里-->
</div>
