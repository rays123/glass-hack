<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');

date_default_timezone_set('America/New_York');

/******************************************************************
 * Autoload Vendor code (Composor, Slim, Twig)
 ******************************************************************/
require __DIR__ . '/../vendor/autoload.php';

/******************************************************************
 * Default path setup
 ******************************************************************/

define('BASEDIR', dirname(dirname(realpath(__FILE__))));
define('PATH_LIB', BASEDIR . '/lib/');
define('PATH_CLASSES', PATH_LIB . 'classes/'); 
define('PATH_ROUTES', PATH_LIB . 'routes/');
define('PATH_CONFIG', PATH_LIB . '/config/');
define('PATH_TEMPLATES', BASEDIR . '/views/');

require_once(PATH_CONFIG . 'config.php');