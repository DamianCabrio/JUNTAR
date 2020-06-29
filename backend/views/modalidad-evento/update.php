<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ModalidadEvento */

$this->title = 'Actualizar Modalidad: ' . $model->descripcionModalidad;
$this->params['breadcrumbs'][] = ['label' => 'Modalidad Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcionModalidad, 'url' => ['view', 'id' => $model->idModalidadEvento]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="modalidad-evento-update">

  <div class="container">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
      <div class="col-12 col-sm-4">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
        <?= Html::button('<i class="material-icons large align-middle">keyboard_return</i>',[
          'class' => 'btn btn-outline-info',
          'onclick' => "history.go(-1)",
          ]) ?>
      </div>
    </div>
  </div>

</div>
