<?php
require_once 'codebird.php';

global $data;

// Twitter App Consumer Key
$consumer_key        = isset($data['twitter_consumer_key']) ? $data['twitter_consumer_key'] : null;
// Twitter App Access Token
$access_token        = isset($data['twitter_access_token']) ? $data['twitter_access_token'] : null;
// Twitter App Consumer Secret
$consumer_secret     = isset($data['twitter_consumer_secret']) ? $data['twitter_consumer_secret'] : null;
// Twitter App Access Token Secret
$access_token_secret = isset($data['twitter_access_token_secret']) ? $data['twitter_access_token_secret'] : null;

if ($consumer_key && $access_token && $consumer_secret && $access_token_secret) {
  $cb = PhoenixTeam_Codebird::getInstance();
  $GLOBALS[THEME_SLUG .'_twitter'] = $cb;
  $cb->setConsumerKey( $consumer_key, $consumer_secret );
  $cb->setToken( $access_token, $access_token_secret );
}
