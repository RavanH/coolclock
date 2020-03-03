<?php

/**
 * CoolClock Class
 */

class CoolClock {

	static $plugin_version;

	static $script_version = '3.2.0';

	private static $plugin_url;

	private static $plugin_basename;

	private static $min = '.min';

	static $add_script = false;

	static $add_moreskins = false;

	private static $done_excanvas = false;

	static $defaults = array(
		'skin' => 'swissRail',
		'radius' => 100,
		'noseconds' => false,	// true to hide second hand
		'gmtoffset' => '',		// GMT offset
		'showdigital' => '',	// show digital time or date
		'scale' => '',				// Define alternative clock type: 'logClock' logarithmic or 'logClockRev' reversed
		'font' => '',					// Define font size and family for digital time, default '15px monospace'
		'fontcolor' => ''			// Define font color for digital time, default '#333'
	);

	static $showdigital_options = array(
		'digital12' => 'showDigital'
	);

	static $advanced = false;

	static $advanced_defaults = array(
		'subtext' => '',
		'align' => 'center'
	);

	static $default_skins = array('swissRail','chunkySwiss','chunkySwissOnBlack');

	static $more_skins = array('fancy','machine','simonbaird_com','classic','modern','simple','securephp','Tes2','Lev','Sand','Sun','Tor','Cold','Babosa','Tumb','Stone','Disc','watermelon','mister');

	static $advanced_skins = array();

	static $advanced_skins_config = array();

	static $clock_types = array(
		'linear' => '',
		'logclock' => 'logClock',
		'logclockrev' => 'logClockRev'
	);

	static $allowed_tags = array(
    'a' => array(
        'href' => array(),
        'title' => array()
    ),
    'br' => array(),
    'em' => array(),
    'strong' => array(),
	);

	/**
	 * METHODS
	 */

	/**
	* Build canvas output
	*
	* @since 2.0
	*
	* @param array $atts Array of sanitized attributes
	* @return string Canvas tag
	*/

