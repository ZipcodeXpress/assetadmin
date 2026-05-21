<?php
$uniboxEnv = getenv('UNIBOX_ENV');
if ($uniboxEnv === false || $uniboxEnv === '') {
    $uniboxEnv = isset($_SERVER['UNIBOX_ENV']) && $_SERVER['UNIBOX_ENV'] !== ''
        ? $_SERVER['UNIBOX_ENV']
        : 'product';
}

$isProduct = ($uniboxEnv === 'product');

defined('YII_DEBUG') or define('YII_DEBUG', !$isProduct);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', $isProduct ? 0 : 3);
defined('YII_ENV') or define('YII_ENV', $isProduct ? 'prod' : 'dev');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

if ($isProduct) {

    $config = yii\helpers\ArrayHelper::merge(
        require(__DIR__ . '/../../common/config/main.php'),
        require(__DIR__ . '/../config/main.php'),
        require(__DIR__ . '/../config/main-local.php')
    );
} else {


    $config = yii\helpers\ArrayHelper::merge(
        require(__DIR__ . '/../../common/config/main-local.php'),
        require(__DIR__ . '/../config/main.php'),
        require(__DIR__ . '/../config/main-local.php')
    );
}

$application = new yii\web\Application($config);
$application->run();
