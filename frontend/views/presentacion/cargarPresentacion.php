<?php

use backend\models\Usuario;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Evento;

/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-8 col-12 m-auto">
        <div class="presentacion-form">
            <h2 class="text-center">Cargar Presentacion a evento</h2>
            <p class="text-center">Complete los siguientes campos</p>

            <!-- Hacer un bucle que pregunte la cantidad de presentaciones que tiene el evento, permitir cortar el ciclo -->


            <?php $form = ActiveForm::begin(); ?>

            <!-- Select de los eventos creados por el usuario -->
            <?php
            $idUsuario = Yii::$app->user->identity->idUsuario;
            $item = Evento::find()     //buscar los eventos del usuario              
                ->select(['nombreEvento'])
                ->indexBy('idEvento')
                ->where(['idUsuario' => $idUsuario])
                ->column();
            ?>
            <?= $form->field($model, 'idEvento')->dropdownList($item,  ['prompt' => 'Sus eventos'])->label('Seleccione un evento *');
            ?>


            <?= $form->field($model, 'tituloPresentacion')->textInput(['maxlength' => true])->label('Titulo de la presentación *') ?>

            <?= $form->field($model, 'descripcionPresentacion')->textarea(['rows' => '8'])->label('Descripción *')  ?>


            <!-- cambiar los campos para la hora -->
            <?= $form->field($model, 'horaInicioPresentacion')->input('time')->label('Hora de incio *') ?>

            <?= $form->field($model, 'horaFinPresentacion')->input('time')->label('Hora de finalización *') ?>

            <?php $usuario = Usuario::find()     //buscar los eventos del usuario              
                ->select(['nombre'])
                ->indexBy('idUsuario')
                ->column();
            ?>
            <?= $form->field($expo, 'idUsuario')->dropdownList($usuario,  ['prompt' => 'Expositor'])->label('Seleccione un Expositor *'); ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>


        </div>
    </div>
</div>