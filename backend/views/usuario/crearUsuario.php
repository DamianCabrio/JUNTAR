<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Usuario */

$this->title = 'Crear Nuevo Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="crear-usuario">
    <div class="col-12 mb-4 p-0">
        <div class="card">
            <h1 class="card-header text-center darkish_bg text-white"><?= Html::encode($this->title) ?></h1>

            <div class="card-body">
                <div class="col-lg-5 m-auto">
                    <?php $form = ActiveForm::begin(['id' => 'registrar-usuario']); ?>

                    <div class="form-group">
                        <?= $form->field($model, 'nombre')->label('Nombre')->textInput(['placeholder' => 'Ejemplo: Juan']) ?>
                        <?= $form->field($model, 'apellido')->label('Apellido')->textInput(['placeholder' => 'Ejemplo: Perez']) ?>
                        <?= $form->field($model, 'pais')->label('Pais')->textInput(['value' => 'Argentina', 'placeholder' => 'Ejemplo: Argentina']); ?>
                        <?= $form->field($model, 'email')->input('email')->label('Dirección de Correo')->textInput(['placeholder' => 'Ejemplo: myEmail@gmail.com']); ?>
                    </div>
                    <div class="form-group mt-2">
                        <?= Html::submitButton('Registrar Usuario', ['class' => 'btn btn-pink col-sm-12', 'name' => 'signup-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>