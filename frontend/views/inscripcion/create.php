<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Inscripcion */

$this->title = 'Create Inscripcion';
$this->params['breadcrumbs'][] = ['label' => 'Inscripcions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inscripcion-create container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
