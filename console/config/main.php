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
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
