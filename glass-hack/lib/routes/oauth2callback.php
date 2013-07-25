<?php

$client = get_google_api_client();

if (isset($_GET['code'])) {
    
  // Handle step 2 of the OAuth 2.0 dance - code exchange
  $client->authenticate();  
  $access_token = $client->getAccessToken();
    
  // Use the identity service to get their ID
  $identity_client = get_google_api_client();
  $identity_client->setAccessToken($access_token);
  $identity_service = new Google_Oauth2Service($identity_client);
  $user = $identity_service->userinfo->get();
  $user_id = $user->getId();
    
  // Store their credentials and register their ID with their session
  $_SESSION['userid'] = $user_id;
    
  store_credentials($user_id, $client->getAccessToken());
    
  // Bootstrap the new user by inserting a welcome message, a contact,
  // and subscribing them to timeline notifications
  bootstrap_new_user();
  
  // redirect back to the base url
  header('Location: ' . $base_url);
  
} elseif (!isset($_SESSION['userid']) || get_credentials($_SESSION['userid']) == null) {
  // Handle step 1 of the OAuth 2.0 dance - redirect to Google      
  header('Location: ' . $client->createAuthUrl());
  exit;
} else {
  // We're authenticated, redirect back to base_url
  header('Location: ' . $base_url);
  exit;
}