<?php

use backend\models\Usuario;
use yii\helpers\Html;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model frontend\models\Expositor */

$this->title = 'Cargar Nuevo Expositor';
?>


<h1><?= Html::encode($this->title) ?></h1>

<div class="expositor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $data = Usuario::find()
        ->select(["CONCAT(nombre,' ',apellido) as value", "CONCAT(nombre,' ',apellido)  as  label", "idUsuario as idUsuario"])
        ->asArray()
        ->all();
    ?>

    <?=
        'Expositor:' . '<br>' .
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
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>



</div>