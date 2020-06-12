<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

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
            ['label' => 'Home', 'url' => ['/site/index'], 'linkOptions' => ['class' => 'link']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Registrarse', 'url' => ['/site/signup'], 'linkOptions' => ['class' => 'link']];
            $menuItems[] = ['label' => 'Ingresar', 'url' => ['/site/login'], 'linkOptions' => ['class' => 'link']];
        } else {
            $menuItems[] = ['label' => 'Acerca de', 'url' => ['/site/about'], 'linkOptions' => ['class' => 'link']];
            $menuItems[] = ['label' => 'Contacto', 'url' => ['/site/contact'], 'linkOptions' => ['class' => 'link']];
            //Logout
            $menuItems[] = [
                'label' => '<img class="ml-1" src="icons/person-circle.svg" alt="Cuenta" width="30" height="30" title="Cuenta" role="img" style="margin: -4px 8px 0 0;">',
                'items' => [
                    ['label' => Yii::$app->user->identity->nombre . ' ' . Yii::$app->user->identity->apellido],
                    ['label' => 'Mi Perfil', 'url' => ['/cuenta/profile'], 'linkOptions' => ['class' => 'yolo, link']],
                    [
                        "label" => "Cerrar Sesión",
                        "url" => ["/site/logout"],
                        "linkOptions" => [
                            "data-method" => "post",
                            'class' => 'link'
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

        <!--<div class="container">-->
            <?php // echo
//                Breadcrumbs::widget([
//                    'itemTemplate' => "\n\t<li class=\"breadcrumb-item\"><i>{link}</i></li>\n", // template for all links
//                    'activeItemTemplate' => "\t<li class=\"breadcrumb-item active\">{link}</li>\n", // template for the active link
//                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
//                ])
            ?>
            <?php // echo Alert::widget() ?>

        <!--</div>-->
        <?php // echo Yii::getAlias('@web');?>
        <?php echo $content ?>
    </div>
    
    <footer class="footer dark_bg text-light">

        <div class="container">
            <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>