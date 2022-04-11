<?php return;
/**
 * This file exists solely to store the plugin translation strings.
 * It is never included anywhere, used only for PO parsing.
 */

// Widget.

__( 'Digital font style:', 'coolclock' );
sprintf( /* Translators: instructions (linked) */
	__( '(enter a size in px and generic font family, see %s)', 'coolclock' ),
	'<a href="https://premium.status301.com/coolclock-widget-settings/#font" target="_blank">' . __( 'instructions', 'coolclock' ) . '</a>'
);
__( 'Digital custom text:', 'coolclock' );
__( '(set Show digital to custom text above)', 'coolclock' );
__( '(minimal width and height are determined by the clock radius above)', 'coolclock' );
__( 'Color:', 'coolclock' );
__( 'Border radius:', 'coolclock' );
__( '(px or %)', 'coolclock' );
__( 'Image URL:', 'coolclock' );
__( 'Position:', 'coolclock' );
__( 'top left', 'coolclock' );
__( 'left', 'coolclock' );
__( 'bottom left', 'coolclock' );
__( 'top', 'coolclock' );
__( 'center', 'coolclock' );
__( 'bottom', 'coolclock' );
__( 'top right', 'coolclock' );
__( 'right', 'coolclock' );
__( 'bottom right', 'coolclock' );
__( 'Repeat image:', 'coolclock' );
__( 'No repeat', 'coolclock' );
__( 'Repeat', 'coolclock' );
__( 'Repeat horizontally', 'coolclock' );
__( 'Repeat vertically', 'coolclock' );
__( 'Repeat & distribute', 'coolclock' );
__( 'Repeat & fit', 'coolclock' );
__( 'Stretching:', 'coolclock' );
__( 'Cover', 'coolclock' );
__( 'Contain', 'coolclock' );
__( 'Adjust clock position', 'coolclock' );
__( 'Clock position relative to background:', 'coolclock' );
__( 'Left', 'coolclock' );
__( 'Top', 'coolclock' );

__( 'CoolClock Advanced License', 'coolclock' );
__( 'License', 'coolclock' );
__( 'Support', 'coolclock' ) ;

// Upgrade notices.

