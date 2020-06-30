<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Cambiar email';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cuenta-cambiar-email container">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <p class="text-center"> Por favor, ingrese su nuevo Email: </p>

    <div class="row">
        <div class="col-lg-5 m-auto">
            <?php $form = ActiveForm::begin(['id' => 'cambiar-email-form']); ?>

            <?= $form->field($model, 'email')->input('email')->label('Dirección de Correo (*)')->textInput(['placeholder' => 'Ejemplo: myEmail@gmail.com']); ?>
            <?= $form->field($model, 'repeatNewEmail')->input('email')->label('Dirección de Correo (*)')->textInput(['placeholder' => 'Repita su nuevo email']); ?>

            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
