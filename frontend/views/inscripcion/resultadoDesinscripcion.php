<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InscripcionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Anular Inscripcion';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inscripcion-index container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($seElimino) {
        echo "Se desinscribió con éxito";
    }else{
        echo "No se desinscribió con éxito";
    }
    ?>

</div>
