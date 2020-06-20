<?php

/* @var $this yii\web\View */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\bootstrap4\LinkPager;

$this->title = 'Proyecto Juntar';
?>
<div class="site-index">

    <div class="body-content">
        <header class="hero gradient-hero">
            <div class="center-content">
                <?= Html::img('images/juntar-logo/svg/juntar-logo-w.svg',  ['class' => 'img-fluid padding_logo']); ?>
                <br>
                <h5 class="text-white text-uppercase">Sistema Gestión de Eventos</h5>
                <br>
                <a href="#events" class="btn btn-primary btn-lg text-uppercase">Empezar</a>
            </div>
        </header>
        <section class="darkish_bg" id="events">
            <div class="container padding_select">
                <form action="#events">
                    <div class="form-group row">

                        <div class="col-sm-12 col-md-4 mb-3">
                            <select name="estadoEvento" class="custom-select custom-select-lg" onchange="this.form.submit()">
                                <option <?= (isset($_GET["estadoEvento"]) && $_GET["estadoEvento"] == 0) ? "selected" : "" ?> value="0">Estado activo</option>
                                <option <?= (isset($_GET["estadoEvento"]) && $_GET["estadoEvento"] == 0) ? "selected" : "" ?> value="1">Estado suspendido</option>
                                <option <?= (isset($_GET["estadoEvento"]) && $_GET["estadoEvento"] == 0) ? "selected" : "" ?> value="2">Estado finalizado</option>
                            </select>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-3">
                            <input class="form-control-lg full_width" type="search" placeholder="Buscar" name="s" value="<?= isset($_GET["s"]) ? $_GET["s"] : "" ?>">
                        </div>

                        <div class="col-sm-12 col-md-2 mb-3">
                            <button class="btn btn-outline-success btn-lg full_width" type="submit">Buscar</button>
                        </div>
                        <div class="col-sm-12 col-md-2 mb-3">
                            <?= Html::a('Restablecer', ["index#events"], ['class' => 'btn btn-secondary btn-lg full_width']); ?>
                        </div>

                    </div>
                </form>
            </div>
        </section>
        <section class="dark_bg">
            <div class="container padding_section">
                <?php if (count($eventos) != 0): ?>
            <h2 class="text-white text-uppercase">Mis eventos</h2><br>
                <div class="row">
                    <?php foreach ($eventos as $evento): ?>
                        <div class='col-12 col-md-4'>
                        <div class='card bg-light mb-3'>
                        <?= Html::img(Url::base('').'/'. Html::encode($evento["imgLogo"]), ["class" => "card-img-top"]) ?>
                            <div class='card-body'>
                                <h5 class='card-title'><?= Html::encode($evento["nombreEvento"]) ?></h5>
                                <h5 class='card-title'><?= Html::encode($evento["fechaInicioEvento"]) ?></h5>
                                <hr>
                                <p class='card-text'><?= Html::encode($evento["lugar"]) ?></p>
                                <p class='card-text'><?= Html::encode(strtok(wordwrap($evento["descripcionEvento"], 100, "...\n"), "\n")) ?> </p>
                                <?= Html::a('Más Información', ['/eventos/ver-evento/'. $evento->nombreCortoEvento], ['class' => 'btn btn-primary btn-lg full_width']); ?>
                                </div>
                        </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                    <div class="row py-5 pagination-lg pagination_center">
                        <?= // display pagination
                            LinkPager::widget([
                                'pagination' => $pages,
                                "disableCurrentPageButton" => true,
                            ]);
                        ?>
                    </div>
            </div>

        <?php else : ?>
            <div class="row">
                <h2 class="text-white text-uppercase">No se encontraron eventos, vuelva a intentar.</h2><br>
            </div>
        <?php endif; ?>
    </div>
    </section>
</div>
</div>