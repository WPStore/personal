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

		if ( self::$options['clear-admin'] === 1 ) {
			add_action( 'admin_menu', array( __CLASS__, 'hide_menus' ), 999 );
		}

	} // END __construct()

	/**
	 *
	 * @since 1.0.0
	 */
	public static function admin_menu() {

		add_menu_page(
			__( 'Dashboard', 'personal' ),
			__( 'Personal', 'personal' ),
			'manage_options', // @todo eval
			'personal',
			array( '\WPStore\Personal\Dashboard', 'return_page' ),
			'dashicons-layout',
			1.1
		);

		add_submenu_page(
			'personal',
			__( 'Dashboard', 'personal' ),
			__( 'Dashboard', 'personal' ),
			'manage_options', // @todo eval
			'personal',
			array( '\WPStore\Personal\Dashboard', 'return_page' )
		);

		do_action( 'personal_menu' );

	} // END admin_menu()

	public static function content_header( $args ) {
	    ?>
        <div class="wrap">
		<?php

	}

	public static function content_footer( $args ) {
	    ?>
        </div><!-- wrap -->
		<?php

	}

	public static function hide_menus() {
		remove_menu_page( 'index.php' );                  // Dashboard
		remove_menu_page( 'edit.php' );                   // Posts
		remove_menu_page( 'edit.php?post_type=page' );    // Pages
		remove_menu_page( 'upload.php' );                 // Media
		remove_menu_page( 'edit-comments.php' );          // Comments
		remove_menu_page( 'themes.php' );                 // Appearance
		remove_menu_page( 'plugins.php' );                // Plugins
		remove_menu_page( 'users.php' );                  // Users
		remove_menu_page( 'tools.php' );                  // Tools
		remove_menu_page( 'options-general.php' );        // Settings

	}

} // END class Admin
