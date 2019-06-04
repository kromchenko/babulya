<?php

class WPML_PP_Buttons extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'items';
	}

	public function get_fields() {
		return array( 
			'text',
			'icon_text',
			'tooltip_content',
			'link' => array( 'url' ),
		);
	}

	protected function get_title( $field ) {
		switch( $field ) {
			case 'text':
				return esc_html__( 'Buttons - Button Text', 'power-pack' );
			case 'icon_text':
				return esc_html__( 'Buttons - Button Icon Text', 'power-pack' );
			case 'tooltip_content':
				return esc_html__( 'Buttons - Button Tooltip Content', 'power-pack' );
			case 'url':
				return esc_html__( 'Buttons - BUtton Link', 'power-pack' );
			default:
				return '';
		}
	}

	protected function get_editor_type( $field ) {
		switch( $field ) {
			case 'text':
				return 'LINE';
			case 'icon_text':
				return 'LINE';
			case 'tooltip_content':
				return 'AREA';
			case 'url':
				return 'LINE';
			default:
				return '';
		}
	}

}
