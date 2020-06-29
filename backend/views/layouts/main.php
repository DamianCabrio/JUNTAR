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
        <?php $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/ico', 'href' => Url::base(true).'/favicon.ico']); ?>
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
          <?php if (Yii::$app->requestedRoute == 'site/index' || Yii::$app->requestedRoute == null ): ?>
            <div class="row">
              <div class="col-12 text-center">
                <?= Html::img('images/juntar-logo/svg/juntar-logo-b.svg',  [
                  'class' => 'img-fluid mx-auto d-block',
                  'style' => ['width' => '25%']
                  ])?>
                  <h3 class="mt-2">Aplicación Backend</h3>
              </div>
            </div>
            <?php
            $menuItems[] = [
                "label" => "Salir (" . Yii::$app->user->identity->nombre ." ". Yii::$app->user->identity->apellido .")",
                "url" => ["/site/logout"],
                "linkOptions" => [
                    "data-method" => "post",
                ]
            ];

            echo Nav::widget([
              'options' => ['class' => 'navbar-nav navbar-collapse justify-content-end'],
              'items' => $menuItems,
            ]);
             ?>
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
                $menuItems[] = ['label' => 'Home', 'url' => ['/site/index']];
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
                //MenuItems ABM Permisos
                $menuItems[] = [
                    'label' => 'Gestionar Permisos',
                    'items' => [
                        ['label' => 'Crear Permiso', 'url' => ['/permission/create-permiso']],
                        ['label' => 'Asignar Permisos', 'url' => ['/permission/asignar-permisos']],
                        ['label' => 'Listado Permisos', 'url' => ['/permission/index']],
                        ['label' => 'Eliminar Permiso', 'url' => ['/permission/remove-permiso']],
                    ],
                ];
                $menuItems[] = [
                    'label' => 'Gestionar Roles',
                    'items' => [
                        ['label' => 'Crear Rol', 'url' => ['/rol/create-rol']],
                        ['label' => 'Listado Roles', 'url' => ['/rol/index']],
                    ],
                ];
                //ABM Usuario
                $menuItems[] = ['label' => 'Gestionar Usuarios', 'url' => ['/usuario/index']];
                //ABM Eventos
                $menuItems[] = [
                    'label' => 'Gestionar Eventos',
                    'items' => [
                        ['label' => 'Listado Eventos', 'url' => ['/evento/index']],
                        ['label' => 'Solicitudes de Aval', 'url' => ['/evento/solicitudes-de-aval']],
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

            <div class="container">
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
        </div>

        <section class="darkish_bg text-light">
            <div class="container" style="padding-bottom: 4vh;">
                <div class="row">
                    <div class="col-12 col-md-5" style="padding-top: 4vh; padding-bottom: 4vh;">
                        <?= Html::img('images/juntar-logo/svg/juntar-logo-w.svg',  ['class' => 'img-fluid']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-8">
                        <h5 class="white-text">Juntar</h5>

                        <p class="grey-text text-lighten-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer malesuada vitae erat a lobortis. Donec pretium tortor eros, a auctor massa suscipit vel. Donec augue odio, vulputate et egestas fringilla, varius vel ligula. Aliquam eu sagittis nisi, vitae imperdiet lorem. Vivamus lobortis diam vel sapien aliquet, dictum placerat tellus imperdiet.</p>

                    </div>
                    <div class="col-12 col-md-4">
                        <h5 class="white-text">Contacto</h5>
                        <ul>
                            <li>
                                <a class="white-text link" href="#!">juntar@fi.uncoma.edu.ar</a>
                            </li>
                        </ul>
                        <h5 class="white-text">Sobre</h5>
                    <ul>
                        <li>
                            <?= Html::a('Sobre', ['site/about'], ['class' => 'profile-link']) ?>
                        </li>
                    </ul>
                    </div>
                </div>
                <hr>
                <div class="row" style="padding-top: 4vh;padding-bottom: 2vh;">
                    <div class="col-12 col-md-6 py-3">
                        <?= Html::img('images/uncoma.png',  ['class' => 'img-fluid']); ?>
                    </div>
                    <div class="col-12 col-md-6 py-3">
                        <?= Html::img('images/fai.png',  ['class' => 'img-fluid']); ?>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer dark_bg text-light">

            <div class="container">
                <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
