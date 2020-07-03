<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <?php $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/ico', 'href' => Url::base(true) . '/favicon.ico']); ?>
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap mt-5">
            <?php if (Yii::$app->requestedRoute == 'site/index' || Yii::$app->requestedRoute == null): ?>
                <!--<header class="darkish_bg">-->
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="mb-4">
                            <?=
                            Html::img('images/juntar-logo/svg/juntar-logo-b.svg', [
                                'class' => 'img-fluid mx-auto d-block',
                                'style' => ['width' => '40%']
                            ]);
                            ?>
                            <h3 class="mt-2 m-auto">Aplicación Backend</h3>
                        </div>

                        <div class="col-10 m-auto">
                            <?php
                            $menuItems[] = [
                                "label" => "Salir (" . Yii::$app->user->identity->nombre . " " . Yii::$app->user->identity->apellido . ")",
                                "url" => ["/site/logout"],
                                "linkOptions" => [
                                    "data-method" => "post",
                                    'class' => 'text-white'
                                ]
                            ];

                            echo Nav::widget([
                                'options' => ['class' => 'btn btn-pink d-block text-center m-auto col-md-2 col-sm-12'],
                                'items' => $menuItems,
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
                <!--</header>-->
            <?php else: ?>
                <?php
                NavBar::begin([
                    'brandLabel' => Html::img('@web/images/juntar-logo/svg/juntar-icon-w.svg', ['style' => 'width:30px']),
                    'brandUrl' => Yii::$app->homeUrl,
                    'options' => [
                        'class' => 'navbar navbar-expand-md navbar-dark fixed-top',
                    ],
                ]);
                if (Yii::$app->user->isGuest) {
                    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
                } else {
//                    $menuItems[] = ['label' => 'Home', 'url' => ['/site/index']];
                    //MenuItems for ABM
                    //MenuItems ABM Permisos
//        $menuItems[] = [
//                       'label' => 'Gestor de Permisos OLD',
//                       'items' => [
//                            ['label' => 'Asignar Permisos', 'url' => ['/permission-manager/index']],
//                            ['label' => 'Asignar Permisos3', 'url' => ['/permission-manager/index3']],
//                            ['label' => 'Asignar Permisos5', 'url' => ['/permission-manager/index5']],
//                            ['label' => 'Asignar Permisos7', 'url' => ['/permission-manager/index7']],
//                            ],
//                        ];
                    //ABM Usuario
                    $menuItems[] = ['label' => 'Usuarios', 'url' => ['/usuario/index']];
                    //ABM Eventos
                    $menuItems[] = [
                        'label' => 'Eventos',
                        'items' => [
                            ['label' => 'Listado Eventos', 'url' => ['/evento/index']],
                            ['label' => 'Solicitudes de Aval', 'url' => ['/solicitud-aval/solicitudes-de-aval']],
                        ],
                    ];
                    //ABM ModalidadEventos
                    $menuItems[] = ['label' => 'Modalidades', 'url' => ['/modalidad-evento/index']];
                    //ABM ModalidadEventos
                    $menuItems[] = ['label' => 'Categorias', 'url' => ['/categoria-evento/index']];
                    //MenuItems ABM Permisos
                    $menuItems[] = [
                        'label' => 'Permisos',
                        'items' => [
                            ['label' => 'Crear Permiso', 'url' => ['/permission/create-permiso']],
                            ['label' => 'Asignar Permisos', 'url' => ['/permission/asignar-permisos']],
                            ['label' => 'Listado Permisos', 'url' => ['/permission/index']],
                            ['label' => 'Eliminar Permiso', 'url' => ['/permission/remove-permiso']],
                        ],
                    ];
                    $menuItems[] = [
                        'label' => 'Roles',
                        'items' => [
                            ['label' => 'Crear Rol', 'url' => ['/rol/create-rol']],
                            ['label' => 'Listado Roles', 'url' => ['/rol/index']],
                        ],
                    ];


//                $menuItems[] = ['label' => 'Gestionar Eventos', 'url' => ['/evento/index']];
                    //Logout
                    $menuItems[] = [
                        "label" => "Salir (" . Yii::$app->user->identity->nombre . ")",
                        "url" => ["/site/logout"],
                        "linkOptions" => [
                            "data-method" => "post",
                        ]
                    ];
                }
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav navbar-collapse justify-content-end'],
                    'items' => $menuItems,
                ]);
                NavBar::end();
                ?>
            <?php endif; ?>


            <!--<div class="container-fluid">-->
            <div class="container p-3">
                <?=
                Breadcrumbs::widget([
                    'itemTemplate' => "\n\t<li class=\"breadcrumb-item\"><i>{link}</i></li>\n", // template for all links
                    'activeItemTemplate' => "\t<li class=\"breadcrumb-item active\">{link}</li>\n", // template for the active link
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
            <!--</div>-->
        </div>

        <footer class="darkish_bg text-white footer fixed-bottom">
            <!--<footer class="footer">-->
            <div class="container">
                <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
