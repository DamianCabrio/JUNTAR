<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */

$this->title = $model->tituloPresentacion;
$this->params['breadcrumbs'][] = ['label' => 'Presentacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="presentacion-view">

    

    <p>
        <?= Html::a('Cargar nueva Presentacion', ['cargar-presentacion'], ['class' => 'btn btn-primary']) ?>
    </p>
    <h2 class="text-center"> Presentacion <?= $model->tituloPresentacion ?> </h2>
    <p class="text-center">Muestra de presentacion recien cargada</p>
    <table class="table table-striped">
        
        <tbody>
            <tr>
                <th scope="col">Evento</th>
                <td><?= $evento->nombreEvento ?></td>
            </tr>
            <tr>
                <th scope="col">Titulo Presentacion</th>
                <td><?= $model->tituloPresentacion ?></td>
            </tr>
            <tr>
                <th scope="col">Descripcion Presentacion</th>
                <td><?= $model->descripcionPresentacion ?></td>
            </tr>
            <tr>
                <th scope="col">Hora Inicio Presentacion</th>
                <td><?= $model->horaInicioPresentacion ?></td>
            </tr>
            <tr>
                <th scope="col">Hora Fin Presentacion</th>
                <td><?= $model->horaFinPresentacion ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <h2 class="text-center"> Expositor</h2>
    <p class="text-center">Expositores asignados para la presentacion</p>
    <table class="table table-striped">
        
        <tbody>
            <tr>
                
                <th scope="col">Nombre Expositor</th>
                <td><?= $expo->nombre ?></td>
            </tr>
            <tr>
                <th scope="col">Email Contacto</th>
                <td><?= $expo->email ?></td>
            </tr>
        </tbody>
    </table>
</div>