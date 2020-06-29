<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ModalidadEventoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Modalidades de los Eventos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modalidad-evento-index container">
  <div class="row align-items-center">
    <div class="col-12">
      <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  </div>
  <div class="row">
    <div class="col-12 col-sm-4 m-3">
      <?php echo $this->render('create', ['model' => $model]); ?>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'columns' => [
              ['class' => 'yii\grid\SerialColumn'],
              [
                'attribute' => 'descripcionModalidad',
                'options' => ['class' => 'col-2']
              ],

              ['class' => 'yii\grid\ActionColumn',

                  'buttons' => [
                      'update' => function($url, $model) {
                          return Html::a('<img src="'.Yii::getAlias('@web/iconos/pencil.svg').'" alt="Editar" width="20" height="20" title="Editar" role="img">', $url, ['class' => 'btn']);
                      },
                      'view' => function($url, $model) {
                          return Html::a('<img src="'.Yii::getAlias('@web/iconos/eye.svg').'" alt="Visualizar" width="20" height="20" title="Visualizar" role="img">', $url, ['class' => 'btn']);
                      },
                      'delete' => function($url, $model) {
                          return Html::a('<img src="'.Yii::getAlias('@web/iconos/trash.svg').'" alt="Borrar" width="20" height="20" title="Borrar" role="img">', $url, ['class' => 'btn']);
                      }
                  ]
              ],

          ],
      ]); ?>
    </div>
  </div>
</div>
