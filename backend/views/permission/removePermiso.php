<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = 'Eliminar Permiso';
$this->params['breadcrumbs'][] = ['label' => 'Rol', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="borrar-permiso">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <h1 class="card-header text-center darkish_bg text-white"> <?= Html::encode($this->title) ?> </h1>

                <div class="card-body">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'name')->dropdownlist($item, ['class' => 'form-control', 'prompt' => 'Seleccione un permiso...']); ?>

                    <div class="form-group">
                        <?=
                        Html::submitButton('Eliminar Permiso', [
                            'class' => 'btn btn-danger col-md-2 col-sm-12',
                            'data' => [
                                'confirm' => '¿Está seguro de querer eliminar el Permiso?'
                            ],
                        ])
                        ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>