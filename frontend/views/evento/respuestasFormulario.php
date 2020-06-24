<?php

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = "Respuesta a el formulario";
?>

<div class="respuestas container">

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
                'value' => function ($dataProvider) {
                    $return = Html::a("Ver respuestas", Url::toRoute("respuesta/ver?id=". $dataProvider->idEvento . "&id2=". $dataProvider->idInscripcion), ["class" => "verRespuesta btn btn-outline-success"]);
                   $return .= Html::a("Inscribir A Evento", Url::toRoute("inscripcion/inscribir-a-usuario?idUsuario=". $dataProvider->idUsuario . "&idEvento=". $dataProvider->idEvento), ['class' => 'ml-2 btn btn-outline-success']);
                    return $return;
                },
                'headerOptions' => ['style' => 'width:30%;text-align:center;'],
            ],
        ]
    ]);
    ?>

    <?= Html::a('Volver Atras', Url::toRoute("eventos/ver-evento/" . $evento->nombreCortoEvento), ['class' => 'btn btn-outline-success']); ?>

    <?php
    Modal::begin([
        'id' => 'modalRespuestas',
        'size' => 'modal-lg'
    ]);
    Modal::end();
    ?>

</div>