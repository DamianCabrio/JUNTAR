<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ModalidadEvento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modalidad-evento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcionModalidad')->textInput(['maxlength' => true])->label('Descripción: ') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-pink col-md-2 col-sm-12']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
