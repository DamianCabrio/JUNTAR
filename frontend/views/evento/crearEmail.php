<?php

use dosamigos\ckeditor\CKEditor;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = "Crear Email";
?>
<div class="dark_light_bg" style="min-height: 100vh;">
    <div class="container padding_section">
        <div class="card shadow">
            <div class="card-header pinkish_bg">
                <h2 class="text-center text-white">Enviar un mail a los participantes</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <div class="evento-form">

                            <?php $form = ActiveForm::begin(['action' => ['evento/enviar-email'], 'method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]); ?>

                            <?= Html::hiddenInput('idEvento', $idEvento); ?>

                            <div class="col-md-12">
                                <?= Html::label('<b>Para: </b>'); ?>
                                <?= Html::dropDownList("para", null, $participantes, ['class' => 'form-control', 'prompt' => 'Elija un grupo de participantes']) ?>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <?= Html::label('<b>Asunto: </b>'); ?>
                                <?= Html::input('text', 'asunto', '', ['class' => 'form-control', 'placeholder' => 'Agregue un asunto']); ?>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <?=
                                CKEditor::widget(['name' => 'mensaje',
                                    "options" => ['rows' => '6'],
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
                                ])
                                ?>
                            </div>
                            <br>

                            <div class="form-group col-md-12">
                                <?= Html::submitButton('Enviar', ['class' => 'btn btn-success']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
