<?php

/******************************************************************
 * Autoload Vendor code (Composor, Slim, Twig)
 ******************************************************************/
require __DIR__ . '/../lib/bootstrap.php';

/******************************************************************
 * instantiate Slim and load all settings
 ******************************************************************/

 // Check for session settings
ini_set('session.gc_maxlifetime', $settings['sessions']['expires']);
ini_set('session.cookie_httponly', true); // try to prevent javascript access
session_name('GOOGLE-GLASS');

session_cache_limiter(false);
session_start();

$app = new \Slim\Slim($settings);

$app->contentType('text/html; charset=utf-8');

/******************************************************************
 * application routes
******************************************************************/

require_once(PATH_LIB . 'routes.php');

/******************************************************************
 * Load Google API and GLASS Client
 ******************************************************************/
 require_once(PATH_LIB . 'glass/config.php');
require_once(PATH_LIB . 'glass/mirror_client.php');
require_once(PATH_LIB . 'glass/google-api-php-client/src/Google_Client.php');
require_once(PATH_LIB . 'glass/google-api-php-client/src/contrib/Google_MirrorService.php');
require_once(PATH_LIB . 'glass/util.php');

/******************************************************************
 * instantiate Twig
 ******************************************************************/
require_once(PATH_CLASSES . 'TwigView.class.php') ;
$app->view('TwigView');
$twig = $app->view()->getEnvironment();

$app->run();