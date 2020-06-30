<?php

use yii\helpers\Html;
use yii\bootstrap\NavBar;
use yii\bootstrap4\Nav;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asignación de Roles';
//$this->params['breadcrumbs'][] = $this->title;
//print_r($permisos2);
//print_r($roles);
//echo "<br><br>";
//print_r($roles2);
//echo "<br><br>";
//print_r($permisos3);
//echo "<br><br>";
//print_r($permisos4);
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
        <div class="col-md-8 col-sm-12 m-auto d-none" id="dataPermission">
            <h1 class="text-center"> Asignar Roles </h1>
            <div class="row" id="dataContainer">
                <!--<div class="col-md-12 col-sm-12" id="roleDiv">-->
                <div class="row col-12" id="roleDiv">
                    <?php
                    foreach ($roles as $index => $rol) {
                        if ($rol['name'] != "Administrador") {
                            ?>
                            <div class="<?php echo'order-' . Html::encode($index); ?> roles col-md-6 col-sm-12 border" id="<?php echo Html::encode($rol['name']); ?>"> 
                                <p class="text-center"> <?php echo Html::encode($rol['name']); ?> </p>
                                <div class="roleActionDiv d-flex justify-content-center"></div>
                            </div>
                            <?php
                        }
                    }
//                    endforeach;
                    ?>
                </div>

                <div class="col-md-12 col-sm-12" id="permissionDiv">
                    <h1 class="text-center mt-4"> Asignar Permisos </h1>
                    <?php // \yii\widgets\Pjax::begin(['timeout' => 1000, 'clientOptions' => ['container' => 'pjax-container']]);  ?>
                    <?php Pjax::begin(); ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
//                        'filterModel' => $searchModel,
                        'columns' => [
//                            ['class' => 'yii\grid\SerialColumn'],
                            'name',
//                            'description:ntext',
                            [
                                'attribute' => 'description',
                                'format' => 'html',
                                'label' => 'Descripcion',
                                'value' => function ($data) {
                                    return Html::tag('dfn', Html::tag('abbr',
                                                            Html::img('iconos/question-circle.svg' . '', ['class' => 'd-none d-md-inline-block filter-blue', 'width' => '26px', 'height' => '26px'])
                                                            , ['title' => $data['description']]), ['class' => 'd-flex justify-content-center']) .
                                            Html::tag('p', $data['description'], ['class' => 'd-sm-none d-inline-block']);
                                },
                            ],
                            'columns' => [
                                'format' => 'raw',
                                'label' => '',
                                'value' => function($model, $key, $index, $column) {
                                    return Html::tag('div', '', ['class' => 'actionDiv d-flex justify-content-center']);
                                }
                            ],
                        ],
//                        'tableOptions' => [
//                                'id' => 'theDatatable',
//                                'class' => 'table table-responsive justify-content-center'
//                            ],
//                        'pager' => [
//                            'class' => '\yii\widgets\LinkPager',
////                            'pagination' => 6,
////                        // Css for each options. Links
//                            'linkOptions' => ['class' => 'btn btn-light pageLink'],
//                        //other pager config if nesessary
//                        ]
                    ]);
                    ?>
                    <?php
                    // display pagination
//                    LinkPager::widget([
//                        'pagination' => $pages,
//                        // Css for each options. Links
//                        'linkOptions' => ['class' => 'btn btn-light'],
//                    ]);
                    ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
        <!-- Tab contents by role -->
    </div>
