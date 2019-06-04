<?php

namespace DynamicContentForElementor\Documents;

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;

use DynamicContentForElementor\DCE_Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 *
 * Adds parallax on widgets and columns
 *
 */
class DCE_Document_ScrollEffects extends DCE_Document_Prototype {
    
    public $name = "ScrollEffects";

	
	protected $is_common = true;

	
	public function get_script_depends() {
		return [
			'dce-lax'
		];
	}

	
	public static function get_description() {
		return __( 'ScrollEffects for document.' );
	}

	
	protected function add_common_sections_actions() {


		// Activate sections for document
		add_action( 'elementor/documents/register_controls', function( $element ) {

			$this->add_common_sections( $element );

		}, 10, 2 );

		// Activate sections for widgets
		/*add_action( 'elementor/element/common/_section_style/after_section_end', function( $element, $args ) {

			$this->add_common_sections( $element, $args );

		}, 10, 2 );*/

		// Activate sections for columns
		/*add_action( 'elementor/element/column/section_advanced/after_section_end', function( $element, $args ) {

			$this->add_common_sections( $element, $args );

		}, 10, 2 );*/

		// Activate sections for sections
		/*add_action( 'elementor/element/section/section_advanced/after_section_end', function( $element, $args ) {

			$this->add_common_sections( $element, $args );

		}, 10, 2 );*/

	}

	/**
	 * Add Actions
	 *
	 * @since 0.5.5
	 *
	 * @access private
	 */
	private function add_controls( $document, $args ) {

	$element_type = $document->get_type();

	//
    // ------------------------------------------
    $dce_data = DCE_Helper::dce_dynamic_data();
    // ------------------------------------------
    $id_page = $dce_data['global_id'];
    $g_id = $dce_data['global_id'];
    $global_is = $dce_data['is'];
    $type_page = $dce_data['type'];


	// se volessi filtrare i campi in base al tipo
	/*if ( $document->get_name() === 'section' ) {

	}*/

	/* ----------------------------------- */
	/*$document->start_controls_section(
    'my_custom_section',
    [
      'label' => __( 'My Custom Section', 'my-domain' ),
      'tab' => Controls_Manager::TAB_SETTINGS
    ]
  	);*/

		
      $document->add_control(
        'enable_scrollEffects',
        [
			'label' => __( 'Effects', DCE_TEXTDOMAIN ),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'label_on' => __( 'Yes', DCE_TEXTDOMAIN ),
            'label_off' => __( 'No', DCE_TEXTDOMAIN ),
            'return_value' => 'yes',
            'render_type' => 'template',
            'frontend_available' => true,
            'separator' => 'before',
            'condition' => [
	                'enable_dceScrolling' => 'yes',
	                
	            ],
		]
      );
      /*$document->add_control(
		  'reload_scrollEffects_btn',
		  [
		     'type'    => Controls_Manager::RAW_HTML,
		     'raw' => '<div class="elementor-update-preview" style="background-color: transparent;margin: 0;">
			<div class="elementor-update-preview-title">'.__( 'Update changes to page', DCE_TEXTDOMAIN).'</div>
			<div class="elementor-update-preview-button-wrapper">
				<button class="elementor-update-preview-button elementor-button elementor-button-success">'. __( 'Apply', DCE_TEXTDOMAIN).'</button>
			</div>
		</div>',
			 'content_classes' => 'dce-btn-reload',
			 
			 'condition' => [
	                'enable_scrollEffects' => 'yes',
	            ],
		  ]
		);*/
       /*$document->add_control(
			'scrollEffects_id_page',
			[
				'label' => __( 'ID Page', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => $id_page,
				'frontend_available' => true,
				'condition' => [
	                'enable_scrollEffects' => 'yes',
	            ],
			]
		);*/
       /*
      	linger 	n/a
		lazy 	100
		eager 	100
		lazy 	100
		slalom 	50
		crazy 	n/a
		spin 	360
		spinRev 	360
		spinIn 	360
		spinOut 	360
		blurInOut 	40
		blurIn 	40
		blurOut 	40
		fadeInOut 	n/a
		fadeIn 	n/a
		fadeOut 	n/a
		driftLeft 	100
		driftRight 	100
		leftToRight 	1
		rightToLeft 	1
		zoomInOut 	0.2
		zoomIn 	0.2
		zoomOut 	0.2
		swing 	30
		speedy 	30
	  */
      $document->add_control(
            'animation_effects', [
		        'label' => __('Animation Effects', DCE_TEXTDOMAIN),
		        'type' => Controls_Manager::SELECT2,
		        'multiple' => true,
		        'label_block' => true,
		        'options' => [
		            '' => __('None', DCE_TEXTDOMAIN),
		            'scaleDown' => __('Scale Down', DCE_TEXTDOMAIN),
		           
		           'scaleDown' => __('ScaleDown', DCE_TEXTDOMAIN),
		            // 'gallery' => __('Gallery', DCE_TEXTDOMAIN),
		            'opacity' => __('Opacity', DCE_TEXTDOMAIN),
		            //'fixed' => __('Fixed', DCE_TEXTDOMAIN),
		            'parallax' => __('Parallax', DCE_TEXTDOMAIN),
		            'rotation'	=> __('Rotation', DCE_TEXTDOMAIN),
		            'linger' => __('Linger', DCE_TEXTDOMAIN),
		            'lazy' => __('Lazy', DCE_TEXTDOMAIN),
		            'eager' => __('Eger', DCE_TEXTDOMAIN),
		            'slalom' => __('Slalom', DCE_TEXTDOMAIN),
		            // 'crazy' => __('Crazy', DCE_TEXTDOMAIN),
		            
		            // 'spin' => __('Spin', DCE_TEXTDOMAIN),
		            'spinRev' => __('SpinRev', DCE_TEXTDOMAIN),
		            // 'spinIn' => __('SpinIn', DCE_TEXTDOMAIN),
		            // 'spinOut' => __('SpinOut', DCE_TEXTDOMAIN),
		            
		            // 'blurInOut' => __('BlurInOut', DCE_TEXTDOMAIN),
		            // 'blurIn' => __('BlurIn', DCE_TEXTDOMAIN),
		            // 'blurOut' => __('BlurOut', DCE_TEXTDOMAIN),

		            // 'fadeInOut' => __('FadeInOut', DCE_TEXTDOMAIN),
		            // 'fadeIn' => __('FadeIn', DCE_TEXTDOMAIN),
		            // 'fadeOut' => __('FadeOut', DCE_TEXTDOMAIN),
		            
		            'driftLeft' => __('DriftLeft', DCE_TEXTDOMAIN),
		            'driftRight' => __('DriftRight', DCE_TEXTDOMAIN),

		            'leftToRight' => __('LeftToRight', DCE_TEXTDOMAIN),
		            'rightToLeft' => __('RightToLeft', DCE_TEXTDOMAIN),

		            'zoomInOut' => __('ZoomInOut', DCE_TEXTDOMAIN),
		            'zoomIn' => __('ZoomIn', DCE_TEXTDOMAIN),
		            'zoomOut' => __('ZoomOut', DCE_TEXTDOMAIN),

		            'swing' => __('Swing', DCE_TEXTDOMAIN),
		            'speedy' => __('Speedy', DCE_TEXTDOMAIN),
		        ],
		        'default' => ['scaleDown'],
	            'frontend_available' => true,
	            'render_type' => 'template',
	            'condition' => [
	                'enable_scrollEffects' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                
	            ],
            ]
        );
        $document->add_control(
            'custom_class_section', [
		        'label' => __('Custom section CLASS', DCE_TEXTDOMAIN),
	            'type' => Controls_Manager::TEXT,
	            'default' => '',
	            'placeholder' => 'Write custom CLASS',
	            'frontend_available' => true,
	            'separator' => 'before',
	            'condition' => [
	                'enable_scrollEffects' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                
	            ],
            ]
        );
        
	}

