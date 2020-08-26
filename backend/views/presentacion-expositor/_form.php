<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PresentacionExpositor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="presentacion-expositor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idExpositor')->dropDownList(
        $users,
        [
            'id' => 'field-id',
            'size' => 10
        ]
    )->label('Expositor') ?>

    <div class="" style="display: none;">
        <?php if ($idPresentation != null): ?>
            <?= $form->field($model, 'idPresentacion')->textInput(['value' => $idPresentation]) ?>
        <?php else: ?>
            <?= $form->field($model, 'idPresentacion')->textInput(['maxlength' => true]) ?>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-pink']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
