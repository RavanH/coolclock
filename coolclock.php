<?php
/*
Plugin Name: CoolClock
Plugin URI: https://status301.net/wordpress-plugins/coolclock/
Description: An analog clock for your site.
Text Domain: coolclock
Requires at least: 5.8
Version: 4.3.8
Author: RavanH
Author URI: https://status301.net/
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'COOLCLOCK_DIR', plugin_dir_path(__FILE__) );

/**************
 *   CLASSES
 **************/

require COOLCLOCK_DIR . 'includes/class-coolclock.php';
require COOLCLOCK_DIR . 'includes/class-coolclock-widget.php';
require COOLCLOCK_DIR . 'includes/class-coolclock-shortcode.php';

/**************
 *  INITIATE
 **************/

new CoolClock( __FILE__, '4.3.8' );
