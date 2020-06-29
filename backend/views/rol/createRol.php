<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
$this->title = 'Crear nuevo Rol';
$this->params['breadcrumbs'][] = ['label' => 'Rol', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12 m-auto">
        <div class="crear-rol">
            <div class="card text-center">
                <h1 class="card-header darkish_bg text-white"> <?= Html::encode($this->title) ?> </h1>
                <div class="card-body">
                    <div class="rol-form">
                        <?php $form = ActiveForm::begin(); ?>
                        <?php echo $form->field($model, 'name')->textInput(['class' => 'form-control rolName'])->Label("Rol: ") ?>
                        <?= $form->field($model, 'description')->textarea(['rows' => 6])->Label("Descripción: ") ?>
                        <div class="form-group">
                            <?= Html::submitButton('Registrar Rol', ['class' => 'assignValueFirst btn btn-pink col-md-2 col-sm-12']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
