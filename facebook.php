<?php
require_once __DIR__ . '/php-graph-sdk-5.0.0/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '1753404014911806',
  'app_secret' => '3a6ca40d67b29e4191acb4bd32626f72',
  'default_graph_version' => 'v2.2',
  ]);

$linkData = [
  'link' => 'http://www.example.com',
  'message' => 'U can vote for this poll',
  ];

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->post('/me/feed', $linkData, 'EAAY6ti904T4BAH6ulhC6FHnmWx4jNrht54DkLYTuZBXnR7uzvwkbFv1RFI9tuNHRRIUCYAfNiG45cN8TZBxII1mgjLl9ef8alRW0hlHx7v4fWQxaHV873t3ZBuE1sDEYQ34x9EUeKxtwdmSf12ayXEOfrMRmkRz25ERn27TbN7Bf1ndtCfF');
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$graphNode = $response->getGraphNode();

echo 'Posted with id: ' . $graphNode['id'];

