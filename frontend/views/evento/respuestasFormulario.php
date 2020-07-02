<?php

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = "Respuesta a el formulario";
?>

<div class="respuestas container">


    <div class="card mb-4">
        <div class="card-header dark_bg text-light">
            <h3>Usuarios Preinscriptos</h3>
        </div>
        <div class="card-body">
            <?=
                \yii\grid\GridView::widget([
                    "dataProvider" => $preinscriptos,
                    'summary' => '',
                    'options' => ['style' => 'width:100%;'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'Nombre del usuario',
                            'format' => 'raw',
                            'value' => function ($dataProvider) {
                                return $dataProvider->idUsuario0->nombre . " " . $dataProvider->idUsuario0->apellido;
                            },
                            'headerOptions' => ['style' => 'width:30%;text-align:center;'],
                        ],
                        [
                            'attribute' => 'Acciones',
                            'format' => 'raw',
                            'value' => function ($dataProvider) use ($hayPreguntas, $evento) {
                                if ($hayPreguntas) {
                                    $return = Html::a("Ver respuestas", Url::toRoute("respuesta/ver/" . $evento->nombreCortoEvento . "/" . $dataProvider->idInscripcion), ["class" => "verRespuesta ml-2 btn btn-outline-success mb-2"]);
                                    $return .= Html::a("Inscribir A Evento", Url::toRoute("inscripcion/inscribir-a-usuario/". $evento->nombreCortoEvento . "/" . $dataProvider->idUsuario), ['class' => 'ml-2 btn btn-outline-success mb-2']);
                                } else {
                                    $return = "No hay preguntas que responder en el evento";
                                }
                                return $return;
                            },
                            'headerOptions' => ['style' => 'width:65%;text-align:center;', 'class' => 'text-center'],
                            'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;']
                        ],
                    ]
                ]);
            ?>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header dark_bg text-light">
        <h3>Usuarios Inscriptos</h3>
        </div>
        <div class="card-body">
        <?=
        \yii\grid\GridView::widget([
            "dataProvider" => $inscriptos,
            'summary' => '',
            'options' => ['style' => 'width:100%;'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'Nombre del usuario',
                    'format' => 'raw',
                    'value' => function ($dataProvider) {
                        return $dataProvider->idUsuario0->nombre . " " . $dataProvider->idUsuario0->apellido;
                    },
                    'headerOptions' => ['style' => 'width:30%;text-align:center;'],
                ],
                [
                    'attribute' => 'Acciones',
                    'format' => 'raw',
                    'value' => function ($dataProvider) use ($evento) {
                        $return = Html::a("Ver respuestas", Url::toRoute("respuesta/ver/" . $evento->nombreCortoEvento . "/" . $dataProvider->idInscripcion), ["class" => "verRespuesta ml-2 btn btn-outline-success mb-2"]);
                        $return .= Html::a("Anular Inscripcion", Url::toRoute("inscripcion/anular-inscripcion/". $evento->nombreCortoEvento . "/" . $dataProvider->idUsuario), ['class' => 'ml-2 btn btn-outline-success mb-2']);
                        return $return;
                    },
                    'headerOptions' => ['style' => 'width:65%;text-align:center;', 'class' => 'text-center'],
                    'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;']
                ],
            ]
        ]);
    ?>
        </div>
    </div>
    

   
    <?= Html::a('Volver Atrás', Url::toRoute("eventos/ver-evento/" . $evento->nombreCortoEvento), ['class' => 'btn btn-lg']); ?>
    
    <?php 
      if($cantidadInscriptos>=1){ 
          echo  Html::a('enviar mail a los insriptos', ["evento/enviar-email-inscriptos", 'idEvento'=> $evento->idEvento], ['class' => 'btn btn-lg']); 
        } 
    ?>

    <?php
    Modal::begin([
        'id' => 'modalRespuestas',
        'size' => 'modal-lg',
        'headerOptions' => ['class' => 'dark_bg text-light']
    ]);
    Modal::end();
    ?>
</div>