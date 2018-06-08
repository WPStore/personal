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
 * @since 0.1.0
 */
class Setup {

	/**
	 * @since 7.0.0
	 * @var   array
	 */
	private $warnings;

	/**
	 * @since 7.0.0
	 * @var   array
	 */
	private $notices;
	private $plugin_file;
	private $network_wide;

	public function __construct( $plugin_file, $network_wide ) {
		$this->plugin_file  = $plugin_file;
		$this->network_wide = $network_wide;
	}


	/**
	 * @todo desc
	 *
	 * @since 0.0.1
	 */
	public function activate() {

		do_action( "personal/setup/pre-activation" );

//		$this->register_options();

		$msg_warning = '';
		$msg_notice  = '';

		if ( $this->warnings ) {
			$msg_warning = '<h1>' . __( 'Plugin Activation Error', 'personal' ) . '</h1>';
			$msg_warning .= '<h3>' . __( "Personal", 'personal' ) . '</h3><ul>';
			foreach ( $this->warnings as $warning ) {
				$msg_warning .= "<li>$warning</li>";
			}
			$msg_warning .= "</ul>";
		}

		if ( $this->notices ) {
			foreach ( $this->notices as $notice ) {
				$msg_notice .= $notice;
			}
		}

		if ( '' !== $msg_warning ) {
			// show warnings
			// abort activation
			wp_die( $msg_warning, __( 'Plugin Activation Error', 'personal' ) );
		}

		if ( '' !== $msg_notice ) {
			// save notice(s) to db (transient?)
			// display notice(s)
		}

		do_action( "personal/setup/post-activation" );

	} // END run()

	public function pre_activation() {

	}

	public function register_options() {

		if ( get_option( 'personal_options' ) == false ) {
			add_option( 'personal_options', Personal::default_options() );
		}

	} // END custom_checks()

	/**
	 * @todo
	 *
	 * @param string $required_version
	 */
	public function wp_require( $required_version = '3.8' ) {
		if ( version_compare( get_bloginfo( 'version' ), $required_version, '<' ) ) {
			$this->warnings['wp_requirement'] = sprintf( __( "WordPress %s or higher required. The plugin was not activated. On a side note: Why are you running an old version? :( Upgrade!", 'personal' ), "<code><b>{$required_version}</b></code>" );
		}
	} // END wp_require()

	/**
	 * @todo
	 *
	 * @param string $required_version
	 */
	public function php_require( $required_version = '5.3.29' ) {
		if ( version_compare( PHP_VERSION, $required_version, '<' ) ) {
			$this->warnings['php_requirement'] = sprintf( __( 'PHP %1$s or higher required. You are running %2$s. Update to a newer version.', 'personal' ), "<code><b>{$required_version}</b></code>", '<code><b>' . PHP_VERSION . '</b></code>' );
		}
	} // END php_require()

} // END class Setup
