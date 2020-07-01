<?php
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use frontend\models\CategoriaEvento;
use frontend\models\ModalidadEvento;
use yii\bootstrap4\ActiveForm;


$this->title = "Cargar Evento";
?>
<div class="dark_light_bg">
    <div class="container padding_section">
        <div class="card shadow">
            <div class="card-header pinkish_bg">
                <h2 class="text-center text-white">Enviar un mail a los participantes</h2>
            </div>
            <div class="card-body">
                <div class="row">
					<div class="col-12">

            <div class="evento-form">
     

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
               

                <div class="row">
                    <div class="col-md-2">
                        <p ><b>Para: </b></p>
                    </div>

                    <div class="col-md-2">
                        <?= Html::radio('nunca', true, ['value' => 1]) ?>
                        <?=Html::label('Todos','alumno[lugarBautismo]') ?>
                    </div>
                    <div class="col-md-2">
                        <?= Html::radio('nunca', true, ['value' => 1]) ?>
                        <?=Html::label('Pre-inscriptos','alumno[lugarBautismo]') ?>
                    </div>
                    <div class="col-md-2">
                        <?= Html::radio('nunca', true, ['value' => 1]) ?>
                        <?=Html::label('Inscriptos','alumno[lugarBautismo]') ?>
                    </div>
                    <div class="col-md-2">
                        <?= Html::radio('nunca', true, ['value' => 1]) ?>
                        <?=Html::label('Expositores','alumno[lugarBautismo]') ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <p ><b>Agregar un asunto: </b></p>
                    </div>

                    <div class="col-md-4">
                    <?=Html::input('text','asunto','',['class'=>'form-control']); ?>
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
                ])->label('<b>Mensaje</b>') ?>

    
                <div class="form-group">
                    <?= Html::submitButton('Enviar', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
                </div>

             </div>
         </div>               
    </div>
</div>
