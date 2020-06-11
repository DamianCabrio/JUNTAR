<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use frontend\models\CategoriaEvento;
use frontend\models\ModalidadEvento;


/* @var $this yii\web\View */
/* @var $model frontend\models\Evento */
/* @var $form yii\widgets\ActiveForm */
?>
<div class = "row">
    <div class = "col-md-8 col-12 m-auto">

        <div class="evento-form">
            <h2 class="text-center">Cargar nuevo evento</h2>
            <p class="text-center">Complete los siguientes campos</p>

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <!-- Oculto, se carga con el id del usuario logueado que esta crendo el evento (usuario organizador) -->
            <?= $form->field($model, 'idUsuario')->hiddenInput(['value' => Yii::$app->user->identity->idUsuario ])->label(false); ?>


            <?= $form->field($model, 'nombreEvento')->textInput(['maxlength' => true, 'placeholder' => 'Máximo 200 caracteres'])->label('Nombre del evento *') ?>

            <?= $form->field($model, 'nombreCortoEvento')->textInput(['maxlength' => true, 'placeholder' => 'Máximo 100 caracteres'])->label('Nombre corto del evento *') ?>

            <?= $form->field($model, 'descripcionEvento')->textarea(['rows' => '8',  'placeholder' => 'Máximo 800 caracteres'])->label('Descripción *') ?>

            <?= $form->field($model, 'lugar')->textInput(['maxlength' => true])->label('Lugar *') ?>

            <!-- select categoria -->
            <?php $categoriasEventos = CategoriaEvento::find()     //buscar todas las categorias         
                ->select(['descripcionCategoria'])
                ->indexBy('idCategoriaEvento')
                ->column();
            ?>
            <?= $form->field($model, 'idCategoriaEvento')->dropdownList($categoriasEventos,  ['prompt' => 'Seleccione una categoria'])->label('Categoria *'); ?>

            <!-- select modalidad -->
            <?php $modalidadEvento = modalidadEvento::find()     //buscar todas las categorias         
                ->select(['descripcionModalidad'])
                ->indexBy('idModalidadEvento')
                ->column();
            ?>
            <?= $form->field($model, 'idModalidadEvento')->dropdownList($modalidadEvento,  ['prompt' => 'Selecciona una modalidad'])->label('Modalidad *'); ?>


            <?= $form->field($model, 'fechaInicioEvento')->input('date', ['style'=>'width: auto'])->label('Fecha Inicio *') ?>
            
            <?= $form->field($model, 'fechaFinEvento')->input('date', ['style'=>'width: auto'])->label('Fecha Fin *') ?>
           
            <!-- input logo -->
            <?= $form->field($modelLogo, 'imageLogo')->fileInput()->label('Ingrese logo (solo .pgn y .jpg)') ?>

            <!-- input flyer -->
             <?= $form->field($modelFlyer, 'imageFlyer')->fileInput()->label('Ingrese flyer (solo .pgn y .jpg)') ?>

            <?= $form->field($model, 'capacidad')->input('number', [ 'min' => 1 , 'max' => 9999])->label('Capacidad de espectadores *')  ?>

            <!-- select requiere preInscripcion -->
            <?php $requiere = ['0' => 'No', '1' => 'Si' ]; ?>
            <?= $form->field($model, 'preInscripcion')->dropDownList($requiere, ['prompt' => '¿Requiere preinscripción? *']) ?>

            <!-- calendar -->
            <?= $form->field($model, 'fechaLimiteInscripcion')->input('date', ['style'=>'width:auto'])->label('Fecha limite de inscripción *')?>

            <?= $form->field($model, 'codigoAcreditacion')->textInput(['maxlength' => true]) ?>


            <p class="font-italic">
                * Campos obligatorios.
            <p>
            <div class="form-group">
                <?= Html::submitButton('Cargar', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
      </div>
    </div>
</div>