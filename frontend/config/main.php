<?php

use ymaker\social\share\configurators\Configurator;
use ymaker\social\share\drivers\Facebook;
use ymaker\social\share\drivers\Twitter;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    "homeUrl" => ["site/index"],
    'bootstrap' => ['log'],
    'language' => "es_AR",
    'timeZone' => 'America/Argentina/Buenos_Aires',
    'aliases' =>[
        '@rutaLogo' => '/eventos/images/logos/',
        '@rutaFlyer' => '/eventos/images/flyers/',
        '@rutaQR' => '/eventos/images/qrcodes/',
        '@rutaImagenPerfil' => '/profile/images/',
    ],
    'components' => [
        "socialShare" => [
            'class' => Configurator::class,
            "socialNetworks" => [
                "facebook" => [
                    "class" => Facebook::class,
                ],
                "twitter" => [
                    "class" => Twitter::class,
                ],
            ],
        ],
        'qr' => [
            'class' => '\Da\QrCode\Component\QrCodeComponent',
            // ... you can configure more properties of the component here
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'opengraph' => [
            'class' => 'umanskyi31\opengraph\OpenGraph',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
          'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
             'rules' => [
                 '<controller:\w+>/<id:\d+>' => '<controller>/view',
                 '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                 '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                 'eventos/ver-evento/<slug>' => 'evento/ver-evento',
                 'eventos/evento-cargado/<slug>' => 'evento/evento-cargado',
                 'eventos/editar-evento/<slug>' => 'evento/editar-evento',
                 'eventos/publicar-evento/<slug>' => 'evento/publicar-evento',
                 'eventos/despublicar-evento/<slug>' => 'evento/despublicar-evento',
                 'eventos/crear-formulario/<slug>' => 'evento/crear-formulario-dinamico',
                 'eventos/responder-formulario/<slug>' => 'evento/responder-formulario',
                 'eventos/respuestas-formulario/<slug>' => "evento/respuestas-formulario",
                 'eventos/suspender-evento/<slug>' => 'evento/suspender-evento',
                 "eventos/no-js" => "evento/no-js",
                 'eventos/finalizar-evento/<slug>' => 'evento/finalizar-evento',
                 'eventos/solicitar-aval/<slug>' => 'evento/solicitar-aval',
                 'presentacion/cargar-presentacion/<slug>' => 'presentacion/cargar-presentacion',
                 'presentacion/view/<presentacion:\d+>' => 'presentacion/view',
                 'presentacion/update/<presentacion:\d+>' => 'presentacion/update',
                 'presentacion/borrar/<presentacion:\d+>' => 'presentacion/borrar',
                 'evento/cargar-expositor/<idPresentacion:\d+>' => 'evento/cargar-expositor',
                 'presentacion-expositor/ver-expositores/<idPresentacion:\d+>' => 'presentacion-expositor/ver-expositores',
                 "acreditacion" => "acreditacion/acreditacion",
                 'defaultRoute' => '/site/index',
              ],
          ],
    ],
    'params' => $params,
];
