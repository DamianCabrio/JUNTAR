<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */

$this->title = 'Editar Presentacion: ' . $model->idPresentacion;
//$this->params['breadcrumbs'][] = ['label' => 'Presentacions', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->idPresentacion, 'url' => ['view', 'id' => $model->idPresentacion]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container">
<div class="presentacion-form">
    <?php
    if (!Yii::$app->user->isGuest && Yii::$app->user->identity->idUsuario == $model->idEvento0->idUsuario0->idUsuario) {
        ?>

        <h1><?= Html::encode($this->title) ?></h1>


            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'idEvento')->textInput() ?>

            <?= $form->field($model, 'tituloPresentacion')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'descripcionPresentacion')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'diaPresentacion')->textInput() ?>

            <?= $form->field($model, 'horaInicioPresentacion')->textInput() ?>

            <?= $form->field($model, 'horaFinPresentacion')->textInput() ?>

            <?= $form->field($model, 'linkARecursos')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>


        <?php
    } else {
        ?>
            <div class="row">
                <div class="col-12 text-center">
                    <div class="row">
                        <div class="col-12" style="padding-top: 4vh; padding-bottom: 4vh;">
                            <p class="display-1">403</p>
                        </div>
                    </div>
                    <p><b>Error</b>: usted no tiene permisos para gestionar este evento.</p>
                    <p>Si cree que esto es un error del servidor, contacte con un administrador del sistema</p>
                </div>
            </div>
    <?php } ?>
</div>
</div>
