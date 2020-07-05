<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
$this->title = 'Crear Nuevo Permiso';
$this->params['breadcrumbs'][] = ['label' => 'Rol', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class=" col-sm-12 m-auto">
        <div class="crear-permiso">
            <div class="card text-center">
                <h1 class="card-header text-center darkish_bg text-white"> <?= Html::encode($this->title) ?> </h1>
                <div class="card-body">

                    <div class="row d-flex justify-content-center">
                        <div class="card text-center col-md-6 col-sm-12 border-0 p-0 mb-3">
                            <a class="btn btn-light col-md-9 col-sm-12 p-0 m-auto border" href="<?= Html::encode(Url::to(['permission/create-permiso', 'entorno' => 'backend'])) ?>">
                                <h5 class="card-header <?php
                                if ($entorno == 'backend') {
                                    echo "pinkish_bg text-white";
                                }
                                ?>">
                                    <img class="<?php
                                    if ($entorno == 'backend') {
                                        echo "filter-white";
                                    }
                                    ?>" src="<?php echo Yii::getAlias('@web/iconos/backend.svg') ?>" alt="backend" title="backend" width="40" height="40" role="img">
                                    Backend
                                </h5>
                            </a>
                        </div>
                        <div class="card text-center col-md-6 col-sm-12 border-0 p-0 mb-3">
                            <a class="btn btn-light col-md-9 col-sm-12 p-0 m-auto border" href="<?= Html::encode(Url::to(['permission/create-permiso', 'entorno' => 'frontend'])) ?>">
                                <h5 class="card-header <?php
                                if ($entorno == 'frontend') {
                                    echo "pinkish_bg text-white";
                                }
                                ?>">
                                    <img class="<?php
                                    if ($entorno == 'frontend') {
                                        echo "filter-white";
                                    }
                                    ?>" src="<?php echo Yii::getAlias('@web/iconos/frontend.svg') ?>" alt="backend" title="backend" width="40" height="40" role="img">

                                    Frontend
                                </h5>
                            </a>
                        </div>
                    </div>
                    <div class="rol-form">
                        <?php $form = ActiveForm::begin(['id' => 'crear-permiso']); ?>
                        <?php echo $form->field($model, 'name')->dropDownList($permisos, ['class' => 'form-control permissionName', 'prompt' => 'Seleccione un permiso... '])->Label("Permiso (Controller/Action):") ?>
                        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                        <div class="form-group">
                            <?= Html::submitButton('Registrar Permiso', ['class' => 'assignValueFirst btn btn-pink col-md-2 col-sm-12']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