sprintf( /* Translators: Premium Plugin name, Plugin name */
	__( 'In order to use %1$s, please activate %2$s.', 'coolclock' ),
	__( 'CoolClock - Advanced', 'coolclock' ),
	'<strong>'.__( 'CoolClock', 'coolclock' ).'</strong>'
);
sprintf( /* Translators: Premium Plugin name, Plugin name (linked) */
	__( 'To use %1$s options, please install and activate %2$s.', 'coolclock' ),
	__( 'CoolClock - Advanced', 'coolclock' ),
	'<a href="' . esc_url( network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=coolclock&TB_iframe=true&width=600&height=550' ) ) . '" target="_blank" class="thickbox">'.__( 'CoolClock', 'coolclock' ).'</a>'
);
__( 'Notice: The current CoolClock plugin version is not fully compatible with your version of the Advanced extension. Some advanced options may not be functional.', 'coolclock' );
sprintf( /* Translators: Plugin name (linked), version number */
	__( 'Please upgrade %1$s to verion %2$s or later.', 'coolclock' ),
	'<a href="' . esc_url( network_admin_url('plugin-install.php?tab=plugin-information&plugin=coolclock&TB_iframe=true&width=600&height=550' ) ) . '" target="_blank" class="thickbox">'.__( 'CoolClock', 'coolclock' ).'</a>',
	self::$compat['min']
);

// Success messages.

__( 'Your license was successfully activated for this site.', 'coolclock' );
__( 'Your license was successfully deactivated for this site.', 'coolclock' );
__( 'Your license is active for this site.', 'coolclock' );
__( 'Your license is not active for this site.', 'coolclock' );

// Error messages.

__( 'Too many requests. Please try again in a minute.', 'coolclock ' );
__( 'Cannot make requests to own domain.', 'coolclock ' );
__( 'Failed identify the product.', 'coolclock ' );
sprintf( /* Translators: http repsonse code */
	__( 'Unexpected response code %d.', 'coolclock' ),
	'<code>' . $response . '</code>'
);
sprintf( /* Translators: Expiration date */
	__( 'Your license key has expired on %s.', 'coolclock' ),
	date_i18n(
		get_option( 'date_format' ),
		strtotime( $expires, current_time( 'timestamp' ) )
	)
);
__( 'Your license key has expired.', 'coolclock' );
__( 'Your license key has been disabled.', 'coolclock' );
__( 'This appears to be an invalid license key.', 'coolclock' );
sprintf( /* Translators: Premium Plugin name */
	__( 'This appears to be an invalid license key for %s.', 'coolclock' ),
	__( 'CoolClock - Advanced', 'coolclock' )
);
__( 'Your license key has reached its activation limit.', 'coolclock' );
__( 'An error occurred, please try again.', 'coolclock' );
__( 'An unkown error occurred. Please try again.', 'coolclock' );
sprintf( /* Translators: license error code, Support (linked) */
	 __( 'Unexpected license error code %1$s. Please try again or get %2$s.', 'coolclock' ),
	 '<code>' . $error . '</code>',
	 '<a target="_blank" href="https://premium.status301.com/support-ticket/">' . __( 'Support', 'coolclock' ) . '</a>'
);
sprintf( /* Translators: Plugin name */
	__( 'You have not yet entered your license key for %s.', 'coolclock' ),
	__( 'CoolClock - Advanced', 'coolclock' )
);
sprintf( /* Translators: plugin admin page URL */
	__( 'To receive plugin updates, please <a href="%s">correct this issue</a>.', 'coolclock' ),
	admin_url('options.php') . '?page=coolclock-license'
);
sprintf( /* Translators: Plugin name */
	__( 'You have an invalid or expired license key for %s.', 'coolclock' ),
	__( 'CoolClock - Advanced', 'coolclock' )
);
sprintf( /* Translators: Premium Plugin name */
	__( 'Your license key for %s is not activated for this site.', 'coolclock' ),
	__( 'CoolClock - Advanced', 'coolclock' )
);

// Admin page.
__( 'License key', 'coolclock' );
sprintf( /* Translators: Plugin name, renew your license (linked) */
	__( 'Enter your license key for %s.', 'coolclock' ),
	'<a href="' . trailingslashit( self::$store_url ) . 'downloads/coolclock-advanced/" target="_blank">' . __( 'CoolClock - Advanced', 'coolclock' ) . '</a>'
);
__( 'An active license key grants you access to plugin updates and support. If a license key is absent, deactivated or expired, the plugin may continue to work properly but you will not receive automatic updates.', 'coolclock' );
sprintf( /* Translators: Premium Plugin name, Status301 Premium account (linked) */
	__( 'You can find your %1$s license key in your %2$s.', 'coolclock' ),
	__( 'CoolClock - Advanced', 'coolclock' ),
	'<a href="https://premium.status301.com/account/" target="_blank">' . __( 'Status301 Premium account', 'coolclock' ) . '</a>'
);
sprintf( /* Translators: Expiration date */
	__( 'Your license expires on %s.', 'coolclock' ),
	$expires
);
sprintf( /* Translators: Plugin name */
	__( 'To receive updates for %s, please activate your license for this site.', 'coolclock' ),
	__( 'CoolClock - Advanced', 'coolclock' )
);
sprintf( /* Translators: Plugin name, renew your license (linked) */
	__( 'To continue receiving updates for %1$s, please %2$s.', 'coolclock' ),
	__( 'CoolClock - Advanced', 'coolclock' ),
	'<a href="' . trailingslashit( self::$store_url ) . 'checkout/?edd_license_key=' . $key . '&download_id=' . self::$item_id . '" target="_blank">' . __( 'renew your license', 'coolclock' ) . '</a>'
);
sprintf( /* Translators: Account (linked), Plugin name */
	__( 'Please check your %1$s for possibilities to upgrade your %2$s license.', 'coolclock' ),
	'<a href="' . $account_url . '" target="_blank">' . __( 'Status301 Premium account', 'coolclock' ) . '</a>',
	__( 'CoolClock - Advanced', 'coolclock' )
);
__( 'Beta version', 'coolclock' );
sprintf( /* Translators: Premium Plugin name */
	__( 'Get updates for pre-release versions of %s.', 'coolclock' ),
	__( 'CoolClock - Advanced', 'coolclock' )
);
__( 'This option will allow you to update the plugin to the latest beta release.', 'coolclock' );
sprintf( /* Translators: Account (linked) */
	__( 'Please note: Auto-updates are blocked for non-stable versions. Once updated a pre-release version, disabling this option will <em>not</em> automatically revert the plugin to the latest stable release. If you wish to downgrade, you can download the latest stable release from your %s and install it manually.', 'coolclock' ),
	'<a href="' . trailingslashit( self::$store_url ) . 'account/#tab-downloads" target="_blank">' . __( 'Status301 Premium account', 'coolclock' ) . '</a>'
);
__( 'License action', 'coolclock' );
__( 'Check license key', 'coolclock' );
__( 'Activate license for this site', 'coolclock' );
__( 'Deactivate license for this site', 'coolclock' );
sprintf( /* Translators: Plugin name, Account (linked) */
	__( 'You can (de)activate your %1$s license from here or manage domains from your %2$s.', 'coolclock' ),
	__( 'CoolClock - Advanced', 'coolclock' ),
	'<a href="' . $account_url . '" target="_blank">' . __( 'Status301 Premium account', 'coolclock' ) . '</a>'
);
