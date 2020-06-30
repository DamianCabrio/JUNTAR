<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
    <div class="centring logos">
      <table>
        <tr>
          <?php
          if ($isOficial) {
            $col = '<td>';
            $col .= '<img id="uncoma-logo" src="images/logo-uncoma-negro.png" alt="">';
            $col .= '</td><td>';
            $col .= '<img id="fai-logo" src="images/fai.png" alt=""></td>';
            $col .= '</td>';
            echo $col;
          } else {
            $pathLogo =  substr($event[0]['imgLogo'], 1);
            $col = '<td></td><td>';
            $col .= '<img id="juntar-logo" class="full_width" src="'.$pathLogo.'">';
            $col .= '</td><td></td>';
            echo $col;
          }
          ?>
        </tr>
      </table>
    </div>
</head>
  <body>
    <?php
    //Obtención de los datos.
    $days = [];
    $hours = new DateTime("0000-00-00 00:00:00");
    $latestDay = null;
    foreach ($presentations['collections'] as $presentation) {
      if ($latestDay < $presentation['diaPresentacion'] ) {
        $latestDay = $presentation['diaPresentacion'];
        $dayPresentation = strtotime($presentation['diaPresentacion']);
        array_push($days, date("d", $dayPresentation));
      }
      $hoursInit = new DateTime($presentation['horaInicioPresentacion']);
      $hoursEnd = new DateTime($presentation['horaFinPresentacion']);
      $hoursDiff = $hoursInit->diff($hoursEnd);
      $hours->add($hoursDiff);
    }

    //Arrays Auxiliar.
    $months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	  $numberMonth = date("m", strtotime($event[0]->fechaInicioEvento)) -1;
      if (count($days) > 1) {
        $daysMessage = "los días ";
        foreach ($days as $day => $value) {
          if (array_key_last($days) == $day) {
            $daysMessage .= $value;
          } else {
            $daysMessage .= $value.", ";
          }
        }
      } else {
        $daysMessage = "el día ".$days[0];
      }
      if ($category->descripcionCategoria != 'Otra') {
        $category = $category->descripcionCategoria ;
      } else {
        $category = 'evento';
      }
      switch ($certificateType) {
        case 'organizador':
          $type = "Participó como Organizador del ";
          break;
        case 'expositor':
          $type = "Participó como Expositor de <b>\"".$presentation->tituloPresentacion."\"</b> en el";
          break;
        case 'asistencia':
          $type = "Asistió al ";
          break;
      }
      ?>

      <div class="container">
        <div class="head">
          <p class="centring title">Certificado</p>
        </div>
        <div class="body">
          <p class="centring">Se certifica que <b><?= $user->apellido.", ".$user->nombre?></b>, DNI Nº <b><?=$user->dni?></b></p>
          <p class="centring">  <?=$type." ".$category?> </p>
          <p class="centring event"><b>"<?= $event[0]['nombreEvento'] ?>"</b></p>
          <p class="centring">  Realizado <?= $daysMessage ?> de <?= $months[$numberMonth]?> de <?= date("Y", strtotime($event[0]['fechaInicioEvento']))?>
            con una duración de <?= $hours->format("H:i")?> Hs, dictado en: <b><?= $event[0]['lugar'] ?></b>.</p>
          <p class="centring">Neuquén, <?= date('d/m/Y')?>.</p>
        </div>
      </div>
  </body>
</html>
