<?php

/******************************************************************
 * Settings for production environment
 ******************************************************************/

 $_ENV['SLIM_MODE'] = 'development';

// These $settings override those declared in config.php
// Only define settings that should be different in dev, qa
$settings['mode'] = 'dev';
$settings['debug'] = true;
$settings['web']['static_dir'] = '';
$settings['web']['static_domain'] = ( isset($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"])==='on' ? '' : 'http://'.$_SERVER['HTTP_HOST']);
$settings['log.level'] = 2;

$settings = array(
	'configuration' => __FILE__,
	'mode' => 'dev',
	'templates.path' => PATH_TEMPLATES
);