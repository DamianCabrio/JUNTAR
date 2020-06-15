<?php

/* @var $this yii\web\View */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\widgets\LinkPager;

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
                <form class="form-inline my-2 my-lg-0" action="#events">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <select name="orden" class="custom-select custom-select-lg mb-3" onchange="this.form.submit()">
                            <option <?= (isset($_GET["orden"]) && $_GET["orden"] == 0) ? "selected" : "" ?> value="0">Fecha de creacion</option>
                            <option <?= (isset($_GET["orden"]) && $_GET["orden"] == 1) ? "selected" : "" ?> value="1">Fecha de inicio del evento</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                            <input class="form-control mr-sm-2" type="search" placeholder="Buscar" name="s" value="<?= isset($_GET["s"]) ? $_GET["s"] : "" ?>">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                            <?= Html::a('Restablecer', "index#events", ['class' => 'btn btn-secondary ml-2']); ?>
                    </div>
                </div>
                </form>
            </div>
        </section>
        <section class="dark_bg">
            <div class="container padding_section">
                <?php if (count($eventos) != 0): ?>
            <h2 class="text-white text-uppercase">Últimos Lanzamientos</h2><br>
                <div class="row">
                    <?php foreach ($eventos as $evento) {
                        if($evento->idEstadoEvento == 1):
                        echo "<div class='col-12 col-md-4'>";
                        echo "<div class='card bg-light'>";
                        echo "<img src='" . $evento["imgLogo"] . " 'class='card-img-top' alt=''...'>";
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>" . $evento["nombreEvento"] . "</h5>";
                        echo "<h5 class='card-title'>" . $evento["fechaInicioEvento"] . "</h5>";
                        echo  "<hr>";
                        echo "<p class='card-text'>" . $evento["lugar"] . "</p>";
                        echo "<p class='card-text'>" . strtok(wordwrap($evento["descripcionEvento"], 100, "...\n"), "\n") . "</p>";
                        echo Html::a('Más Información', ['/evento/ver-evento', "idEvento" => $evento["idEvento"]], ['class' => 'btn btn-primary btn-lg full_width']);
                        echo "</div></div></div>";
                        endif;
                    } ?>
                </div>

                <div class="row">
                    <?= // display pagination
                         LinkPager::widget([
                        'pagination' => $pages,
                        ]); 
                    ?>
        
                </div>

                <?php else: ?>
                <div class="row">
                    <h2 class="text-white text-uppercase">No se encontraron eventos, vuelva a intentar.</h2><br>
                </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>