<?php

/**
 * CoolClock Class
 */

class CoolClock {

	static $plugin_version = '4.0';

	static $script_version = '3.0.0';

	private static $plugin_url;

	private static $plugin_basename;

	private static $min = '.min';

	static $add_script = false;

	static $add_moreskins = false;

	private static $done_excanvas = false;

	static $defaults = array (
			'skin' => 'swissRail',
			'radius' => 100,
			'noseconds' => false,	// Hide seconds
			'gmtoffset' => '',		// GMT offset
			'showdigital' => '',	// Show digital time or date
			'scale' => 'linear'		// Define type of clock linear/logarithmic/log reversed
		);

	static $showdigital_options = array (
				'' => '',
				'digital12' => 'showDigital'
			);

	static $advanced;

	static $advanced_defaults = array (
				'subtext' => '',
				'align' => 'center'
			);

	static $default_skins = ['swissRail','chunkySwiss','chunkySwissOnBlack'];

	static $more_skins = ['fancy','machine','simonbaird_com','classic','modern','simple','securephp','Tes2','Lev','Sand','Sun','Tor','Cold','Babosa','Tumb','Stone','Disc','watermelon','mister'];

	static $advanced_skins = [];

	static $advanced_skins_config = [];

	static $clock_types = array (
	    		'linear' => '',
	    		'logClock' => 'logClock',
	    		'logClockRev' => 'logClockRev'
	    	);

	/**
	 * MAIN
	 */

	public static function canvas( $atts ) {
		extract( $atts );

		$output = '';

		if ( ! self::$done_excanvas ){
			$output .= '<!--[if lte IE 8]>';
			$output .= '<script type=\'text/javascript\' src=\'' . self::$plugin_url . 'js/excanvas' . self::$min . '.js\'></script>';
			$output .= '<![endif]-->' . PHP_EOL;
			self::$done_excanvas = true;
		}

		$output .= '<div class="coolclock';

		// align class ans style
		$output .= ( $align ) ? ' align' . $align : '';
		$output .= '" style="width:' . 2 * $radius . 'px;max-width:100%;height:auto">';
		// canvas parameters
		$output .= '<canvas class="CoolClock:' . $skin . ':' . $radius . ':';
		$output .= ( $noseconds == 'true' ||  $noseconds == '1' ) ? 'noSeconds:' : ':';
		$output .= $gmtoffset;

		// show digital
		if ( $showdigital == 'true' || $showdigital == '1' )
			$showdigital = 'digital12'; // backward compat

		if ( isset(self::$showdigital_options[$showdigital]) )
			$output .= ':'.self::$showdigital_options[$showdigital];
		else
			$output .= ':';

		// set type
		if ( isset(self::$clock_types[$scale]) )
			$output .= ':'.self::$clock_types[$scale];
		else
			$output .= ':';

		$output .= '"></canvas>';
		$output .= ( $subtext ) ? '<div style="width:100%;text-align:center;padding-bottom:10px">' . $subtext . '</div></div>' : '</div>';

		return $output;
	}

	public static function enqueue_scripts() {
		if ( ! self::$add_script )
			return;

		wp_enqueue_script( 'coolclock', self::$plugin_url . 'js/coolclock' . self::$min . '.js', array('jquery'), self::$script_version, true );

		if ( self::$add_moreskins )
			wp_enqueue_script( 'coolclock-moreskins', self::$plugin_url . 'js/moreskins' . self::$min . '.js', array('coolclock'), self::$script_version, true );

		if ( is_array( self::$advanced_skins_config ) && !empty( self::$advanced_skins_config ) ) {
			$script =  'jQuery.extend(CoolClock.config.skins, {' . PHP_EOL;
			// loop through plugin custom skins
			foreach (self::$advanced_skins_config as $key => $value)
				$script .= $key.':{'.$value.'},' . PHP_EOL;
			$script .= '});';

			if ( self::$add_moreskins )
				wp_add_inline_script( 'coolclock-moreskins', $script );
			else
				wp_add_inline_script( 'coolclock', $script );
		}
	}

	public static function textdomain() {
		load_plugin_textdomain( 'coolclock', false, dirname(self::$plugin_basename).'/languages' );
	}

	public static function register_widget() {
		register_widget("CoolClock_Widget");
	}

	/**
	 * INIT
	 */

	public function __construct( $file ) {
 		// VARS
 		self::$plugin_url = plugins_url( '/', $file );
 		self::$plugin_basename = plugin_basename( $file );

 		if ( defined('WP_DEBUG') && WP_DEBUG ) {
 			self::$min = '';
 		}
 	}

}
