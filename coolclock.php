<?php
/*
Plugin Name: CoolClock
Plugin URI: https://status301.net/wordpress-plugins/coolclock/
Description: Add an analog clock to your sidebar.
Text Domain: coolclock
Domain Path: languages
Version: 4.1-alpha
Author: RavanH
Author URI: https://status301.net/
*/

if ( ! defined( 'ABSPATH' ) ) exit;

/**************
 *   CLASSES
 **************/

require plugin_dir_path( __FILE__ ) . '/includes/class-coolclock.php';
require plugin_dir_path( __FILE__ ) . '/includes/class-coolclock-widget.php';
require plugin_dir_path( __FILE__ ) . '/includes/class-coolclock-shortcode.php';

/**************
 *    HOOKS
 **************/

// text domain
add_action( 'plugins_loaded', array( 'CoolClock', 'textdomain' ) );

// widgets
add_action( 'widgets_init', array( 'CoolClock', 'register_widget' ) );

// enqueue scripts but only if shortcode or widget has been used
// so it has to be done as late as the wp_footer action
add_action( 'wp_footer', array( 'CoolClock', 'enqueue_scripts' ), 1 );

/**************
 *  SHORTCODE
 **************/

add_shortcode( 'coolclock', array( 'CoolClock_Shortcode', 'handle_shortcode' ) );

// prevent texturizing shortcode content
add_filter( 'no_texturize_shortcodes', array( 'CoolClock_Shortcode', 'no_wptexturize') );

/**************
 *  INITIATE
 **************/

new CoolClock( __FILE__ );
