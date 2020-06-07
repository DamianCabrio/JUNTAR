<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Evento */
/* @var $form yii\widgets\ActiveForm */
?>
<div class = "row">
    <div class = "col-md-8 col-12 m-auto">

        <div class="evento-form">
            <h2 class="text-center">Cargar nuevo evento</h2>
            <p class="text-center">Complete los siguientes campos</p>

            <?php $form = ActiveForm::begin(); ?>
            <!-- Oculto, se carga con el id del usuario logueado que esta crendo el evento -->
            <?= $form->field($model, 'idUsuario')->hiddenInput(['value' => Yii::$app->user->identity->idUsuario ])->label(false); ?>


            <?= $form->field($model, 'nombreEvento')->textInput(['maxlength' => true])->label('Nombre del evento *') ?>

            <?= $form->field($model, 'descripcionEvento')->textarea(['rows' => '8'])->label('Descripción *') ?>

            <?= $form->field($model, 'lugar')->textInput(['maxlength' => true])->label('Lugar *') ?>

            <?= $form->field($model, 'fechaInicio')->input('date')->label('Fecha Inicio del evento *') ?>
            
            <?= $form->field($model, 'fechaFin')->input('date')->label('Fecha Fin del evento *') ?>

            <!-- select modalidad -->
            <?php $modalidad = ['Presencial' => 'Presencial',  'Semi presencial' => 'Semi presencial', 'A distancia' => 'A distancia' ]; ?>
            <?= $form->field($model, 'modalidad')->dropDownList($modalidad, ['prompt' => 'Seleccione tipo de modalidad *' ]) ?>

            <?= $form->field($model, 'linkPresentaciones')->textInput(['maxlength' => true])->label('Ingrese link de las Recursos') ?>

            <?= $form->field($model, 'linkFlyer')->textInput(['maxlength' => true])->label('Ingrese link del flyer') ?>

            <?= $form->field($model, 'linkLogo')->textInput(['maxlength' => true])->label('Ingrese link a logo') ?>

            <?= $form->field($model, 'capacidad')->input('number')->label('Ingrese capacidad de espectadores*')  ?>

            <!-- select requiere preInscripcion -->
            <?php $requiere = ['0' => 'No', '1' => 'Si' ]; ?>
            <?= $form->field($model, 'preInscripcion')->dropDownList($requiere, ['prompt' => '¿Requiere preinscripcion? *']) ?>

            <!-- calendar -->
            <?= $form->field($model, 'fechaLimiteInscripcion')->input('date')->label('Fecha limite de inscripcion *')?>


            <?= $form->field($model, 'codigoAcreditacion')->textInput(['maxlength' => true]) ?>

            <p class="font-italic">
                * campos obligatorios.
            <p>
            <div class="form-group">
                <?= Html::submitButton('Cargar', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>
</div>