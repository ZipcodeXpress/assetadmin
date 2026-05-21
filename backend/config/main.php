<?php
$uniboxEnv = getenv('UNIBOX_ENV');
if ($uniboxEnv === false || $uniboxEnv === '') {
    $uniboxEnv = isset($_SERVER['UNIBOX_ENV']) && $_SERVER['UNIBOX_ENV'] !== ''
        ? $_SERVER['UNIBOX_ENV']
        : 'product';
}
$isProduct = ($uniboxEnv === 'product');

$commonParams = require(__DIR__ . '/../../common/config/params.php');
if (!$isProduct) {
    $commonParams = array_merge(
        $commonParams,
        require(__DIR__ . '/../../common/config/params-local.php')
    );
}

$params = array_merge(
    $commonParams,
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'auth_item',
            'assignmentTable' => 'auth_assignment',
            'itemChildTable' => 'auth_item_child',
        ],
    ],
    'params' => $params,
];
