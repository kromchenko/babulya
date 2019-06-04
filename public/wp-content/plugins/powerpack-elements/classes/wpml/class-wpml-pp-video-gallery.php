<?php

class WPML_PP_Video_Gallery extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'gallery_videos';
	}

	public function get_fields() {
		return array( 
			'youtube_url',
			'vimeo_url',
			'dailymotion_url',
			'filter_label',
			'filter_all_label',
		);
	}

	protected function get_title( $field ) {
		switch( $field ) {
			case 'youtube_url':
				return esc_html__( 'Video Gallery - YouTube URL', 'power-pack' );
			case 'vimeo_url':
				return esc_html__( 'Video Gallery - Vimeo URL', 'power-pack' );
			case 'dailymotion_url':
				return esc_html__( 'Video Gallery - Dailymotion URL', 'power-pack' );
			case 'filter_label':
				return esc_html__( 'Video Gallery - Filter Label', 'power-pack' );
			case 'filter_all_label':
				return esc_html__( 'Video Gallery - "All" Filter Label', 'power-pack' );
			default:
				return '';
		}
	}

	protected function get_editor_type( $field ) {
		switch( $field ) {
			case 'youtube_url':
				return 'LINE';
			case 'vimeo_url':
				return 'LINE';
			case 'dailymotion_url':
				return 'LINE';
			case 'filter_label':
				return 'LINE';
			case 'filter_all_label':
				return 'LINE';
			default:
				return '';
		}
	}

}
