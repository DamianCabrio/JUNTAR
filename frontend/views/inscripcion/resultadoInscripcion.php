<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InscripcionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Resultado inscripcion';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inscripcion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if($seGuardo){
        echo "Se preinscribio con exito";
    }else{
        echo "No se preinscribio con exito";
    }?>

</div>
