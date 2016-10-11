<?php

require_once __DIR__ . '/php-graph-sdk-5.0.0/src/Facebook/autoload.php';
session_start();

$fb = new Facebook\Facebook([
  'app_id' => '1753404014911806', // Replace {app-id} with your app id
  'app_secret' => '3a6ca40d67b29e4191acb4bd32626f72',
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email', 'publish_actions']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://localhost/diplomna/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';