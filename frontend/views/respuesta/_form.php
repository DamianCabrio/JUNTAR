<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model frontend\models\RespuestaFile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="respuesta-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],
        'id' => 'responder-pregunta-form',
    ]); ?>

    <?php if($pregunta->tipo == 1): ?>
    <?= $form->field($model, 'respuesta')->textInput(['maxlength' => true])->label(false) ?>
    <?php endif; ?>
    <?php if($pregunta->tipo == 2): ?>
        //echo $form->field($model, 'respuesta')->textarea(['maxlength' => true])->label(false);
        <?= $form->field($model, 'respuesta')->widget(CKEditor::className(), [
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
                ])->label(false) ?>
    <?php endif; ?>
    <?php if($pregunta->tipo == 3): ?>
        <?= $form->field($model, 'file')->fileInput()->label(false) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-lg']) ?>
        <?php if($volverAtras): ?>
        <?= Html::a("Volver Atras", Url::toRoute(["eventos/responder-formulario/" . $inscripcion->idEvento0->nombreCortoEvento]) ,['class' => 'btn btn-lg']) ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
