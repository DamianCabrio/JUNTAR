<?php
/* @var $this yii\web\View */

use yii\bootstrap4\Html;

$this->title = 'Proyecto Juntar';
?>
<div class="evento-codigos-qr">

    <!--<div class="col-12 m-auto">-->
    <div class="container-fluid dark_light_bg p-4">
        <div class="row">
            <div class="col-md-7 col-sm-12 m-auto p-0 text-center">
            <!--<div class="w-50 m-auto p-0 text-center">-->
                <div class="card">
                    <h5 class="card-header text-center pinkish_bg text-white"> QR Evento: </h5>
                    <div class="card-body">
                        <?php if ((@getimagesize($imageEventoQR))): ?>
                            <p> El siguiente código QR permite visualizar el evento creado en Juntar: </p>
                            <img class="mt-2 full_width" src="<?= Html::encode($imageEventoQR) ?>" title="<?= Html::encode($slug); ?>">
                            <br>
                            <br>
                            <a href="<?= Html::encode($imageEventoQR) ?>" class="btn btn-secondary" download> Descargar </a>
                        <?php else: ?>
                            <small> Lo sentimos, no pudimos encontrar la imagen solicitada ): </small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if ($imageAcreditacionEventoQR != null && $imageAcreditacionEventoQR != ''): ?>
                <div class="col-md-7 col-sm-12 m-auto p-0 text-center">
                    <div class="card mt-3">
                        <h5 class="card-header text-center pinkish_bg text-white"> QR Acreditación Evento: </h5>
                        <div class="card-body">
                            <?php if ((@getimagesize($imageAcreditacionEventoQR))): ?>
                                <p> El siguiente código QR permite a un usuario inscripto acreditarse al evento en Juntar: </p>
                                <img class="mt-2 full_width" src="<?= Html::encode($imageAcreditacionEventoQR) ?>" title="<?= Html::encode($slug); ?>">
                                <br>
                                <br>
                                <a href="<?= Html::encode($imageAcreditacionEventoQR) ?>" class="btn btn-secondary" download> Descargar </a>
                            <?php else: ?>
                                <small> Lo sentimos, no pudimos encontrar la imagen solicitada ): </small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <!--</div>-->
        <!--</div>-->
    </div>