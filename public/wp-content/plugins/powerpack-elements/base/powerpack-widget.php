<?php
/**
 * PowerPack Elements Common Widget.
 *
 * @package PowerPack Elements
 */

namespace PowerpackElements\Base;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Common Widget
 *
 * @since 0.0.1
 */
abstract class Powerpack_Widget extends Widget_Base {

	/**
	 * Get categories
	 *
	 * @since 0.0.1
	 */
	public function get_categories() {
		return [ 'powerpack-elements' ];
	}

	/**
	 * Add a placeholder for the widget in the elementor editor
	 *
	 * @access public
	 * @since 1.3.11
	 *
	 * @return void
	 */
	public function render_editor_placeholder( $args = array() ) {

		if ( ! \Elementor\Plugin::instance()->editor->is_edit_mode() ) {
			return;
		}

		$defaults = [
			'title' => $this->get_title(),
			'body' 	=> __( 'This is a placeholder for this widget and is visible only in the editor.', 'powerpack' ),
		];

		$args = wp_parse_args( $args, $defaults );

		$this->add_render_attribute([
			'placeholder' => [
				'class' => 'pp-editor-placeholder',
			],
			'placeholder-title' => [
				'class' => 'pp-editor-placeholder-title',
			],
			'placeholder-content' => [
				'class' => 'pp-editor-placeholder-content',
			],
		]);

		?><div <?php echo $this->get_render_attribute_string( 'placeholder' ); ?>>
			<h4 <?php echo $this->get_render_attribute_string( 'placeholder-title' ); ?>>
				<?php echo $args['title']; ?>
			</h4>
			<div <?php echo $this->get_render_attribute_string( 'placeholder-content' ); ?>>
				<?php echo $args['body']; ?>
			</div>
		</div><?php
	}
}
