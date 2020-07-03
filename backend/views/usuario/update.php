<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\Usuario */

$this->title = 'Actualizar datos de ' . $model->nombre . ' ' . $model->apellido;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre . ' ' . $model->apellido, 'url' => ['view', 'id' => $model->idUsuario]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usuario-update">

    <div class="card">
        <div class="card-header darkish_bg text-white text-center">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <?php Pjax::begin(); ?>
        <div class="row">
            <div class="col-md-7 col-sm-12">
                <div class="card">
                    <div class="card-header darkish_bg text-white text-center mt-3">
                        <h4> Datos Usuario</h4>
                    </div>
                    <div class="card-body">
                        <?=
                        $this->render('_form', [
                            'model' => $model,
                        ])
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12">
                <?php if ($modelCambiarPw != null) { ?>
                    <div class="card">
                        <div class="card-header darkish_bg text-white text-center mt-3">
                            <h4> Editar </h4>
                        </div>
                        <div class="card-body">
                            <?php $form = ActiveForm::begin(['id' => 'cambiarPwBack']); ?>

                            <?= $form->field($modelCambiarPw, 'newPassword')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($modelCambiarPw, 'repeatNewPassword')->textInput(['maxlength' => true]) ?>

                            <div class="form-group">
                                <?= Html::submitButton('Guardar', ['class' => 'btn btn-pink']) ?>
                            </div>
                            <?php ActiveForm::end(); ?>

                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php Pjax::end(); ?>
    </div>
</div>