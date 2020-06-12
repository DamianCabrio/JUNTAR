<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Evento */

$this->title = $model->nombreEvento;
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="evento-view container">

    <h1><?= Html::encode($this->title) ?></h1>
    <h1><?= Html::encode('Cupos restantes:'.$cupos) ?></h1>

    <p>
        <?php
        if (!Yii::$app->user->can('Administrador')) {
            Html::a('Update', ['update', 'id' => $model->idEvento], ['class' => 'btn btn-primary']);
            Html::a('Delete', ['delete', 'id' => $model->idEvento], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        } ?>
        <?PHP
        if (!$yaInscripto && !$noHayCupos) {
            if ($model->preInscripcion == 1 && $model->fechaLimiteInscripcion >= date("Y-m-d")) {
                if($cupos>0)
                {
                    echo Html::a('Pre-inscribirse', ['inscripcion/preinscripcion', 'id' => $model->idEvento], ['class' => 'btn btn-primary']);

                }

            } else if ($model->preInscripcion == 0) {
                if($cupos>0)
                {
                    echo Html::a('Inscribirse', ['inscripcion/preinscripcion', 'id' => $model->idEvento], ['class' => 'btn btn-primary']);
                }else{
                    echo Html::a('Sin cupos', ['inscripcion/preinscripcion', 'id' => $model->idEvento], ['class' => 'btn btn-primary disabled']);
                }

            }
        } else {
            if($noHayCupos && !$yaInscripto){
                echo Html::a('Sin cupos', ['inscripcion/preinscripcion', 'id' => $model->idEvento], ['class' => 'btn btn-primary disabled']);
            }
            //Anular Inscripcion antes de la fecha del evento
            elseif ($acreditacion != 1 && $evento->fechaInicioEvento > date("Y-m-d") ) {// * condicionar con la fecha hoy  menor estricto fecha inicio  hoy()<FechaIncio
                echo Html::a('Anular Inscripcion', ['inscripcion/eliminar-inscripcion', 'id' => $model->idEvento], ['class' => 'btn btn-primary']);
            }elseif ( $evento->fechaInicioEvento <= date("Y-m-d") ){
                echo Html::label('El evento ya esta iniciado');
            }
        }
        if ($evento->fechaInicioEvento <= date("Y-m-d") && $yaInscripto && $acreditacion != 1 && $model->codigoAcreditacion != null) {
            echo Html::a('Acreditación', ['acreditacion/acreditacion', 'id' => $model->idEvento], ['class' => 'btn btn-primary']);
        } else if ($acreditacion == 1) {
            echo Html::label("Usted ya se acredito en este evento");
        }

        ?>

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