	public static function canvas( $atts ) {
		/**
		* ARRAY VALUES
		* skin					@param string - skin ID. Must be one of these: 'swissRail' (default skin), 'chunkySwiss', 'chunkySwissOnBlack', 'fancy', 'machine', 'simonbaird_com', 'classic', 'modern', 'simple', 'securephp', 'Tes2', 'Lev', 'Sand', 'Sun', 'Tor', 'Cold', 'Babosa', 'Tumb', 'Stone', 'Disc', 'watermelon' or 'mister'.
		* 							If the Advanced extension is activated, there is also 'minimal' available.
		* radius				@param int - Define the clock radius.
		* noseconds			@param bool - True to hide the second hand.
		* gmtoffset			@param float - Timezone offset relative the Greenwhich Mean Time
		* showdigital		@param string|bool - Set to 'digital12' to show the time in 12h digital format (with am/pm).
		* font					@param string - Set to a font size, family and style for the digital time
		* fontcolor			@param string - Set to a color value to change the digital time color
		* scale					@param string - Optional alternative clock scale 'logClock' or 'logClockRev'
		* subtext				@param string - Optional text, centered below the clock
		* align					@param string - Sets floating of the clock: 'left', 'right' or 'center'
		*/

		// get defaults for missing attributes
		$defaults = array_merge( self::$defaults, self::$advanced_defaults );

		// radius, used in wrapper style and coolclock fields
		$radius = !empty( $atts['radius'] ) && is_numeric($atts['radius']) ? (int) $atts['radius'] : $defaults['radius'];
		if ( 10 > $radius ) $radius = 10; // minimum size

		// wrapper style
		$style = 'width:' . 2 * $radius . 'px;max-width:100%;height:auto';
		// wrapper class
		$align = !empty( $atts['align'] ) ? $atts['align'] : $defaults['align'];
		$class = in_array( $align, array('left','right','center') ) ? 'coolclock align' . $align : 'coolclock';
		// sub text
		$subtext = ( isset( $atts['subtext'] ) ) ? $atts['subtext'] : $defaults['subtext'];

		// CoolClock fields array
		$fields = array();
		$fields[] = 'CoolClock';
		// skin id
		$fields[] = !empty( $atts['skin'] ) ? $atts['skin'] : $defaults['skin'];
		// radius
		$fields[] = $radius;
		// noseconds
		$noseconds = isset( $atts['noseconds'] ) ? (bool) $atts['noseconds'] : $defaults['noseconds'];
		$fields[] = $noseconds ? 'noSeconds' : '';
		// gmt offset
		$fields[] = isset( $atts['gmtoffset'] ) && is_numeric( $atts['gmtoffset'] ) ? (float) $atts['gmtoffset'] : $defaults['gmtoffset'];
		// show digital
		$showdigital = isset($atts['showdigital']) ? $atts['showdigital'] : $defaults['showdigital'];
		if ( true === $showdigital )
			$showdigital = 'digital12';
		$fields[] = isset( self::$showdigital_options[$showdigital] ) ? self::$showdigital_options[$showdigital] : '';
		// clock type
		$scale = isset( $atts['scale'] ) ? strtolower( $atts['scale'] ) : $defaults['scale'];
		$fields[] = isset( self::$clock_types[$scale] ) ? self::$clock_types[$scale] : '';
		// set font color
		$fields[] = isset( $atts['fontcolor'] ) ? $atts['fontcolor'] : $defaults['fontcolor'];

		$fields = apply_filters( 'coolclock_fields_array', $fields, $atts, $defaults );

		// build output
		$output = '';

		if ( ! self::$done_excanvas ){
			$output .= '<!--[if lte IE 8]>';
			$output .= '<script type=\'text/javascript\' src=\'' . self::$plugin_url . 'js/excanvas' . self::$min . '.js\'></script>';
			$output .= '<![endif]-->' . PHP_EOL;
			self::$done_excanvas = true;
		}
		// begin wrapper
		$output .= '<div class="' . $class . '" style="' . $style . '">';

		// canvas parameters
		$output .= '<canvas class="' . implode(':',$fields) . '"></canvas>';

		// end wrapper
		$output .= !empty( $subtext ) ? '<div style="width:100%;text-align:center;padding-bottom:10px">' . $subtext . '</div></div>' : '</div>';

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

	// add links to plugin's description
	public static function plugin_meta_links($links, $file) {
	  $support_link = '<a target="_blank" href="https://wordpress.org/support/plugin/coolclock/">' . __('Support','coolclock') . '</a>';
	  $rate_link = '<a target="_blank" href="https://wordpress.org/support/plugin/coolclock/reviews/?filter=5#new-post">' . __('Rate ★★★★★','coolclock') . '</a>';

	  if ( $file == self::$plugin_basename ) {
	    $links[] = $support_link;
	    $links[] = $rate_link;
	  }

	  return $links;
	}

	public static function colorval( $color )
	{
		$color = wp_strip_all_tags( $color );
		$color = trim( $color );

		if (substr($color, 0, 1) == '#') {
			if ( ctype_xdigit(substr($color, 1)) )
				return $color;

			return substr($color, 1);
		}

		return ctype_xdigit($color) ? '#'.$color : $color;
	}

	/**
	 * INIT
	 */

	public function __construct( $plugin_file, $plugin_version ) {
 		// VARS
 		self::$plugin_url = plugins_url( '/', $plugin_file );
 		self::$plugin_basename = plugin_basename( $plugin_file );
		self::$plugin_version = $plugin_version;

 		if ( defined('WP_DEBUG') && WP_DEBUG ) {
 			self::$min = '';
 		}

		// text domain
		add_action( 'plugins_loaded', array( __CLASS__, 'textdomain' ) );

		// widgets
		add_action( 'widgets_init', array( __CLASS__, 'register_widget' ) );

		// enqueue scripts but only if shortcode or widget has been used
		// so it has to be done as late as the wp_footer action
		add_action( 'wp_footer', array( __CLASS__, 'enqueue_scripts' ), 1 );

		add_filter( 'plugin_row_meta', array( __CLASS__, 'plugin_meta_links' ), 10, 2);

		/**************
		 *  SHORTCODE
		 **************/

		add_shortcode( 'coolclock', array( 'CoolClock_Shortcode', 'handle_shortcode' ) );

		// prevent texturizing shortcode content
		add_filter( 'no_texturize_shortcodes', array( 'CoolClock_Shortcode', 'no_wptexturize') );
 	}

}
