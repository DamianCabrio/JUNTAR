<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Jugador */

$this->title = 'Actualizar Información: ';

$this->params['breadcrumbs'][] = 'Actualizar información';
?>
<div class="profile-update container">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_form', ['model' => $model,]) ?>

    <div class="row">
        <div class="col-lg-5 m-auto">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'nombre')->label('Nombre *') ?>
            <?= $form->field($model, 'apellido')->label('Apellido *') ?>
            <?= $form->field($model, 'dni')->input('number')->label('DNI *'); ?>
            <?= $form->field($model, 'telefono')->label('Telefono *'); ?>
            <?= $form->field($model, 'localidad')->label('Localidad *'); ?>
            <?= $form->field($model, 'fecha_nacimiento')->input('date')->label('Fecha de Nacimiento *'); ?>

            <?= $form->field($model, 'email')->input('email')->label('Email *'); ?>
            <div class="form-group">
                <?= Html::submitButton('Guardar Cambios', ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>