<?php

/* @var $this yii\web\View */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\LinkPager;

$this->title = 'Proyecto Juntar';
?>
<div class="site-index">

    <div class="body-content">
        <header class="hero gradient-hero">
            <div class="center-content">
                <?= Html::img('images/juntar-logo-b.svg',  ['class' => 'img-fluid']); ?>
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

                        <div class="col-sm-12 col-md-4 top_buffer">
                            <select name="orden" class="custom-select custom-select-lg" onchange="this.form.submit()">
                                <option <?= (isset($_GET["orden"]) && $_GET["orden"] == 0) ? "selected" : "" ?> value="0">Fecha de creación</option>
                                <option <?= (isset($_GET["orden"]) && $_GET["orden"] == 0) ? "selected" : "" ?> value="1">Fecha de inicio del evento</option>
                            </select>
                        </div>

                        <div class="col-sm-12 col-md-4 top_buffer">
                            <input class="form-control-lg full_width" type="search" placeholder="Buscar" name="s" value="<?= isset($_GET["s"]) ? $_GET["s"] : "" ?>">
                        </div>

                        <div class="col-sm-12 col-md-2 top_buffer">
                            <button class="btn btn-outline-success btn-lg full_width" type="submit">Buscar</button>
                        </div>
                        <div class="col-sm-12 col-md-2 top_buffer">
                            <?= Html::a('Restablecer', ["index#events"], ['class' => 'btn btn-secondary btn-lg full_width']); ?>
                        </div>

                    </div>
                </form>

            </div>
        </section>
        <section class="dark_bg">
            <div class="container padding_section">
                <?php if (count($eventos) != 0): ?>
                <div class="row">
                    <?php foreach ($eventos as $evento) {
                        if ($evento->idEstadoEvento == 1):
                            echo "<div class='col-12 col-md-4 mb-3'>";
                            echo "<div class='card bg-light'>";
                            echo "<img src='" . $evento["imgLogo"] . " 'class='card-img-top' alt=''...'>";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>" . $evento["nombreEvento"] . "</h5>";
                            echo "<h5 class='card-title'>" . $evento["fechaInicioEvento"] . "</h5>";
                            echo "<hr>";
                            echo "<p class='card-text'>" . $evento["lugar"] . "</p>";
                            echo "<p class='card-text'>" . strtok(wordwrap($evento["descripcionEvento"], 100, "...\n"), "\n") . "</p>";
                            echo Html::a('Más Información', ['eventos/ver-evento/'. $evento->nombreCortoEvento], ['class' => 'btn btn-primary btn-lg full_width']);
                        echo "</div></div></div>";
                        endif;
                    } ?>
                </div>

                <div class="row m-auto">
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