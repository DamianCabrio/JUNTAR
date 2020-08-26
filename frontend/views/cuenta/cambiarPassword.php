<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model ResetPasswordForm */

use frontend\models\ResetPasswordForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Cambiar contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password container">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <p class="text-center"> Por favor, ingrese su nueva contraseña: </p>

    <div class="row">
        <div class="col-lg-5 m-auto">
            <?php $form = ActiveForm::begin(['id' => 'cambiar-password-form']); ?>

            <?= $form->field($model, 'actualPassword')->passwordInput(['autofocus' => true, 'placeholder' => 'Contraseña actual', 'class' => 'form-control showCambiarPw',])->label('Escriba su contraseña actual: ') ?>
            <?=
            $form->field($model, 'newPassword')->passwordInput([
                'placeholder' => 'Ejemplo: Mypass1234, myPass32',
                'class' => 'form-control showCambiarPw',
                'data-title' => 'Requisitos',
                'data-toggle' => 'popover',
                'data-placement' => 'bottom',
                'data-content' => 'La contraseña debe tener entre 6 y 20 caracteres y contener como mínimo un numero y una mayúscula.',
            ])->label('Nueva contraseña: ');
            ?>
            <?= $form->field($model, 'repeatNewPassword')->passwordInput(['placeholder' => 'Repita la nueva contraseña', 'class' => 'form-control showCambiarPw',])->label('Repetir nueva contraseña: ') ?>
            <?= $form->field($model, 'showpw', ['options' => ['class' => 'showpw mb-2']])->checkBox()->label("Mostrar Contraseñas") ?>

            <div class="form-group">
                <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
