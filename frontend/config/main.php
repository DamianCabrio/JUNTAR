<?php
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
    'bootstrap' => ['log'],
    'language' => "es_AR",
    'timeZone' => 'America/Argentina/Buenos_Aires',
    'aliases' =>[
        '@rutaLogo' => '/eventos/images/logos/',
        '@rutaFlyer' => '/eventos/images/flyers/',
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
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
                 'eventos/ver-evento/<slug>' => 'evento/ver-evento',
                 'eventos/evento-cargado/<slug>' => 'evento/evento-cargado',
                 'eventos/editar-evento/<slug>' => 'evento/editar-evento',
                 'eventos/publicar-evento/<slug>' => 'evento/publicar-evento',
                 'eventos/cargar-expositor/<idPresentacion:\d+>/<slug>' => 'evento/cargar-expositor',
                 'eventos/despublicar-evento/<slug>' => 'evento/despublicar-evento',
                 'presentacion/cargar-presentacion/<slug>' => 'presentacion/cargar-presentacion',
                 'presentacion/editar-presentacion/<idPresentacion:\d+><slug>' => 'presentacion/editar-presentacion',
                 'presentacion/borrar-presentacion/<idPresentacion:\d+><slug>' => 'presentacion/borrar-presentacion',
                // 'presentacion/ver-presentacion/<slug>' => 'presentacion/ver-presentacion',
                 'defaultRoute' => '/site/index',
              ],
          ],
    ],
    'params' => $params,
];
