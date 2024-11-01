<?php

function sc_render_login_form_all_inclusive( $args = NULL ) {

	if( $args == NULL )
		$display_label = true;
	elseif ( is_array( $args ) )
		extract( $args );

	if( !isset( $images_url ) )
		$images_url = all_inclusive_PLUGIN_URL . '/media/img/';

	$twitter_enabled = get_option( 'all_inclusive_twitter_enabled' ) && get_option( 'all_inclusive_twitter_consumer_key' ) && get_option( 'all_inclusive_twitter_consumer_secret' );
	$facebook_enabled = get_option( 'all_inclusive_facebook_enabled', 1 ) && get_option( 'all_inclusive_facebook_api_key' ) && get_option( 'all_inclusive_facebook_secret_key' );
	$google_enabled = get_option( 'all_inclusive_google_enabled', 1 );
	$yahoo_enabled = get_option( 'all_inclusive_yahoo_enabled', 1 );
	$wordpress_enabled = get_option( 'all_inclusive_wordpress_enabled', 1 );
	?>
	<div class="all_inclusive_ui <?php if( strpos( $_SERVER['REQUEST_URI'], 'wp-signup.php' ) ) echo 'mu_signup'; ?>">
		<?php if( $display_label !== false ) : ?>
			<div style="margin-bottom: 3px;"><label><?php _e( 'Connect with', 'all_inclusive' ); ?>:</label></div>
		<?php endif; ?>
		<div class="all_inclusive_form" title="All Inclusive">
			<?php if( $facebook_enabled ) : ?>
				<a href="javascript:void(0);" title="Facebook" class="all_inclusive_login_facebook"><img alt="Facebook" src="<?php echo $images_url . 'facebook_32.png' ?>" /></a>
			<?php endif; ?>
			<?php if( $twitter_enabled ) : ?>
				<a href="javascript:void(0);" title="Twitter" class="all_inclusive_login_twitter"><img alt="Twitter" src="<?php echo $images_url . 'twitter_32.png' ?>" /></a>
			<?php endif; ?>
			<?php if( $google_enabled ) : ?>
				<a href="javascript:void(0);" title="Google" class="all_inclusive_login_google"><img alt="Google" src="<?php echo $images_url . 'google_32.png' ?>" /></a>
			<?php endif; ?>
			<?php if( $yahoo_enabled ) : ?>
				<a href="javascript:void(0);" title="Yahoo" class="all_inclusive_login_yahoo"><img alt="Yahoo" src="<?php echo $images_url . 'yahoo_32.png' ?>" /></a>
			<?php endif; ?>
			<?php if( $wordpress_enabled ) : ?>
				<a href="javascript:void(0);" title="WordPress.com" class="all_inclusive_login_wordpress"><img alt="Wordpress.com" src="<?php echo $images_url . 'wordpress_32.png' ?>" /></a>
			<?php endif; ?>
		</div>

		<?php
	$all_inclusive_provider = isset( $_COOKIE['all_inclusive_current_provider']) ? $_COOKIE['all_inclusive_current_provider'] : '';

?>
	<div id="all_inclusive_facebook_auth">
		<input type="hidden" name="client_id" value="<?php echo get_option( 'all_inclusive_facebook_api_key' ); ?>" />
		<input type="hidden" name="redirect_uri" value="<?php echo urlencode( all_inclusive_PLUGIN_URL . '/facebook/callback.php' ); ?>" />
	</div>
	<div id="all_inclusive_twitter_auth"><input type="hidden" name="redirect_uri" value="<?php echo( all_inclusive_PLUGIN_URL . '/twitter/connect.php' ); ?>" /></div>
	<div id="all_inclusive_google_auth"><input type="hidden" name="redirect_uri" value="<?php echo( all_inclusive_PLUGIN_URL . '/google/connect.php' ); ?>" /></div>
	<div id="all_inclusive_yahoo_auth"><input type="hidden" name="redirect_uri" value="<?php echo( all_inclusive_PLUGIN_URL . '/yahoo/connect.php' ); ?>" /></div>
	<div id="all_inclusive_wordpress_auth"><input type="hidden" name="redirect_uri" value="<?php echo( all_inclusive_PLUGIN_URL . '/wordpress/connect.php' ); ?>" /></div>

	<div class="all_inclusive_wordpress_form" title="WordPress">
		<p><?php _e( 'Enter your WordPress.com blog URL', 'all_inclusive' ); ?></p><br/>
		<p>
			<span>http://</span><input class="wordpress_blog_url" size="15" value=""/><span>.wordpress.com</span> <br/><br/>
			<a href="javascript:void(0);" class="all_inclusive_wordpress_proceed"><?php _e( 'Proceed', 'all_inclusive' ); ?></a>
		</p>
	</div>
</div> <!-- End of all_inclusive_ui div -->
<?php
}
add_action( 'login_form',          'sc_render_login_form_all_inclusive' );
add_action( 'register_form',       'sc_render_login_form_all_inclusive' );
add_action( 'after_signup_form',   'sc_render_login_form_all_inclusive' );
add_action( 'all_inclusive_form', 'sc_render_login_form_all_inclusive' );


