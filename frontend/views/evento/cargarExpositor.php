<?php

use backend\models\Usuario;
use yii\helpers\Html;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model frontend\models\Expositor */

$this->title = 'Cargar Nuevo Expositor';
?>


<h1><?= Html::encode($this->title) ?></h1>

<div class="expositor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $usuario = Usuario::find()     //buscar los eventos del usuario              
        ->select(['nombre'])
        ->indexBy('idUsuario')
        ->column();
    ?>
    <?= $form->field($model, 'idUsuario')->dropdownList($usuario,  ['prompt' => 'Expositor'])->label('Seleccione un Expositor *'); ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>



</div>