<?php

use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

use frontend\models\CategoriaEvento;
use frontend\models\ModalidadEvento;


/* @var $this yii\web\View */
/* @var $model frontend\models\Evento */
/* @var $form yii\widgets\ActiveForm */
$this->title = "Editar Evento - " . $model->nombreCortoEvento;
?>
<div class="dark_light_bg">
    <div class="container padding_section">
        <div class="card shadow">
            <div class="card-header pinkish_bg">
                <h2 class="text-center text-white">Editar Evento</h2>
            </div>
            <div class="card-body">
                <div class="row">
					<div class="col-12">

            <div class="evento-form">
                    <p class="text-center">Complete los siguientes campos</p>

                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                    <!-- Oculto, se carga con el id del usuario logueado que esta crendo el evento (usuario organizador) -->
                    <?= $form->field($model, 'idUsuario')->hiddenInput(['value' => Yii::$app->user->identity->idUsuario])->label(false); ?>

                    <?= $form->field($model, 'nombreEvento')->textInput(['maxlength' => true, 'placeholder' => 'Ingrese nombre'])->label('Nombre del evento *') ?>

                   
                <label for="evento-nombrecortoevento"> Nombre corto del evento: * </label>
                <div class="row">
                    <div class="col-4 form-advice">
                        <span class="m-auto"> Opciones automaticas: </span>
                    </div>
                    <div class="nombresCortos" id="automaticSlug">
                    </div>
                    <br>
                    <div class="col-12 mt-2 nombresCortos">
                        <!--<input type="radio" id="otro" name="shortName" value=""> <label for="otro">Otro: </label>-->
                        <?= $form->field($model, 'nombreCortoEvento')->textInput(['maxlength' => true, 'placeholder' => 'Ingrese  nombre corto',
                            'data-title' => 'Requisitos',
                            'data-toggle' => 'popover',
                            'data-content' => 'Solo puede tener numeros y letras, sin caracteres especiales y los espacios deben ser guiones. Ejemplo test-evento.',])->label(false) ?>
                    </div>
                </div>

                <?= $form->field($model, 'descripcionEvento')->widget(CKEditor::className(), [
                    "options" => ['rows' => '8'],
                    "preset" => "custom",
                    "clientOptions" => [
                        'toolbarGroups' => [
                            ['name' => 'clipboard', 'groups' => ['clipboard', 'undo']],
                            ['name' => 'editing', 'groups' => ['find', 'selection', 'spellchecker']],
                            '/',
                            ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup']],
                            ['name' => 'colors'],
                            ['name' => 'paragraph', 'groups' => ['list', 'indent', 'blocks', 'align', 'bidi']],
                            ['name' => 'links'],
                            ['name' => 'styles'],
                            ['name' => 'colors'],
                            ['name' => 'tools'],
                            ['name' => 'others'],
                            
                        ],
                        'removeButtons' => 'Subscript,Superscript,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe',
                        'removePlugins' => 'elementspath',
                        'resize_enabled' => false
                    ],
                ])->label('Descripción *') ?>

                    <?= $form->field($model, 'lugar')->textInput(['placeholder' => 'Ingrese lugar'], ['maxlength' => true])->label('Lugar *') ?>

                    <!-- select categoria -->
                    <?= $form->field($model, 'idCategoriaEvento')->dropdownList($categoriasEventos,  ['prompt' => 'Seleccione una categoria'])->label('Categoria *'); ?>

                    <!-- select modalidad -->  
                    <?= $form->field($model, 'idModalidadEvento')->dropdownList($modalidadEvento,  ['prompt' => 'Selecciona una modalidad'])->label('Modalidad *'); ?>

                    <!-- input logo -->
                    <?= $form->field($modelLogo, 'imageLogo')->fileInput()->label('Ingrese logo [solo formato png, jpg y jpeg]') ?>
                    <button type="button" id="quitarLogo" class="btn btn-sm btn-outline">Quitar</button>
                    <br>
                    <br>
                    <!-- input flyer -->
                    <?= $form->field($modelFlyer, 'imageFlyer')->fileInput()->label('Ingrese flyer [solo formato png,  jpg y jpeg]') ?>
                    <button type="button" id="quitarFlyer" class="btn btn-sm btn-outline">Quitar</button> 
                    <br>
                    <br>
                    <?= $form->field($model, 'fechaInicioEvento')->input('date', ['style' => 'width: auto'])->label('Fecha Inicio *') ?>

                    <?= $form->field($model, 'fechaFinEvento')->input('date', ['style' => 'width: auto'])->label('Fecha Fin *') ?>
                    <div class="form-group">
                        <label>¿Posee límite de participantes?</label><br>

                        <div role="radiogroup" aria-required="true">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="espectadores-no" name="posee-espectadores" value="-1" checked required>
                                <label class="custom-control-label" for="espectadores-no">No</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="espectadores-si" name="posee-espectadores" value="2">
                                <label class="custom-control-label" for="espectadores-si">Si</label><br>
                            </div>
                        </div>
                    </div>

                    <div id="mostrarCapacidad">
                        <?= $form->field($model, 'capacidad')->input('number', ['min' => 1, 'max' => 10000])->label('Ingrese número de participantes *')  ?>
                    </div>

                    <!-- select requiere preInscripcion -->
                    <?= $form->field($model, 'preInscripcion')->radioList([0 => 'No', 1 => 'Si'])->label('¿Requiere preinscripción? *') ?>

                    <!-- calendar -->
                    <div id="fechaLimite">
                        <?= $form->field($model, 'fechaLimiteInscripcion')->input('date', ['style' => 'width:auto'])->label('Fecha límite de pre-inscripción *') ?>
                    </div>
                    <?= $form->field($model, 'codigoAcreditacion')->textInput(['placeholder' => 'Ingrese código de acreditación'], ['maxlength' => true]) ?>


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
      </div>
     </div>
    </div>
  </div>
</div>
