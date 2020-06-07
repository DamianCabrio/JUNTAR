<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = "Perfil";
$this->params['breadcrumbs'][] = $this->title;
$dataUser = array_shift($data);
//print_r($dataUser);
?>

<h1 class="text-center"> Información de la Cuenta </h1>
<div class='row'>
    <!-- Profile Sidebar Menu-->
    <div class="col-sm-3 mt-4 bg-profile-sidebar">
        <ul class="nav nav-tabs mt-2 text-center">
            <li class="nav-item profile-sidebar col-12">
                <a class="nav-link" data-toggle="tab" data-target="01" href=""> Información de la Cuenta </a>
            </li>
            <li class="nav-item profile-sidebar col-12">
                <a class="nav-link bg-gray" data-toggle="tab" data-target="02" href=""> Cambiar Contraseña </a>
            </li>
            <li class="nav-item profile-sidebar col-12">
                <a class="nav-link" data-toggle="tab" data-target="01" href=""> Preferencias de Email </a>
            </li>
            <li class="nav-item profile-sidebar col-12">
                <a class="nav-link bg-gray" data-toggle="tab" data-target="02" href=""> Desactivar mi Cuenta </a>
            </li>
            <li class="nav-item profile-sidebar col-12">
              <?php $assigned = yii::$app->authManager->getAssignment('Organizador', Yii::$app->user->identity->id); ?>
              <?php if (!$assigned): ?>
                <?= Html::a("Ser un Gestor de Eventos",
                ['cuenta/change-rol', 'id' => Yii::$app->user->identity->id],
                ['class' => $assigned?"btn btn-sm btn-outline-info":"btn btn-sm btn-outline-info"])?>
              <?php endif; ?>
            </li>
        </ul>
    </div>
    <!-- Profile Sidebar Menu-->

    <!-- Profile Card Content -->
    <div class="col-md-9 col-sm-4 mt-4 ">
        <div class="card">

            <!-- Profile Card Header -->
            <div class="card-header">
                <div class="row"> 
                    <h4 class="col-md-9 col-sm-12">Perfil de <?= Html::encode($dataUser['nombre'] . ' ' . $dataUser['apellido']); ?> </h4>
                    <?=
                    Html::a(' Editar Perfil '
                            . '<img class="ml-1" src="icons/pencil.svg" alt="Editar" width="18" height="18" title="Editar" role="img" style="margin-top: -4px;">',
                            Url::toRoute(['editprofile']),
                            ['class' => 'col-md-3 col-sm-12 btn btn-primary']);
                    ?>
                </div>
            </div>
            <!-- Profile Card Header -->

            <!-- Profile Card Body -->
            <div class="card-body col-12">
                <div class="row">

                    <!-- Profile Card Body IMG -->
                    <div class="col-md-5 col-sm-12">
                        <img class="card-img" width="450" height="400" src="icons/person-bounding-box.svg" title="<?= Html::encode($dataUser['nombre']); ?>">
                    </div>
                    <!-- Profile Card Body IMG -->

                    <!-- Profile Card Body Content -->
                    <div class="col-md-7 col-sm-12">
                        <table class="table table-hover table-responsive">
                            <tbody>
                                <tr>
                                    <th> Nombre: </td>
                                    <td> <?= Html::encode($dataUser['nombre']); ?> </td>
                                </tr>
                                <tr>
                                    <th> Apellido: </td>
                                    <td> <?php echo Html::encode($dataUser['apellido']); ?> </td>
                                </tr>
                                <tr>
                                    <th> DNI: </td>
                                    <td> <?php echo Html::encode($dataUser['dni']); ?> </td>
                                </tr>
                                <tr>
                                    <th> Fecha Nacimiento: </td>
                                    <td> <?php echo Html::encode($dataUser['fecha_nacimiento']); ?> </td>
                                </tr>
                                <tr>
                                    <th> Teléfono: </td>
                                    <td> <?php echo Html::encode($dataUser['telefono']); ?> </td>
                                </tr>
                                <tr>
                                    <th> Localidad: </td>
                                    <td> <?php echo Html::encode($dataUser['localidad']); ?> </td>
                                </tr>
                                <tr>
                                    <th> Email: </td>
                                    <td> <?php echo Html::encode($dataUser['email']); ?> </td>
                                </tr>
                                <tr>
                                    <th> Rol: </th>
                                    <td><?php echo Html::encode($dataUser['rol']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Profile Card Body Content -->

                </div>
            </div>
            <!-- Profile Card Body -->

        </div>
    </div>
    <!-- Profile Card Content -->

</div>

<!--<a href="<?= Url::toRoute(['club/listarposicionesclub']); ?>">Volver</a>-->
