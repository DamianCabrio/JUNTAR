<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoriaEvento */

$this->title = 'Actualizar Categoria: ' . $model->descripcionCategoria;
$this->params['breadcrumbs'][] = ['label' => 'Categoria Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcionCategoria, 'url' => ['view', 'id' => $model->idCategoriaEvento]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="categoria-evento-update">
    <div class="col-12 mb-4 p-0">
        <div class="card">
            <h1 class="card-header text-center darkish_bg text-white"><?= Html::encode($this->title) ?></h1>

            <div class="card-body">
                <?=
                $this->render('_form', [
                    'model' => $model,
                ])
                ?>
            </div>
        </div>
    </div>
</div>
