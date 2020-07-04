<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ModalidadEvento */

$this->title = $model->descripcionModalidad;
$this->params['breadcrumbs'][] = ['label' => 'Modalidad Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="modalidad-evento-view">
    <div class="col-12 mb-4 p-0">
        <div class="card">
            <h1 class="card-header text-center darkish_bg text-white"><?= Html::encode($this->title) ?></h1>

            <p class="m-3">
                <?= Html::a('Actualizar', ['update', 'id' => $model->idModalidadEvento], ['class' => 'btn btn-pink col-md-2 col-sm-12']) ?>
                <?=
                Html::a('Borrar', ['delete', 'id' => $model->idModalidadEvento], [
                    'class' => 'btn btn-danger col-md-2 col-sm-12',
                    'data' => [
                        'confirm' => '¿Está seguro de querer borrar esta modalidad?',
//                'method' => 'post',
                    ],
                ])
                ?>
            </p>

            <div class="card-body">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'idModalidadEvento',
                        'descripcionModalidad',
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
</div>