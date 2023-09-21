<?php
/*
Plugin Name: CoolClock
Plugin URI: https://status301.net/wordpress-plugins/coolclock/
Description: An analog clock for your site.
Text Domain: coolclock
Domain Path: languages
Version: 4.4-alpha2
Author: RavanH
Author URI: https://status301.net/
*/

defined( 'ABSPATH' ) || exit;

define( 'COOLCLOCK_VERSION', '4.4-alpha6' );
define( 'COOLCLOCK_DIR', plugin_dir_path( __FILE__ ) );

/***************
 *  MAIN CLASS
 ***************/

require COOLCLOCK_DIR . 'includes/class-coolclock.php';

new CoolClock( __FILE__, '4.3.6' );

/**************
 *  SHORTCODE
 **************/

require COOLCLOCK_DIR . 'includes/class-coolclock-shortcode.php';

add_shortcode( 'coolclock', array( 'CoolClock_Shortcode', 'handle_shortcode' ) );

// Prevent texturizing shortcode content.
add_filter( 'no_texturize_shortcodes', array( 'CoolClock_Shortcode', 'no_wptexturize') );

// Backward compatible filter, may be removed in the future.
add_filter( 'coolclock_shortcode', function( $output, $atts, $content ) {
	return apply_filters( 'coolclock_shortcode_advanced', $output, $atts, $content );
}, 10, 3 );

/**************
 *   WIDGET
 **************/

require COOLCLOCK_DIR . 'includes/class-coolclock-widget.php';

add_action( 'widgets_init', function() {
	register_widget( 'CoolClock_Widget' );
} );

// Backward compatible filter, may be removed in the future.
add_filter( 'coolclock_widget', function( $output, $args, $instance ) {
	return apply_filters( 'coolclock_widget_advanced', $output, $args, $instance );
}, 10, 3 );

/**************
 *    BLOCK
 **************/

require COOLCLOCK_DIR . 'includes/block.php';

add_action( 'init', 'coolclock_block_init' );

