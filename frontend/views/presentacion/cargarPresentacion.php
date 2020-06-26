<?php

use frontend\models\Usuario;
use yii\helpers\Html;
use frontend\models\Evento;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\bootstrap4\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Cargar Presentación - " . $evento->nombreCortoEvento;

?>
<div class="container">

    <div class="row">
        <div class="col-md-8 col-12 m-auto">
            <div class="presentacion-form">
                <?php
                if (!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario == $evento->idUsuario0->idUsuario) {
                ?>
                    <h2 class="text-center">Cargar Presentacion a evento</h2>
                    <p class="text-center">Complete los siguientes campos</p>

                    <?php $form = ActiveForm::begin([
                        'id' => 'cargarPresentacion',
                    ]); ?>

                    <?= $form->field($model, 'idEvento')->dropdownList($item,  ['value' => $evento->idEvento, 'readonly' => true])->label('Seleccione un evento *');
                    ?>

                    <?= $form->field($model, 'tituloPresentacion')->textInput(['maxlength' => true,  'placeholder' => 'Ingrese título de la presentación'])->label('Titulo de la presentación *') ?>

                    <?= $form->field($model, 'descripcionPresentacion')->textarea(['rows' => '8', 'placeholder' => 'Descripción de la presentación [ máximo 800 caracteres ]'])->label('Descripción *')  ?>

                    <input id="fechaIniEvento" type="hidden" value="<?= $evento->fechaInicioEvento ?>">
                    <input id="fechaFinEvento" type="hidden" value="<?= $evento->fechaFinEvento ?>">

                    <?= $form->field($model, 'diaPresentacion')->input('date', ['style' => 'width: auto'])->label('Ingrese fecha *') ?>
                    <div id="invalidFecha" class="invalid-feedback">
                    </div>

                    <?= $form->field($model, 'horaInicioPresentacion')->input('time', ['style' => 'width: auto'])->label('Hora de incio (HH:MM) *') ?>

                    <?= $form->field($model, 'horaFinPresentacion')->input('time', ['style' => 'width: auto'])->label('Hora de finalización (HH:MM) *') ?>

                    <?= $form->field($model, 'linkARecursos')->textInput(['placeholder' => 'Ingrese link a recursos'], ['maxlength' => true]) ?>

                    <p class="font-italic">
                        Los campos marcados con (*) son obligatorios. 
                    <p>
                    <div class="form-group">
                        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>


            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-12 text-center">
            <div class="row">
                <div class="col-12" style="padding-top: 4vh; padding-bottom: 4vh;">
                    <p class="display-1">403</p>
                </div>
            </div>
            <p><b>Error</b>: usted no tiene permisos para gestionar esta presentacion.</p>
            <p>Si cree que esto es un error del servidor, contacte con un administrador del sistema</p>
        </div>
    </div>
<?php } ?>
</div>