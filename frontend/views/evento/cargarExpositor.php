<?php

use frontend\models\Usuario;
use yii\helpers\Html;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model frontend\models\Expositor */

$this->title = "Cargar Expositor";
?>
<div class="container">
<?php
//echo $objetoEvento->idUsuario0->idUsuario;
if(!Yii::$app->user->isGuest && $objetoEvento->idUsuario0->idUsuario == Yii::$app->user->identity->idUsuario){
?>
    <div class = "row">
        <div class = "col-md-8 col-12 m-auto">
            <div class="evento-form">
                <h2 class="text-center">Cargar expositor</h2>
                <p class="text-center">Escriba el nombre del expositor</p>

                    <div class="expositor-form">

                        <?php $form = ActiveForm::begin(); ?>
                        <?=
                            'Expositor ' . '<br>' .
                                AutoComplete::widget([
                                    'clientOptions' => [
                                        'source' => $usuarios,
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
                            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                </div>                           
            </div>                          
        </div>
    </div>
	<?php } 
	else{ ?>
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
</div>
</div>