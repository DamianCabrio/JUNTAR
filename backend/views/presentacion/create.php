<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Presentacion */

$this->title = 'Crear Presentación';
$this->params['breadcrumbs'][] = ['label' => 'Presentacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="presentacion-create">
    <div class="col-12 mb-4 p-0">
        <div class="card">
            <h1 class="card-header text-center darkish_bg text-white"><?= Html::encode($this->title) ?></h1>

            <div class="card-body">
              <?= $this->render('_form', [
                  'model' => $model,
                  'id' => $idEvent,
              ]) ?>
            </div>
        </div>
    </div>
</div>
