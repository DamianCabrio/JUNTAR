<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Fecha */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fecha-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idEvento')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
