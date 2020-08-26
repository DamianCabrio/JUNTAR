<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model SignupForm */

use frontend\models\SignupForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

//use yii\jui\DatePicker;

$this->title = 'Crear cuenta';
$this->params['breadcrumbs'][] = $this->title;
?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<div class="site-signup container">

    <h1 class="text-center mb-2"><?= Html::encode($this->title) ?></h1>

    <p class="text-center"> Complete el formulario para registrarse en la plataforma: </p>

    <div class="col-lg-5 m-auto">
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <div class="form-group">
            <?= $form->field($model, 'nombre')->label('Nombre (*)')->textInput(['placeholder' => 'Ejemplo: Juan']) ?>
            <?= $form->field($model, 'apellido')->label('Apellido (*)')->textInput(['placeholder' => 'Ejemplo: Perez']) ?>
            <?= $form->field($model, 'dni')->label('DNI (*)')->textInput(['placeholder' => 'Ejemplo: 26734824']); ?>
            <?=
            $form->field($model, 'pais')->label('País (*)')->widget(AutoComplete::classname(), [
                'options' => ['class' => 'form-control'],
                'clientOptions' => [
                    'source' => $paises,
                    'autoFill' => true,
                    'minLength' => '3',
                    'options' => ['class' => 'form-control'],
                    'select' => new JsExpression("function( event, ui ) {
                                    $('#signupform-pais').val(ui.item.id);
                                  }")],
            ])->textInput(['value' => 'Argentina']);
            ?>
            <?= $form->field($model, 'provincia')->label('Provincia (*)')->textInput(['placeholder' => 'Ejemplo: Buenos Aires']); ?>
            <?= $form->field($model, 'localidad')->label('Localidad (*)')->textInput(['placeholder' => 'Ejemplo: Neuquen']); ?>
            <?= $form->field($model, 'email')->input('email')->label('Dirección de Correo (*)')->textInput(['placeholder' => 'Ejemplo: myEmail@gmail.com']); ?>    
            <?=
            $form->field($model, 'password')->passwordInput([
                'placeholder' => 'Ejemplo: Mypass1234, myPass32',
                'data-title' => 'Requisitos',
                'data-toggle' => 'popover',
                'data-placement' => 'bottom',
                'data-content' => 'La contraseña debe tener entre 6 y 20 caracteres y contener como mínimo un número y una mayúscula.',
            ])->label('Contraseña (*)');
            ?>
            <?= $form->field($model, 'showpw', ['options' => ['class' => 'showpw']])->checkBox()->label('Mostrar Contraseña') ?>
        </div>

        <div class="form-advice">
            Los campos marcados con (*) son obligatorios.
        </div>
        <div class="form-group mt-2">
            <?= Html::submitButton('Registrarse', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
