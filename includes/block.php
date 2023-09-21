<?php
/**
 * CoolClock Block
 *
 * @package CoolClock
 * @since 4.4
 */

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 */
function coolclock_block_init() {
	if ( ! function_exists( 'register_block_type' ) ) {
		// Block editor is not available.
		return;
	}

	// automatically load dependencies and version
	/*$asset_file = include( COOLCLOCK_DIR . 'analog-clock/index.asset.php');

	wp_register_script(
		'coolclock-analog-clock',
		plugins_url( '/', COOLCLOCK_DIR . 'coolclock.php' ) . 'analog-clock/index.js',
		$asset_file['dependencies'],
		$asset_file['version']
	);*/

	register_block_type(
		COOLCLOCK_DIR . 'analog-clock',
		array(
			'api_version' => 2,
			//'editor_script' => 'coolclock-analog-clock',
			'render_callback' => 'coolclock_block_render_callback'
		)
	);
}

/**
 * This function is called when the block is being rendered on the front end of the site
 *
 * @param array    $attributes     The array of attributes for this block.
 * @param string   $content        Rendered block output. ie. <InnerBlocks.Content />.
 * @param WP_Block $block_instance The instance of the WP_Block class that represents the block being rendered.
 */
function coolclock_block_render_callback( $attributes, $content, $block_instance ) {

	if ( is_feed() ) {
		return;
	}

	$defaults = array_merge( CoolClock::$defaults, CoolClock::$advanced_defaults );

	// Set footer script flags.
	CoolClock::$add_script = true;

	// Prepare skin.
	$atts['skin'] = CoolClock::parse_skin(
		! empty( $attributes['skin'] ) ? $attributes['skin'] : $defaults['skin'],
		! empty( $attributes['custom_skin'] ) ? $attributes['custom_skin'] : ''
	);

	// Radius, used in wrapper style and coolclock fields.
	$atts['radius'] = ! empty( $attributes['radius'] ) && is_numeric( $attributes['radius'] ) ? (int) $attributes['radius'] : $defaults['radius'];
	if ( 10 > $atts['radius'] ) $atts['radius'] = 10; // absolute minimum size 20x20

	// Prepare classes.
	$align = ! empty( $attributes['align'] ) ? 'align' . $attributes['align'] : '';

	$styles = array(
		'width' => 2 * $atts['radius'] . 'px',
		'height' => 'auto',
	);
	$styles = apply_filters( 'coolclock_container_styles', $styles, $atts, $defaults );

	// Build output
	// begin wrapper
	$output = '<figure class="coolclock-container"' . CoolClock::inline_style( $styles ) . '>';
	// add canvas
	$output .= CoolClock::canvas( $atts );
	// end wrapper
	$output .= '</figure>';

	/*if ( is_admin() ) {
		$plugin_url = plugins_url( '/', COOLCLOCK_DIR . 'coolclock.php' );
		// Print Style.
		$output .= '<style src="' . $plugin_url . 'css/coolclock.css"></style>';
		// Print scripts.
		$output .= '<script src="' . $plugin_url . 'js/coolclock.js"></script>';
		$output .= '<script src="' . $plugin_url . 'js/moreskins.js"></script>';
		$output .= '<script>CoolClock.findAndCreateClocks();</script>';
	//} */
	// DEBUG
	$output .= '<!-- ' . print_r( $attributes, true) . ' -->';

	// Return filtered output.
	return apply_filters( 'coolclock_block', $output, $attributes, $block_instance );
}
