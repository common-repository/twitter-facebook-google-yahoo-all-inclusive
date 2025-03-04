<?php
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/wp-load.php');
require_once(dirname(__FILE__) . '/EpiCurl.php' );
require_once(dirname(__FILE__) . '/EpiOAuth.php' );
require_once(dirname(__FILE__) . '/EpiTwitter.php' );
require_once(dirname(dirname(__FILE__)) . '/utils.php' );

$consumer_key = get_option('all_inclusive_twitter_consumer_key');
$consumer_secret = get_option('all_inclusive_twitter_consumer_secret');
$twitter_api = new EpiTwitter($consumer_key, $consumer_secret);

$twitter_api->setToken($_GET['oauth_token']);
$token = $twitter_api->getAccessToken();
$twitter_api->setToken($token->oauth_token, $token->oauth_token_secret);

$user = $twitter_api->get_accountVerify_credentials();
$name = $user->name;
$screen_name = $user->screen_name;
$twitter_id = $user->id;
$signature = all_inclusive_generate_signature($twitter_id);
?>

<html>
<head>
<script>
function init() {
  window.opener.wp_all_inclusive({'action' : 'all_inclusive', 'all_inclusive_provider' : 'twitter', 
    'all_inclusive_signature' : '<?php echo $signature ?>',
    'all_inclusive_twitter_identity' : '<?php echo $twitter_id ?>',
    'all_inclusive_screen_name' : '<?php echo $screen_name ?>',
    'all_inclusive_name' : '<?php echo $name ?>'});
    
  window.close();
}
</script>
</head>
<body onload="init();">
</body>
</html>
