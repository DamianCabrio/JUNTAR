<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Jugador */

$this->title = 'Desactivar Cuenta ';

$this->params['breadcrumbs'][] = 'Actualizar información';
?>
<div class="profile-update container">

    <h1 class="text-center"> Desactivar Mi cuenta </h1>
    <p> ¿Está seguro que desea desactivar su cuenta? Esta opción no le permitirá acceder al sitio hasta que pida un mail de activación. </p>

    <div class="row">
        <div class="col-lg-5 m-auto profileForm">
            <?php $form = ActiveForm::begin(); ?>
            <div class="form-group">
                <?= Html::submitButton('Desactivar Cuenta', ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>