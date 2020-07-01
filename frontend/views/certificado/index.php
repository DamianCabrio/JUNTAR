<?php
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<div class="container">
  <div class="certificate-index">
    <div class="certificates-buttons">
      <!-- Botón para general los archivos PDF dependiendo de la participación en el evento. -->
      <?php $iconsPdf = '<i class="material-icons large align-middle">picture_as_pdf</i>';?>
      <div class="row m-2 ">
        <div class="col-12 col-md-6">
          <?php if ($attendanceCertificate) {
            echo '<label>Asistencia</label></br>'.Html::a($iconsPdf, ['certificado/preview-attendance', 'id' => $idEvent], ['class' => 'btn btn-primary']);
          } ?>
        </div>
        <div class="col-12 col-md-6">
          <?php if ($organizerCertificate) {
            echo '<label>Organizador</label></br>';
            echo Html::a($iconsPdf, ['certificado/preview-organizer', 'id' => $idEvent], ['class' => 'btn btn-primary']);
          } ?>
        </div>
      </div>
      <div class="row p-3">
        <div class="col-md-12">
              <?php if ($exhibitorCertificate): ?>
              <?php $form = ActiveForm::begin([
                'id' => 'presentation-form',
                'enableClientValidation' => false,
                'enableAjaxValidation' => true,
              ]);?>
              <?= $form->field($model, 'idPresentacion')->dropdownList($presentations)->label('Como expositor de')?>
              <div class="form-group">

              <?= Html::submitButton($iconsPdf, ['class' => 'btn btn-primary']) ?>
              </div>
              <?php ActiveForm::end();?>
              <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
