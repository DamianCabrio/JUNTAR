<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
?>
<div class="container">
  <div class="certificate-index">

    <div class="">
      <?php
      //Cálculo de horas en total
      $latest = count($presentaciones)-1;
      $firtsDate = new DateTime($presentaciones[0]->horaInicioPresentacion);
      $latestDate = new DateTime($presentaciones[$latest]->horaInicioPresentacion);
      $diff = $firtsDate->diff($latestDate);
      $isExhibitor = false;
      foreach ($presentaciones as $presentacion) {
        foreach ($presentacion->presentacionExpositors as $objExpoPre) {
          $expositor = $objExpoPre->idExpositor0;
          if ($expositor->idUsuario == Yii::$app->user->identity->id) {
            $isExhibitor = true;
          }
        }
      }

      $isOficial = false;
      if (strpos($OrganizadorEmail, '@fi.uncoma.edu.ar') ) {
        $isOficial = true;
      }
      //Datos enviado por GET, se encriptan para evitar manipulación de datos.
      $common = [
        'id' => $evento->idEvento,
        'type' => $isOficial,
        'typeC' => base64_encode('Asistencia'),
        'count' => base64_encode($diff->format("%h:%I")),
      ];
      $iconsPdf = '<img class="ml-1" src="'.Yii::getAlias("@web/images/file-pdf.svg").'" alt="Visualizar" width="25" height="25" title="Visualizar" role="img" style="margin-top: -4px;">';
      ?>
      <!-- Botón para general los archivos PDF dependiendo de la participación en el evento. -->
      <label>Certificado de Asistencia</label><?= Html::a($iconsPdf, ['certificado/preview', $common]); ?>
      <?php if ($isExhibitor) {
        $common['typeC'] = base64_encode('Expositor');
        echo '<label>Certificado de Expositor</label>'.Html::a($iconsPdf, ['certificado/preview', $common]);
      } ?>
      <?php if ($evento->idUsuario0->idUsuario == Yii::$app->user->identity->id) {
        $common['typeC'] = base64_encode('Organizador');
        echo '<label>Certificado de Organizador</label>'.Html::a($iconsPdf, ['certificado/preview', $common]);
      } ?>
    </div>
  </div>
</div>
