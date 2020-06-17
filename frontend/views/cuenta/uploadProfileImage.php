<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Jugador */

$this->title = 'Actualizar Información: ';

$this->params['breadcrumbs'][] = 'Actualizar información';
?>
<div class="profile-update container">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_form', ['model' => $model,]) ?>

    <div class="row">
        <div class="col-lg-5 m-auto uploadProfileImageForm">
            <?php $form = ActiveForm::begin(); ?>
            <!-- input image -->
            <?= $form->field($model, 'profileImage')->fileInput()->label('Ingrese una imagen de perfil:') ?>
            <div class="form-group">
                <?= Html::submitButton('Guardar Cambios', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>