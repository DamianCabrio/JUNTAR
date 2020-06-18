<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

use frontend\models\CategoriaEvento;
use frontend\models\ModalidadEvento;


/* @var $this yii\web\View */
/* @var $model frontend\models\Evento */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
if(!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario == $model->idUsuario0->idUsuario){
?>
<div class="container">
    <div class = "row">
        <div class = "col-md-8 col-12 m-auto">

            <div class="evento-form">
                <h2 class="text-center">Editar evento</h2>
                <p class="text-center">Complete los siguientes campos</p>

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                <!-- Oculto, se carga con el id del usuario logueado que esta crendo el evento (usuario organizador) -->
                <?= $form->field($model, 'idUsuario')->hiddenInput(['value' => Yii::$app->user->identity->idUsuario ])->label(false); ?>


                <?= $form->field($model, 'nombreEvento')->textInput(['maxlength' => true, 'placeholder' => 'Ingrese nombre'])->label('Nombre del evento *') ?>

                <?= $form->field($model, 'nombreCortoEvento')->textInput(['maxlength' => true, 'placeholder' => 'Ingrese  nombre corto'])->label('Nombre corto del evento *') ?>

                <?= $form->field($model, 'descripcionEvento')->textarea(['rows' => '8',  'placeholder' => ' Descripción del evento  [ Máximo 800 caracteres ]'])->label('Descripción *') ?>

                <?= $form->field($model, 'lugar')->textInput(['placeholder' => 'Ingrese lugar'] , ['maxlength' => true])->label('Lugar *') ?>

            
                <?= $form->field($model, 'idCategoriaEvento')->dropdownList($categoriasEventos,  ['prompt' => 'Seleccione una categoria'])->label('Categoria *'); ?>


                <?= $form->field($model, 'idModalidadEvento')->dropdownList($modalidadEvento,  ['prompt' => 'Selecciona una modalidad'])->label('Modalidad *'); ?>

                <!-- input logo -->
                <?= $form->field($modelLogo, 'imageLogo')->fileInput()->label('Ingrese logo [solo formato png, jpg y jpeg]') ?>
                
                <!-- input flyer -->
                <?= $form->field($modelFlyer, 'imageFlyer')->fileInput()->label('Ingrese flyer [solo formato png,  jpg y jpeg]') ?>

                <?= $form->field($model, 'fechaInicioEvento')->input('date', ['style'=>'width: auto'])->label('Fecha Inicio *') ?>
                
                <?= $form->field($model, 'fechaFinEvento')->input('date', ['style'=>'width: auto'])->label('Fecha Fin *') ?>

                <label>¿Posee límite de espectadores?</label><br>
                <input type="radio" id="espectadores-no" name="posee-espectadores" value="-1" checked required>
                <label for="espectadores-no">No</label><br>
                <input type="radio" id="espectadores-si" name="posee-espectadores" value="2">
                <label for="espectadores-si">Si</label><br>

                <div id="mostrarCapacidad">
                    <?= $form->field($model, 'capacidad')->input('number',[ 'min' => 1 , 'max' => 10000])->label('Ingrese número espectadores *')  ?>
                </div>    

                <!-- select requiere preInscripcion -->
                <?php $requiere = ['0' => 'No', '1' => 'Si' ]; ?>
                <?= $form->field($model, 'preInscripcion')->dropDownList($requiere, ['prompt' => '¿Requiere preinscripción? *']) ?>

                <!-- calendar -->
                <div id="fechaLimite">
                    <?= $form->field($model, 'fechaLimiteInscripcion')->input('date', ['style'=>'width:auto'])->label('Fecha limite de inscripción *')?>
                </div>
                <?= $form->field($model, 'codigoAcreditacion')->textInput(['placeholder' => 'Ingrese código de acreditación'] , ['maxlength' => true]) ?>

                <?= $form->field($model, 'fechaCreacionEvento')->input('date', ['style'=>'width: auto'])->label('Fecha publicación del evento *') ?>

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
<?php
}
else{
	?>
	<div class="container">
		<div class="row">
			<div class="col-12 text-center">
				<div class="row">
					<div class="col-12" style="padding-top: 4vh; padding-bottom: 4vh;">
						<p class="display-1">403</p>
					</div>
				</div>
				<p><b>Error</b>: usted no tiene permisos para gestionar este evento.</p>
				<p>Si cree que esto es un error del servidor, contacte con un administrador del sistema</p>
			</div>
		</div>
	</div>
<?php } ?>
