<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PresentacionExpositor */

$this->title = 'Asignar Expositor';
$this->params['breadcrumbs'][] = ['label' => 'Presentacion Expositors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="presentacion-expositor-create">
    <div class="col-12 mb-4 p-0">
        <div class="card">
            <h1 class="card-header text-center darkish_bg text-white"><?= Html::encode($this->title) ?></h1>

            <div class="card-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'idPresentation' => $idPresentation,
                    'users' => $users,
                ]) ?>
            </div>
        </div>
    </div>
</div>
