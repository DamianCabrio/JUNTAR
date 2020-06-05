<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
<<<<<<< HEAD
/* @var $model common\models\Evento */
=======
/* @var $model common\models\evento */
>>>>>>> c0503ad64a517a0a11aecb6b2fd47fe90b2ea636

$this->title = 'Update Evento: ' . $model->idEvento;
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idEvento, 'url' => ['view', 'id' => $model->idEvento]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="evento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
