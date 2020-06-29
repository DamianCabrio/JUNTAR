<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;

$this->title = 'Proyecto Juntar';
?>
<div class="site-index">
    <div class="body-content">
      <div class="row ">
      <div class="col-12 col-md-4 p-2">
        <div class="card text-center" style="width: 18rem;">
          <img class="card-img-top w-50 mx-auto d-block m-2"  src="<?= Yii::getAlias("@web/iconos/person.svg")?>" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Usuarios</h5>
            <p class="card-text">Panel para gestionar todos los usuario que están registrados en la plataforma.</p>
            <a href="<?= Url::to(['usuario/index']); ?>" class="btn btn-primary">Gestionar</a>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 p-2">
        <div class="card text-center" style="width: 18rem;">
          <img class="card-img-top w-50 mx-auto d-block m-2"  src="<?= Yii::getAlias("@web/iconos/shield-check.svg")?>" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Permisos</h5>
            <p class="card-text">Panel para gestionar los permisos que tiene los diferentes roles dentro de la plataforma.</p>
            <a href="<?= Url::to(['permission/index']); ?>" class="btn btn-primary">Gestionar</a>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 p-2">
        <div class="card text-center" style="width: 18rem;">
          <img class="card-img-top w-50 mx-auto d-block m-2"  src="<?= Yii::getAlias("@web/iconos/people.svg")?>" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Roles</h5>
            <p class="card-text">Panel para gestionar los Roles que se le pueden asignar a los usuarios.</p>
            <a href="<?= Url::to(['rol/index']); ?>" class="btn btn-primary">Gestionar</a>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-4 p-2">
        <div class="card text-center" style="width: 18rem;">
          <img class="card-img-top w-50 mx-auto d-block m-2"  src="<?= Yii::getAlias("@web/iconos/list-unordered.svg")?>" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Modalidades</h5>
            <p class="card-text">Dar de alta y modificar las modalidades que pueden tener los Eventos gestionados en la plataforma.</p>
            <a href="<?= Url::to(['modalidad-evento/index']); ?>" class="btn btn-primary">Gestionar</a>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 p-2">
        <div class="card text-center" style="width: 18rem;">
          <img class="card-img-top w-50 mx-auto d-block m-2"  src="<?= Yii::getAlias("@web/iconos/versions.svg")?>" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Eventos</h5>
            <p class="card-text">Panel para gestionar todos los Eventos que están registrados en la plataforma.</p>
            <a href="<?= Url::to(['evento/index']); ?>" class="btn btn-primary" >Gestionar</a>
          </div>
        </div>
      </div>
    </div>
    </div>
</div>
