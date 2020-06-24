<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Evento */

$this->title = $model->nombreEvento;
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="evento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idEvento], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->idEvento], [
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
//            'idEvento',
            [
                'attribute' => 'idUsuario',
                'label' => 'Organizador',
                'value' => $model->idUsuario0->nombre, //valor referenciado
            ],
            [
                'attribute' => 'idCategoriaEvento',
                'label' => 'Categoria',
                'value' => $model->idCategoriaEvento0->descripcionCategoria, //valor referenciado por ActiveQuery
            ],
            [
                'attribute' => 'idEstadoEvento',
                'label' => 'Estado',
                'value' => $model->idEstadoEvento0->descripcionEstado, //valor referenciado por ActiveQuery
            ],
            [
                'attribute' => 'idModalidadEvento',
                'label' => 'Modalidad',
                'value' => $model->idModalidadEvento0->descripcionModalidad, //valor referenciado por ActiveQuery
            ],
            'nombreEvento',
            'nombreCortoEvento',
            'descripcionEvento',
            'lugar',
            'fechaInicioEvento',
            'fechaFinEvento',
            'imgFlyer',
            'imgLogo',
            'capacidad',
            [
                'attribute' => 'preInscripcion',
                'label' => 'Pre-Inscripcion',
                'value' => function ($dataProvider) {
//                    $fechaConBarras = date('d/m/Y', strtotime($dataProvider->diaPresentacion));
                    return ($dataProvider->preInscripcion == 0 ? 'No' : 'Si');
                }, //valor referenciado por ActiveQuery en el metodo idClub0
            ],
//            'preInscripcion',
            'fechaLimiteInscripcion',
            'codigoAcreditacion',
            'fechaCreacionEvento',
        ],
    ]) ?>

</div>
