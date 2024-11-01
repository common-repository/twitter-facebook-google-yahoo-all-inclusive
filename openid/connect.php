<?php
require_once(dirname(dirname(__FILE__)) . '/openid/openid.php');
require_once(dirname(dirname(__FILE__)) . '/utils.php' );

try {
  if(!isset($_GET['openid_mode']) || $_GET['openid_mode'] == 'cancel') {
    $openid = new LightOpenID;
    $openid->identity = urldecode($_GET['openid_url']);
    $openid->required = array('namePerson/first', 'namePerson/last', 'contact/email');
    header('Location: ' . $openid->authUrl());
  } else {
    $openid = new LightOpenID;
    if($openid->validate()) {
      $open_id = $openid->identity;
      $attributes = $openid->getAttributes();
      $email = $attributes['contact/email'];
      $first_name = $attributes['namePerson/first'];
      $last_name = $attributes['namePerson/last'];
      $signature = all_inclusive_generate_signature($open_id);
      ?>
<html>
<head>
<script>
function init() {
  window.opener.wp_all_inclusive({'action' : 'all_inclusive', 'all_inclusive_provider' : 'openid', 
    'all_inclusive_openid_identity' : '<?php echo $open_id ?>',
    'all_inclusive_signature' : '<?php echo $signature ?>',
    'all_inclusive_email' : '<?php echo $email ?>',
    'all_inclusive_first_name' : '<?php echo $first_name ?>',
    'all_inclusive_last_name' : '<?php echo $last_name ?>'});
    
  window.close();
}
</script>
</head>
<body onload="init();">
</body>
</html>      
      <?php
    }
  }
} catch(ErrorException $e) {
  echo $e->getMessage();
}
?>
