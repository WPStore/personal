<?php
/**
 * @author    WPStore.io <code@wpstore.io>
 * @copyright Copyright (c) 2018, WPStore.io
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0+
 * @package   WPStore\Plugins\Personal
 */

namespace WPStore\Personal;

/**
 *
 * @since 1.0.0
 */
class Info {

	public function __construct() {
		add_filter( 'personal_settings_tabs', array( __CLASS__, 'add_tab' ) );
		add_action( 'personal_menu', array( __CLASS__, 'add_settings' ) );

	}

	public static function add_tab( $tabs ) {

		$tabs['info'] = array(
			'label' => __( 'Info', 'personal' ),
			'cap'   => 'manage_options',
			'style' => 'float:right;',
		);

		return $tabs;

	} // END add_tab()

	public static function add_settings() {

		// TAB: 'Info'
		// SECTION: 'default'
		add_settings_section(
			'default',
			'',
			'__return_empty_string',
			'personal-info'
		);

		add_settings_field(
			'developers',
			__( 'Developers', 'personal' ),
			array( __CLASS__, 'show_description' ),
			'personal-info',
			'default',
			array(
				'id'          => 'frontend-block',
				'title'       => esc_html__( 'Block Frontend', 'personal' ),
				'label'       => __( 'Activate/Deactivate frontend output completely', 'personal' ),
				'description' => esc_html__( 'If unchecked the frontend for visitors will be completely blocked.', 'personal' ),
			)
		);

		// TAB: 'Info'
		// SECTION: 'extensions'
		add_settings_section(
			'extensions',
			__( 'Extensions', 'personal' ),
			'__return_empty_string',
			'personal-info'
		);

		add_settings_field(
			'extensions-available',
			__( 'Available Extensions', 'personal' ),
			array( __CLASS__, 'show_description' ),
			'personal-info',
			'extensions',
			array(
				'id'          => 'frontend-block',
				'title'       => esc_html__( 'Block Frontend', 'personal' ),
				'label'       => __( 'Activate/Deactivate frontend output completely', 'personal' ),
				'description' => esc_html__( 'If unchecked the frontend for visitors will be completely blocked.', 'personal' ),
			)
		);

	} // END add_settings()

	public static function show_description() {
		?>
		SOME DESCR
		<?php

	}


} // END class Info
