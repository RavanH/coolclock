<?php

/**
 * CoolClock Shortcode Class
 */

class CoolClock_Shortcode {

	public static function handle_shortcode( $atts, $content = null )
	{
		/**
		* skin					Must be one of these: 'swissRail' (default skin), 'chunkySwiss', 'chunkySwissOnBlack', 'fancy', 'machine', 'simonbaird_com', 'classic', 'modern', 'simple', 'securephp', 'Tes2', 'Lev', 'Sand', 'Sun', 'Tor', 'Cold', 'Babosa', 'Tumb', 'Stone', 'Disc', 'watermelon' or 'mister'.
		* 							If the Advanced extension is activated, there is also 'minimal' available.
		* radius				A number to define the clock radius. Do not add 'px' or any other measure descriptor.
		* noseconds			Set to 'true' or 1 or without value to hide the second hand.
		* gmtoffset			A number to define a timezone relative the Greenwhich Mean Time. Do not set this parameter to default to local time.
		* showdigital		Set to 'true' or 1 or 'digital12' or without value to show the time in 12h digital format (with am/pm) too
		* color					Set to a color value to change the digital time color, digitalcolor for backward compatibility
		* scale					Must be one of these: 'linear' (default scale), 'logClock' or 'logClockRev'. Linear is our normal clock scale, the other two show a logarithmic time scale
		* subtext				Optional text, centered below the clock
		* align					Sets floating of the clock: 'left', 'right' or 'center'
		*/

		if ( is_feed() )
			return '';

		// backward compat fontcolor
		if ( !empty( $atts['digitalcolor'] ) ) {
			$atts['fontcolor'] = $atts['digitalcolor'];
		}

		// pre-treat possible empty attributes
		if ( is_int( array_search( 'noseconds', $atts ) ) )
			$atts['noseconds'] = true;
		if ( is_int( array_search( 'showdigital', $atts ) ) )
			$atts['showdigital'] = 'digital12';

		// filter shortcode attributes
		$defaults = array_merge( CoolClock::$defaults, CoolClock::$advanced_defaults );
		$atts = shortcode_atts( $defaults, $atts, 'coolclock' );

		// parse skin
		$atts['skin'] = self::parse_skin( $atts['skin'], $content );

		// clean gmtoffset
		if ( !empty( $atts['gmtoffset'] ) ) {
			$atts['gmtoffset'] = str_replace( ',', '.', $atts['gmtoffset'] );
			$atts['gmtoffset'] = str_replace( array('1/2','½'), '.5', $atts['gmtoffset'] );
			$atts['gmtoffset'] = str_replace( array('h',' '), '', $atts['gmtoffset'] );
			$atts['gmtoffset'] = is_numeric( $atts['gmtoffset'] ) ? (float) trim( $atts['gmtoffset'] ) : '';
		}

		if ( !empty( $atts['fontcolor'] ) ) {
			$atts['fontcolor'] = CoolClock::colorval( $atts['fontcolor'] );
		}

		if ( !empty( $atts['scale'] ) )
			$atts['scale'] = wp_strip_all_tags( $atts['scale'] );

		// post-treat showdigital
		if ( in_array( $atts['showdigital'], array('true','1') ) )
			$atts['showdigital'] = true;
		elseif ( !in_array( $atts['showdigital'], array('false','0') ) )
			$atts['showdigital'] = wp_strip_all_tags( $atts['showdigital'] );
		else
			$atts['showdigital'] = '';

		// post-treat noseconds
		if ( 'false' === $atts['noseconds'] )
			$atts['noseconds'] = false;

		if ( !empty( $atts['font'] ) )
			$atts['font'] = wp_strip_all_tags( $atts['font'] );

		if ( !empty( $atts['align'] ) )
			$atts['align'] = wp_strip_all_tags( $atts['align'] );

		if ( !empty( $atts['subtext'] ) )
			$atts['subtext'] = wp_kses( $atts['subtext'], CoolClock::$allowed_tags );

		// get output
		$output = CoolClock::canvas( $atts );

		return apply_filters( 'coolclock_shortcode_advanced', $output, $atts, $content );
	}

	private static function parse_skin( $skin_name, $content )
	{
		// look trhough the default skins first
		foreach ( CoolClock::$default_skins as $skin ) {
			if ( strtolower($skin_name) == strtolower($skin) )
			// return the matching skin
			return $skin;
		}

		// still here? then search in the $more_skins array
		foreach ( CoolClock::$more_skins as $skin ) {
			if ( strtolower($skin_name) == strtolower($skin) ) {
				// set more_skins flag
				CoolClock::$add_moreskins = true;
				// return the matching skin
				return $skin;
			}
		}

		// still here? then skin is a custom skin

		// add custom skin parameters to the advanced skins array
		if ( !in_array( $skin_name, CoolClock::$advanced_skins ) && !empty( $content ) ) {
			CoolClock::$advanced_skins[] = $skin_name;
			CoolClock::$advanced_skins_config[$skin_name] = wp_strip_all_tags( $content, true );
		}

		return $skin_name;
	}

	public static function no_wptexturize( $shortcodes )
	{
		$shortcodes[] = 'coolclock';
		return $shortcodes;
	}

}
