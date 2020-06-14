<?php

use yii\helpers\Html;
use yii\bootstrap\NavBar;
use yii\bootstrap4\Nav;

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
            <?php foreach ($roles as $rol): ?>
                <a class="btn col-12 buttonRol nav-link" data-toggle="pill" data-id="<?php echo Html::encode($rol['name']) ?>" href="#"> 
                    <?php echo $rol['name'] ?> 
                </a>
            <?php endforeach; ?>

        </div>
        <!-- Roles tab links-->

        <!-- Tab contents by role -->
        <div class="col-md-8 col-sm-12 m-auto">
            <h1 class="text-center"> Permisos </h1>
            <div class="row invisible" id="dataContainer">
                <div class="col-md-3 col-sm-12" id="roleDiv">
                    <?php
                    foreach ($roles as $index => $rol):
                        if ($rol['name'] != "Administrador") {
                            ?>
                            <div class="<?php echo'order-' . Html::encode($index); ?>" id="<?php echo Html::encode($rol['name']); ?>"> 
                                <p> <?php echo Html::encode($rol['name']); ?> </p>
                                <span class="imageDiv"></span>
                            </div>
                            <?php
                        }
                    endforeach;
                    ?>
                </div>

                <div class="col-md-9 col-sm-12" id="permissionDiv">
                    <table class="table table-hover table-sm table-responsive" id="permissionTable">
                        <tbody>
                            <?php foreach ($permisos as $index => $unPermiso): ?>
                                <tr class="<?php echo Html::encode($unPermiso['name']); ?>">
                                    <td class="col-6">  <?php echo Html::encode($unPermiso['name']); ?>  </td>
                                    <td class="col-4">
                                        <dfn>
                                            <abbr title="<?php echo Html::encode($unPermiso['description']); ?>">
                                                <img src="icons/question-circle.svg" class="d-none d-md-inline-block filter-blue fixed-right" role="img" width="20" height="20" style="margin: 0px 10px 0 20px;">
                                            </abbr>
                                        </dfn>
                                        <p class="d-sm-none d-inline-block"> <?php echo Html::encode($unPermiso['description']); ?> </p>
                                    </td>
                                    <td class="col-2">
                                        <!--<div class="col-md-2 <?php // echo "button".Html::encode($unPermiso['name']); ?>"></div>-->
                                        <div class="col-md-2 buttonDiv"></div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Tab contents by role -->

        </div>
    </div>
    <?php
    $this->registerJs('$(function (){
  $("#tab-permission").children().first().addClass("active show");
  $("#nav-rol").children().first().children().addClass("active");
});', \yii\web\View::POS_READY);
    ?>
