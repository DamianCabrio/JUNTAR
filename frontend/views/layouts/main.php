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
                'brandLabel' => Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar navbar-expand-md navbar-dark bg-dark',
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Registrarse', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Ingresar', 'url' => ['/site/login']];
            } else {
                //Despues Borrar
                $menuItems[] = ['label' => 'Cargar Evento', 'url' => ['/evento/cargar-evento']];
                $menuItems[] = ['label' => 'Listar Eventos', 'url' => ['/evento/listar-eventos']];
                $menuItems[] = ['label' => 'Acerca de', 'url' => ['/site/about']];
                $menuItems[] = ['label' => 'Contacto', 'url' => ['/site/contact']];
                //Logout
                $menuItems[] = [
                    'label' => '<img class="ml-1" src="icons/person-circle.svg" alt="Cuenta" width="30" height="30" title="Cuenta" role="img" style="margin: -4px 8px 0 0;">',
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

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
