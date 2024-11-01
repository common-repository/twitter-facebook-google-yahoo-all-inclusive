<?php

function sc_all_inclusive_admin_menu(){
	add_options_page('All Inclusive', 'All Inclusive', 'manage_options', 'all-inclusive-id', 'sc_render_all_inclusive_settings' );
	add_action( 'admin_init', 'sc_register_all_inclusive_settings' );
}
add_action('admin_menu', 'sc_all_inclusive_admin_menu' );

function sc_register_all_inclusive_settings(){
	register_setting( 'all-inclusive-settings-group', 'all_inclusive_facebook_enabled' );  
	register_setting( 'all-inclusive-settings-group', 'all_inclusive_facebook_api_key' );
	register_setting( 'all-inclusive-settings-group', 'all_inclusive_facebook_secret_key' );

	register_setting( 'all-inclusive-settings-group', 'all_inclusive_twitter_enabled' );
	register_setting( 'all-inclusive-settings-group', 'all_inclusive_twitter_consumer_key' );
	register_setting( 'all-inclusive-settings-group', 'all_inclusive_twitter_consumer_secret' );

	register_setting( 'all-inclusive-settings-group', 'all_inclusive_google_enabled' );      
	register_setting( 'all-inclusive-settings-group', 'all_inclusive_yahoo_enabled' );      
	register_setting( 'all-inclusive-settings-group', 'all_inclusive_wordpress_enabled' );    
}

