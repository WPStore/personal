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
class Settings {

	/**
	 * Settings constructor.
	 */
	public function __construct() {

		new Info();

		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
		add_action( 'personal_menu', array( __CLASS__, 'add_menu' ) );
	}

	/**
	 *
	 * @since 1.0.0
	 */
	public static function add_menu() {

		add_submenu_page(
			'personal',
			__( 'Personal', 'personal' ),
			__( 'Settings', 'personal' ),
			'manage_options', // @todo eval
			'personal-settings',
			array( __CLASS__, 'page_settings' )
		);

	} // END add_menu()

	/**
	 *
	 * @since 1.0.0
	 */
	public static function page_settings() {
		$parent_slug = 'admin.php?page=personal-settings';
		$tabs        = self::get_settings_tabs();
		$current_tab = self::get_current_tab();


		$id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;
		?>
        <div class="wrap">
            <h1><?php _e( 'Personal Settings', 'personal' ); ?></h1>
            <!--            <p class="personal-settings-actions"><a href="#">Visit</a> | <a href="#">Dashboard</a></p>-->
			<?php self::settings_tabs( $parent_slug, $tabs ); ?>

            <form method="post" action="<?php echo $parent_slug; ?>?action=update">
				<?php settings_fields( 'personal-settings' ); ?>
                <table class="form-table">
					<?php
					do_settings_sections( 'personal-' . $current_tab );
					do_settings_fields( 'personal-' . $current_tab, '' );
					?>
                </table>
				<?php submit_button(); ?>
            </form>
        </div><!-- wrap -->
		<?php
	} // END page_settings()

	/**
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_settings_tabs() {

		/**
		 * Filters the links that appear on site-editing network pages.
		 *
		 * Default links: 'site-info', 'site-users', 'site-themes', and 'site-settings'.
		 *
		 * @since 4.6.0
		 *
		 * @param array $tabs {
		 *     An array of link data representing individual network admin pages.
		 *
		 * @type array $link_slug {
		 *         An array of information about the individual link to a page.
		 *
		 *         $type string $label Label to use for the link.
		 *         $type string $url   URL, relative to `network_admin_url()` to use for the link.
		 *         $type string $cap   Capability required to see the link.
		 *     }
		 * }
		 */
		$tabs = apply_filters(
			'personal_settings_tabs', array(
				'main' => array(
					'label' => __( 'Main', 'personal' ),
					'cap'   => 'manage_options',
				),
//				'welcome' => array(
//					'label' => __( 'Welcome', 'personal' ),
//					'cap'   => 'manage_options',
//					'style' => 'float:right;background-color:orange;',
//				),
			)
		);

		return $tabs;

	} // END get_settings_tabs()

	/**
	 * @param string $default
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_current_tab( $default = 'main' ) {

		if ( ! isset( $_GET['tab'] ) ) {
			$current_tab = $default;
		} else {
			$current_tab = sanitize_key( $_GET['tab'] );
		}

		return $current_tab;

	}

	/**
	 * @param $parent_slug
	 * @param $tabs
	 *
	 * @since 1.0.0
	 */
	public static function settings_tabs( $parent_slug, $tabs ) {

		// Setup the links array
		$screen_links = array();


		$current_tab = self::get_current_tab();

		// Loop through tabs
		foreach ( $tabs as $tab_id => $link ) {

			// Skip link if user can't access
//			if ( ! current_user_can( $link['cap'], $r['blog_id'] ) ) {
//				continue;
//			}

			// Link classes
			$classes = array( 'nav-tab' );

			// Highlight selected tab
			if ( $current_tab === $tab_id ) {
				$classes[] = 'nav-tab-active';
			}

			$float = '';
			// Float right
			if ( isset( $link['style'] ) ) {
				$float = ' style="' . $link['style'] . '"';
			}

			// Escape each class
			$esc_classes = implode( ' ', $classes );

			// Get the URL for this link
			$url = add_query_arg( array( 'page' => 'personal-settings', 'tab' => $tab_id ), admin_url( $parent_slug ) );

			// Add link to nav links
			$screen_links[ $tab_id ] = '<a href="' . esc_url( $url ) . '" id="' . esc_attr( $tab_id ) . '" class="' . $esc_classes . '"' . $float . '>' . esc_html( $link['label'] ) . '</a>';
		}

		// All done!
		echo '<h2 class="nav-tab-wrapper wp-clearfix">';
		echo implode( '', $screen_links );
		echo '</h2>';
	}

	/**
	 * @since 1.0.0
	 */
	public static function register_settings() {

		// TAB: 'Main'
		// SECTION: 'default'
		add_settings_section(
			'default',
			'',
			'__return_empty_string',
			'personal-main'
		);

//		add_settings_field(
////			$id, $title, $callback, $page, $section = 'default', $args = array()
//			'frontend-switch',
//			__( 'Frontend active', 'personal' ),
//			array( __CLASS__, 'on_off' ),
//			'personal-main',
//			'default',
//			array()
//		);

		add_settings_field(
			'frontend-block',
			__( 'Frontend active', 'personal' ),
			array( __CLASS__, 'on_off' ),
			'personal-main',
			'default',
			array(
				'id'          => 'frontend-block',
				'title'       => esc_html__( 'Frontend active', 'personal' ),
				'label'       => __( 'Activate/Deactivate frontend output completely', 'personal' ),
				'description' => esc_html__( 'If unchecked the frontend for visitors will be completely blocked.', 'personal' ),
			)
		);

		add_settings_field(
			'clear-admin',
			__( 'Clear Admin', 'personal' ),
			array( __CLASS__, 'on_off' ),
			'personal-main',
			'default',
			array(
				'id'          => 'clear-admin',
				'title'       => esc_html__( 'Clear Admin', 'personal' ),
				'label'       => __( 'Remove all menu items', 'personal' ),
				'description' => __( 'If checked all standard WordPress menu items will be removed.', 'personal' ) . " <a href='" . admin_url( 'plugins.php' ) . "'>" . __( 'Plugins' ) . "</a>",
			)
		);


		add_settings_section(
			'second',
			__( 'SEcond', 'personal' ),
			array( __CLASS__, 'show_description' ),
			'personal-main'
		);

		do_action( 'personal_add_settings' );

	} // END register_settings()

	public static function show_description() {
		?>
        SOME DESCR
		<?php
	}

	/**
	 * @param $args
	 *
	 * @since 1.0.0
	 */
	public static function on_off( $args ) { ?>
        <fieldset>
            <legend class="screen-reader-text"><span><?php echo $args['title']; ?></span></legend>
            <label for="<?php echo $args['id']; ?>">
                <input name="<?php echo $args['id']; ?>" type="checkbox" id="<?php echo $args['id']; ?>" value="1">
				<?php echo $args['label']; ?>
            </label>
            <p class="description"><?php echo $args['description']; ?></p>
        </fieldset>
		<?php
	}


} // END class Settings
