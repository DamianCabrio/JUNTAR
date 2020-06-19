<?php

use common\widgets\Alert;
use frontend\models\Usuario;
use yii\helpers\Html;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model frontend\models\Expositor */

?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-12 m-auto">
            <div class="evento-form">
                <h2 class="text-center">Cargar expositor</h2>
                <p class="text-center">Escriba el nombre del expositor</p>
                <?php if ($alert != "") { ?>
                    <div class="expositor-form">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Ups!</strong> <?= $alert?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>
                    <?php $form = ActiveForm::begin(); ?>
                    <?=
                        'Expositor ' . '<br>' .
                            AutoComplete::widget([
                                'clientOptions' => [
                                    'source' => $data,
                                    'autoFill' => true,
                                    'minLength' => '3',
                                    'select' => new JsExpression("function( event, ui ) { $('#inputIdExpositor').val(ui.item.idUsuario);}")
                                ],
                                'options' => [
                                    'class' => 'form-control'
                                ]
                            ]);
                    ?>
                    <?= Html::activeHiddenInput($model, 'idExpositor', ['id' => 'inputIdExpositor']) . '<br>' ?>
                    <div class="form-group">
                        <?= Html::submitButton('Guardar', ['id' => 'cargarExpositor', 'class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                    </div>
            </div>
        </div>
    </div>
</div>