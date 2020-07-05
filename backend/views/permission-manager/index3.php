<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asignación de Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rol-index">


    <div class="row">
        <!-- Roles tab links -->
        <div class="col-md-4 col-sm-12">
            <h1 class="text-center"> Roles </h1>
            <ul class="nav nav-pills flex-column" id="nav-rol" role="tablist">
                <?php foreach ($roles as $rol): ?>
                    <li class="nav-item">
                        <a class="nav-link text-center" data-toggle="pill"
                           href="#<?= $rol->name ?>"><?= $rol->name ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- Roles tab links-->

        <!-- Tab contents by role -->
        <div class="col-md-8 col-sm-12 m-auto">
            <h1 class="text-center"> Permisos </h1>
            <div class="tab-content" id="tab-permission">
                <?php foreach ($roles as $rol): ?>
                    <div id="<?= $rol->name ?>" class="tab-pane fade" role="tabpanel">

                        <!-- Table with contents -->
                        <table class="table table-striped table-sm table-responsive-sm table-responsive-md ">
                            <tbody>
                            <?php
                            foreach ($permisos as $key => $unPermiso):
                                $assigned = yii::$app->authManager->hasChild($rol, $unPermiso);
                                ?>
                                <tr>
                                    <td>
                                        <?= $unPermiso->name ?>
                                        <dfn>
                                            <abbr title="<?php echo $unPermiso->description ?>">
                                                <img src="icons/question-circle.svg"
                                                     class="filter-blue d-block float-right" role="img" width="20"
                                                     height="20" style="margin: 8px 10px 0 20px;">
                                            </abbr>
                                        </dfn>
                                    </td>
                                    <td>

                                        <?=
                                        Html::a($assigned ? '<img src="icons/x-circle.svg" class="filter-red" alt="Quitar" title="Quitar" role="img" width="20" height="20" style="margin-top: 4px 0 0;">' : '<img src="icons/plus-circle.svg" class="filter-green" alt="Agregar" title="Agregar" role="img" width="20" height="20" style="margin-top: 4px 0 0;">',
                                            ['permission-manager/assing-permission', 'rol' => $rol->name, 'permission' => $unPermiso->name],
                                            ['class' => $assigned ? "btn btn-sm btn-light" : "btn btn-sm btn-light"])
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- Table with contents -->

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Tab contents by role -->

    </div>
</div>
<?php
$this->registerJs('$(function (){
  $("#tab-permission").children().first().addClass("active show");
  $("#nav-rol").children().first().children().addClass("active");
});', View::POS_READY);
?>
