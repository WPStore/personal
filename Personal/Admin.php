<?php
/**
 * @author    WPStore.io <code@wpstore.io>
 * @copyright Copyright (c) 2018, WPStore.io
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   WPStore\Plugins\Personal
 */

namespace WPStore\Personal;

use WPStore\Personal;

/**
 * @todo
 *
 * @since 1.0.0
 */
class Admin {

	/**
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected static $options = array();

	/**
	 * Admin constructor.
	 */
	public function __construct() {

	    new Settings();

		self::$options = get_option( 'personal_options', Personal::default_options() );

		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );

	} // END __construct()

	/**
	 *
	 * @since 1.0.0
	 */
	public static function admin_menu() {

		add_menu_page(
			__( 'Personal', 'personal' ),
			__( 'Personal', 'personal' ),
			'manage_options', // @todo eval
			'personal',
			array( __CLASS__, 'page_main' ),
			'dashicons-layout'//, 3.5
		);

		add_submenu_page(
			'personal',
			__( 'Personal', 'personal' ),
			__( 'Main', 'personal' ),
			'manage_options', // @todo eval
			'personal',
			array( __CLASS__, 'page_main' )
		);

		do_action( 'personal_menu' );

	} // END admin_menu()

	public static function content_header( $args ) { ?>
        <div class="wrap">
		<?php

	}

	public static function content_footer( $args ) { ?>
        </div><!-- wrap -->
		<?php
	}

	/**
	 * @since 1.0.0
	 */
	public static function page_main() {
		?>
        <div class="wrap">
            <h1><?php _e( 'Personal', 'personal' ); ?></h1>
        </div><!-- wrap -->
		<?php
	}




} // END class Admin
