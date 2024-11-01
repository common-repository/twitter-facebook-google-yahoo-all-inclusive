jQuery.noConflict();
(function($) { 
	$(function() {
		// ready to roll
		var _all_inclusive_wordpress_form = $($('.all_inclusive_wordpress_form')[0]);
		_all_inclusive_wordpress_form.dialog({ autoOpen: false, modal: true, dialogClass: 'all-inclusive-dialog', resizable: false, maxHeight: 400, width:350, maxWidth: 600 });

		var _do_google_connect = function() {
			var google_auth = $('#all_inclusive_google_auth');
			var redirect_uri = google_auth.find('input[type=hidden][name=redirect_uri]').val();

			window.open(redirect_uri,'','scrollbars=no,menubar=no,height=400,width=800,resizable=yes,toolbar=no,status=no');
		};

		var _do_yahoo_connect = function() {
			var yahoo_auth = $('#all_inclusive_yahoo_auth');
			var redirect_uri = yahoo_auth.find('input[type=hidden][name=redirect_uri]').val();

			window.open(redirect_uri,'','scrollbars=no,menubar=no,height=400,width=800,resizable=yes,toolbar=no,status=no');
		};

		var _do_twitter_connect = function() {
			var twitter_auth = $('#all_inclusive_twitter_auth');
			var redirect_uri = twitter_auth.find('input[type=hidden][name=redirect_uri]').val();

			window.open(redirect_uri,'','scrollbars=no,menubar=no,height=400,width=800,resizable=yes,toolbar=no,status=no');
		};

		var _do_wordpress_connect = function(e) {
			var wordpress_auth = $('#all_inclusive_wordpress_auth');
			var redirect_uri = wordpress_auth.find('input[type=hidden][name=redirect_uri]').val();
			var context = $(e.target).parents('.all_inclusive_wordpress_form')[0];
			var blog_name = $('.wordpress_blog_url', context).val();
			var blog_url = "http://" + blog_name + ".wordpress.com";
			redirect_uri = redirect_uri + "?wordpress_blog_url=" + encodeURIComponent(blog_url);

			window.open(redirect_uri,'','scrollbars=yes,menubar=no,height=400,width=800,resizable=yes,toolbar=no,status=no');
		};

		var _do_facebook_connect = function() {
			var facebook_auth = $('#all_inclusive_facebook_auth');
			var client_id = facebook_auth.find('input[type=hidden][name=client_id]').val();
			var redirect_uri = facebook_auth.find('input[type=hidden][name=redirect_uri]').val();

			if(client_id == "") {
				alert("Supra Connect plugin has not been configured for this provider")
			} else {
				window.open('https://graph.facebook.com/oauth/authorize?client_id=' + client_id + '&redirect_uri=' + redirect_uri + '&scope=email',
				'','scrollbars=no,menubar=no,height=400,width=800,resizable=yes,toolbar=no,status=no');
			}
		};

		// Close dialog if open and user clicks anywhere outside of it
		function overlay_click_close() {
			if (closedialog) {
				_all_inclusive_already_connected_form.dialog('close');
			}
			closedialog = 1;
		}

		$(".all_inclusive_login_facebook").click(function() {
			_do_facebook_connect();
		});

		$(".all_inclusive_login_continue_facebook").click(function() {
			_do_facebook_connect();
		});

		$(".all_inclusive_login_twitter").click(function() {
			_do_twitter_connect();
		});

		$(".all_inclusive_login_continue_twitter").click(function() {
			_do_twitter_connect();
		});

		$(".all_inclusive_login_google").click(function() {
			_do_google_connect();
		});

		$(".all_inclusive_login_continue_google").click(function() {
			_do_google_connect();
		});

		$(".all_inclusive_login_yahoo").click(function() {
			_do_yahoo_connect();
		});

		$(".all_inclusive_login_continue_yahoo").click(function() {
			_do_yahoo_connect();
		});

		$(".all_inclusive_login_wordpress").click(function() {
			_all_inclusive_wordpress_form.dialog('open');     
		});

		$(".all_inclusive_wordpress_proceed").click(function(e) {
			_do_wordpress_connect(e);
		});
	});
})(jQuery);


window.wp_all_inclusive = function(config) {
	jQuery('#loginform').unbind('submit.simplemodal-login');

	var form_id = '#loginform';

	if(!jQuery('#loginform').length) {
		// if register form exists, just use that
		if(jQuery('#registerform').length) {
			form_id = '#registerform';
		} else {
			// create the login form
			var login_uri = jQuery("#all_inclusive_login_form_uri").val();
			jQuery('body').append("<form id='loginform' method='post' action='" + login_uri + "'></form>");
			jQuery('#loginform').append("<input type='hidden' id='redirect_to' name='redirect_to' value='" + window.location.href + "'>");
		}
	}

	jQuery.each(config, function(key, value) { 
		jQuery("#" + key).remove();
		jQuery(form_id).append("<input type='hidden' id='" + key + "' name='" + key + "' value='" + value + "'>");
	});  

	if(jQuery("#simplemodal-login-form").length) {
		var current_url = window.location.href;
		jQuery("#redirect_to").remove();
		jQuery(form_id).append("<input type='hidden' id='redirect_to' name='redirect_to' value='" + current_url + "'>");
	}

	jQuery(form_id).submit();
}
