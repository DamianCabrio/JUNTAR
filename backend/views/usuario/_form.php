<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>
<?php echo Html::a('Enviar restaurar contraseña', ['usuario/restore-password', 'id' => $model->idUsuario], ['class' => 'btn btn-warning col-md-12 col-sm-12 mb-4']) ?>
<div class="usuario-form">

    <?php $form = ActiveForm::begin(['id' => 'userFormBack']); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellido')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dni')->textInput()->label('DNI') ?>

    <?= $form->field($model, 'pais')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'provincia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'localidad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>



    <?php // echo $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>
    <?php if (!empty($model) && $model != null && $model->status != 0): ?>
        <div class="form-group">
            <?php echo $form->field($model, 'password_hash')->textInput(['maxlength' => true, 'disabled' => true]) ?>
            <?php echo Html::a('Cambiar contraseña', ['/usuario/cambiar-password', 'id' => $model->idUsuario], ['class' => 'btn btn-pink col-md-3 col-sm-12 popUpChangePassword']) ?>
        </div>
    <?php endif; ?>
    <?=
    $form->field($model, 'status')->textInput()->dropDownList([
        '0' => 'Eliminado',
        '9' => 'Inactivo',
        '10' => 'Activo',
    ])->label('Estado')
    ?>

    <?php // echo $form->field($model, 'created_at')->textInput() ?>

    <?php // echo $form->field($model, 'updated_at')->textInput() ?>

    <?php // echo $form->field($model, 'verification_token')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-pink col-md-2 col-sm-12']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
