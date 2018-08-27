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
 * @since 0.1.0
 */
class Dashboard {

	public function __construct() {
	}

	public static function return_page() {
		?>

		<div class="wrap">
			<h1><?php _e( 'Dashboard', 'personal' ); ?></h1>



			<div id="dashboard-widgets-wrap">
				<?php self::dashboard(); ?>
			</div><!-- dashboard-widgets-wrap -->

		</div><!-- wrap -->

		<?php
	}

	public static function dashboard() {
		$screen      = get_current_screen();
		$columns     = absint( $screen->get_columns() );
		$columns_css = '';
		if ( $columns ) {
			$columns_css = " columns-$columns";
		}

		?>
		<div id="dashboard-widgets" class="metabox-holder<?php echo $columns_css; ?>">
			<div id="postbox-container-1" class="postbox-container">
				<?php do_meta_boxes( $screen->id, 'normal', '' ); ?>
			</div>
			<div id="postbox-container-2" class="postbox-container">
				<?php do_meta_boxes( $screen->id, 'side', '' ); ?>
			</div>
			<div id="postbox-container-3" class="postbox-container">
				<?php do_meta_boxes( $screen->id, 'column3', '' ); ?>
			</div>
			<div id="postbox-container-4" class="postbox-container">
				<?php do_meta_boxes( $screen->id, 'column4', '' ); ?>
			</div>
		</div>
		<?php
	}

	public static function add_metaboxes() {

		add_meta_box(

		);

	}


} // END class Dashboard
