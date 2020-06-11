<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contacto';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <p class="text-center"> Por cualquier consulta, complete el siguiente formulario para contactarnos. Muchas gracias. </p>

    <div class="row">
        <div class="col-lg-5 m-auto">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'nombre')->textInput(['autofocus' => true])->label("Nombre: ") ?>

                <?= $form->field($model, 'email')->label("Email: ") ?>

                <?= $form->field($model, 'asunto')->label("Asunto: ") ?>

                <?= $form->field($model, 'consulta')->textarea(['rows' => 6])->label("Consulta: ") ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'captchaAction' => 'site/captcha',
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
