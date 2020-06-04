<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Iniciar sesion';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
        <h1 class="text-center mb-2"><?= Html::encode($this->title) ?></h1>

        <div class="row">
            <div class="col-lg-5 m-auto">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'showpw', ['options' => ['class' => 'showpw']])->checkBox()->label("Mostrar Contraseña") ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label("Recordarme") ?>

                <div  class="form-advice">
                    Si olvidaste tu contraseña puedes <?= Html::a('restablecerla', ['site/request-password-reset']) ?>.
                    <br>
                    ¿No pudiste realizar la verificación? <?= Html::a('Solicitar nuevo correo de verificacion', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
</div>
