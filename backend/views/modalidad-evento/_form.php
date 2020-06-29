<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\ModalidadEvento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modalidad-evento-form">
  <?php $form = ActiveForm::begin([

  ]); ?>

  <?= $form->field($model, 'descripcionModalidad')->textInput(['maxlength' => true]) ?>

  <div class="form-group">
      <?= Html::submitButton('Guardar', ['class' => 'btn btn-success ml-1']) ?>
  </div>

  <?php ActiveForm::end(); ?>
</div>
