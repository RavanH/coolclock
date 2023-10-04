<?php

/**
 * CoolClock Shortcode Class.
 */

class CoolClock_Shortcode {

	public static function handle_shortcode( $atts, $content = '' )
	{
		/**
		* skin			Must be one of these: 'swissRail' (default skin), 'chunkySwiss', 'chunkySwissOnBlack', 'fancy', 'machine', 'simonbaird_com', 'classic', 'modern', 'simple', 'securephp', 'Tes2', 'Lev', 'Sand', 'Sun', 'Tor', 'Cold', 'Babosa', 'Tumb', 'Stone', 'Disc', 'watermelon' or 'mister'.
		* 				If the Advanced extension is activated, there is also 'minimal' available.
		* radius		A number to define the clock radius. Do not add 'px' or any other measure descriptor.
		* noseconds		Set to 'true' or 1 or without value to hide the second hand.
		* gmtoffset		A number to define a timezone relative the Greenwhich Mean Time. Do not set this parameter to default to local time.
		* showdigital	Set to 'true' or 1 or 'digital12' or without value to show the time in 12h digital format (with am/pm) too
		* fontcolor		Set to a color value to change the digital time color, digitalcolor for backward compatibility
		* scale			Must be one of these: 'linear' (default scale), 'logClock' or 'logClockRev'. Linear is our normal clock scale, the other two show a logarithmic time scale
		* subtext		Optional text, centered below the clock
		* align			Sets floating of the clock: 'left', 'right' or 'center'
		*/

		if ( is_feed() ) {
			return '';
		}

		// Force empty parameter noseconds to true.
		if ( ! empty( $atts ) && in_array( 'noseconds', $atts, true ) && ! array_key_exists( 'noseconds', $atts ) ) {
			$atts['noseconds'] = true;
		}
		// Force empty parameter showdigital to default.
		if ( ! empty( $atts ) && in_array( 'showdigital', $atts, true ) && ! array_key_exists( 'showdigital', $atts ) ) {
			$atts['showdigital'] = 'digital12';
		}

		// Filter shortcode attributes.
		$defaults = array_merge( CoolClock::$defaults, CoolClock::$advanced_defaults );
		$atts = shortcode_atts( $defaults, $atts, 'coolclock' );

		// Sanitize user input.
		$content = wp_strip_all_tags( $content );

		// Backward compat fontcolor.
		if ( ! empty( $atts['digitalcolor'] ) && empty($atts['fontcolor']) ) {
			$atts['fontcolor'] = $atts['digitalcolor'];
		}

		// Pre-treat possible empty attributes.
		if ( is_int( array_search( 'noseconds', $atts ) ) ) {
			$atts['noseconds'] = true;
		}
		if ( is_int( array_search( 'showdigital', $atts ) ) ) {
			$atts['showdigital'] = 'digital12';
		}

		// Parse skin.
		$atts['skin'] = CoolClock::parse_skin( $atts['skin'], $content );

		// Radius, used in wrapper style and coolclock fields.
		$atts['radius'] = !empty( $atts['radius'] ) && is_numeric($atts['radius']) ? (int) $atts['radius'] : $defaults['radius'];
		if ( 10 > $atts['radius'] ) $atts['radius'] = 10; // absolute minimum size 20x20

		// Clean gmtoffset.
		if ( !empty( $atts['gmtoffset'] ) ) {
			$atts['gmtoffset'] = str_replace( ',', '.', $atts['gmtoffset'] );
			$atts['gmtoffset'] = str_replace( array('1/2','½'), '.5', $atts['gmtoffset'] );
			$atts['gmtoffset'] = str_replace( array('h',' '), '', $atts['gmtoffset'] );
			$atts['gmtoffset'] = is_numeric( $atts['gmtoffset'] ) ? (float) trim( $atts['gmtoffset'] ) : '';
		}

		if ( !empty( $atts['scale'] ) )
			$atts['scale'] = wp_strip_all_tags( $atts['scale'] );

		// Post-treat showdigital.
		if ( in_array( $atts['showdigital'], array('true','1') ) )
			$atts['showdigital'] = true;
		elseif ( !in_array( $atts['showdigital'], array('false','0') ) )
			$atts['showdigital'] = wp_strip_all_tags( $atts['showdigital'] );
		else
			$atts['showdigital'] = '';

		// Post-treat noseconds.
		if ( 'false' === $atts['noseconds'] )
			$atts['noseconds'] = false;

		if ( !empty( $atts['fontcolor'] ) )
			$atts['fontcolor'] = CoolClock::colorval( $atts['fontcolor'] );

		if ( !empty( $atts['font'] ) )
			$atts['font'] = wp_strip_all_tags( $atts['font'] );

		if ( !empty( $atts['subtext'] ) )
			$atts['subtext'] = wp_kses( $atts['subtext'], CoolClock::$allowed_tags );

		$align = !empty( $atts['align'] ) ? wp_strip_all_tags( $atts['align'] ) : $defaults['align'];
		$class = in_array( $align, array('left','right','center') ) ? ' align' . $align : '';

		// Inline container style.
		$styles = array(
			'width' => 2 * $atts['radius'] . 'px',
			'height' => 'auto' // Leave height:auto at the end for old pro filter to find and replace.
		);
		$styles = apply_filters( 'coolclock_container_styles', $styles, $atts, $defaults );

		// Set footer script flags.
		CoolClock::$add_script = true;

		/**
		 * Build output.
		 */

		// Begin wrapper.
		$output = '<figure class="coolclock-container ' . $class . '"' . CoolClock::inline_style( $styles ) . '>'; // Should end with height:auto"> for old pro plugin to find and replace.

		// Add canvas.
		$output .= CoolClock::canvas( $atts );

		// Add subtext.
		$subtext = ( isset( $atts['subtext'] ) ) ? $atts['subtext'] : $defaults['subtext'];
		if ( ! empty( $subtext ) ) {
			$output .= '<figcaption class="coolclock-subtext">' . $subtext . '</figcaption>';
		}

		// End wrapper.
		$output .= '</figure>';

		/**
		 * Return filtered output.
		 */
		return apply_filters( 'coolclock_shortcode', $output, $atts, $content );
	}

	public static function no_wptexturize( $shortcodes )
	{
		$shortcodes[] = 'coolclock';
		return $shortcodes;
	}

}
