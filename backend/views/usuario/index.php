<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-index">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?=
    GridView::widget([
        //Redefinimos el sumario
        'summary' => '<p class="text-center col-12 d-block float-left"> Mostrando <b>{begin}-{end}</b> de <b>{totalCount}</b> usuarios registrados </p>',
        //Definimos caption con un boton para crear nuevo usuario
        'caption' => Html::a('Nuevo Usuario', ['create'], ['class' => 'btn btn-primary d-flex float-right']),
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            'apellido',
            'dni',
            /*[
                'attribute' => 'fecha_nacimiento',
                'label' => 'Nacimiento',
                'value' => 'fecha_nacimiento', //valor referenciado por ActiveQuery en el metodo idClub0
            ],
            [
               'attribute' => 'item',
               'label' => 'Rol',
               'value' => 'usuarioRols.item', //valor referenciado por ActiveQuery en el metodo idClub0
            ],*/
            'localidad',
            //'telefono',
            //'email:email',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'status',
            //'created_at',
            //'updated_at',
            //'verification_token',
            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function($url, $model) {
                        return Html::a('<img src="icons/pencil.svg" alt="Editar" width="20" height="20" title="Editar" role="img">', $url, ['class' => 'btn']);
                    },
                    'view' => function($url, $model) {
                        return Html::a('<img src="icons/eye.svg" alt="Visualizar" width="20" height="20" title="Visualizar" role="img">', $url, ['class' => 'btn']);
                    },
                    'delete' => function($url, $model) {
                        return Html::a('<img src="icons/trash.svg" alt="Borrar" width="20" height="20" title="Borrar" role="img">', $url, ['class' => 'btn']);
                    }
                ]
            ],
        ],
    ]);
    ?>
</div>
