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
        <div class="col-lg-5 m-auto profileForm">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-6">
                    <?= $form->field($model, 'nombre')->label('Nombre (*)')->textInput(['placeholder' => 'Ejemplo: Juan']) ?>
                </div>
                <div class="col-6">
                    <?= $form->field($model, 'apellido')->label('Apellido (*)')->textInput(['placeholder' => 'Ejemplo: Perez']) ?>
                </div>
                <div class="col-12">
                    <?= $form->field($model, 'dni')->label('DNI (*)')->textInput(['placeholder' => 'Ejemplo: 26734824']); ?>
                </div>
                <div class="col-4">
                    <?= $form->field($model, 'pais')->label('Pais (*)')->textInput(['value' => 'Argentina']); ?>
                </div>
                <div class="col-4">
                    <?= $form->field($model, 'provincia')->label('Provincia (*)')->textInput(['placeholder' => 'Ejemplo: Buenos Aires']); ?>
                </div>
                <div class="col-4">
                    <?= $form->field($model, 'localidad')->label('Localidad (*)')->textInput(['placeholder' => 'Ejemplo: Neuquen']); ?>
                </div>
            </div>
            <?php // echo $form->field($model, 'email')->input('email')->label('Email *'); ?>
            <div class="form-group">
                <?= Html::submitButton('Guardar Cambios', ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>