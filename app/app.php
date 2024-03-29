<?php

use CODEAlchemy\Wisdom\Silex\Provider as WisdomProvider;
use Silex\Provider\MonologServiceProvider;
use MarcW\Silex\Provider\BuzzServiceProvider;
use Provider\Controller\UserControllerProvider;

$baseDir = dirname(__DIR__);
require_once $baseDir . '/app/bootstrap.php';

$app = new Silex\Application();

if ("dev" === getenv("APPLICATION_ENV")) {
    //todo : move to somewhere else  
    $app['debug'] = true;
    ini_set('error_reporting', -1);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

$app->register(new WisdomProvider, array(
    'wisdom.path' => $baseDir . '/config',
    'wisdom.options' => array(
        'prefix' => getenv("APPLICATION_ENV") . '.'
    )
));
$config = $app['wisdom']->get('config.json');

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => $config['log']['path'],
    'monolog.level' => constant('Monolog\Logger::' . $config['log']['level']),
    'monolog.name' => 'silex-api-consumer'
));

$app->register(new BuzzServiceProvider());

$app->mount('/users', new UserControllerProvider());

return $app;