function sc_all_inclusive_add_comment_meta( $comment_id ) {
	$all_inclusive_comment_via_provider = isset( $_POST['all_inclusive_comment_via_provider']) ? $_POST['all_inclusive_comment_via_provider'] : '';
	if( $all_inclusive_comment_via_provider != '' ) {
		update_comment_meta( $comment_id, 'all_inclusive_comment_via_provider', $all_inclusive_comment_via_provider );
	}
}
add_action( 'comment_post', 'sc_all_inclusive_add_comment_meta' );


function sc_all_inclusive_render_comment_meta( $link ) {
	global $comment;
	$images_url = all_inclusive_PLUGIN_URL . '/media/img/';
	$all_inclusive_comment_via_provider = get_comment_meta( $comment->comment_ID, 'all_inclusive_comment_via_provider', true );
	if( $all_inclusive_comment_via_provider && current_user_can( 'manage_options' )) {
		return $link . '&nbsp;<img class="all_inclusive_comment_via_provider" alt="'.$all_inclusive_comment_via_provider.'" src="' . $images_url . $all_inclusive_comment_via_provider . '_16.png"  />';
	} else {
		return $link;
	}
}
add_action( 'get_comment_author_link', 'sc_all_inclusive_render_comment_meta' );


function sc_render_comment_form_all_inclusive() {
	if( comments_open() && !is_user_logged_in()) {
		sc_render_login_form_all_inclusive();
	}
}
add_action( 'comment_form_top', 'sc_render_comment_form_all_inclusive' );


function sc_render_login_page_uri(){
	?>
	<input type="hidden" id="all_inclusive_login_form_uri" value="<?php echo site_url( 'wp-login.php', 'login_post' ); ?>" />
	<?php
}
add_action( 'wp_footer', 'sc_render_login_page_uri' );


/**
 * AllInclusiveWidget Class
 */
class AllInclusiveWidget extends WP_Widget {
	/** constructor */
	function AllInclusiveWidget() {
		parent::WP_Widget(
			'all_inclusive', //unique id
			'All Inclusive', //title displayed at admin panel
			//Additional parameters
			array( 
				'description' => __( 'Login or register with Facebook, Twitter, Yahoo, Google or a Wordpress.com account', 'all_inclusive' ))
			);
	}

	/** This is rendered widget content */
	function widget( $args, $instance ) {
		extract( $args );
		
		if($instance['hide_for_logged_in']==1 && is_user_logged_in()) return;
		
		echo $before_widget;

		if( !empty( $instance['title'] ) ){
			$title = apply_filters( 'widget_title', $instance[ 'title' ] );
			echo $before_title . $title . $after_title;
		}

		if( !empty( $instance['before_widget_content'] ) ){
			echo $instance['before_widget_content'];
		}

		sc_render_login_form_all_inclusive( array( 'display_label' => false ) );

		if( !empty( $instance['after_widget_content'] ) ){
			echo $instance['after_widget_content'];
		}

		echo $after_widget;
	}

	/** Everything which should happen when user edit widget at admin panel */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['before_widget_content'] = $new_instance['before_widget_content'];
		$instance['after_widget_content'] = $new_instance['after_widget_content'];
		$instance['hide_for_logged_in'] = $new_instance['hide_for_logged_in'];

		return $instance;
	}

	/** Widget edit form at admin panel */
	function form( $instance ) {
		/* Set up default widget settings. */
		$defaults = array( 'title' => '', 'before_widget_content' => '', 'after_widget_content' => '' );

		foreach( $instance as $key => $value ) 
			$instance[ $key ] = esc_attr( $value );

		$instance = wp_parse_args( (array)$instance, $defaults );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'all_inclusive' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			<label for="<?php echo $this->get_field_id( 'before_widget_content' ); ?>"><?php _e( 'Before widget content:', 'all_inclusive' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'before_widget_content' ); ?>" name="<?php echo $this->get_field_name( 'before_widget_content' ); ?>" type="text" value="<?php echo $instance['before_widget_content']; ?>" />
			<label for="<?php echo $this->get_field_id( 'after_widget_content' ); ?>"><?php _e( 'After widget content:', 'all_inclusive' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'after_widget_content' ); ?>" name="<?php echo $this->get_field_name( 'after_widget_content' ); ?>" type="text" value="<?php echo $instance['after_widget_content']; ?>" />
			<br /><br /><label for="<?php echo $this->get_field_id( 'hide_for_logged_in' ); ?>"><?php _e( 'Hide for logged in users:', 'all_inclusive' ); ?></label>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'hide_for_logged_in' ); ?>" name="<?php echo $this->get_field_name( 'hide_for_logged_in' ); ?>" type="text" value="1" <?php if($instance['hide_for_logged_in']==1) echo 'checked="checked"'; ?> />
		</p>
		<?php
}

}
add_action( 'widgets_init', create_function( '', 'return register_widget( "AllInclusiveWidget" );' ));


function sc_all_inclusive_shortcode_handler( $args ) {
	if( !is_user_logged_in()) {
		sc_render_login_form_all_inclusive();
	}
}
add_shortcode( 'all_inclusive', 'sc_all_inclusive_shortcode_handler' );
