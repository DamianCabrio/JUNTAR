<?php
use yii\helpers\Html;

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
                <a class="btn col-12 buttonRol" data-id="<?php echo Html::encode($rol['name']) ?>" href="#"> 
                    <?php echo $rol['name'] ?> 
                </a>
            <?php endforeach; ?>

        </div>
        <!-- Roles tab links-->

        <!-- Tab contents by role -->
        <div class="col-md-8 col-sm-12 m-auto d-none" id="dataPermission">
            <h1 class="text-center"> Permisos </h1>
            <div class="row" id="dataContainer">
                <div class="col-md-3 col-sm-12" id="roleDiv">
                    <?php
                    foreach ($roles as $index => $rol) {
                        if ($rol['name'] != "Administrador") {
                            ?>
                            <div class="<?php echo'order-' . Html::encode($index); ?> roles" id="<?php echo Html::encode($rol['name']); ?>"> 
                                <p> <?php echo Html::encode($rol['name']); ?> </p>
                                <div class="roleActionDiv"></div>
                            </div>
                            <?php
                        }
                    }
//                    endforeach;
                    ?>
                </div>

                <div class="col-md-9 col-sm-12" id="permissionDiv">
                    <table class="table table-hover table-sm table-responsive" id="permissionTable">
                        <tbody>
                            <?php foreach ($permisos as $index => $unPermiso): ?>
                                <tr class="<?php echo Html::encode($unPermiso['name']); ?>">
                                    <td class="col-md-6">  <?php echo Html::encode($unPermiso['name']); ?>  </td>
                                    <td class="col-md-2">
                                        <dfn>
                                            <abbr title="<?php echo Html::encode($unPermiso['description']); ?>">
                                                <img src="iconos/question-circle.svg" class="d-none d-md-inline-block filter-blue fixed-right" role="img" width="20" height="20" style="margin: 0px 10px 0 20px;">
                                            </abbr>
                                        </dfn>
                                        <p class="d-sm-none d-inline-block"> <?php echo Html::encode($unPermiso['description']); ?> </p>
                                    </td>
                                    <td class="col-md-4 actionDiv">
                                        <!--<div class="col-md-2 <?php // echo "button".Html::encode($unPermiso['name']);      ?>"></div>-->
                                        <!--<div class="col-md-2 buttonDiv"></div>-->
                                        <!--<div class="col-md-2 textRoleDiv"></div>-->
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Tab contents by role -->
    </div>