<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="post">

      <div class="row">
          <div class="col-12 mb-4">
              <div class="card">
                  <h3 class="card-header text-center darkish_bg text-white"> <?= Html::encode($model->tituloPresentacion) ?> </h3>

                  <?php // echo Html::a('Crear Evento', ['create'], ['class' => 'btn btn-pink mt-3 ml-3 col-2'])   ?>

                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">
                        <label><b>Descripción</b></label>
                        <p><?= HtmlPurifier::process($model->descripcionPresentacion) ?></p>
                        <label><b>Expositor:</b> <?=$model->idExpositors['nombre'].' '.$model->idExpositors['apellido']?></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-12 col-sm-3">
                        <label><b>Día de Presentacion</b></label>
                        <p><?= Html::encode(date('d-m-Y', strtotime($model->diaPresentacion))) ?></p>
                      </div>
                      <div class="col-12 col-sm-3">
                        <label><b>Hora de Inicio</b></label>
                        <p><?= Html::encode($model->horaInicioPresentacion) ?></p>
                      </div>
                      <div class="col-12 col-sm-3">
                        <label><b>Hora de Finalización</b></label>
                        <p><?= Html::encode($model->horaFinPresentacion) ?></p>
                      </div>
                      <div class="col-12 col-sm-3">
                        <label><b>Link de Recursos</b></label>
                        <p><?= Html::encode($model->linkARecursos) ?></p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <?= Html::a('Modificar', ['update', 'id' => $model->idPresentacion], ['class' => 'btn btn-pink']) ?>
                        <?= Html::a('Eliminar', ['delete', 'id' => $model->idPresentacion], [
                            'class' => 'btn btn-pink',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ])?>
                        <?php if ($model->idExpositors['dni'] == null): ?>
                          <?= Html::a('Asignar Expositor', ['/presentacion-expositor/create', 'id' => $model->idPresentacion], ['class' => 'btn btn-pink mt-2']) ?>
                        <?php else: ?>
                          <?= Html::a('Modificar Expositor', ['/presentacion-expositor/update', 'idExpositor' => $model->idExpositors['idUsuario'], 'idPresentacion' => $model->idPresentacion], ['class' => 'btn btn-pink mt-2']) ?>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
