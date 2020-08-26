<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Presentacion */

$this->title = $model->idPresentacion;
$this->params['breadcrumbs'][] = ['label' => 'Presentacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="presentacion-view">
    <div class="col-12 mb-4 p-0">
        <div class="card">
            <h1 class="card-header text-center darkish_bg text-white"><?= Html::encode($model->tituloPresentacion) ?></h1>

            <p class="m-3">
                <?= Html::a('Volver', ['/presentacion/list-of-presentation', 'id' => $model->idEvento], ['class' => 'btn btn-pink']) ?>
            </p>
            <div class="card-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'idEvento',
                            'label' => 'Evento',
                            'value' => $model->idEvento0->nombreEvento,
                        ],
                        'tituloPresentacion',
                        'descripcionPresentacion',
                        'diaPresentacion',
                        'horaInicioPresentacion',
                        'horaFinPresentacion',
                        'linkARecursos',
                    ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
