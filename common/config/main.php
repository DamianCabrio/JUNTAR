<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'name' => 'Juntar',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],'assetManager' => [
            'appendTimestamp' => true,
        ],
        //configuramos el nombre modificado de las tablas que utilizará authManager
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
//            'class' => 'vendor\yourVenderName\auth\models\DbManager',

              // uncomment if you want to cache RBAC items hierarchy
//            'cache' => 'cache',

            
            //renombramos las tablas auth  
            'itemTable' => 'permiso',
            'assignmentTable' => 'usuario_rol',
            'itemChildTable' => 'permiso_rol',
            'ruleTable' => 'regla',
        ],
    ],
];
