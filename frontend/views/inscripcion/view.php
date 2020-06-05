<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Inscripcion */

$this->title = $model->idInscripcion;
$this->params['breadcrumbs'][] = ['label' => 'Inscripcions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="inscripcion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idInscripcion], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idInscripcion], [
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
            'idInscripcion',
            'idUsuario',
            'idEvento',
            'estado',
            'fecha_preinscripcion',
            'fecha_inscripcion',
            'acreditacion',
            'certificado',
        ],
    ]) ?>

</div>
