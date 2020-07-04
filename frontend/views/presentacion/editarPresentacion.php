<?php

use dosamigos\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-12 m-auto">
            <div class="presentacion-form">
                <h2 class="text-center">Editar Presentación</h2>
                <p class="text-center">Complete los siguientes campos</p>

                <h1><?= Html::encode($this->title) ?></h1>

                <div class="presentacion-form">
                    <?php yii\widgets\Pjax::begin(['id' => 'log-in']) ?>
                    <?php $form = ActiveForm::begin(['id' => 'editarPresentacion', 'options' => ['data-pjax' => true]]); ?>


                    <?= $form->field($model, 'tituloPresentacion')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'descripcionPresentacion')->widget(CKEditor::className(), [
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
                    <input id="fechaIniEvento" type="hidden" value="<?= $evento->fechaInicioEvento ?>">
                    <input id="fechaFinEvento" type="hidden" value="<?= $evento->fechaFinEvento ?>">

                    <?= $form->field($model, 'diaPresentacion')->input('date', ['style' => 'width: auto'])->label('Ingrese fecha de presentación *') ?>
                    <div id="invalidFecha" class="invalid-feedback">
                    </div>

                    <?= $form->field($model, 'horaInicioPresentacion')->input('time', ['style' => 'width: auto'])->label('Hora incio (HH:MM) *') ?>

                    <?= $form->field($model, 'horaFinPresentacion')->input('time', ['style' => 'width: auto'])->label('Hora finalización (HH:MM) *') ?>

                    <?= $form->field($model, 'linkARecursos')->textInput(['placeholder' => 'https//ejemplo.com o http://ejemplo.com'], ['maxlength' => true]) ?>
                    <p class="font-italic">
                        Los campos marcados con (*) son obligatorios.
                    <p>
                    <div class="form-group">
                        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <?php yii\widgets\Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
