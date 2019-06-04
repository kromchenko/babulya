<?php

namespace DynamicContentForElementor\Documents;

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;

use DynamicContentForElementor\DCE_Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 *
 * Inertia Scroll Document
 *
 */
class DCE_Document_InertiaScroll extends DCE_Document_Prototype {
    
    public $name = "InertiaScroll";
        
       
	protected $is_common = true;
   
	public function get_script_depends() {
		return [
			'dce-tweenMax-lib', 'inertiaScroll', 'dce-inertiaScroll'
		];
	}
	public static function get_description() {
		return __( 'Inertial Scroll.' );
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

	private function add_controls( $document, $args ) {

		$element_type = $document->get_type();

		//
	    // ------------------------------------------
	    $dce_data = DCE_Helper::dce_dynamic_data();
	    // ------------------------------------------
	    $id_page = $dce_data['global_id'];

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
        'enable_inertiaScroll',
        [
			'label' => __( 'InertiaScroll', DCE_TEXTDOMAIN ),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'label_on' => __( 'Yes', DCE_TEXTDOMAIN ),
            'label_off' => __( 'No', DCE_TEXTDOMAIN ),
            'return_value' => 'yes',
            'frontend_available' => true,
            'condition' => [
	                'enable_dceScrolling' => 'yes',
	            ],
		]
      );
      /*$document->add_control(
        'scroll_direction_info',
        [
			'label' => __( 'Direction info', DCE_TEXTDOMAIN ),
            'type' => Controls_Manager::RAW_HTML,
            'show_label' => false,
            'default' => '',
           
          	'raw' 				=> __( '<div>Definisce se lo scorrimento delle sezioni è Naturale (verticale) oppure Orizzontale (richiede trasformazioni)</div>', DCE_TEXTDOMAIN ),
			'content_classes' 	=> 'dce-document-settings',
			
			'condition' => [
	                'enable_dceScrolling' => 'yes',
	            ],
		]
      );*/
      $document->add_control(
         'coefSpeed_inertiaScroll', [
	            'label' => __('Coef. of Speed (0-1) Default: 0.05', DCE_TEXTDOMAIN),
	            'type' => Controls_Manager::SLIDER,
	            'default' => [
	                'size' => '0.05',
	            ],
	            'range' => [
	                'px' => [
	                    'max' => 1,
	                    'min' => 0,
	                    'step' => 0.01,
	                ],
	            ],
	            'frontend_available' => true,
	            'condition' => [
	                'enable_dceScrolling' => 'yes',
	                'enable_inertiaScroll' => 'yes'

	            ],
          ]
        );
     /* $document->add_control(
          'directionScroll', [
            'label' => __('Direction', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'vertical' => __('Vertical', DCE_TEXTDOMAIN),
                'horizontal' => __('Horizontal', DCE_TEXTDOMAIN),
            ],
            'default' => 'vertical',
            //'prefix_class' => 'scroll-direction-',
            'frontend_available' => true,
            'condition' => [
	                'enable_dceScrolling' => 'yes',
	                'enable_inertiaScroll' => 'yes'
	            ],
          ]
        );*/
      $document->add_control(
			'directionScroll',
			[
				'label' => __( 'direction of Scroll', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => 'vertical',
				'frontend_available' => true,
				'condition' => [
	                'enable_dceScrolling' => 'yes',
	                'enable_inertiaScroll' => 'yes'
	            ],
			]
		);
      $document->add_control(
        'scroll_target',
        [
			'label' => __( 'Target (optional)', DCE_TEXTDOMAIN ),
			'description' => 'the ID tag of the main item to be scrolled',
            'type' => Controls_Manager::TEXT,
            'default' => '',
           
            'frontend_available' => true,
            'condition' => [
	                'enable_dceScrolling' => 'yes',
	                'enable_inertiaScroll' => 'yes'

	            ],
		]
      );
      /*$document->add_control(
			'inertiaScroll_id_page',
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


	}

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
		
		
		/*add_action( 'elementor/frontend/post/after_render', function( $element, $args ) {

			echo 'ciao';

		}, 10, 2 );*/

	}

}
