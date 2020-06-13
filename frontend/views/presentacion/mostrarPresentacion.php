<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\PresentacionExpositor;
/* @var $this yii\web\View */
/* @var $model frontend\models\Presentacion */

$this->title = $model->tituloPresentacion;
\yii\web\YiiAsset::register($this);

?>
<div class="container">
    <div class = "row">
        <div class = "col-md-8 col-12 m-auto">
             <h2 class="text-center">Presentación cargada</h2>
                <div class="p-3 mb-2 bg-success text-white text-center">
                    Su presentación ha sido cargado exitosamente
                </div>
                <br>
                <hr>
                <div class="d-flex justify-content-center">
                    <div>
                        <?= Html::a('Nueva Presentación', ['cargar-presentacion', 'idEvento' => $evento->idEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                        <?= Html::a('Ver evento', ['evento/ver-evento', 'idEvento' => $evento->idEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                        <?= Html::a('Editar evento ', ['evento/editar-evento', 'idEvento' => $evento->idEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                        <?= Html::a('Publicar evento ', ['evento/publicar-evento', 'idEvento' => $model->idEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                    </div>
                </div>    
        </div>
    </div>
</div>