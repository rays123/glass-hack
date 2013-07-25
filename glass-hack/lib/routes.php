<?php

// Check if this is an AJAX request
if ( $app->request()->isAjax() ) {
    Core::$request_type = 'ajax';
}

/***********************************************************************************
 * application routes 
 ***********************************************************************************/
 
$app->map('/', function() use ($app) {       
    require(PATH_ROUTES. 'home.php');
})->via('GET','POST');

$app->map('/notify/', function() use ($app) {       
    require(PATH_ROUTES. 'notify.php');
})->via('GET','POST');

$app->map('/oauth2callback/', function() use ($app) {       
    require(PATH_ROUTES. 'oauth2callback.php');
})->via('GET','POST');