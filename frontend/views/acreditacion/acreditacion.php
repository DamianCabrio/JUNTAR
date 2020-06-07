<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Evento */

$this->title = "Acreditacion";
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="acreditacion-view">

    <?php $form = ActiveForm::begin(['id' => 'acreditacion-form']); ?>

    <?= $form->field($model, 'codigoAcreditacion')->textInput(['autofocus' => true])->label("Ingrese el codigo de acreditacion: ") ?>

    <div class="form-group">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>