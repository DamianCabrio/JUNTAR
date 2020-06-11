<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PresentacionExpositor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="presentacion-expositor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idExpositor')->textInput() ?>

    <?= $form->field($model, 'idPresentacion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
