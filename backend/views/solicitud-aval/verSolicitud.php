<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SolicitudAval */

$this->title = $model->idSolicitudAval;
$this->params['breadcrumbs'][] = ['label' => 'Solicitud Avals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="solicitud-aval-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idSolicitudAval], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idSolicitudAval], [
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
            'idSolicitudAval',
            'idEvento',
            'fechaSolicitud',
            'tokenSolicitud',
            'fechaRevision',
            'avalado',
            'validador',
        ],
    ]) ?>

</div>
