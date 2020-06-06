<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Expositor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="expositor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idUsuario')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
