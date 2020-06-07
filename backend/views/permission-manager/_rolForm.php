<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="rol-form">

        <?php $form = ActiveForm::begin(); ?>
        <?php echo $form->field($model, 'name')->dropDownList($permissions, ['class' => 'form-control permissionName' ] ) ?>
        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'assignValueFirst btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
