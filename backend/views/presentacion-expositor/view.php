<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PresentacionExpositor */

$this->title = $model->idExpositor;
$this->params['breadcrumbs'][] = ['label' => 'Presentacion Expositors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="presentacion-expositor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idExpositor' => $model->idExpositor, 'idPresentacion' => $model->idPresentacion], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idExpositor' => $model->idExpositor, 'idPresentacion' => $model->idPresentacion], [
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
            'idExpositor',
            'idPresentacion',
        ],
    ]) ?>

</div>
