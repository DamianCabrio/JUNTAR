<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;

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
        <section class="darkish_bg">
            <div class="container padding_select">
                <select class="custom-select custom-select-lg mb-3">
                    <option selected>Funcional en la próxima entrega</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
        </section>
        <section id="events" class="dark_bg">
            <div class="container padding_section">
            <h2 class="text-white text-uppercase">Últimos Lanzamientos</h2><br>
                <div class="row">
                    <?php foreach ($eventos as $evento) {
                        echo "<div class='col-12 col-md-4'>";
                        echo "<div class='card bg-light'>";
                        echo "<img src='" . $evento["linkLogo"] . " 'class='card-img-top' alt=''...'>";
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>" . $evento["nombreEvento"] . "</h5>";
                        echo "<h5 class='card-title'>" . $evento["fechaLimiteInscripcion"] . "</h5>";
                        echo  "<hr>";
                        echo "<p class='card-text'>" . $evento["lugar"] . "</p>";
                        echo "<p class='card-text'>" . strtok(wordwrap($evento["descripcionEvento"], 100, "...\n"), "\n") . "</p>";
                        echo Html::a('Más Información', ['/evento/view', "id" => $evento["idEvento"]], ['class' => 'btn btn-primary btn-lg full_width']);
                        echo "</div></div></div>";
                    } ?>
                </div>
            </div>
        </section>
    </div>
</div>