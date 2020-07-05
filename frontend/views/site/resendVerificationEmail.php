<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model ResetPasswordForm */

use frontend\models\ResetPasswordForm;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Confirmación de correo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-resend-verification-email container">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <p class="text-center">Por favor, ingrese su cuenta de correo.</p>

    <div class="row">
        <div class="col-lg-5 m-auto">
            <?php $form = ActiveForm::begin(['id' => 'resend-verification-email-form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <div class="form-advice">
                <p class=""> El correo de activación será enviado a dicha cuenta. </p>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
