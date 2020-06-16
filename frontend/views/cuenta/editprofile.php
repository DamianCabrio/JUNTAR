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

            <?= $form->field($model, 'nombre')->label('Nombre (*)')->textInput(['placeholder' => 'Ejemplo: Juan']) ?>
            <?= $form->field($model, 'apellido')->label('Apellido (*)')->textInput(['placeholder' => 'Ejemplo: Perez']) ?>
            <?= $form->field($model, 'dni')->label('DNI (*)')->textInput(['placeholder' => 'Ejemplo: 26734824']); ?>
            <?= $form->field($model, 'pais')->label('Pais (*)')->textInput(['value' => 'Argentina']); ?>
            <?= $form->field($model, 'provincia')->label('Provincia (*)')->textInput(['placeholder' => 'Ejemplo: Buenos Aires']); ?>
            <?= $form->field($model, 'localidad')->label('Localidad (*)')->textInput(['placeholder' => 'Ejemplo: Neuquen']); ?>
            <?= $form->field($model, 'email')->input('email')->label('Dirección de Correo (*)')->textInput(['placeholder' => 'Ejemplo: myEmail@gmail.com']); ?>

            <?php // echo $form->field($model, 'email')->input('email')->label('Email *'); ?>
            <div class="form-group">
                <?= Html::submitButton('Guardar Cambios', ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>