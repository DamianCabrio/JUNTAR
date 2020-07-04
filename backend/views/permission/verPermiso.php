<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Permiso */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Permisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="permiso-view">
    <div class="card">

        <h1 class="card-header text-center darkish_bg text-white"> Permiso: <?= Html::encode($this->title) ?> </h1>

        <div class="card-body">
            <p class="m-3">
                <?php // echo Html::a('Update', ['update-permiso', 'name' => $model->name], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a('Eliminar Permiso', ['/permission/remove-permiso', 'name' => $model->name], [
                    'class' => 'btn btn-danger col-md-2 col-sm-12',
                    'data' => [
                        'confirm' => '¿Está seguro que desea eliminar este permiso?',
                    ],
                ])
                ?>
            </p>

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    [
                        'attribute' => 'type',
                        'label' => 'Tipo',
                        'value' => ($model->type == 1) ? 'Rol' : 'Permiso', //valor referenciado
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
                        'attribute' => 'updated_at',
                        'label' => 'Fecha Actualización',
                        'value' => date("Y-m-d H:i:s", $model->updated_at), //valor referenciado
                    ],
//            'created_at',
//            'updated_at',
                ],
            ])
            ?>
        </div>
    </div>

</div>
