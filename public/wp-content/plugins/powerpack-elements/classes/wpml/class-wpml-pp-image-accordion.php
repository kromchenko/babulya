<?php

class WPML_PP_Image_Accordion extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'accordion_items';
	}

	public function get_fields() {
		return array( 
			'title',
			'description',
			'button_text',
			'link',
		);
	}

	protected function get_title( $field ) {
		switch( $field ) {
			case 'title':
				return esc_html__( 'Image Accordion - Item Title', 'power-pack' );
			case 'description':
				return esc_html__( 'Image Accordion - Item Description', 'power-pack' );
			case 'button_text':
				return esc_html__( 'Image Accordion - Button Text', 'power-pack' );
			case 'link':
				return esc_html__( 'Image Accordion - Item Link', 'power-pack' );
			default:
				return '';
		}
	}

	protected function get_editor_type( $field ) {
		switch( $field ) {
			case 'title':
				return 'LINE';
			case 'description':
				return 'LINE';
			case 'button_text':
				return 'LINE';
			case 'link':
				return 'LINE';
			default:
				return '';
		}
	}

}
