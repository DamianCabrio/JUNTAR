<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <div class="col-12 mb-4">
        <div class="card">
            <h1 class="card-header text-center darkish_bg text-white"><?= Html::encode($this->title) ?></h1>

            <div class="card-body">
                <div class="alert alert-danger">
                    <?= nl2br(Html::encode($message)) ?>
                </div>

                <p>
                    El error ocurrió cuando el servidor intentaba procesar su petición.
                </p>
                <p>
                    Si el problema persiste, contacte al desarrollador para intentar solucionar este problema.
                </p>

            </div>
        </div>
    </div>
</div>
