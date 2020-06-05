<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
<<<<<<< HEAD
/* @var $model common\models\EventoSearch */
=======
/* @var $model common\models\eventoSearch */
>>>>>>> c0503ad64a517a0a11aecb6b2fd47fe90b2ea636
/* @var $form yii\widgets\ActiveForm */
?>

<div class="evento-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idEvento') ?>

    <?= $form->field($model, 'idUsuario') ?>

    <?= $form->field($model, 'nombreEvento') ?>

    <?= $form->field($model, 'descripcionEvento') ?>

    <?= $form->field($model, 'lugar') ?>

    <?php // echo $form->field($model, 'modalidad') ?>

    <?php // echo $form->field($model, 'linkPresentaciones') ?>

    <?php // echo $form->field($model, 'linkFlyer') ?>

    <?php // echo $form->field($model, 'linkLogo') ?>

    <?php // echo $form->field($model, 'capacidad') ?>

    <?php // echo $form->field($model, 'preInscripcion') ?>

    <?php // echo $form->field($model, 'fechaLimiteInscripcion') ?>

    <?php // echo $form->field($model, 'codigoAcreditacion') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
