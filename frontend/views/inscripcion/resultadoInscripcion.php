<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InscripcionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inscripto';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="inscripcion-index container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($seGuardo && !$esPreInscripcion) {
        echo "Se inscribió con éxito";
    } elseif ($esPreInscripcion && $seGuardo) {
        echo "Se preinscribió con éxito";
    } elseif (!$seGuardo) {
        echo "No se preinscribió con éxito";
    }
    ?>

</div>