<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Actualizar Información: ';

$this->params['breadcrumbs'][] = 'Actualizar información';
?>

<div class="profile-update container">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-12 m-auto profileForm">
            <?php $form = ActiveForm::begin(['id' => 'editProfileForm']); ?>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <?= $form->field($model, 'nombre')->label('Nombre (*)')->textInput(['placeholder' => 'Ejemplo: Juan']) ?>
                </div>
                <div class="col-md-6 col-sm-12">
                    <?= $form->field($model, 'apellido')->label('Apellido (*)')->textInput(['placeholder' => 'Ejemplo: Perez']) ?>
                </div>
                <div class="col-12">
                    <?= $form->field($model, 'dni')->label('DNI (*)')->textInput(['placeholder' => 'Ejemplo: 26734824']); ?>
                </div>
                <div class="col-md-4 col-sm-12">
                    <?= $form->field($model, 'pais')->label('Pais (*)')->textInput(['value' => 'Argentina']); ?>
                </div>
                <div class="col-md-4 col-sm-12">
                    <?= $form->field($model, 'provincia')->label('Provincia (*)')->textInput(['placeholder' => 'Ejemplo: Buenos Aires']); ?>
                </div>
                <div class="col-md-4 col-sm-12">
                    <?= $form->field($model, 'localidad')->label('Localidad (*)')->textInput(['placeholder' => 'Ejemplo: Neuquen']); ?>
                </div>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Guardar Cambios', ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>