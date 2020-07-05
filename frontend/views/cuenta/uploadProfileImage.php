<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Jugador */

$this->title = 'Actualizar imagen: ';

//$this->params['breadcrumbs'][] = 'Actualizar imagen ';
?>
<div class="profile-update container">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_form', ['model' => $model,]) ?>

    <div class="row">
        <div class="col-12 m-auto uploadProfileImageForm">
            <?php $form = ActiveForm::begin(['id' => 'updateProfileImage']); ?>
            <!-- input image -->
            <?= $form->field($model, 'profileImage')->fileInput()->label('Ingrese una imagen de perfil:') ?>
            <div class="form-group">
                <?= Html::submitButton('Guardar Cambios', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>