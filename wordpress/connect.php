<?php
require_once(dirname(dirname(__FILE__)) . '/openid/openid.php');
require_once(dirname(dirname(__FILE__)) . '/utils.php' );
try {
	if(!isset($_GET['openid_mode'])) {
		$openid = new LightOpenID;
		$openid->identity = urldecode($_GET['wordpress_blog_url']);
		$openid->required = array('namePerson', 'namePerson/friendly', 'contact/email');
		header('Location: ' . $openid->authUrl());
	} elseif($_GET['openid_mode'] == 'cancel') {
			?>
			<html>
			<body>
				<p><?php _e( 'You have cancelled this login. Please close this window and try again.', 'all-inclusive' ); ?></p>
			</body>
			</html>
			<?php
	} else {
		$openid = new LightOpenID;
		if($openid->validate()) {
			$wordpress_id = $openid->identity;
			$attributes = $openid->getAttributes();
			$email = isset($attributes['contact/email']) ? $attributes['contact/email'] : '';
			$name = isset($attributes['namePerson']) ? $attributes['namePerson'] : '';
			$signature = all_inclusive_generate_signature($wordpress_id);
			if($email == '') {
				?>
				<html>
				<body>
					<p><?php _e( 'You need to share your email address when prompted at wordpress.com. Please close this window and try again.', 'all-inclusive' ); ?></p>
				</body>
				</html>
				<?php
			die();
		}

		?>
		<html>
		<head>
		<script>
		function init() {
			window.opener.wp_all_inclusive({'action' : 'all_inclusive', 'all_inclusive_provider' : 'wordpress',
			'all_inclusive_signature' : '<?php echo $signature ?>',
			'all_inclusive_openid_identity' : '<?php echo $wordpress_id ?>',
			'all_inclusive_email' : '<?php echo $email ?>',
			'all_inclusive_name' : '<?php echo $name ?>'
		});
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