<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="rol-form">

        <?php $form = ActiveForm::begin(); ?>
        <?php echo $form->field($model, 'name')->input('name')->textInput(['autofocus' => true, 'placeholder' => 'Ingrese el nuevo Rol']) ?>
        <?= $form->field($model, 'description')->textarea(['rows' => 6, 'placeholder' => '¿Qué hará este rol?']) ?>
        <div class="form-group">
            <?= Html::submitButton('Registrar Rol', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
