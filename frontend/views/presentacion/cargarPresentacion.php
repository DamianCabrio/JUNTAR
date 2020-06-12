<?php

use backend\models\Usuario;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Evento;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-8 col-12 m-auto">
        <div class="presentacion-form">
            <h2 class="text-center">Cargar Presentacion a evento</h2>
            <p class="text-center">Complete los siguientes campos</p>

            <?php $form = ActiveForm::begin(); ?>

            <!-- Select de los eventos creados por el usuario -->
            <?php
            $idUsuario = Yii::$app->user->identity->idUsuario;
            $item = Evento::find()     //buscar los eventos del usuario              
                ->select(['nombreEvento'])
                ->indexBy('idEvento')
                ->where(['idUsuario' => $idUsuario, 'idEvento' => $idEvento])
                ->column();
            $evento = Evento::findOne($idEvento);
            ?>
            <?= $form->field($model, 'idEvento')->dropdownList($item,  ['value' => $idEvento, 'readonly' => true])->label('Seleccione un evento *');
            ?>

            <?= $form->field($model, 'tituloPresentacion')->textInput(['maxlength' => true,  'placeholder' => 'Máximo 200 caracteres'])->label('Titulo de la presentación *') ?>

            <?= $form->field($model, 'descripcionPresentacion')->textarea(['rows' => '8', 'placeholder' => 'Máximo 800 caracteres'])->label('Descripción *')  ?>

            <?= $form->field($model, 'diaPresentacion')->input('date', ['style' => 'width: auto'])->label('Ingrese fecha *') ?>

            <?= $form->field($model, 'horaInicioPresentacion')->input('time', ['style' => 'width: auto'])->label('Hora de incio (HH:MM) *') ?>

            <?= $form->field($model, 'horaFinPresentacion')->input('time', ['style' => 'width: auto'])->label('Hora de finalización (HH:MM) *') ?>

            <?= $form->field($model, 'linkARecursos')->textInput(['maxlength' => true]) ?>

            <select id="cantExpositor">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">3</option>
                <option value="5">5</option>
            </select>
            <div id="divCantExpo">

            </div>

            <?php $data = Usuario::find()
                ->select(['nombre as value', 'nombre as  label', 'idUsuario as idUsuario'])
                ->asArray()
                ->all();
            
                echo AutoComplete::widget([
                'model' => $data,
                'clientOptions' => [
                    'source' => $data,
                    'minLength' => '3',
                ],
                'options' => [
                    'class' => 'form-control'
                ]
            ]);
            ?>
            <?= Html::activeHiddenInput($preExpositor, 'idExpositor') ?>

            <?php /*$usuario = Usuario::find()     //buscar los eventos del usuario              
                ->select(['nombre'])
                ->indexBy('idUsuario')
                ->column();*/
            ?>


            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>


        </div>
    </div>
</div>