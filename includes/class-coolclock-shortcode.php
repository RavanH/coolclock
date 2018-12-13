<?php

/**
 * CoolClock Shortcode Class
 */

class CoolClock_Shortcode {

	public static function handle_shortcode( $atts, $content = null ) {
		if ( is_feed() )
			return '';

		$atts = shortcode_atts( array_merge( CoolClock::$defaults, CoolClock::$advanced_defaults ), $atts, 'coolclock' );

		// TODO user input (attributes) validation here !!
		/*
		skin -- must be one of these: 'swissRail' (default skin), 'chunkySwiss', 'chunkySwissOnBlack', 'fancy', 'machine', 'simonbaird_com', 'classic', 'modern', 'simple', 'securephp', 'Tes2', 'Lev', 'Sand', 'Sun', 'Tor', 'Cold', 'Babosa', 'Tumb', 'Stone', 'Disc', 'watermelon' or 'mister'. If the Advanced extension is activated, there is also 'minimal' available. Please note that these names are case sensitive.
		radius -- a number to define the clock radius. Do not add 'px' or any other measure descriptor.
		noseconds -- set to true (or 1) to hide the second hand
		gmtoffset -- a number to define a timezone relative the Greenwhich Mean Time. Do not set this parameter to default to local time.
		showdigital -- set to 'digital12' to show the time in 12h digital format (with am/pm) too
		fontcolor -- set to a color value to change the digital time color
		scale -- must be one of these: 'linear' (default scale), 'logClock' or 'logClockRev'. Linear is our normal clock scale, the other two show a logarithmic time scale
		subtext -- optional text, centered below the clock
		align -- sets floating of the clock: 'left', 'right' or 'center'
		*/

		// set footer script flags
		CoolClock::$add_script = true;

		if ( !isset( $atts['skin'] ) )
			$atts['skin'] = CoolClock::$defaults['skin'];

		if ( in_array( $atts['skin'], CoolClock::$more_skins ) )
			CoolClock::$add_moreskins = true;

		// get output
		$output = CoolClock::canvas( $atts );

		return apply_filters( 'coolclock_shortcode_advanced', $output, $atts, $content );
	}

	public static function no_wptexturize($shortcodes) {
		$shortcodes[] = 'coolclock';
		return $shortcodes;
	}

}
