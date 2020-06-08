<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = $model->apellido.' '.$model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idUsuario], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->idUsuario], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro de eliminar este usuario?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
      <div class="col-6">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'idUsuario',
                'nombre',
                'apellido',
                'dni',
                //'fecha_nacimiento',
                'localidad',
                //'telefono',
                'email:email',
                //'auth_key',
                //'password_hash',
                //'password_reset_token',
                'status',
                'created_at:datetime',
                'updated_at:datetime',
                //'verification_token',
            ],
        ]) ?>
      </div>
      <div class="col-6">
        <h3>Roles</h3>
        <ul class="list-group">
        <?php foreach ($roles as $rol): ?>
          <?php $assigned = yii::$app->authManager->getAssignment($rol->name, $model->idUsuario);?>
            <li class="list-group-item list-group-flush">
              <h4><?= $rol->name ?>
                <?= Html::a($assigned?"Quitar":"Agregar",
                ['usuario/assign', 'id' => $model->idUsuario, 'rol' => $rol->name],
                ['class' => $assigned?"btn btn-sm btn-danger ":"btn btn-sm btn-primary"]) ?>
                <small>
                  <p><?=$rol->description?></p>
                </small>
              </h4>
          </li>
        <?php endforeach;?>
        </ul>
      </div>
    </div>


</div>
