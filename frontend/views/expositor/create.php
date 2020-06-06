<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Expositor */

$this->title = 'Create Expositor';
$this->params['breadcrumbs'][] = ['label' => 'Expositors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expositor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
