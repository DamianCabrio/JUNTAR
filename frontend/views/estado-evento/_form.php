<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\EstadoEvento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estado-evento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcionEstado')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
