<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="presentacion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idEvento')->textInput() ?>

    <?= $form->field($model, 'tituloPresentacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcionPresentacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'horaInicioPresentacion')->textInput() ?>

    <?= $form->field($model, 'horaFinPresentacion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
