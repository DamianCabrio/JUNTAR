<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
$this->title = $evento->nombreEvento;
/* @var $model frontend\models\Evento */

$this->title = $model->idEvento;
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
            Html::a('Update', ['update', 'id' => $evento->idEvento], ['class' => 'btn btn-primary']);
            Html::a('Delete', ['delete', 'id' => $evento->idEvento], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        } ?>
        <?php

        switch ($estadoEvento){
            case "puedeInscripcion":
                echo Html::a('Inscribirse', ['inscripcion/preinscripcion', 'id' => $evento->idEvento], ['class' => 'btn btn-primary']);
                break;
            case "puedePreinscripcion":
                echo Html::a('Pre-inscribirse', ['inscripcion/preinscripcion', 'id' => $evento->idEvento], ['class' => 'btn btn-primary']);
                break;
            case "sinCupos":
                echo Html::label('Sin cupos');
                break;
            case "yaAcreditado":
                echo Html::label("Usted ya se acredito en este evento");
                break;
            case "inscriptoYEventoIniciado":
                echo Html::label("El evento ya inicio, pasela bien");
                break;
            case "yaPreinscripto":
                echo Html::a('Anular Pre-inscripcion', ['inscripcion/eliminar-inscripcion', 'id' => $evento->idEvento], ['class' => 'btn btn-primary']);
                break;
            case "yaInscripto":
                echo Html::a('Anular Inscripcion', ['inscripcion/eliminar-inscripcion', 'id' => $evento->idEvento], ['class' => 'btn btn-primary']);
                break;
            case "noInscriptoYFechaLimiteInscripcionPasada":
                echo Html::label('No se puede inscribir, el evento ya inicio');
                break;
            case "puedeAcreditarse":
                echo Html::a('Acreditación', ['acreditacion/acreditacion', 'id' => $evento->idEvento], ['class' => 'btn btn-primary']);
                break;
        }

        ?>

    </p>

    <?= DetailView::widget([
        'model' => $evento,
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
