<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Evento */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-8 col-12 m-auto">
        <h2 class="text-center">Eventos que posee cargados</h2>
        <p class="text-center">A continuación posee una lista con todos sus eventos cargados</p>

        <table class="table">
            <tbody>
                <tr>
                    <th scope="col">Nombre del evento</th>
                    <td> </td>
                <tr>
                    <?php foreach ($model as $objEvento) : ?>
                <tr>
                    <td><?= $objEvento->nombreEvento ?></td>
                    <td>
                        <?= Html::a('Informacion', ['informacion-evento', 'idEvento' => $objEvento->idEvento], ['class' => 'btn btn-outline-success btn-sm']) ?>
                        <!--<button type="button" class="btn btn-outline-success btn-sm">Informacion</button>-->
                        <button type="button" class="btn btn-outline-success btn-sm">Editar</button>
                        <button type="button" class="btn btn-outline-success btn-sm">Presentaciones</button>
                    </td>
                <tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>