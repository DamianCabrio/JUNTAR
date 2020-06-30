<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Asignación de Permisos';
$this->params['breadcrumbs'][] = ['label' => 'Rol', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asignar-permisos">

    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-12 mb-4">
            <h1 class="card-header text-center darkish_bg text-white"> <?= Html::encode($this->title) ?> </h1>
        </div>
        <!-- Roles tab links -->
        <div class="col-md-4 col-sm-12">
            <!-- inicio card Roles -->
            <div class="card text-center lightblue_bg">
                <h2 class="card-header text-center lightblue_bg text-white"> Roles </h2>
                <div class="card-body ">
                    <?php foreach ($roles as $rol) : ?>
                        <!-- inicio card unRol -->
                        <a class="btn col-12 p-0 mb-3" href="<?= Html::encode(Url::to(['/permission/asignar-permisos', 'unRol' => $rol['name']])) ?>">
                            <div class="card text-center bg-light d-block p-0">
                                <h5 class="card-header <?php
                                                        if ($rolSeleccionado == $rol['name']) {
                                                            //distinguimos el rol seleccionado coloreando su card
                                                            echo "pinkish_bg text-white";
                                                        }
                                                        ?>">
                                    <img class="<?php
                                                if ($rolSeleccionado == $rol['name']) {
                                                    echo "filter-white";
                                                }
                                                ?>" src="<?php echo Yii::getAlias('@web/iconos/' . $rol['name'] . '.svg') ?>" alt="<?= Html::encode($rol['name']) ?>" title="<?= Html::encode($rol['name']) ?>" width="40" height="40" role="img">
                                    <?= Html::encode($rol['name']) ?>
                                </h5>
                                <div class="card-body">
                                    <p class="card-text"> <?= Html::encode($rol['description']) ?> </p>
                                </div>
                            </div>
                        </a>
                        <!-- fin card unRol -->
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- fin card Roles-->
        </div>
        <!-- Roles tab links-->

        <!-- Contenido por rol -->
        <div class="col-md-8 col-sm-12" id="dataPermission">
            <div class="col-12 p-0">
                <!-- Card asignar rol -->
                <div class="card text-center">
                    <h4 class="card-header text-center lightblue_bg text-white"> Asignar Rol </h4>
                    <div class="card-body p-0 m-2">
                        <?php
                        foreach ($roles as $rol) :
                            if ($rol['name'] != "Administrador" && $rol['name'] != $rolSeleccionado) {
                        ?>
                                <!-- inicio card unRol -->
                                <a class="btn col-md-5 col-sm-12 p-0 m-auto mb-3" href="<?= Html::encode(Url::to(['/permission/asignar-permisos', 'unRol' => $rolSeleccionado, 'asignarPermiso' => $rol['name']])) ?>">
                                    <div class="card text-center bg-light p-0">
                                        <h5 class="card-header">
                                            <img src="<?php echo Yii::getAlias('@web/iconos/' . $rol['name'] . '.svg') ?>" alt="<?= Html::encode($rol['name']) ?>" title="<?= Html::encode($rol['name']) ?>" width="40" height="40" role="img">
                                            <?= Html::encode($rol['name']) ?>
                                            <?php
                                            if ($rolSeleccionado != null && $rolSeleccionado != '') {
                                                //buscamos si el rol seleccionado tiene asignados los permisos del rol para buscar la imagen correspondiente
                                                if (in_array($rol['name'], array_column($rolesAsignados, 'name'))) {
                                                    //si los tiene, cargamos el nombre de quitar
                                                    $nombreAccion = "Quitar";
                                                } else {
                                                    //si no, el nombre de agregar
                                                    $nombreAccion = "Agregar";
                                                }
                                                $rutaImagen = Yii::getAlias('@web/iconos/' . $nombreAccion . '.svg');
                                            } else {
                                                //si no hay rol seleccionado, no se carga ninguna imagen
                                                $rutaImagen = "";
                                                $nombreAccion = "";
                                            }
                                            ?>
                                            <img class="ml-3 <?= $nombreAccion ?>" src="<?= Html::encode($rutaImagen) ?>" alt="<?= Html::encode($nombreAccion) ?>" title="<?= Html::encode($nombreAccion) ?>" width="40" height="40" role="img">
                                        </h5>
                                    </div>
                                </a>
                                <!-- fin card unRol -->
                        <?php
                            }
                        endforeach;
                        ?>
                    </div>
                </div>
                <!-- Fin Card asignar rol -->
            </div>

            <div class="card text-center col-12 p-0 mt-4">
                <h4 class="card-header text-center lightblue_bg text-white"> Asignar Permiso </h4>
                <div class="col-md-12 col-sm-12 p-0 table-responsive" id="permissionDiv">
                    <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'summary' => '',
                            //                        'filterModel' => $searchModel,
                            'columns' => [
                                //                            ['class' => 'yii\grid\SerialColumn'],
                                //                            'name',
                                [
                                    'attribute' => 'name',
                                    'label' => 'Permiso',
                                    'value' => 'name',
                                    'headerOptions' => ['style' => 'width:40%;'],
                                ],
                                [
                                    'attribute' => 'description',
                                    'format' => 'html',
                                    'label' => 'Descripcion',
                                    'value' => 'description',
                                    //                                'value' => function ($data) {
                                    //                                    return Html::tag('dfn', Html::tag('abbr',
                                    //                                                            Html::img('iconos/question-circle.svg' . '', ['class' => 'd-none d-md-inline-block filter-blue', 'width' => '26px', 'height' => '26px'])
                                    //                                                            , ['title' => $data['description']]), ['class' => 'd-flex justify-content-center']) .
                                    //                                            Html::tag('p', $data['description'], ['class' => 'd-sm-none d-inline-block']);
                                    //                                },
                                    'headerOptions' => ['style' => 'width:50%;', 'class' => 'text-center'],
                                ],
                                [
                                    //genera una url para cada boton de accion
                                    'class' => 'yii\grid\ActionColumn',
                                    'urlCreator' => function ($action, $model, $key, $index) use ($rolSeleccionado) {
                                        if ($action == "update") {
                                            return Url::to(['/permission/asignar-permisos', 'unRol' => $rolSeleccionado, 'asignarPermiso' => $model['name']]);
                                        }
                                    },
                                    //describe los botones de accion
                                    'buttons' => [
                                        'view' => function ($url, $model) {
                                            return "";
                                        },
                                        'delete' => function ($url, $model) {
                                            return "";
                                        },
                                        'update' => function ($url, $model) use ($rolSeleccionado, $permisosAsignados) {
                                            if ($rolSeleccionado != null) {
                                                //bandera utilizada para evitar sobreescribir el resultado necesario
                                                //comprueba si tiene el permiso asignado o si lo hereda de algun otro rol
                                                $sobreescribir = true;

                                                foreach ($permisosAsignados as $clave => $permisosRol) :
                                                    //comprobacion para saber si tiene el permiso
                                                    if (in_array($model['name'], array_column($permisosRol, 'name'))) {
                                                        if ($clave == $rolSeleccionado && $sobreescribir) {
                                                            $nombreAccion = "Quitar";
                                                            $sobreescribir = false;
                                                        } else {
                                                            $nombreAccion = $clave;
                                                            $sobreescribir = false;
                                                        }
                                                    } else {
                                                        if ($sobreescribir) {
                                                            $nombreAccion = "Agregar";
                                                        }
                                                    }
                                                endforeach;

                                                //genera la imagen final a mostrar
                                                $rutaImagen = Yii::getAlias("@web/iconos/" . $nombreAccion . ".svg");
                                                $imagen = '<img src="' . $rutaImagen . '" alt="' . $nombreAccion . '" title="' . $nombreAccion . '" width="30" height="30" role="img">';

                                                if ($nombreAccion != "Quitar" && $nombreAccion != "Agregar") {
                                                    //si el permiso lo tiene por un rol, se agrega la imagen del rol sin enlace
                                                    return $imagen;
                                                } else {
                                                    //si no viene por rol, se agrega el enlace para quitar el permiso
                                                    return Html::a($imagen, $url, ['class' => "btn btn_icon $nombreAccion"]);
                                                }
                                            } else {
                                                return "";
                                            }
                                        },
                                    ],
                                    'header' => 'Accion',
                                    'headerOptions' => ['style' => 'width:10%;'],
                                ],
                            ],
                            'pager' => [
                                'class' => '\yii\widgets\LinkPager',
                                // Css for each options. Links
                                'linkOptions' => ['class' => 'btn btn-light pageLink'],
                                'disabledPageCssClass' => 'btn disabled',
                                'options' => ['class' => 'pagination d-flex justify-content-center'],
                                'prevPageLabel' => 'Anterior',
                                'nextPageLabel' => 'Siguiente',
                                //                            Current Active option value
                                'activePageCssClass' => 'activePage',
                            ],
                        ]);
                    ?>
                </div>
            </div>
        </div>
        <!-- Tab contents by role -->
    </div>
    <?php Pjax::end(); ?>
</div>