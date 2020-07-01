<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;

$this->title = "Perfil";
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid padding_section dark_light_bg" style="min-height: 100vh;">
    <div class="container">
        <div class="card">
            <div class="card-header pinkish_bg">
                <h2 class="text-center text-white">Información de la Cuenta</h2>
            </div>
            <div class="card-body">
            
        <div class='row'>
            <!-- Profile Sidebar Menu-->
            <div class="col-sm-3 mt-4 bg-profile-sidebar">
                <ul class="nav nav-tabs mt-2 text-center">
                    <li class="nav-item profile-sidebar col-12">
                        <a class="nav-link active" href="profile"> Información de la Cuenta </a>
                    </li>
                    <li class="nav-item profile-sidebar col-12">
                        <?= Html::a('Cambiar Contraseña', ['cuenta/cambiar-password'], ['class' => 'nav-link']);?>
                    </li>
                    <!-- a futuro -->
                    <li class="nav-item profile-sidebar col-12">
                        <?= Html::a('Cambiar dirección de correo', ['cuenta/cambiar-email-request'], ['class' => 'nav-link']);?>
                    </li>
                    <!-- a futuro -->
                    <!--                <li class="nav-item profile-sidebar col-12">
                    <a class="nav-link" href=""> Preferencias de Email </a>
                </li>-->
                    <li class="nav-item profile-sidebar col-12">
                        <a class="nav-link bg-gray" href="<?= Url::toRoute(['cuenta/desactivar-cuenta']) ?>"> Desactivar mi Cuenta </a>
                    </li>
                    <!--<li class="nav-item mt-2 profile-sidebar col-12">-->
                    <?php // $assigned = yii::$app->authManager->getAssignment('Organizador', Yii::$app->user->identity->id); 
                    ?>
                    <?php // if (!$assigned): 
                    ?>
                    <?php // echo
                    //                        Html::a("Ser un Gestor de Eventos",
                    //                                ['cuenta/change-rol', 'id' => Yii::$app->user->identity->id],
                    //                                ['class' => $assigned ? "btn btn-sm btn-outline-info" : "btn btn-sm btn-outline-info"])
                    ?>
                    <?php // endif; 
                    ?>
                    <!--</li>-->
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
                            <?php $urlPencil = Url::base(true) . '/iconos/pencil.svg'; ?>
                            <?=
                                Html::a(
                                    ' Editar Perfil '
                                        . Html::img($urlPencil, [
                                            "alt" => "Editar", "title" => "Editar", "width" => "18", "height" => "18", "role" => "img",
                                            "class" => "ml-1 filter-white", "style" => "margin-top: -4px;", "data-id" => Url::toRoute(["editprofile"])
                                        ]),
                                    Url::toRoute(['editprofile']),
                                    ['class' => 'col-md-3 col-sm-12 btn btn-primary editProfile', "data-id" => Url::toRoute(["editprofile"])]
                                );
                            ?>
                        </div>
                    </div>
                    <!-- Profile Card Header -->

                    <!-- Profile Card Body -->
                    <div class="card-body col-12">
                        <div class="row">

                            <!-- Profile Card Body IMG -->
                            <div class="col-md-5 col-sm-12">
                                <img class="card-img" width="100%" height="" src="<?php echo $profileImage ?>" title="<?= Html::encode($dataUser['nombre']); ?>">
                                <!-- Input profile image -->
                                <div class=".text-center d-flex justify-content-center">
                                    <?php $urlUpload = Url::base(true) . '/iconos/cloud-upload.svg'; ?>
                                    <?=
                                        Html::a(
                                            ' Subir imagen '
                                                . Html::img($urlUpload, [
                                                    "alt" => "Subir Imagen", "title" => "Subir Imagen", "width" => "18", "height" => "18",
                                                    "role" => "img", "class" => "ml-1"
                                                ]),
                                            Url::toRoute(['upload-profile-image']),
                                            ['class' => 'btn btn-primary uploadProfileImage', "data-id" => Url::toRoute(["upload-profile-image"])]
                                        );
                                    ?>
                                </div>
                                <?php // echo $form->field($modelLogo, 'imageLogo')->fileInput()->label('Ingrese logo [solo formato png, jpg y jpeg]') 
                                ?>
                            </div>
                            <!-- Profile Card Body IMG -->

                            <!-- Profile Card Body Content -->
                            <div class="col-md-7 col-sm-12 mt-3">
                                <div class="row">
                                    <div class="col-8 mb-3">
                                        <h5>Nombre:</h5>
                                        <?= Html::encode($dataUser['nombre']) . ' ' . Html::encode($dataUser['apellido']); ?>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <h5> DNI: </h5>
                                        <?= Html::encode($dataUser['dni']); ?>
                                    </div>
                                    <div class="col-12 mb-5">
                                        <h5> Email: </h5>
                                        <?= Html::encode($dataUser['email']); ?>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <h5> Pais: </h5>
                                        <?= Html::encode($dataUser['pais']); ?>
                                    </div>
                                    <div class="col-md-4 col-sm-3">
                                        <h5> Provincia: </h5>
                                        <?= Html::encode($dataUser['provincia']); ?>
                                    </div>
                                    <div class="col-md-4 col-sm-5">
                                        <h5> Localidad: </h5>
                                        <?= Html::encode($dataUser['localidad']); ?>
                                    </div>

                                </div>
                            </div>
                            <!-- Profile Card Body Content -->

                        </div>
                    </div>
                    <!-- Profile Card Body -->

                </div>
                <?php
                Modal::begin([
                    'id' => 'profileModal',
                    'size' => 'modal-lg'
                ]);
                Modal::end();
                //Este es un comentario del señor yii modales: DAMIÁN, DEJÁ DE BORRAR COSAS
                ?>
            </div>
            <!-- Profile Card Content -->

        </div>
            </div>
        </div>

    </div>
</div>