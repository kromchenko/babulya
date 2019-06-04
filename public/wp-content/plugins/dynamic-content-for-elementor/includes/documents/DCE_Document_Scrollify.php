<?php

namespace DynamicContentForElementor\Documents;

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;

use DynamicContentForElementor\DCE_Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 *
 * Scrolling Scrollify SnapScroll
 *
 */
class DCE_Document_Scrollify extends DCE_Document_Prototype {
    
        public $name = "Scrollify";

	/**
	 * Is Common Extension
	 *
	 * Defines if the current extension is common for all element types or not
	 *
	 * @since 0.5.4
	 * @access private
	 *
	 * @var bool
	 */
	protected $is_common = true;

	/**
	 * A list of scripts that the widgets is depended in
	 *
	 * @since 0.5.4
	 **/
	public function get_script_depends() {
		return [
			'scrollify','dce-scrollify'
		];
	}

	/**
	 * The description of the current extension
	 *
	 * @since 0.5.4
	 **/
	public static function get_description() {
		return __( 'Scroll snap for sections.' );
	}

	/**
	 * Add common sections
	 *
	 * @since 0.5.4
	 *
	 * @access protected
	 */
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
        $id_page = $dce_data['id'];

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
        'enable_scrollify',
        [
			'label' => __( 'Snap', DCE_TEXTDOMAIN ),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'label_on' => __( 'Yes', DCE_TEXTDOMAIN ),
            'label_off' => __( 'No', DCE_TEXTDOMAIN ),
            'return_value' => 'yes',
            //'render_type' => 'template',
            'frontend_available' => true,
            'separator' => 'before',
            'condition' => [
	                'enable_dceScrolling' => 'yes',
	                //'directionScroll' => 'vertical'
	            ],
		]
      );
      /*$document->add_control(
		  'reload_scrollify_btn',
		  [
		     'type'    => Controls_Manager::RAW_HTML,
		     'raw' => '<div class="elementor-update-preview" style="background-color: transparent;margin: 0;">
			<div class="elementor-update-preview-title">'.__( 'Update changes to page', DCE_TEXTDOMAIN).'</div>
			<div class="elementor-update-preview-button-wrapper">
				<button class="elementor-update-preview-button elementor-button elementor-button-success">'. __( 'Apply', DCE_TEXTDOMAIN).'</button>
			</div>
		</div>',
			 'content_classes' => 'dce-btn-reload',
			 'separator' => 'after',
			 'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	            ],
		  ]
		);*/
	$document->add_control(
            'custom_class_section_sfy', [
		        'label' => __('Custom section CLASS', DCE_TEXTDOMAIN),
	            'type' => Controls_Manager::TEXT,
	            'default' => '',
	            'placeholder' => 'Write custom CLASS',
	            'frontend_available' => true,
	            
	            'label_block' => true,
	            'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                //'directionScroll' => 'vertical'
	            ],
            ]
        );
     /* $document->add_control(
			'scrollify_id_page',
			[
				'label' => __( 'ID Page', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => $dce_data['id'],
				'frontend_available' => true,
				'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	            ],
			]
		);*/

      	$document->add_control(
          	'interstitialSection',
          	[
	            'label'       => __( 'Interstitial Section', DCE_TEXTDOMAIN ),
	            'type'        => Controls_Manager::TEXT,
	            'default'     => __( '', DCE_TEXTDOMAIN ),
	            'placeholder' => __( 'header, footer', DCE_TEXTDOMAIN ),
	            'frontend_available' => true,
	            'label_block' => true,
	            'condition' => [
		                'enable_scrollify' => 'yes',
		                'enable_dceScrolling' => 'yes',
		                //'directionScroll' => 'vertical'
		            ],
          	]
        );
      $document->add_control(
        'scrollSpeed',
        [
            'label' => __( 'Scroll Speed', DCE_TEXTDOMAIN ),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 1000,
            ],
            'range' => [
                'px' => [
                    'min' => 500,
                    'max' => 2400,
                    'step' => 10,
                ],
            ],
            'size_units' => [ 'ms', ],
            'frontend_available' => true,
            'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                //'directionScroll' => 'vertical'
	            ],
        ]
    );
     $document->add_control(
        'offset',
        [
            'label' => __( 'Offset', DCE_TEXTDOMAIN ),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 0,
            ],
            'range' => [
                'px' => [
                    'min' => -500,
                    'max' => 500,
                    'step' => 1,
                ],
            ],
            'size_units' => [ 'px' ],
            'frontend_available' => true,
            'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                //'directionScroll' => 'vertical'
	            ],
        ]
    );
    $document->add_control(
    	'ease_scrollify',
        [
			'label' => __( 'Ease', DCE_TEXTDOMAIN ),
			'type' => Controls_Manager::SELECT,
			'default' => 'easeOutQuad',
			'options' => DCE_Helper::get_ease_timingFunctions(), 
			'frontend_available' => true,
			'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                //'directionScroll' => 'vertical'
	            ],
		]
	);
	$document->add_control(
        'setHeights',
        [
			'label' => __( 'Set Heights', DCE_TEXTDOMAIN ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __( 'Yes', DCE_TEXTDOMAIN ),
            'label_off' => __( 'No', DCE_TEXTDOMAIN ),
            'return_value' => 'yes',
            'frontend_available' => true,
            'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                //'directionScroll' => 'vertical'
	            ],
		]
      );
	$document->add_control(
        'overflowScroll',
        [
			'label' => __( 'Overflow Scroll', DCE_TEXTDOMAIN ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __( 'Yes', DCE_TEXTDOMAIN ),
            'label_off' => __( 'No', DCE_TEXTDOMAIN ),
            'return_value' => 'yes',
            'frontend_available' => true,
            'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                //'directionScroll' => 'vertical'
	            ],
		]
      );
	$document->add_control(
        'updateHash',
        [
			'label' => __( 'Update Hash', DCE_TEXTDOMAIN ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __( 'Yes', DCE_TEXTDOMAIN ),
            'label_off' => __( 'No', DCE_TEXTDOMAIN ),
            'return_value' => 'yes',
            'frontend_available' => true,
            'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                //'directionScroll' => 'vertical'
	            ],
		]
      );
	$document->add_control(
        'touchScroll',
        [
			'label' => __( 'Touch Scroll', DCE_TEXTDOMAIN ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __( 'Yes', DCE_TEXTDOMAIN ),
            'label_off' => __( 'No', DCE_TEXTDOMAIN ),
            'return_value' => 'yes',
            'frontend_available' => true,
            'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                //'directionScroll' => 'vertical'
	            ],
		]
      );
	// -----------------------------------------
	$document->add_control(
        'enable_scrollify_nav',
        [
			'label' => __( 'Enable navigation', DCE_TEXTDOMAIN ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __( 'Yes', DCE_TEXTDOMAIN ),
            'label_off' => __( 'No', DCE_TEXTDOMAIN ),
            'return_value' => 'yes',
            'frontend_available' => true,
            'render_type' => 'template',
            'separator' => 'before',
            'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                //'directionScroll' => 'vertical'
	            ],
		]
      );
	  /*$document->add_control(
	  'scrollify_nav_border_type',
	    [
	       'label'       => __( 'Select', DCE_TEXTDOMAIN ),
	       'type' => Controls_Manager::SELECT,
	       'default' => 'solid',
	       'options' => [
	          'solid'  => __( 'Solid', DCE_TEXTDOMAIN ),
	          'dashed' => __( 'Dashed', DCE_TEXTDOMAIN ),
	          'dotted' => __( 'Dotted', DCE_TEXTDOMAIN ),
	          'double' => __( 'Double', DCE_TEXTDOMAIN ),
	          'none'   => __( 'None', DCE_TEXTDOMAIN ),
	       ],
	      //'frontend_available' => true,
	       'selectors' => [ // You can use the selected value in an auto-generated css rule.
	          '{{WRAPPER}}.dce-scrollify .dce-scrollify-pagination a' => 'border-style: {{VALUE}}',
	       ],
	       'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                'enable_scrollify_nav' => 'yes',
	            ],
	    ]
	  );*/
	  
	  $document->add_control(
        'scrollify_nav_size',
        [
            'label' => __( 'Size', DCE_TEXTDOMAIN ),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 10,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 80,
                    'step' => 1,
                ],
            ],
            'size_units' => [ 'px' ],
            'selectors' => [
	              '{{WRAPPER}}.dce-scrollify .dce-scrollify-pagination a:after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
	          ],
            'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                'enable_scrollify_nav' => 'yes',
	            ],
        ]
    );
	  $document->add_control(
        'scrollify_nav_border_size',
        [
            'label' => __( 'Border size', DCE_TEXTDOMAIN ),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 1,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                ],
            ],
            'size_units' => [ 'px' ],
            'selectors' => [
	              '{{WRAPPER}}.dce-scrollify .dce-scrollify-pagination a:after' => 'border-width: {{SIZE}}{{UNIT}}',
	          ],
            'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                'enable_scrollify_nav' => 'yes',
	            ],
        ]
    );
	   $document->add_control(
        'scrollify_nav_border_active_size',
        [
            'label' => __( 'Active border size', DCE_TEXTDOMAIN ),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 3,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                ],
            ],
            'size_units' => [ 'px' ],
            'selectors' => [
	              '{{WRAPPER}}.dce-scrollify .dce-scrollify-pagination a.active:after' => 'box-shadow: inset 0 0 0 {{SIZE}}{{UNIT}};',
	          ],
            'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                'enable_scrollify_nav' => 'yes',
	            ],
        ]
    );
	  $document->add_control(
        'scrollify_nav_space',
        [
            'label' => __( 'Space', DCE_TEXTDOMAIN ),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'size' => 10,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'size_units' => ['px'],
            'selectors' => [
	              '{{WRAPPER}}.dce-scrollify .dce-scrollify-pagination a' => 'padding: {{SIZE}}{{UNIT}}',
	          ],
            'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                'enable_scrollify_nav' => 'yes',
	            ],
        ]
    );
	  $document->add_control(
	    'scrollify_nav_color',
	      [
	          'label' => __( 'Color', DCE_TEXTDOMAIN ),
	          'type' => Controls_Manager::COLOR,
	          'scheme' => [
	              'type' => Scheme_Color::get_type(),
	              'value' => Scheme_Color::COLOR_1,
	          ],
	          'default' => '#444444',
	          'selectors' => [
	              '{{WRAPPER}}.dce-scrollify .dce-scrollify-pagination a:after' => 'color: {{VALUE}}',
	          ],
	          'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                'enable_scrollify_nav' => 'yes',
	            ],
	      ]
	  );
	   $document->add_control(
	    'scrollify_nav_color_active',
	      [
	          'label' => __( 'Active color', DCE_TEXTDOMAIN ),
	          'type' => Controls_Manager::COLOR,
	          'scheme' => [
	              'type' => Scheme_Color::get_type(),
	              'value' => Scheme_Color::COLOR_1,
	          ],
	          'default' => '',
	          'selectors' => [
	              '{{WRAPPER}}.dce-scrollify .dce-scrollify-pagination a.active, {{WRAPPER}}.dce-scrollify .dce-scrollify-pagination a.active:after' => 'color: {{VALUE}}',
	          ],
	          'condition' => [
	                'enable_scrollify' => 'yes',
	                'enable_dceScrolling' => 'yes',
	                'enable_scrollify_nav' => 'yes',
	            ],
	      ]
	  );
	  // Apply Effects On

	  //$document->end_controls_section();


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
		
		/*add_action( 'elementor/frontend/post/after_render', function( $element, $args ) {

			echo 'ciao';

		}, 10, 2 );*/

	}

}
