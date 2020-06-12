<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

//use yii\jui\DatePicker;

$this->title = 'Registrarse';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

        <section class="darkish_bg">
    <!--<div class="body-content">-->
            <div class="col-lg-5 p-5 m-auto bg-light signupShadow">
                <h1 class="text-center mb-2"><?= Html::encode($this->title) ?></h1>

                <p class="text-center"> Complete el formulario para registrarse en la plataforma: </p>
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <div class="form-group">
                    <?= $form->field($model, 'nombre')->label('Nombre (*)')->textInput(['placeholder' => 'Ejemplo: Juan']) ?>
                    <?= $form->field($model, 'apellido')->label('Apellido (*)')->textInput(['placeholder' => 'Ejemplo: Perez']) ?>
                    <?= $form->field($model, 'dni')->label('DNI (*)')->textInput(['placeholder' => 'Ejemplo: 26734824']); ?>
                    <?php
                    echo
                    $form->field($model, 'pais')->label('Pais (*)')->widget(AutoComplete::classname(), [
                        'model' => $model,
                        'attribute' => 'pais',
                        'options' => ['class' => 'form-control', 'placeholder' => 'Ejemplo: Argentina'],
                        'clientOptions' => [
                            'source' => $paises,
                            'autoFill' => true,
                            'minLength' => '2',
                            'select' => new JsExpression("function( event, ui ) {
                                    $('#signupform-pais').val(ui.item.id);
                                  }")],
                    ]);
                    ?>
                    <?= $form->field($model, 'provincia')->label('Provincia (*)')->textInput(['placeholder' => 'Ejemplo: Buenos Aires']); ?>
                    <?= $form->field($model, 'localidad')->label('Localidad (*)')->textInput(['placeholder' => 'Ejemplo: Neuquen']); ?>
                    <?= $form->field($model, 'email')->input('email')->label('Dirección de Correo (*)')->textInput(['placeholder' => 'Ejemplo: myEmail@gmail.com']); ?>
                    <?=
                    $form->field($model, 'password')->passwordInput([
                        'placeholder' => 'Ejemplo: Mypass1234, myPass32',
                        'data-title' => 'Requisitos',
                        'data-toggle' => 'popover',
                        'data-content' => 'La contraseña debe tener entre 8 y 20 caracteres y contener como mínimo un número y una mayúscula.',
                    ])->label('Contraseña (*)');
                    ?>
                    <?= $form->field($model, 'showpw', ['options' => ['class' => 'showpw']])->checkBox()->label('Mostrar Contraseña') ?>
                </div>

                <div class="form-advice">
                    Los campos marcados con (*) son obligatorios.
                </div>
                <div class="form-group mt-2">
                    <?= Html::submitButton('Registrarse', ['class' => 'btn btn-primary signup-button', 'name' => 'signup-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </section>
    <!--</div>-->
</div>
