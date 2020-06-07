<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
?>
<div class="row">
    <div class="col-6 col  offset-3">
        <?php
        $this->title = 'Crear nuevo Permiso';
        $this->params['breadcrumbs'][] = ['label' => 'Rol', 'url' => ['index']];
        $this->params['breadcrumbs'][] = $this->title;
        ?>
        <div class="rol-create">

            
            <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

            <?=
            $this->render('_rolForm', [
                'model' => $model,
                'permisos' => $permisos,
            ])
            ?>
        </div>
    </div>
</div>
