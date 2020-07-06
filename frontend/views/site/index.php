<?php
/* @var $this yii\web\View */

use frontend\components\validateEmail;
use yii\bootstrap4\Html;
use yii\bootstrap4\LinkPager;
use yii\helpers\Url;

$openGraph = Yii::$app->opengraph;

$openGraph->getBasic()
        ->setUrl(Yii::$app->request->hostInfo . Yii::$app->request->url)
        ->setTitle("Juntar")
        ->setDescription("Somos una plataforma web para gestión de eventos libre y gratuita. El sitio permite a los usuarios navegar, crear y participar de eventos. Nació como un desafío universitario y podemos asegurar que hemos llegado a la meta que teníamos como objetivo e incluso la hemos superado gracias a un gran equipo de trabajo. Licencia GNU GPL version 3")
        ->setSiteName("Juntar")
        ->setLocale('es_AR')
        ->render();

$openGraph->useTwitterCard()
        ->setCard('summary')
        ->setSite(Yii::$app->request->hostInfo . Yii::$app->request->url)
        ->render();

$openGraph->getImage()
        ->setUrl(Url::base('') . "images/juntar-logo/png/juntar-avatar-bg-b.png")
        ->setAttributes([
            'secure_url' => Url::base('') . "images/juntar-logo/png/juntar-avatar-bg-b.png",
            'width' => 100,
            'height' => 100,
            'alt' => "Logo Evento",
        ])
        ->render();

$this->title = 'Juntar';
?>
<div class="site-index">

    <div class="body-content">
        <header class="hero gradient-hero">
            <div class="center-content padding_hero">
                <?= Html::img('@web/images/juntar-logo/svg/juntar-logo-w.svg', ['class' => 'img-fluid padding_logo']); ?>
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
                            <select name="orden" class="custom-select custom-select-lg" onchange="this.form.submit()">
                                <option <?= (isset($_GET["orden"]) && $_GET["orden"] == 0) ? "selected" : "" ?>
                                    value="0">Fecha de inicio del evento
                                </option>
                                <option <?= (isset($_GET["orden"]) && $_GET["orden"] == 1) ? "selected" : "" ?>
                                    value="1">Fecha de creación
                                </option>
                            </select>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-3">
                            <input class="form-control-lg full_width" type="search" placeholder="Buscar" name="s"
                                   value="<?= isset($_GET["s"]) ? $_GET["s"] : "" ?>">
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
                <?php if (count($eventos) != 0) : ?>
                    <div class="row">
                        <?php $validarEmail = new validateEmail(); ?>
                        <?php foreach ($eventos as $evento) : ?>
                            <div class="col-sm-12 col-md-4 mb-5">
                                <div class='card'>
                                    <div class='card bg-light'>
                                        <?= Html::a(Html::img(Url::base('') . '/' . Html::encode($evento["imgLogo"]), ["class" => "card-img-top"]), ['/eventos/ver-evento/' . $evento->nombreCortoEvento]) ?>
                                        <div class='card-body'>
                                            <h4 class='card-title'><?= Html::encode($evento["nombreEvento"]) ?></h4>
                                            <h5 class='card-title'><?= Html::encode("Organizador: " . $evento["idUsuario0"]["nombre"] . " " . $evento["idUsuario0"]["apellido"]) ?></h5>
                                            <h5 class='card-title'><?= Html::encode(date('d/m/Y', strtotime($evento["fechaInicioEvento"]))) ?></h5>
                                            <hr>
                                            <p class='card-text'><?= Html::encode($evento["lugar"]) ?></p>
                                            <p class='card-text'><?= Html::decode(strtok(wordwrap($evento["descripcionEvento"], 100, "...\n"), "\n")) ?> </p>
                                            <?= Html::a('Más Información', ['/eventos/ver-evento/' . $evento->nombreCortoEvento], ['class' => 'btn btn-primary btn-lg full_width']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="row py-5 pagination-lg pagination_center">
                        <?=
                        // display pagination
                        LinkPager::widget([
                            'pagination' => $pages,
                            "disableCurrentPageButton" => true,
                        ]);
                        ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="container">
                    <div class="row">
                        <h2 class="text-white text-uppercase padding_section">No se encontraron eventos, vuelva a
                            intentar.</h2><br>
                    </div>
                </div>
            <?php endif; ?>

        </section>
    </div>
</div>
</div>
