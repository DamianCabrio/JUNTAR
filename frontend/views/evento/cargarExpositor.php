<?php

use backend\models\Usuario;
use yii\helpers\Html;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model frontend\models\Expositor */

$this->title = 'Cargar Nuevo Expositor';
?>

<div class = "row">
    <div class = "col-md-8 col-12 m-auto">
    <h2><?= Html::encode($this->title) ?></h2>

    <div class="expositor-form">

        <?php $form = ActiveForm::begin(); ?>

        <?php $usuario = Usuario::find()     //buscar los eventos del usuario              
            ->select(['nombre'])
            ->indexBy('idUsuario')
            ->column();
        ?>
        <?= $form->field($model, 'idUsuario')->dropdownList($usuario,  ['prompt' => 'Expositor'])->label('Seleccione un Expositor *'); ?>
        <p class="font-italic">
                * campos obligatorios.
        <p>
        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
        </div>
        
        <?php ActiveForm::end(); ?>
    </div>
</div>

</div>