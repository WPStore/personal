<?php
/**
 * @author    WPStore.io <code@wpstore.io>
 * @copyright Copyright (c) 2018, WPStore.io
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   WPStore\Plugins\Personal
 */

namespace WPStore\Personal;

/**
 * @todo
 *
 * @since 1.0.0
 */
class Frontend {

	/**
	 * Frontend constructor.
	 */
	public function __construct() {
		add_action( 'init', array( __CLASS__, 'block_frontend' ) );
	}

	/**
	 *
	 * @since 1.0.0
	 */
	public static function block_frontend() {

		$options = get_option( 'personal_options' );

		if ( $options['frontend-block'] == 1 && self::is_not_admin() ) {
			wp_redirect( network_admin_url() );
		}

	}

	/**
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public static function is_not_admin() {

		if ( ! is_admin() && ! in_array( $_SERVER[ 'PHP_SELF' ], array( '/wp-login.php', '/wp-register.php' ) ) ) {
			return true;
		}
		return false;
	}

} // END class Frontend
