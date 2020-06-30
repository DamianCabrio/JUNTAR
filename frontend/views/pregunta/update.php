<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Pregunta */

$this->title = 'Actualizar Pregunta';
?>
<div class="pregunta-update container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        "esAjax" => $esAjax,
    ]) ?>

</div>
