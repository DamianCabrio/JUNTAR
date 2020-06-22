<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idUsuario',
            'nombre',
            'apellido',
            'dni',
            'pais',
            //'provincia',
            //'localidad',
            //'email:email',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            //'status',
            //'created_at',
            //'updated_at',
            //'verification_token',

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
