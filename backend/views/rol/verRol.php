<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Permiso */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Permisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="permiso-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // echo Html::a('Update', ['update-permiso', 'name' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['/rol/remove-rol', 'name' => $model->name], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de querer eliminar este Rol?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'attribute' => 'type',
                'label' => 'Tipo',
                'value' => ($model->type == 1)? 'Rol':'Permiso', //valor referenciado
            ],
            [
                'attribute' => 'description',
                'label' => 'Descripcion',
                'value' => $model->description, //valor referenciado
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Fecha Creación',
                'value' => date("Y-m-d H:i:s", $model->created_at), //valor referenciado
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Fecha Actualización',
                'value' => date("Y-m-d H:i:s", $model->updated_at), //valor referenciado
            ],
        ],
    ]) ?>

</div>
