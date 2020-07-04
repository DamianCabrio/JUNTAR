<?php

/* @var $this yii\web\View */
/* @var $model app\models\ModalidadEvento */

//$this->title = 'Create Modalidad Evento';
//$this->params['breadcrumbs'][] = ['label' => 'Modalidad Eventos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modalidad-evento-create">
    <div class="col-12 mb-4 p-0">
        <div class="card">
            <h1 class="card-header text-center darkish_bg text-white">Nueva Modalidad:</h1>
            <div class="card-body">
                <?=
                $this->render('_form', [
                    'model' => $model,
                ])
                ?>
            </div>
        </div>
    </div>
</div>