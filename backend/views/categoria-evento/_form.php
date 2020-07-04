<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoriaEvento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categoria-evento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcionCategoria')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-pink col-md-2 col-sm-12']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
