<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Evento */

$this->title = $model->idEvento;
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="evento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idEvento], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idEvento], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idEvento',
            'idUsuario',
            'idCategoriaEvento',
            'idEstadoEvento',
            'idModalidadEvento',
            'nombreEvento',
            'nombreCortoEvento',
            'descripcionEvento',
            'lugar',
            'fechaInicioEvento',
            'fechaFinEvento',
            'imgFlyer',
            'imgLogo',
            'capacidad',
            'preInscripcion',
            'fechaLimiteInscripcion',
            'codigoAcreditacion',
            'fechaCreacionEvento',
        ],
    ]) ?>

</div>
