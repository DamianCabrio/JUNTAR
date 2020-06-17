<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\rbac\Permission;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::$app->charset; ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Html::img('@web/images/juntar-icon-b.svg',  ['style' => 'width:30px']),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark fixed-top',
            ],
        ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Registrarse', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Ingresar', 'url' => ['/site/login']];
            } else {
                // Opciones solo para usuario con rol organizador 
                if (Yii::$app->user->can('Organizador')) {

                    $menuItems[] = ['label' => 'Cargar Evento', 'url' => ['/evento/cargar-evento']];
                    $menuItems[] = ['label' => 'Gestionar Eventos', 'url' => ['/evento/listar-eventos']];
                }  
                    $menuItems[] = ['label' => 'Acerca de', 'url' => ['/site/about']];
                    $menuItems[] = ['label' => 'Contacto', 'url' => ['/site/contact']];  
                    //Logout
                    $menuItems[] = [
                        'label' => '<img class="ml-1 filter-white" src="icons/person-circle.svg" alt="Cuenta" width="30" height="30" title="Cuenta" role="img" style="margin: -4px 8px 0 0;">',
                        'items' => [
                            ['label' => Yii::$app->user->identity->nombre . ' ' . Yii::$app->user->identity->apellido],
                            ['label' => 'Mi Perfil', 'url' => ['/cuenta/profile'], 'linkOptions' => ['class' => 'yolo']],
                            
                            [
                                "label" => "Cerrar Sesión",
                                "url" => ["/site/logout"],
                                "linkOptions" => [
                                    "data-method" => "post",
                                ]
                            ],
                        ],
                    ];
               
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-collapse justify-content-end'],
                'items' => $menuItems,
                'encodeLabels' => false,
            ]);
            NavBar::end();
            ?>
                <?= Breadcrumbs::widget([
                    'itemTemplate' => "\n\t<li class=\"breadcrumb-item\"><i>{link}</i></li>\n", // template for all links
                    'activeItemTemplate' => "\t<li class=\"breadcrumb-item active\">{link}</li>\n", // template for the active link
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
            ?>

            <?php echo Alert::widget() ?>

        </div>

        <?php echo $content ?>
      
    </div>
    <section class="darkish_bg text-light">
        <div class="container" style="padding-bottom: 4vh;">
            <div class="row">
                <div class="col-12 col-md-5" style="padding-top: 4vh; padding-bottom: 4vh;">
                    <?= Html::img('images/juntar-logo-b.svg',  ['class' => 'img-fluid']); ?>
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
                            <a class="white-text" href="#!">juntar@fi.uncoma.edu.ar</a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row" style="padding-top: 4vh;padding-bottom: 2vh;">
                <div class="col s12 m6">
                    <?= Html::img('images/uncoma.png',  ['class' => 'img-fluid']); ?>
                </div>
                <div class="col s12 m6">
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