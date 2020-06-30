<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PresentacionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="presentacion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idPresentacion') ?>

    <?= $form->field($model, 'idEvento') ?>

    <?= $form->field($model, 'tituloPresentacion') ?>

    <?= $form->field($model, 'descripcionPresentacion') ?>

    <?= $form->field($model, 'diaPresentacion') ?>

    <?php // echo $form->field($model, 'horaInicioPresentacion') ?>

    <?php // echo $form->field($model, 'horaFinPresentacion') ?>

    <?php // echo $form->field($model, 'linkARecursos') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
