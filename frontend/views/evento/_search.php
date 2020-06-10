<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\controllers\EventoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="evento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idEvento') ?>

    <?= $form->field($model, 'idUsuario') ?>

    <?= $form->field($model, 'idCategoria') ?>

    <?= $form->field($model, 'idEstadoEvento') ?>

    <?= $form->field($model, 'idModalidadEvento') ?>

    <?php // echo $form->field($model, 'nombreEvento') ?>

    <?php // echo $form->field($model, 'nombreCortoEvento') ?>

    <?php // echo $form->field($model, 'descripcionEvento') ?>

    <?php // echo $form->field($model, 'lugar') ?>

    <?php // echo $form->field($model, 'fechaInicioEvento') ?>

    <?php // echo $form->field($model, 'fechaFinEvento') ?>

    <?php // echo $form->field($model, 'imgFlyer') ?>

    <?php // echo $form->field($model, 'imgLogo') ?>

    <?php // echo $form->field($model, 'capacidad') ?>

    <?php // echo $form->field($model, 'preInscripcion') ?>

    <?php // echo $form->field($model, 'fechaLimiteInscripcion') ?>

    <?php // echo $form->field($model, 'codigoAcreditacion') ?>

    <?php // echo $form->field($model, 'fechaCreacionEvento') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
