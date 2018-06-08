<?php
/**
 * @author    WPStore.io <code@wpstore.io>
 * @copyright Copyright (c) 2018, WPStore.io
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0
 * @package   WPStore\Plugins\Personal
 * @version   0.0.1
 */
/**
Plugin Name: Personal
Plugin URI:  https://www.wpstore.io/plugin/personal
Description: Desc
Version:     0.0.1
Author:      WPStore.io
Author URI:  https://www.wpstore.io
Donate link: https://www.wpstore.io/donate
License:     GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: personal
Domain Path: /languages

	Personal
	Copyright (C) 2018 WPStore.io (https://www.wpstore.io)

	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace WPStore;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct access! This plugin requires WordPress to be loaded.' );
}

/**
 * Class Personal
 * @package WPStore
 */
final class Personal {

	/**
	 * Current version
	 *
	 * @var  string
	 * @since  0.1.0
	 */
	const VERSION = '0.0.1';

	/**
	 * Path of plugin directory
	 *
	 * @var string
	 * @since  1.0.0
	 */
	var $path = '';

	/**
	 * Plugin basename
	 *
	 * @var string
	 * @since  1.0.0
	 */
	protected $basename = '';

	/**
	 *
	 * @var object|null
	 * @since  1.0.0
	 */
	protected static $single_instance = null;

	/**
	 * @since  1.0.0
	 *
	 * @return null|object|Personal
	 */
	public static function get_instance() {
		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * Personal constructor.
	 */
	protected function __construct() {

		$this->basename = $this->get_basename();
		$this->path     = $this->get_path();

		$this->autoloader();

	} // END __construct()

	/**
	 * @todo DESC
	 *
	 * @since 0.0.1
	 * @return void
	 */
	private function autoloader() {

		$base = $this->path . '/';

		if ( !class_exists('\\WPUtils\\Autoloader') ) {
			require_once( $base . 'utils/wp-autoloader.php' );
		}

		// instantiate the loader
		$loader = new \WPUtils\Autoloader;

		// register the autoloader
		$loader->register();

		// register the base directories for the namespace prefix
		$loader->addNamespace('WPStore\Personal', $base . '/Personal');

	} // END autoloader()

	/**
	 * Init hooks
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function init() {

		add_action( 'plugins_loaded', array( __CLASS__, 'load_textdomain' ) );

		if ( ! is_admin() ) {
			// Frontend
			new Personal\Frontend();
		} // END if

		if ( is_admin() && ! is_network_admin() ) {
			new Personal\Admin();
		}

	} // END init()

	/** Helper functions ******************************************************/

	/**
	 * Get the plugin path.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $folder (optional) appended path.
	 *
	 * @return string       Directory and path
	 */
	public function get_path( $folder = '' ) {

		$path = (string) apply_filters( "personal/path", untrailingslashit( plugin_dir_path( __FILE__ ) ) );

		return $path . $folder;

	} // End get_path()

	/**
	 * Get the plugin url.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $path (optional) appended path.
	 *
	 * @return string URL and path
	 */
	public function get_url( $path = '' ) {

		$url = esc_url( apply_filters( "personal/url", plugins_url( '', __FILE__ ) ) );

		return $url . $path;

	} // End get_url()

	/**
	 * Get plugin basename
	 *
	 * @since  1.0.0
	 *
	 * @return string
	 */
	public function get_basename() {
		return plugin_basename( __FILE__ );
	} // get_basename()

	/**
	 * Load language files
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public static function load_textdomain() {

		load_plugin_textdomain(
			'personal',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages/'
		);

	} // END load_textdomain()

	/**
	 * @todo DESC
	 *
	 * @todo Check for PHP >= 5.3
	 * @todo Check for PHP json: extension_loaded('json')
	 * @todo Check WP version >= 3.8
	 * @todo redirect to welcome/auth/plugin page
	 *
	 * @since 0.0.1
	 * @return void
	 */
	public static function activation( $network_wide ) {

		require_once dirname( __FILE__ ) . '/Personal/Setup.php';

		$activation = new \WPStore\Personal\Setup( __FILE__, $network_wide );

		$activation->wp_require( '4.8' );
		$activation->php_require( '5.4' );

		$activation->activate();

	} // END activation()

	/**
	 * @todo
	 *
	 * @param bool $network_wide
	 */
	public static function deactivation( $network_wide ) {

//		if ( true == $network_wide ) {
//			return;
//		} else {
//			flush_rewrite_rules();
//		}

	} // END deactivation()

	public static function default_options() {

		$defaults = array(
			'frontend-block' => '0',
			'clear-admin' => '0',
		);

		return apply_filters( 'personal_default_options', $defaults );

	} // END default_options()

} // END class

/**
 * Grab the wpstore_personal object and return it.
 * Wrapper for wpstore_personal::get_instance()
 *
 * @since  0.1.0
 * @return wpstore_personal  Singleton instance of plugin class.
 */
function wpstore_personal() {
	return \WPStore\Personal::get_instance();
} // END wpstore_personal()

// Kick it off.
add_action( 'plugins_loaded', array( wpstore_personal(), 'init' ) );

/** (De-)Activation */
register_activation_hook( __FILE__, array( wpstore_personal(), 'activation' ) );
register_deactivation_hook( __FILE__, array( wpstore_personal(), 'deactivation' ) );
