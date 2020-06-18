<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
?>
<div class="row">
    <div class="col-6 col  offset-3">
        <?php
        $this->title = 'Crear nuevo Permiso';
        $this->params['breadcrumbs'][] = ['label' => 'Rol', 'url' => ['index']];
        $this->params['breadcrumbs'][] = $this->title;
        ?>
        <div class="rol-create">


            <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

            <div class="rol-form">

                <?php $form = ActiveForm::begin(); ?>
                <?php echo $form->field($model, 'name')->dropDownList($permisos, ['class' => 'form-control permissionName', 'prompt'=>'Seleccione un permiso... '])->Label("Permiso (Controller/Action):") ?>
                <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                <div class="form-group">
                    <?= Html::submitButton('Registrar Permiso', ['class' => 'assignValueFirst btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
