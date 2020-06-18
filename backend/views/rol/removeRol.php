<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
?>
<div class="row">
  <div class="col-10 col  offset-1">
<?php
$this->title = 'Eliminar Rol';
$this->params['breadcrumbs'][] = ['label' => 'Rol', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rol-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->dropdownlist($item, ['class' => 'form-control', 'prompt'=>'Seleccione un rol...']); ?>

    <div class="form-group">
      <?= Html::submitButton('Eliminar', [
        'class' => 'btn btn-danger',
        'data' => [
          'confirm' => '¿Está seguro de querer eliminar el Rol?'
        ],
        ]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