	/**
	 * Add Actions
	 *
	 * @since 0.5.5
	 *
	 * @access private
	 */
	protected function add_actions() {
		//$settings = $this->get_settings();
		//page-settings
		//document
		//common (i widget)
		$element_data;
		// Activate controls for Post
		add_action( 'elementor/element/post/section_dce_document_scroll/before_section_end', function( $element, $args ) {

			$this->add_controls( $element, $args );
			/*$element_data = $element;

			  foreach ($element_data as $name => $value) {
			      echo "$name: $value\n";
			  }*/
		}, 10, 2 );
		add_action( 'elementor/element/page/section_dce_document_scroll/before_section_end', function( $element, $args ) {

			$this->add_controls( $element, $args );
			/*$element_data = $element;

			  foreach ($element_data as $name => $value) {
			      echo "$name: $value\n";
			  }*/
		}, 10, 2 );

		add_action( 'elementor/element/section/section_dce_document_scroll/before_section_end', function( $element, $args ) {

			$this->add_controls( $element, $args );
			/*$element_data = $element;

			  foreach ($element_data as $name => $value) {
			      echo "$name: $value\n";
			  }*/
		}, 10, 2 );
		add_action( 'elementor/element/product/section_dce_document_scroll/before_section_end', function( $element, $args ) {

			$this->add_controls( $element, $args );
			/*$element_data = $element;

			  foreach ($element_data as $name => $value) {
			      echo "$name: $value\n";
			  }*/
		}, 10, 2 );
		
		// Activate controls for widgets
		/*add_action( 'elementor/element/common/section_DynamicContentForElementor_document/before_section_end', function( $element, $args ) {

			$this->add_controls( $element, $args );

		}, 10, 2 );*/

		// Activate controls for columns
		/*add_action( 'elementor/element/column/section_DynamicContentForElementor_document/before_section_end', function( $element, $args ) {

			$this->add_controls( $element, $args );

		}, 10, 2 );*/

		// Activate controls for sections
		/*add_action( 'elementor/element/section/section_DynamicContentForElementor_document/before_section_end', function( $element, $args ) {

			$this->add_controls( $element, $args );

		}, 10, 2 );*/
		// 
		/*add_action( 'elementor/frontend/section/before_render', function( $element) {
			$settings = $element->get_settings_for_display();
			$element_type = $element->get_type();
			$element_name = $element->get_unique_name();
            $element_id = $element->get_id();
            //$title_type = $content->get_post_type_title();

            // Get the current post id
			$post_id = get_the_ID();

			// Get the page settings manager
			$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );

			// Get the settings model for current post
			$page_settings_model = $page_settings_manager->get_model( $post_id );

			// Retrieve the color we added before
			$scroll_effect = $page_settings_model->get_settings( 'animation_effects' );
			if( is_array($scroll_effect) ){
				$scroll_effect_string = implode(" ", $scroll_effect);
			}else{
				$scroll_effect_string = $scroll_effect;
			}
			//echo $scroll_effect_string;
			//echo $element_type;
			//var_dump($settings);

			if( $element_type == 'section' ){
				$element->add_render_attribute( '_wrapper', 'class', 'lax' );
				$element->add_render_attribute( '_wrapper', 'data-lax-preset', $scroll_effect_string );
				//$element->add_render_attribute( '_wrapper', 'data-lax-anchor', '#outer-wrap' );
			}
		}, 10, 2 );*/
		
	}

}
