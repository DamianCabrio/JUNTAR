<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listado de Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rol-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
      <div class="col-4">
        <ul class="nav nav-pills flex-column" id="nav-rol" role="tablist">
        <?php foreach ($roles as $rol): ?>

            <li class="nav-item">
              <a class="nav-link" data-toggle="pill" href="#<?= $rol->name ?>"><?= $rol->name ?></a>
            </li>

        <?php endforeach;?>
        </ul>
      </div>
      <div class="col-8">
        <div class="tab-content" id="tab-permission">
        <?php foreach ($roles as $rol): ?>
            <div id="<?= $rol->name ?>" class="tab-pane fade" role="tabpanel">

              <table class="table table-striped table-sm">
                <tbody>
                  <?php foreach ($permissions as $permission): ?>
                    <tr>
                <td><?=$permission->description?></td><td><?= $permission->name ?></td>
                <td>
                <?php $assigned = yii::$app->authManager->hasChild($rol, $permission);?>
                  <?= Html::a($assigned?"Deshabilitar":"Habilitar",
                  ['permission-manager/assing-permission','rol' => $rol->name, 'permission' => $permission->name],
                  ['class' => $assigned?"btn btn-sm btn-danger ":"btn btn-sm btn-primary"]) ?>
                </td>
              </tr>
            <?php endforeach;?>
            </tbody>
            </table>
            </div>
        <?php endforeach;?>
        </div>
      </div>
    </div>
</div>
<?php
$this->registerJs('$(function (){
  $("#tab-permission").children().first().addClass("active show");
  $("#nav-rol").children().first().children().addClass("active");
});', \yii\web\View::POS_READY);

?>
