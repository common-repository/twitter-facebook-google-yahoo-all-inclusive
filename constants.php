<?php
require_once( dirname( dirname( dirname( dirname( __FILE__ )))) . '/wp-load.php' );

if( !defined( 'all_inclusive_PLUGIN_URL' )) {
  define( 'all_inclusive_PLUGIN_URL', plugins_url() . '/' . basename( dirname( __FILE__ )));
}

?>