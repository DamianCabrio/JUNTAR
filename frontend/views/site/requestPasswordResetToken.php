<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Solicitar cambio de contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <p class="text-center">Por favor, ingrese su cuenta de correo.</p>

    <div class="row">
        <div class="col-lg-5 m-auto">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <div  class="form-advice">
                <p class=""> Se le enviará un correo a su cuenta para reestablecer la contraseña </p>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
