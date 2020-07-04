<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Proyecto Juntar';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-4 p-2 d-flex justify-content-center">
                <div class="card text-center" style="width: 18rem;">
                    <img class="card-img-top w-50 m-auto d-block" src="<?= Yii::getAlias("@web/iconos/people.svg") ?>"
                         alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Usuarios</h5>
                        <p class="card-text">Panel para gestionar todos los usuarios que están registrados en la plataforma.</p>
                        <a href="<?= Url::to(['/usuario/index']); ?>" class="btn btn-pink">Gestionar</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 p-2 d-flex justify-content-center">
                <div class="card text-center" style="width: 18rem;">
                    <img class="card-img-top w-50 m-auto d-block "
                         src="<?= Yii::getAlias("@web/iconos/versions.svg") ?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Eventos</h5>
                        <p class="card-text">Panel para gestionar todos los Eventos que están registrados en la plataforma.</p>
                        <a href="<?= Url::to(['/evento/index']); ?>" class="btn btn-pink" >Gestionar</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 p-2 d-flex justify-content-center">
                <div class="card text-center" style="width: 18rem;">
                    <img class="card-img-top w-50 m-auto d-block m-2"
                         src="<?= Yii::getAlias("@web/iconos/solicitudesAval.svg") ?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"> Solicitudes de Aval </h5>
                        <p class="card-text"> Dar aval de la FAI a Eventos gestionados en la plataforma.</p>
                        <a href="<?= Url::to(['/solicitud-aval/solicitudes-de-aval']); ?>" class="btn btn-pink"> Gestionar </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 p-2 d-flex justify-content-center">
                <div class="card text-center" style="width: 18rem;">
                    <img class="card-img-top w-50 m-auto d-block m-2"
                         src="<?= Yii::getAlias("@web/iconos/list-unordered.svg") ?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Modalidades</h5>
                        <p class="card-text"> Alta y modificación de las modalidades que pueden tener los Eventos gestionados en la plataforma.</p>
                        <a href="<?= Url::to(['/modalidad-evento/index']); ?>" class="btn btn-pink">Gestionar</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 p-2 d-flex justify-content-center">
                <div class="card text-center" style="width: 18rem;">
                    <img class="card-img-top w-50 m-auto" src="<?= Yii::getAlias("@web/iconos/permisos.svg") ?>"
                         alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Permisos</h5>
                        <p class="card-text">Panel para gestionar los permisos que tienen los diferentes roles dentro de la plataforma.</p>
                        <a href="<?= Url::to(['/permission/index']); ?>" class="btn btn-pink">Gestionar</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 p-2 d-flex justify-content-center">
                <div class="card text-center" style="width: 18rem;">
                    <img class="card-img-top w-50 m-auto d-block m-2"
                         src="<?= Yii::getAlias("@web/iconos/roles.svg") ?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Roles</h5>
                        <p class="card-text">Panel para gestionar los Roles que se le pueden asignar a los usuarios.</p>
                        <a href="<?= Url::to(['/rol/index']); ?>" class="btn btn-pink">Gestionar</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 p-2 d-flex justify-content-center">
                <div class="card text-center" style="width: 18rem;">
                    <img class="card-img-top w-50 m-auto d-block m-2"  src="<?= Yii::getAlias("@web/iconos/categorias.svg") ?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Categorias</h5>
                        <p class="card-text"> Panel para gestionar las categorias de los eventos.</p>
                        <a href="<?= Url::to(['/categoria-evento/index']); ?>" class="btn btn-pink">Gestionar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
