<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\Usuario */

$this->title = 'Asignar nueva contraseña';
?>
<div class="usuario-update">

    <div class="card">
        <div class="card-header darkish_bg text-white text-center">
            <h4><?= Html::encode($this->title) ?></h4>
        </div>
        <div class="row">
            <div class="col-md-8 col-sm-12 m-auto">
                <div class="card">
                    
                    <div class="card-body">
                    <?php $form = ActiveForm::begin(['id' => 'cambiarPwBack']); ?>

                    <?= $form->field($modelCambiarPw, 'newPassword')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($modelCambiarPw, 'repeatNewPassword')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Asignar Contraseña', ['class' => 'btn btn-pink col-md-3 col-sm-12']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>

                </div>
                </div>
            </div>
    </div>
</div>
