<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ModalidadEvento */

//$this->title = 'Create Modalidad Evento';
//$this->params['breadcrumbs'][] = ['label' => 'Modalidad Eventos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modalidad-evento-create">
<h6>Agregue una nueva Modalidad:</h6>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
