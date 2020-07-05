<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PresentacionExpositor */

$this->title = 'Update Presentacion Expositor: ' . $model->idExpositor;
$this->params['breadcrumbs'][] = ['label' => 'Presentacion Expositors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idExpositor, 'url' => ['view', 'idExpositor' => $model->idExpositor, 'idPresentacion' => $model->idPresentacion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="presentacion-expositor-update">
  <div class="col-12 mb-4 p-0">
      <div class="card">
          <h1 class="card-header text-center darkish_bg text-white"><?= Html::encode($this->title) ?></h1>

          <!--<div class="row">-->
          <!--<div class="col-12 col-sm-4">-->
          <div class="card-body">
              <?= $this->render('_form', [
                  'model' => $model,
                  'users' => $users,
                  'idPresentation' => null,
              ])?>
              <?=
              Html::button('<i class="material-icons large align-middle">keyboard_return</i>', [
                  'class' => 'btn btn-outline-info',
                  'onclick' => "history.go(-1)",
              ])
              ?>
          </div>
      </div>
  </div>
</div>
