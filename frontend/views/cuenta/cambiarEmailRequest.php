<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Solicitar cambio de email';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cuenta-cambiar-email-request container">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <p class="text-center"> Si realmente necesita cambiar su dirección de correo, puede solicitarlo aquí. </p>
    <p class="text-center"> Tenga en cuenta que la dirección debe ser única y que la cuenta actual será reemplazada por la nueva ingresada. </p>
    

    <div class="row">
        <div class="col-lg-5 m-auto">
            <?php $form = ActiveForm::begin(['id' => 'cambiar-email-request-form']); ?>
            <div  class="form-advice">
                <p> Se le enviará un correo a su cuenta para cambiar su email. </p>
                <p> Si desea volver atrás en este cambio, deberá pasar por el mismo proceso. </p>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Enviar Correo', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
