<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoriaEvento */

$this->title = $model->descripcionCategoria;
$this->params['breadcrumbs'][] = ['label' => 'Categoria Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="categoria-evento-view">
    <div class="col-12 mb-4 p-0">
        <div class="card">
            <h1 class="card-header text-center darkish_bg text-white"><?= Html::encode($this->title) ?></h1>

            <p class="m-3">
                <?= Html::a('Actualizar', ['update', 'id' => $model->idCategoriaEvento], ['class' => 'btn btn-pink col-md-2 col-sm-12']) ?>
                <?=
                Html::a('Eliminar', ['delete', 'id' => $model->idCategoriaEvento], [
                    'class' => 'btn btn-pink col-md-2 col-sm-12',
                    'data' => [
                        'confirm' => '¿Estás seguro de querer eliminar esta categoría?',
//                        'method' => 'post',
                    ],
                ])
                ?>
            </p>

            <div class="card-body">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'idCategoriaEvento',
                        'descripcionCategoria',
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
</div>
