<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Evento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="evento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // echo $form->field($model, 'idUsuario')->textInput() ?>

    <?= $form->field($model, 'idCategoriaEvento')->textInput() ?>

    <?= $form->field($model, 'idEstadoEvento')->textInput() ?>

    <?= $form->field($model, 'idModalidadEvento')->textInput() ?>

    <?= $form->field($model, 'nombreEvento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombreCortoEvento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcionEvento')->textArea(['rows' => 6, 'maxlength' => true]) ?>

    <?= $form->field($model, 'lugar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fechaInicioEvento')->input('date', ['style' => 'width: auto'])->label('Fecha Inicio') ?>

    <?= $form->field($model, 'fechaFinEvento')->input('date', ['style' => 'width: auto'])->label('Fecha Finalización') ?>

    <?= $form->field($model, 'imgFlyer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imgLogo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'capacidad')->textInput() ?>

    <?= $form->field($model, 'preInscripcion')->textInput() ?>

    <?= $form->field($model, 'fechaLimiteInscripcion')->input('date', ['style' => 'width: auto'])->label('Fecha Limite Inscripcion') ?>

    <?= $form->field($model, 'codigoAcreditacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fechaCreacionEvento')->input('date', ['style' => 'width: auto'])->label('Fecha Creación') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-pink col-md-2 col-sm-12']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
