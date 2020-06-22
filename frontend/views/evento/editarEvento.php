<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

use frontend\models\CategoriaEvento;
use frontend\models\ModalidadEvento;


/* @var $this yii\web\View */
/* @var $model frontend\models\Evento */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Editar Evento - " . $model->nombreCortoEvento;
?>
<div class="container-fluid padding_section dark_light_bg">
    <div class="container">
    <div class="card">
        <div class="card-header pinkish_bg">
            <h2 class="text-center text-white">Editar Evento</h2>
        </div>
        <div class="card-body">
        <div class="row padding_section">
            <div class="col-md-8 col-12 m-auto">
                <p class="text-center">Complete los siguientes campos</p>
                <div class="evento-form">
                    <h2 class="text-center">Editar evento</h2>
                    <p class="text-center">Complete los siguientes campos</p>

                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                    <!-- Oculto, se carga con el id del usuario logueado que esta crendo el evento (usuario organizador) -->
                    <?= $form->field($model, 'idUsuario')->hiddenInput(['value' => Yii::$app->user->identity->idUsuario])->label(false); ?>


                    <?= $form->field($model, 'nombreEvento')->textInput(['maxlength' => true, 'placeholder' => 'Ingrese nombre'])->label('Nombre del evento *') ?>

                    <?= $form->field($model, 'nombreCortoEvento')->textInput(['maxlength' => true, 'placeholder' => 'Ingrese  nombre corto'])->label('Nombre corto del evento *') ?>

                    <?= $form->field($model, 'descripcionEvento')->textarea(['rows' => '8',  'placeholder' => ' Descripción del evento  [ Máximo 800 caracteres ]'])->label('Descripción *') ?>

                    <?= $form->field($model, 'lugar')->textInput(['placeholder' => 'Ingrese lugar'], ['maxlength' => true])->label('Lugar *') ?>

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

                    <!-- input logo -->
                    <?= $form->field($modelLogo, 'imageLogo')->fileInput()->label('Ingrese logo [solo formato png, jpg y jpeg]') ?>

                    <!-- input flyer -->
                    <?= $form->field($modelFlyer, 'imageFlyer')->fileInput()->label('Ingrese flyer [solo formato png,  jpg y jpeg]') ?>

                    <?= $form->field($model, 'fechaInicioEvento')->input('date', ['style' => 'width: auto'])->label('Fecha Inicio *') ?>

                    <?= $form->field($model, 'fechaFinEvento')->input('date', ['style' => 'width: auto'])->label('Fecha Fin *') ?>
                    <div class="form-group">
                        <label>¿Posee límite de espectadores?</label><br>

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
                        <?= $form->field($model, 'capacidad')->input('number', ['min' => 1, 'max' => 10000])->label('Ingrese número espectadores *')  ?>
                    </div>

                    <!-- select requiere preInscripcion -->
                    <?= $form->field($model, 'preInscripcion')->radioList([0 => 'No', 1 => 'Si'])->label('¿Requiere preinscripción? *') ?>

                    <!-- calendar -->
                    <div id="fechaLimite">
                        <?= $form->field($model, 'fechaLimiteInscripcion')->input('date', ['style' => 'width:auto'])->label('Fecha limite de inscripción *') ?>
                    </div>
                    <?= $form->field($model, 'codigoAcreditacion')->textInput(['placeholder' => 'Ingrese código de acreditación'], ['maxlength' => true]) ?>

                    <?= $form->field($model, 'fechaCreacionEvento')->input('date', ['style' => 'width: auto'])->label('Fecha publicación del evento *') ?>

                    <p class="font-italic">
                        * Campos obligatorios.
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
