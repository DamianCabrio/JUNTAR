<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model backend\models\Evento */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Modificar Organizador';
$this->params['breadcrumbs'][] = $this->title;
//print_r($alert);
?>

<div class="evento-modificar-organizador">

    <div class="col-12 mb-4 p-0">
        <div class="card">
            <h4 class="card-header text-center darkish_bg text-white"> <?= Html::encode($this->title) ?> </h4>
            <div class="card-body">
                <!--    <p class="text-center"> Por favor, ingrese el email del usuario buscado: </p>-->

                <!--<div class="row">-->
                <!--<div class="col-12 m-auto">-->
                <?php $form = ActiveForm::begin(['id' => 'cambiar-organizador-form']); ?>

                <?=
                $form->field($model, 'email')->label('Email organizador')->widget(AutoComplete::classname(), [
                    'clientOptions' => [
                        'source' => $usuarios,
                        'autoFill' => true,
                        'minLength' => '3',
                        'options' => ['class' => 'form-control'],
                        'select' => new JsExpression("function( event, ui ) {
                                    $('#cambiarorganizadorform-email').val(ui.item.id);
                                  }"),
                        'appendTo' => '#cambiar-organizador-form',
                    ],
                ])->textInput();
                ?>

                <div class="form-group">
                    <?= Html::submitButton('Reemplazar', ['class' => 'btn btn-pink col-md-2 col-sm-12']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>