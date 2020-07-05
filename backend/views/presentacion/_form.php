<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Presentacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="presentacion-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="" style="display: none;">
      <?php if ($id != null): ?>
        <?= $form->field($model, 'idEvento')->textInput(['value' => $id,'maxlength' => true]) ?>
      <?php else: ?>
        <?= $form->field($model, 'idEvento')->textInput(['maxlength' => true]) ?>
      <?php endif; ?>
    </div>

    <?= $form->field($model, 'tituloPresentacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcionPresentacion')->textarea(['maxlength' => true, 'rows' => '10']) ?>

    <?= $form->field($model, 'diaPresentacion')->input('date', ['style' => 'width: auto']) ?>

    <?= $form->field($model, 'horaInicioPresentacion')->input('time', ['style' => 'width: auto']) ?>

    <?= $form->field($model, 'horaFinPresentacion')->input('time', ['style' => 'width: auto']) ?>

    <?= $form->field($model, 'linkARecursos')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-pink']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
