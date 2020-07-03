<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\YiiAsset;

?>
<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Evento */

$this->title = "Acreditación";
$this->params['breadcrumbs'][] = ['label' => 'Eventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="acreditacion-view container">

    <?php $form = ActiveForm::begin(['id' => 'acreditacion-form']); ?>

    <?php if ($acrPreg == false): ?>
        <?= $form->field($model, 'codigoAcreditacion')->textInput(['autofocus' => true])->label("Ingrese el codigo de acreditacion: ") ?>
    <?php else: ?>
        <?= $form->field($model, 'codigoAcreditacion')->textInput(['autofocus' => true])->label($acrPreg->pregunta) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>