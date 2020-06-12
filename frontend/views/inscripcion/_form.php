<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Inscripcion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inscripcion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idUsuario')->textInput() ?>

    <?= $form->field($model, 'idEvento')->textInput() ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <?= $form->field($model, 'fechaPreInscripcion')->textInput() ?>

    <?= $form->field($model, 'fechaInscripcion')->textInput() ?>

    <?= $form->field($model, 'acreditacion')->textInput() ?>

    <?= $form->field($model, 'certificado')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
