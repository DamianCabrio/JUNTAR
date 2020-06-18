<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
      <div class="centring logos">
        <table>
          <tr>
            <td><?php if ($isOficial) {
              echo '<img id="uncoma-logo" src="images/logo-uncoma-negro.png" alt="">';
            } else {
              echo '<img id="juntar-logo" src="images/juntar-logo/png/juntar-logo-k.png" alt="">';
            }?></td>
            <td><img id="fai-logo" src="images/fai.png" alt=""></td>
          </tr>
        </table>
      </div>
  </head>
  <body>
    <div class="container">
      <div class="title">
        <p class="centring">Certificado</p>
      </div>
      <?php if ($event[0]['fechaInicioEvento'] == $event[0]['fechaFinEvento']) {
        $date = "el día ".$event[0]['fechaInicioEvento'];
      } else {
        $date = "desde el día ".$event[0]['fechaInicioEvento']." al día ".$event[0]['fechaFinEvento'];
      }
      if ($event[0]['descripcionCategoria'] != 'Otra') {
        $category = $event[0]['descripcionCategoria'] ;
      } else {
        $category = 'evento';
      }
      switch ($certificateType) {
        case 'Organizador':
          $type = "fue Organizador del ";
          break;
        case 'Expositor':
          $type = "fue Expositor en el ";
          break;
        default:
          $type = "Asistió al ";
          break;
      }
      ?>
      <div class="body">
        <p class="centring">Se certifica que <b><?= $user[0]['apellido'].", ".$user[0]['nombre']?></b>, DNI Nº <b><?=$user[0]['dni']?>, </b>
          <?=$type." ".$category?> <b>"<?=$event[0]['nombreEvento']?>"</b>,
          <?= $date ?> con una duración de <?= $timeCount ?> Hs, dictado en: <b><?= $event[0]['lugar'] ?></b>.</p>
        <p class="centring">Neuquén, <?= date('d/m/Y')?>.</p>
      </div>
    </div>
  </body>
</html>
