<?php

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = "Crear Formulario";
?>

<div class="formulario-dinamico container">

        <?= Html::a("Agregar Pregunta", Url::toRoute(["pregunta/create?id=" . $evento->idEvento]),
            ['class' => 'btn btn-primary agregarPregunta mb-4', "data-id" => Url::toRoute(["pregunta/create?id=" . $evento->idEvento])]) ?>

        <?=
        \yii\grid\GridView::widget([
                "dataProvider" => $preguntas,
            'summary' => '',
            'options' => ['style' => 'width:100%;'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'Tipo de pregunta',
                    'format' => 'raw',
                    'value' => function ($dataProvider) {
                        if($dataProvider->tipo == 1){
                            $retorno = "Respuesta Corta";
                        }else if($dataProvider->tipo == 2){
                            $retorno = "Respuesta Larga";
                        }else if($dataProvider->tipo == 3){
                            $retorno = "Subir Archivo";
                        }
                        return $retorno;
                    },
                    'headerOptions' => ['style' => 'width:30%;text-align:center;'],
                ],
                [
                    'attribute' => 'Respuesta',
                    'format' => 'raw',
                    'value' => function ($dataProvider) {
                        return $dataProvider->descripcion;
                    },
                    'headerOptions' => ['style' => 'width:30%;text-align:center;'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    //genera una url para cada boton de accion
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action == "update") {
                            return Url::to(['/pregunta/update', 'id' => $key]);
                        }
                        if ($action == "delete") {
                            return Url::to(['/pregunta/delete', 'id' => $key]);
                        }
                    },
                    //describe los botones de accion
                    'buttons' => [
                        'update' => function ($url, $model) {
//                                                    return Html::a('<img src="' . Yii::getAlias('@web/icons/pencil.svg') . '" alt="Editar" width="20" height="20" title="Editar" role="img">', $url, ['class' => 'btn editarPresentacion']);
                            return Html::a('<i class="material-icons">edit</i>', $url, ['class' => 'btn btn_icon btn-outline-success editarPregunta']);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<i class="material-icons">remove_circle_outline</i>', $url, ['class' => 'btn btn_icon btn-outline-success borrarPregunta', 'data-method' => 'POST']);
                        }
                    ],
                    'header' => 'Acciones',
                    'headerOptions' => ['style' => 'text-align:center;'],
                    'contentOptions' => ['style' => 'text-align:center; vertical-align:middle;'],
                ],
                ]
        ]);
        ?>

        <?= Html::a('Volver Atras', Url::toRoute("eventos/ver-evento/" . $evento->nombreCortoEvento), ['class' => 'btn btn-outline-success']); ?>

    <?php
        Modal::begin([
            'id' => 'modalPregunta',
            'size' => 'modal-lg'
        ]);
        Modal::end();
        ?>

</div>