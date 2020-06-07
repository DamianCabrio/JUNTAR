<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
//use yii\jui\DatePicker;

$this->title = 'Crear cuenta';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

    <div class="m-auto">
        <h1 class="text-center mb-2"><?= Html::encode($this->title) ?></h1>

        <p class="text-center"> Complete el formulario para registrarse en la plataforma: </p>

        <div class="row">
            <div class="col-lg-5 m-auto">
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <div class="form-group">
                    <?= $form->field($model, 'nombre')->label('Nombre *') ?>
                    <?= $form->field($model, 'apellido')->label('Apellido *') ?>
                    <?= $form->field($model, 'dni')->label('DNI *'); ?>
                    <?= $form->field($model, 'localidad')->label('Localidad *'); ?>
                    <?= $form->field($model, 'email')->input('email')->label('Email *'); ?>
                    <?= $form->field($model, 'password')->passwordInput()->label('Contraseña *'); ?>
                    <?= $form->field($model, 'showpw', ['options' => ['class' => 'showpw']])->checkBox()->label('Mostrar Contraseña') ?>
                </div>

                <div class="form-advice">
                    Los campos marcados con * son obligatorios.
                </div>
                <div class="form-group mt-2">
                    <?= Html::submitButton('Registrarse', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
