<?php
/*
* Copyright (C) 2013 Google Inc.
*
* Licensed under the Apache License, Version 2.0 (the "License");
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
*      http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
*/
//  Author: Jenny Murphy - http://google.com/+JennyMurphy

require_once(PATH_LIB . 'glass/config.php');
require_once(PATH_LIB . 'glass/mirror_client.php');
require_once(PATH_LIB . 'glass/google-api-php-client/src/Google_Client.php');
require_once(PATH_LIB . 'glass/google-api-php-client/src/contrib/Google_Oauth2Service.php');

function store_credentials($user_id, $credentials) {
  $dbh = init_db();

  $user_id = strip_tags($user_id);
  $credentials = strip_tags($credentials);
  
  $stmt = $dbh->prepare("insert or replace into credentials VALUES ('$user_id', '$credentials')"); 
  $stmt->execute();
}

function get_credentials($user_id) {
  $dbh = init_db();
  $user_id = strip_tags($user_id);
  
  $sth = $dbh->prepare("select * from credentials where userid = '{$user_id}'"); 
  $sth->execute();
  $row = $sth->fetch();
  
  if (!empty($row['credentials'])) {
    return $row['credentials'];    
  }
  return false;
}

function list_credentials() {
  $dbh = init_db();

  // Must use explicit select instead of * to get the rowid
  
  $dbh->prepare("select userid, credentials from credentials");
  $dbh->execute();
  return $dbh->fetchAll();
}

// Create the credential storage if it does not exist
function init_db() {
  global $sqlite_database;    
  
  //$db = sqlite_open($sqlite_database);
  $dbh = new PDO('sqlite:'.$sqlite_database);  
  $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
  
  $sth = $dbh->prepare("select count(*) as cnt from sqlite_master where name = 'credentials'");
  
  $sth->execute();
  $row = $sth->fetch();
    
  if ($row['cnt'] == 0) {
      $sth = $dbh->prepare("create table credentials (userid text not null unique, credentials text not null)");
      $sth->execute();
  }
  
  return $dbh;
}

function bootstrap_new_user() {
  global $base_url;
    
  $client = get_google_api_client();
  
  $client->setAccessToken(get_credentials($_SESSION['userid']));

  // A glass service for interacting with the Mirror API
  $mirror_service = new Google_MirrorService($client);

  $timeline_item = new Google_TimelineItem();
  
  $timeline_item->setText("Welcome to the Mirror API PHP Quick Start");

  insert_timeline_item($mirror_service, $timeline_item, null, null);
  
  subscribe_to_notifications($mirror_service, "timeline", $_SESSION['userid'], 'https://mirrornotifications.appspot.com/forward?url='.$base_url . "/notify/");
  
}