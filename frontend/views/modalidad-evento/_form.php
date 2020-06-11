<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ModalidadEvento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modalidad-evento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcionModalidad')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
