<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Evento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="evento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'idUsuario')->textInput() ?>

    <?= $form->field($model, 'idCategoriaEvento')->textInput() ?>

    <?= $form->field($model, 'idEstadoEvento')->textInput() ?>

    <?= $form->field($model, 'idModalidadEvento')->textInput() ?>

    <?= $form->field($model, 'nombreEvento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombreCortoEvento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcionEvento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lugar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fechaInicioEvento')->textInput() ?>

    <?= $form->field($model, 'fechaFinEvento')->textInput() ?>

    <?= $form->field($model, 'imgFlyer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imgLogo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'capacidad')->textInput() ?>

    <?= $form->field($model, 'preInscripcion')->textInput() ?>

    <?= $form->field($model, 'fechaLimiteInscripcion')->textInput() ?>

    <?= $form->field($model, 'codigoAcreditacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fechaCreacionEvento')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