function sc_render_all_inclusive_settings(){
	?>
	<div class="wrap">
		<h2><?php _e('All Inclusive Settings', 'all_inclusive'); ?></h2>

		<form method="post" action="options.php">
			<?php settings_fields( 'all-inclusive-settings-group' ); ?>
			<h3><?php _e('Facebook Settings', 'all_inclusive'); ?></h3>
			<p><?php _e('To connect your site to Facebook, you need a Facebook Application. If you have already created one, please insert your API & Secret key below.', 'all_inclusive'); ?></p>
			<p><?php printf(__('Already registered? Find your keys in your <a target="_blank" href="%2$s">%1$s Application List</a>', 'all_inclusive'), 'Facebook', 'http://www.facebook.com/developers/apps.php'); ?></li>
				<p><?php _e('Need to register?', 'all_inclusive'); ?></p>
				<ol>
					<li><?php printf(__('Visit the <a target="_blank" href="%1$s">Facebook Application Setup</a> page', 'all_inclusive'), 'http://www.facebook.com/developers/createapp.php'); ?></li>
					<li><?php printf(__('Get the API information from the <a target="_blank" href="%1$s">Facebook Application List</a>', 'all_inclusive'), 'http://www.facebook.com/developers/apps.php'); ?></li>
					<li><?php _e('Select the application you created, then copy and paste the API key & Application Secret from there.', 'all_inclusive'); ?></li>
				</ol>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Enable?', 'all_inclusive'); ?></th>
						<td>
							<input type="checkbox" name="all_inclusive_facebook_enabled" value="1" <?php checked(get_option('all_inclusive_facebook_enabled', 1 ), 1 ); ?> /><br/>
							<?php _e('Check this box to enable register/login using Facebook.', 'all_inclusive'); ?>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('API Key', 'all_inclusive'); ?></th>
						<td><input type="text" name="all_inclusive_facebook_api_key" value="<?php echo get_option('all_inclusive_facebook_api_key' ); ?>" /></td>
					</tr>

					<tr valign="top">
						<th scope="row"><?php _e('Secret Key', 'all_inclusive'); ?></th>
						<td><input type="text" name="all_inclusive_facebook_secret_key" value="<?php echo get_option('all_inclusive_facebook_secret_key' ); ?>" /></td>
					</tr>
				</table>

				<h3><?php _e('Twitter Settings', 'all_inclusive'); ?></h3>
				<p><?php _e('To offer login via Twitter, you need to register your site as a Twitter Application and get a <strong>Consumer Key</strong>, a <strong>Consumer Secret</strong>, an <strong>Access Token</strong> and an <strong>Access Token Secret</strong>.', 'all_inclusive'); ?></p>
				<p><?php printf(__('Already registered? Find your keys in your <a target="_blank" href="%2$s">%1$s Application List</a>', 'all_inclusive'), 'Twitter', 'https://dev.twitter.com/apps'); ?></p>
				<p><?php printf(__('Need to register? <a href="%1$s">Register an Application</a> and fill the form with the details below:', 'all_inclusive'), 'http://dev.twitter.com/apps/new'); ?>
					<ol>
						<li><?php _e('Application Type: <strong>Browser</strong>', 'all_inclusive'); ?></li>
						<li><?php printf(__('Callback URL: <strong>%1$s</strong>', 'all_inclusive'), all_inclusive_PLUGIN_URL . '/twitter/callback.php'); ?></li>
						<li><?php _e('Default Access: <strong>Read &amp; Write</strong>', 'all_inclusive'); ?></li>
					</ol>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php _e('Enable?', 'all_inclusive'); ?></th>
							<td>
								<input type="checkbox" name="all_inclusive_twitter_enabled" value="1" <?php checked(get_option('all_inclusive_twitter_enabled' ), 1 ); ?> /><br/>
								<?php _e('Twitter integration requires the generation of dummy email addresses for authenticating users.<br/>Please check with your domain administrator as this may require changes to your mail server.', 'all_inclusive'); ?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Consumer Key', 'all_inclusive'); ?></th>
							<td><input type="text" name="all_inclusive_twitter_consumer_key" value="<?php echo get_option('all_inclusive_twitter_consumer_key' ); ?>" /></td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Consumer Secret', 'all_inclusive'); ?></th>
							<td><input type="text" name="all_inclusive_twitter_consumer_secret" value="<?php echo get_option('all_inclusive_twitter_consumer_secret' ); ?>" /></td>
						</tr>
					</table>

					<h3><?php _e('OpenID Providers', 'all_inclusive'); ?></h3>
					<p><?php _e('Choose the OpenID providers your visitors can use to register, comment and login.', 'all_inclusive'); ?></p>
					<table class="form-table">
						<tr valign="top">
							<th scope="row">Google</th>
							<td>
								<input type="checkbox" name="all_inclusive_google_enabled" value="1" <?php checked(get_option('all_inclusive_google_enabled', 1 ), 1 ); ?> />
							</td>
						</tr>        
						<tr valign="top">
							<th scope="row">Yahoo</th>
							<td>
								<input type="checkbox" name="all_inclusive_yahoo_enabled" value="1" <?php checked(get_option('all_inclusive_yahoo_enabled', 1 ), 1 ); ?> />
							</td>
						</tr>        
						<tr valign="top">
							<th scope="row">WordPress.com</th>
							<td>
								<input type="checkbox" name="all_inclusive_wordpress_enabled" value="1" <?php checked(get_option('all_inclusive_wordpress_enabled', 1 ), 1 ); ?> />
							</td>
						</tr>        
					</table>

					<p class="submit">
						<input type="submit" class="button-primary" value="<?php _e('Save Changes' ) ?>" />
					</p>

					<h2><?php _e('Rewrite Diagnostics', 'all_inclusive'); ?></h2>
					<p><?php _e('Click on the link below to confirm your URL rewriting and query string parameter passing are setup correctly on your server. If you see a "Test was successful" message after clicking the link then you are good to go. If you see a 404 error or some other error then you need to update rewrite rules or ask your service provider to configure your server settings such that the below URL works correctly.', 'all_inclusive'); ?></p>
					<p><a class="button-primary" href='<?php echo all_inclusive_PLUGIN_URL ?>/diagnostics/test.php?testing=http://www.example.com' target='_blank'><?php _e('Test server redirection settings', 'all_inclusive'); ?></a></p>
					<p>If you web server fails this test, please have your hosting provider whitelist your domain on <em>mod_security</em>.
				</form>
			</div> <?php
	}
