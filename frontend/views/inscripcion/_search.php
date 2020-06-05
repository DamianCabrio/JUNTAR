<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\InscripcionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inscripcion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idInscripcion') ?>

    <?= $form->field($model, 'idUsuario') ?>

    <?= $form->field($model, 'idEvento') ?>

    <?= $form->field($model, 'estado') ?>

    <?= $form->field($model, 'fecha_preinscripcion') ?>

    <?php // echo $form->field($model, 'fecha_inscripcion') ?>

    <?php // echo $form->field($model, 'acreditacion') ?>

    <?php // echo $form->field($model, 'certificado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
