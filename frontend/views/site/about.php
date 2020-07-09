<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Sobre Nosotros';
$this->params['breadcrumbs'][] = $this->title;

shuffle($arrayProfes);
shuffle($arrayUsers);
?>
<section class="" style="min-height: 100vh;">
    <div class="site-about container">
        <div class="">
            <p>Equipo Programación Web Avanzada - 2020</p>
            <hr>
        </div>
        <!--<div class="">-->
        <div class="row">
            <?php
            foreach ($arrayUsers as $codigoEspaguetti) {
                ?>
                <div class="col-sm-12 col-md-3 mb-4">
                    <div class="card shadow">
                        <div class="card-header super_bg"> <?php echo Html::encode($codigoEspaguetti); ?> </div>

                        <div class="card-body darkish_bg text-light">
                            <p> <?php echo Html::encode($info->mensajeRandomCardPWA($codigoEspaguetti)); ?> </p>
                        </div>

                        <div class="card-footer darkish_bg text-center">
                            <a class="text-light linkAbout" data-id="<?php echo Html::encode($codigoEspaguetti); ?>"><i class="material-icons" style="font-size:36px;">contact_mail</i></a>
                        </div>

                    </div>
                </div>
                <?php
            }
            ?>
            <?php
            foreach ($arrayProfes as $unaProfe) {
                ?>
                <div class="col-sm-12 col-md-3 mb-4">
                    <div class="card shadow">
                        <div class="card-header dark_bg"><span class="text-light"> <?php echo Html::encode($unaProfe); ?> </span> </div>

                        <div class="card-body darkish_bg text-light">
                            <p> <?php echo Html::encode($info->mensajeRandomCardPWA($unaProfe)); ?> </p>
                        </div>

                        <div class="card-footer darkish_bg text-center">
                            <a class="text-light linkAbout" data-id="<?php echo Html::encode($unaProfe); ?>"><i class="material-icons" style="font-size:36px;">contact_mail</i></a>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <div>
            <hr>
            <p><b><a class="link" href="https://github.com/DamianCabrio/JUNTAR" target="_blank">Link a repositorio Juntar</a></b> Licencia GNU GPL version 3</p>
            <p>Universidad Nacional del Comahue</p>
            <hr>
        </div>

        <a class="float-right link" href="https://www.youtube.com/embed/upL2HCdkBSc" target="_blank">
            <small>.</small>
        </a>

        <!-- Modal -->
        <div class="modal fade p-0" id="aboutUsModal" tabindex="-1" role="dialog" aria-labelledby="labelAboutUsModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal modalAboutUs modal-lg" role="document">
                <div class="modal-content super_bg">
                    <h2 class="modal-title p-2 text-white text-center" id="aboutUsTitle"></h2>
                    <!--<hr class="text-white">-->
                    <div class="modal-body text-center">

                    </div>
                </div>
            </div>
        </div>

        <!-- 用大量的工作和爱创造的页面 !-->
        <!-- 素晴らしいチーム、これは10/10です !-->
        <!-- Von hier zu den Sternen ★★★★★ -->

    </div>
</section>

