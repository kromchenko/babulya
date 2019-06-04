<?php

namespace DynamicContentForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use DynamicContentForElementor\DCE_Helper;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Elementor Popups & Modals
 *
 * Elementor widget for Dinamic Content Elements
 *
 */

class DCE_Widget_PopUp extends DCE_Widget_Prototype {

    public function get_name() {
        return 'dyncontel-popup';
    }

    public function get_title() {
        return __('Modals', DCE_TEXTDOMAIN);
    }
    public function get_description() {
        return __('Add a modal inside your page', DCE_TEXTDOMAIN);
    }
    public function get_docs() {
        return 'https://www.dynamic.ooo/widget/popups/';
    }
    public function get_icon() {
        return 'icon-dyn-popups';
    }

    static public function is_enabled() {
        return true;
    }

    public function get_script_depends() {
        return ['dce-popup'];
    }

    public function get_style_depends() {
        return ['elementor-animations', 'dce-modal'];
    }
    static public function get_position() {
        return 5;
    }
    protected function _register_controls() {


        $this->start_controls_section(
            'section_popup_content', [
                'label' => __('Content', DCE_TEXTDOMAIN),
            ]
        );

        $this->add_control(
            'show_popup_editor', [
                'label' => __('Show PopUp PREVIEW in Editor Mode', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_block' => true,
                'label_on' => __('Yes', DCE_TEXTDOMAIN),
                'label_off' => __('No', DCE_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'content_hr', [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );


       $this->add_control(
            'content_type', [
                'label' => __('Content type', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'options' => [
                    'content' => [
                        'title' => __('Content', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-align-left',
                    ],
                    'template' => [
                        'title' => __('Template', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-th-large',
                    ]
                ],
                'default' => 'content',
            ]
        );
        $this->add_control(
            'template', [
                'label' => __('PopUp Template', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT2,
                //'options' => get_post_taxonomies( $post->ID ),
                'options' => DCE_Helper::get_all_template(),
                'description' => 'Use a Elementor Template as content of popup, usefull for complex structure.',
                'label_block' => true,
                'default' => '',
                     'condition' => [
                      'content_type' => 'template',
                      ],
            ]
        );
         $this->add_control(
                'modal_content', [
            'label' => __('PopUp Content', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::WYSIWYG,
            'default' => 'Write the content of popup!',
            'description' => 'The main content of the popup. You can use ShortCode and Tokens.',
            'dynamic' => [
                'active' => true,
            ],
            'condition' => [
                      'content_type' => 'content',
                      ],
                ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_popup_settings', [
                'label' => __('Settings', DCE_TEXTDOMAIN),

            ]
        );
       /* $this->add_control(
          'animation_speed', [
          'label' => __('Animation Speed', DCE_TEXTDOMAIN),
          'type' => Controls_Manager::NUMBER,
          'default' => '500',
          'description' => 'Time in MilliSeconds. Leave 0 for no delay. 1000 ms = 1 second.',
          'condition' => [
          'animation!' => ''
          ]
          ]
          ); */

        $this->add_control(
            'trigger', [
                'label' => __('Trigger', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'default' => 'onload',
                'options' => [
                    'onload' => __('On Page Load', DCE_TEXTDOMAIN),
                    'button' => __('On Click Button', DCE_TEXTDOMAIN),
                    'scroll' => __('On Scroll Page', DCE_TEXTDOMAIN),
                    'widget' => __('On Widget position', DCE_TEXTDOMAIN),
                ],

            ]
        );
        /* $this->add_control(
          'button_close', [
          'label' => __('Only a Close button', DCE_TEXTDOMAIN),
          'type' => Controls_Manager::SWITCHER,
          'default' => '',
          'label_on' => __('Yes', DCE_TEXTDOMAIN),
          'label_off' => __('No', DCE_TEXTDOMAIN),
          'description' => 'A simple CTA button to insert in another popop, no popup will be generated for this widget.',
          ]
          ); */
        $this->add_control(
            'hr_button', [
            'type' => \Elementor\Controls_Manager::DIVIDER,
            'style' => 'thick',
            'condition' => [
                    'trigger' => 'button'
                ]
            ]
        );
        $this->add_control(
            'title_button', [
                'label' => __('Button', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'trigger' => 'button'
                ]
            ]
        );
        $this->add_control(
            'button_type', [
                'label' => __('Button type', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'text',
                'options' => [
                    'text' => [
                        'title' => __('Text', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-italic',
                    ],
                    'image' => [
                        'title' => __('Image', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-picture-o',
                    ],
                    'hamburger' => [
                        'title' => __('Hamburger', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-bars',
                    ],
                ],
                'condition' => [
                    'trigger' => 'button'
                ]
            ]
        );
        $this->add_control(
            'hamburger_style', [
                'label' => __('Hanmburger Type', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'default' => 'x',
                'options' => [
                    'x' => __('X', DCE_TEXTDOMAIN),
                    'arrow_left' => __('Arrow Left', DCE_TEXTDOMAIN),
                    'arrow_right' => __('Arrow Right', DCE_TEXTDOMAIN),
                    'fall' => __('Fall', DCE_TEXTDOMAIN),
                ],
                'condition' => [
                    //'button_image[id]' => '',
                    'trigger' => 'button',
                    'button_type' => 'hamburger'
                ]
            ]
        );
        $this->add_control(
            'button_text', [
                'label' => __('Text', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::TEXT,
                'default' => __('Get Started', DCE_TEXTDOMAIN),
                'placeholder' => __('Get Started', DCE_TEXTDOMAIN),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    //'button_image[id]' => '',
                    'trigger' => 'button',
                    'button_type' => 'text'
                ]
            ]
        );



        $this->add_control(
            'button_icon', [
                'label' => __('Icon', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::ICON,
                'label_block' => true,
                'default' => '',
                'condition' => [
                    //'button_image[id]' => '',
                    'trigger' => 'button',
                    'button_type' => 'text'
                ]
            ]
        );
        $this->add_control(
          'button_image',
          [
             'label' => __( 'Button Image', DCE_TEXTDOMAIN ),
             'type' => Controls_Manager::MEDIA,
             'dynamic' => [
                    'active' => true,
                ],
            'default' => [
                    'url' => '',
                ],
            'condition' => [
                    'trigger' => 'button',
                    'button_type' => 'image'
                ],
            'description' => __('Use an image instead of the button', DCE_TEXTDOMAIN),
          ]
        );
        /* ------- Hamburger --------- */

        /* ------------------ */
        $this->add_control(
            'button_purpose', [
                'label' => __('Button Purpose', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'options' => [
                    'open' => [
                        'title' => __('Default', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-expand',
                    ],
                    'close' => [
                        'title' => __('Use button in teplate for close', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-window-close-o ',
                    ],
                    
                ],
                'default' => 'open',
                'description' => 'Decide if this it is a simple CTA button to insert in another popop, no popup will be generated for this widget. If you need use other element to close modal simply add class <strong>.dce-button-close-modal</strong> to them.',
                'condition' => [
                    'trigger' => 'button'
                ],
                'separator' => 'before'
            ]
        );


        /*$this->add_control(
                'scroll_display', [
            'label' => __('Display on scroll', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'label_on' => __('Yes', DCE_TEXTDOMAIN),
            'label_off' => __('No', DCE_TEXTDOMAIN),
            'description' => 'Show popup only when scrolling page and reach the widget placeholder.',
            'condition' => [
                'button_purpose!' => 'close'
            ]
                ]
        );*/

        $this->add_control(
            'scroll_display_displacement', [
                'label' => __('Scroll displacement', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'description' => 'Pixel to wait until make PopUp appear.',
                'frontend_available' => true,
                'condition' => [
                    'trigger' => 'scroll'
                ]
            ]
        );
        /*$this->add_control(
            'playstop_animation', [
                'label' => __('', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'paused',
                'options' => [
                    'running' => [
                        'title' => __('Play', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-play',
                    ],
                    'paused' => [
                        'title' => __('Pause', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-pause',
                    ],
                //animation-play-state: paused; running
                ],
                'render_type' => 'template',
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .modal-dialog' => 'animation-play-state: {{VALUE}}; -webkit-animation-play-state: {{VALUE}};',
                ],
            ]
        );*/
        /*$this->add_control(
            'open_animation', [
                'label' => __('Open animation', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'groups' => DCE_Helper::get_anim_in(),
                'default' => 'fadeInUp',
                'separator' => 'before',
                'frontend_available' => true,
                'condition' => [
                    'button_purpose!' => 'close'
                ],
                
            ]
        );
        $this->add_control(
            'close_animation', [
                'label' => __('Close animation', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'groups' => DCE_Helper::get_anim_out(),
                'default' => 'fadeOutDown',
                'separator' => 'after',
                'frontend_available' => true,
                'condition' => [
                    'button_purpose!' => 'close'
                ],
                
            ]
        );*/
        $this->add_control(
            'enabled_push', [
                'label' => __('Push', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => __('Yes', DCE_TEXTDOMAIN),
                'label_off' => __('No', DCE_TEXTDOMAIN),
                'frontend_available' => true,
                'separator' => 'before',
                'description' => 'Move body wrapper.',
                'condition' => [
                    'button_purpose!' => 'close'
                ]
            ]
        );


        $this->add_control(
            'wrapper_maincontent', [
                'label' => __('Wrapper of Content', DCE_TEXTDOMAIN),
                'description' => 'The ID of the main content of your site. (OceanWP use: #wrap, Astra use: #page)',
                'type' => Controls_Manager::TEXT,
                'frontend_available' => true,
                'default' => '#wrap',
                'placeholder' => '#wrap',
                'condition' => [
                    'button_purpose!' => 'close',
                    'enabled_push' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'close_animation_push', [
                'label' => __('CLOSE body push', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'groups' => DCE_Helper::get_anim_close(), //DCE_Helper::get_anim_in(),
                'default' => 'exitToScaleBack',
                'frontend_available' => true,
                'separator' => 'after',
                'render_type' => 'template',
                'condition' => [
                    'button_purpose!' => 'close',
                    'enabled_push' => 'yes'
                ],
                'selectors' => [
                    'body.modal-open-dce-popup-{{ID}} .dce-push' => 'animation-name: {{VALUE}}; -webkit-animation-name: {{VALUE}};'
                ],
            ]
        );
        $this->add_control(
            'open_animation_push', [
                'label' => __('OPEN body push', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'groups' => DCE_Helper::get_anim_open(), //DCE_Helper::get_anim_in(),
                'default' => 'enterFormScaleBack',
                'frontend_available' => true,
                'render_type' => 'template',
                'condition' => [
                    'button_purpose!' => 'close',
                    'enabled_push' => 'yes'
                ],
                'selectors' => [
                    'body.modal-close-dce-popup-{{ID}} .dce-push' => 'animation-name: {{VALUE}}; -webkit-animation-name: {{VALUE}};'
                ],
            ]
        );


        // -------------




        $this->add_control(
            'title_open_modal', [
                'label' => __('OPEN Animation', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'button_purpose!' => 'close'
                ],
            ]
        );
        
        $this->add_control(
            'open_animation', [
                'label' => __('Style', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'groups' => DCE_Helper::get_anim_open(), //DCE_Helper::get_anim_in(),
                'default' => 'enterFromTop',
                'frontend_available' => true,
                'render_type' => 'template',
                'condition' => [
                    'button_purpose!' => 'close'
                ],
                'selectors' => [
                    'body.modal-open-dce-popup-{{ID}} #dce-popup-{{ID}} .modal-dialog' => 'animation-name: {{VALUE}}Popup; -webkit-animation-name: {{VALUE}}Popup;'
                ],
            ]
        );
        
        $this->add_control(
            'open_timingFunction', [
                'label' => __('Timing function', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'groups' => DCE_Helper::get_anim_timingFunctions(),
                'default' => 'ease-in-out',
                
                'frontend_available' => true,
                'condition' => [
                    'button_purpose!' => 'close'
                ],
                'selectors' => [
                    'body.modal-open-dce-popup-{{ID}} .dce-push, body.modal-open-dce-popup-{{ID}} #dce-popup-{{ID}} .modal-dialog' => 'animation-timing-function: {{VALUE}}; -webkit-animation-timing-function: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'open_speed', [
                'label' => __('Speed', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1
                    ],
                ],
                'default' => [
                    'size' => 0.6,

                ],
                'selectors' => [
                    'body.modal-open-dce-popup-{{ID}} .dce-push, body.modal-open-dce-popup-{{ID}} #dce-popup-{{ID}} .modal-dialog.animated' => '-webkit-animation-duration: {{SIZE}}s; animation-duration: {{SIZE}}s'
                ],
                'condition' => [
                    'button_purpose!' => 'close'
                ]
            ]
        );
        $this->add_control(
            'open_delay', [
                'label' => __('Delay', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'description' => 'Time in MilliSeconds. Leave 0 for no delay. 1000 ms = 1 second.',
                'frontend_available' => true,
                'condition' => [
                    'button_purpose!' => 'close'
                ],
                'selectors' => [
                    '#dce-popup-{{ID}}-background' => '-webkit-animation-delay: {{SIZE}}ms; animation-delay: {{SIZE}}ms'
                ],

            ]
        );
        
        $this->add_control(
            'title_close_modal', [
                'label' => __('CLOSE Animation', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'button_purpose!' => 'close'
                ],
            ]
         );
                 
        $this->add_control(
            'close_animation', [
                'label' => __('Style', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'groups' => DCE_Helper::get_anim_close(), //DCE_Helper::get_anim_out(),
                'default' => 'exitToBottom',
                'frontend_available' => true,
                'render_type' => 'template',
                'condition' => [
                    'button_purpose!' => 'close'
                ],
                'selectors' => [
                    '#dce-popup-{{ID}} .modal-dialog' => 'animation-name: {{VALUE}}Popup; -webkit-animation-name: {{VALUE}}Popup;'
                ],
            ]
        );
        
        $this->add_control(
            'close_timingFunction', [
                'label' => __('Timing function', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'groups' => DCE_Helper::get_anim_timingFunctions(),
                'default' => 'ease-in-out',
                
                'frontend_available' => true,
                'condition' => [
                    'button_purpose!' => 'close'
                ],
                'selectors' => [
                    'body.modal-close-dce-popup-{{ID}} .dce-push, #dce-popup-{{ID}} .modal-dialog' => 'animation-timing-function: {{VALUE}}; -webkit-animation-timing-function: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'close_speed', [
                'label' => __('Speed', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1
                    ],
                ],
                'default' => [
                    'size' => 0.6,

                ],
                'selectors' => [
                    'body.modal-close-dce-popup-{{ID}} .dce-push, #dce-popup-{{ID}} .modal-dialog.animated' => '-webkit-animation-duration: {{SIZE}}s; animation-duration: {{SIZE}}s'
                ],
                'condition' => [
                    'button_purpose!' => 'close'
                ],
            ]
        );
        /*
        https://codemyui.com/multiple-hamburger-menu-animations/
        https://codemyui.com/elastic-hamburger-close-icon-animation/
        https://codemyui.com/simple-slideout-sidebar-menu/?relatedposts_hit=1&relatedposts_origin=23&relatedposts_position=0
        https://codemyui.com/simple-hamburger-menu-x-mark-animation/
        */
        
       
       
        $this->add_control(
            'hide_hr', [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'thick',
                'condition' => [
                    'button_purpose!' => 'close'
                ]
            ]
        );
        $this->add_control(
            'title_options', [
                'label' => __('Options', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'button_purpose!' => 'close'
                ],
            ]
         );
        $this->add_control(
            'scroll_hide', [
                'label' => __('Hide on scroll', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => __('Yes', DCE_TEXTDOMAIN),
                'label_off' => __('No', DCE_TEXTDOMAIN),
                'description' => 'Hide popup when user scroll page.',
                'condition' => [
                    'button_purpose!' => 'close'
                ]
            ]
        );
        $this->add_control(
            'close_delay', [
                'label' => __('Close Delay', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'description' => 'Time in MilliSeconds. Leave 0 for no delay. 1000 ms = 1 second.',
                'frontend_available' => true,
                'condition' => [
                    'scroll_hide!' => ['', '0'],
                    'button_purpose!' => 'close'
                ]
            ]
        );

        $this->add_control(
            'esc_hide', [
                'label' => __('Hide on press ESC', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', DCE_TEXTDOMAIN),
                'label_off' => __('No', DCE_TEXTDOMAIN),
                'description' => 'Hide popup when user press Esc button.',
                'condition' => [
                    'button_purpose!' => 'close'
                ]
            ]
        );





        $this->add_control(
            'visibile_hr', [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'thick',
                'condition' => [
                    'button_purpose!' => 'close'
                ]
            ]
        );


        $this->add_control(
            'always_visible', [
                'label' => __('Show PopUp on every page load', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => __('Yes', DCE_TEXTDOMAIN),
                'label_off' => __('No', DCE_TEXTDOMAIN),
                'frontend_available' => true,
                'condition' => [
                    'button_purpose!' => 'close',
                    'trigger!' => 'button'
                ]
            ]
        );
        $this->add_control(
            'cookie_lifetime', [
                'label' => __('Cookie Lifetime', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'frontend_available' => true,
                'description' => 'Time in seconds. 86400 seconds is a day. 0 is still browser is open.',
                'condition' => [
                    'always_visible' => '',
                    'button_purpose!' => 'close',
                    'trigger!' => 'button'
                ]
            ]
        );

        $this->end_controls_section();




        // ++++++++++++++++++++++ Overlay ++++++++++++++++++++++
        $this->start_controls_section(
            'section_style_bglayer', [
                'label' => __('Overlay', DCE_TEXTDOMAIN),
                'condition' => [
                    'button_purpose!' => 'close'
                ]
            ]
        );
        $this->add_control(
            'background_layer', [
                'label' => __('Enable Overlay', DCE_TEXTDOMAIN),
                'description' => __('Show a page overlay when PopUp is visible', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', DCE_TEXTDOMAIN),
                'label_off' => __('No', DCE_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );
        /*$this->add_control(
                'background_layer_color', [
                    'label' => __('Background Overlay Color', DCE_TEXTDOMAIN),
                    'type' => Controls_Manager::COLOR,
                    'default' => 'rgba(0,0,0,0.4)',
                    'selectors' => [
                        '{{WRAPPER}} .dce-modal-background-layer' => 'background-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'background_layer' => 'yes'
                    ]
                ]
        );*/
         $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background_overlay',
                'label' => __('Background Overlay Color', DCE_TEXTDOMAIN),
                'types' => [ 'classic', 'gradient' ],
                /*'fields_options' => [
                    'background' => [
                        'frontend_available' => true,
                    ],
                    'video_link' => [
                        'frontend_available' => true,
                    ],
                ],*/
                /*'default' => [
                    'color' => 'rgba(0,0,0,0.4)'
                ],*/
                'selector' => '{{WRAPPER}} .dce-modal-background-layer',

            ]
        );
        $this->add_control(
                'background_layer_close', [
            'label' => __('Close PopUp clicking on Background Layer.', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'label_on' => __('Yes', DCE_TEXTDOMAIN),
            'label_off' => __('No', DCE_TEXTDOMAIN),
            'return_value' => 'yes',
            'condition' => [
                'background_layer' => 'yes'
            ]
                ]
        );

        $this->end_controls_section();





        //////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////  STYLE  ///////////////////////////
         // ++++++++++++++++++++++ Modal ++++++++++++++++++++++

        $this->start_controls_section(
                'section_style_modal', [
            'label' => __('Modal', DCE_TEXTDOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'button_purpose!' => 'close'
            ]
                ]
        );

        $this->add_responsive_control(
          'modal_width',
          [
              'label' => __( 'Width', DCE_TEXTDOMAIN ),
              'type' => Controls_Manager::SLIDER,
              'default' => [
                'size' => '',
                'unit' => 'px',
            ],
            'tablet_default' => [
                'unit' => 'px',
            ],
            'mobile_default' => [
                'unit' => 'px',
            ],
              'range' => [
                  'px' => [
                      'min' => 0,
                      'max' => 1920,
                      'step' => 1,
                  ],
                  '%' => [
                      'min' => 5,
                      'max' => 100,
                      'step' => 1,
                  ],
              ],
              'size_units' => [ '%', 'px', 'vw' ],
              'selectors' => [
                '#dce-popup-{{ID}}.dce-modal' => 'width: {{SIZE}}{{UNIT}};',
              ],
          ]
        );
        $this->add_responsive_control(
          'modal_height',
          [
              'label' => __( 'height', DCE_TEXTDOMAIN ),
              'type' => Controls_Manager::SLIDER,
              'default' => [
                'size' => '80',
                'unit' => 'vh',
              ],
            'tablet_default' => [
                'unit' => 'vh',
            ],
            'mobile_default' => [
                'unit' => 'vh',
            ],
              'range' => [
                  'px' => [
                      'min' => 0,
                      'max' => 1920,
                      'step' => 1,
                  ],
                  '%' => [
                      'min' => 5,
                      'max' => 100,
                      'step' => 1,
                  ],
              ],
              'size_units' => [ '%', 'px', 'vh' ],
              'selectors' => [
                '#dce-popup-{{ID}} .modal-content' => 'max-height: {{SIZE}}{{UNIT}};',
              ],
            ]
        );
        $this->add_control(
                'modal_padding', [
            'label' => __('Padding', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em'],

            'selectors' => [
                '#dce-popup-{{ID}} .modal-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );
        $this->add_control(
                'modal_margin', [
            'label' => __('Margin', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em'],

            'selectors' => [
                '#dce-popup-{{ID}} .modal-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'modal_text_typography',
                'label' => __('Typography', DCE_TEXTDOMAIN),
                'selector' => '#dce-popup-{{ID}} .modal-content',
            ]
        );
        $this->add_control(
                'modal_text_color', [
            'label' => __('Text Color', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::COLOR,

            'selectors' => [
                '#dce-popup-{{ID}} .modal-content' => 'color: {{VALUE}};',
            ],
                ]
        );
        $this->add_control(
                'modal_background_color', [
            'label' => __('Background Color', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::COLOR,

            'selectors' => [
                '#dce-popup-{{ID}} .modal-content' => 'background-color: {{VALUE}};',
            ],
                ]
        );
        /*$this->add_control(
                'modal_border', [
            'label' => __('Border', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::TEXT,
            'default' => '1px solid #666',
                ]
        );*/
        $this->add_group_control(
                Group_Control_Border::get_type(), [
            'name' => 'modal_border',
            'label' => __('Border', DCE_TEXTDOMAIN),
            'placeholder' => '1px',

            'selector' => '#dce-popup-{{ID}} .modal-content',
                ]
        );



        $this->add_control(
                'modal_border_radius', [
            'label' => __('Border Radius', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em'],

            'selectors' => [
                '#dce-popup-{{ID}} .modal-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
                ]
        );

        /*
          $this->add_control(
          'modal_box_shadow', [
          'label' => __('Box shadow', DCE_TEXTDOMAIN),
          'type' => Controls_Manager::TEXT,
          'default' => '5px 5px 5px #ccc',
          ]
          );
         */
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'label' => __('Box shadow', DCE_TEXTDOMAIN),
                'name' => 'modal_box_shadow',
                'selector' => '#dce-popup-{{ID}} .modal-content',
            ]
        );



        $this->end_controls_section();

        // ++++++++++++++++++++++ Button ++++++++++++++++++++++

        $this->start_controls_section(
            'section_style_button', [
                'label' => __('Button', DCE_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'trigger' => 'button'
                ]
            ]
        );



        $this->add_control(
            'button_icon_align', [
                'label' => __('Icon Position', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => __('Before', DCE_TEXTDOMAIN),
                    'right' => __('After', DCE_TEXTDOMAIN),
                ],
                'condition' => [
                    'button_icon!' => '',
                    'button_image[id]' => ''
                ],
            ]
        );
        $this->add_responsive_control(
            'button_icon_size', [
                'label' => __('Icon Size', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dce-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    //'{{WRAPPER}} button.close .close-img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
                'condition' => [
                    'enable_close_button' => 'yes',
                    'button_icon!' => '',
                    'button_image[id]' => ''
                ]
            ]
        );
        $this->add_responsive_control(
            'button_icon_indent', [
                'label' => __('Icon Spacing', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'condition' => [
                    'button_icon!' => '',
                    'button_image[id]' => ''
                ],
                'selectors' => [
                    '{{WRAPPER}} .dce-button-popoup .dce-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .dce-button-popoup .dce-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_image_size', [
                'label' => __('Image Size', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dce-button-img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
                'condition' => [
                    'button_image[id]!' => '',
                    'button_type' => 'image'
                ]
            ]
        );

        /*$this->add_control(
                'button_style', [
            'label' => __('Type', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT,
            'default' => '',
            'options' => \DynamicContentForElementor\DCE_Helper::bootstrap_styles(),
                ]
        );*/

        $this->add_responsive_control(
            'button_align', [
                'label' => __('Alignment', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
                'default' => '',

            ]
        );


        /*$this->add_control(
                'button_size', [
            'label' => __('Size', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT,
            'default' => 'sm',
            'options' => \DynamicContentForElementor\DCE_Helper::bootstrap_button_sizes(),
                ]
        );*/


        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'button_typography',
                'label' => __('Typography', DCE_TEXTDOMAIN),
                'selector' => '{{WRAPPER}} .dce-button-popoup',
                'condition' => [
                    'button_image[id]' => '',
                    'button_type' => 'text'
                ]
            ]
        );

        // ....
        $this->add_control(
            'hr_button_border', [
            'type' => \Elementor\Controls_Manager::DIVIDER,
            'style' => 'thick',
            'condition' => [
                    'button_type' => 'text'
                ]
            ]
        );
        $this->add_control(
            'title_button_border', [
                'label' => __('Border', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'button_type' => 'text'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'button_border',
                'label' => __('Border', DCE_TEXTDOMAIN),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .dce-button-popoup',
                'condition' => [
                    'button_type!' => 'image'
                ]
            ]
        );

        $this->add_control(
            'button_border_radius', [
                'label' => __('Border Radius', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dce-button-popoup' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'button_type!' => 'image'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .dce-button-popoup',
                'condition' => [
                    'button_type!' => 'image'
                ]
            ]
        );

        $this->add_control(
            'button_padding', [
                'label' => __('Text Padding', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dce-button-popoup' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'button_type!' => 'image'
                ]
            ]
        );

        $this->add_control(
            'hr_button_color', [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'thick',
                'condition' => [
                    'button_type!' => 'image'
                ]
            ]
        );
        $this->add_control(
            'title_button_colors', [
                'label' => __('Colors', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'button_type!' => 'image'
                ]
            ]
        );
        $this->start_controls_tabs( 'buttontext_colors' );

        $this->start_controls_tab(
            'buttontext_colors_normal',
            [
                'label' => __( 'Normal', DCE_TEXTDOMAIN ),
                'condition' => [
                    'button_type!' => 'image',

                ]
            ]
        );

        $this->add_control(
            'button_text_color', [
                'label' => __('Text Color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dce-button-popoup' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'button_type' => 'text'
                ]
            ]
        );
        $this->add_control(
            'bars_color', [
                'label' => __('Bars Color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dce-popup-hamburger .bar' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'button_type' => 'hamburger'
                ]
            ]
        );
       

        $this->add_control(
            'button_background_color', [
                'label' => __('Background Color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                
                'selectors' => [
                    '{{WRAPPER}} .dce-button-popoup' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                        'button_type!' => 'image'
                    ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'buttontext_colors_hover',
            [
                'label' => __( 'Hover', DCE_TEXTDOMAIN ),
                'condition' => [
                    'button_type!' => 'image'
                ]
            ]
        );
        $this->add_control(
            'title_button_hover', [
                'label' => __('Hover', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'button_hover_color', [
                'label' => __('Text Color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dce-button-popoup:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'button_type' => 'text'
                ]

            ]
        );
        $this->add_control(
            'bars_hover_color', [
                'label' => __('Bars Color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dce-popup-hamburger .con:hover .bar, {{WRAPPER}} .special-con:hover .bar' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'button_type' => 'hamburger'
                ]
            ]
        );
        $this->add_control(
            'button_background_hover_color', [
                'label' => __('Background Color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dce-button-popoup:hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_hover_border_color', [
                'label' => __('Border Color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dce-button-popoup:hover' => 'border-color: {{VALUE}};',
                ],

            ]
        );
       

        $this->add_control(
            'button_hover_animation', [
                'label' => __('Animation', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        // ++++++++++++++++++++++ Position ++++++++++++++++++++++

        $this->start_controls_section(
            'section_style_position', [
                'label' => __('Position', DCE_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'button_purpose!' => 'close'
                ]
            ]
        );
        $this->add_control(
            'modal_align', [
                'label' => __('PopUp horizontal alignment', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', DCE_TEXTDOMAIN),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', DCE_TEXTDOMAIN),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', DCE_TEXTDOMAIN),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'center',
            ]
        );

        $this->add_control(
            'modal_valign', [
                'label' => __('PopUp vertical alignment', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'bottom' => [
                        'title' => __('Bottom', DCE_TEXTDOMAIN),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'middle' => [
                        'title' => __('Middle', DCE_TEXTDOMAIN),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'top' => [
                        'title' => __('Top', DCE_TEXTDOMAIN),
                        'icon' => 'eicon-v-align-top',
                    ],
                ],
                'default' => 'middle'
            ]
        );

        $this->end_controls_section();

        // ++++++++++++++++++++++ Close ++++++++++++++++++++++

        $this->start_controls_section(
            'section_style_close', [
                'label' => __('Close button', DCE_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'button_purpose!' => 'close'
                ]
            ]
        );
        $this->add_control(
            'enable_close_button', [
                'label' => __('Enable close button', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', DCE_TEXTDOMAIN),
                'label_off' => __('No', DCE_TEXTDOMAIN),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'close_type', [
                'label' => __('Close type', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'icon' => [
                        'title' => __('Icon', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-asterisk',
                    ],
                    'image' => [
                        'title' => __('Image', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-picture-o',
                    ],
                    'text' => [
                        'title' => __('Text', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-italic',
                    ]
                ],
                'toggle' => false,
                'default' => 'icon',
                'condition' => [
                    'enable_close_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
                'close_icon', [
            'label' => __('Close Icon', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::ICON,
            'label_block' => true,
            'default' => 'fa fa-times',
            'condition' => [
                'close_type' => 'icon',
                'enable_close_button' => 'yes'
            ]
                ]
        );

        $this->add_control(
          'close_image',
          [
             'label' => __( 'Close Image', DCE_TEXTDOMAIN ),
             'type' => Controls_Manager::MEDIA,
             'default' => [
                'url' => '',
             ],
             'condition' => [
                'close_type' => 'image',
                'enable_close_button' => 'yes'
            ]
          ]
        );

        $this->add_control(
            'close_text', [
                'label' => __('Close Text', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::TEXT,
                'default' => __('Close', DCE_TEXTDOMAIN),
                'condition' => [
                        'close_type' => 'text',
                        'enable_close_button' => 'yes'
                    ]
            ]
        );

        $this->start_controls_tabs( 'close_colors' );

        $this->start_controls_tab(
            'close_colors_normal',
            [
                'label' => __( 'Normal', DCE_TEXTDOMAIN ),
                'condition' => [
                    'close_type!' => 'image',
                ]
            ]
        );
        $this->add_control(
            'close_icon_color', [
                'label' => __('Icon color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '#dce-popup-{{ID}} button.close' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'close_type!' => 'image',
                    'enable_close_button' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'close_text_color', [
                'label' => __('Text color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '#dce-popup-{{ID}} button.close' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'close_type' => 'text',
                    'close_text!' => '',
                    'enable_close_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'close_bg_color', [
                'label' => __('Background color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '#dce-popup-{{ID}} button.close' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_close_button' => 'yes',
                    'close_type!' => 'image',
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'close_bg_border',
                'label' => __('Border', DCE_TEXTDOMAIN),
                'selector' => '#dce-popup-{{ID}} button.close',
                'condition' => [
                        'enable_close_button' => 'yes'
                    ]
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'close_colors_hover',
            [
                'label' => __( 'Hover', DCE_TEXTDOMAIN ),
                'condition' => [
                    'close_type!' => 'image',
                ]
            ]
        );
        $this->add_control(
            'close_icon_color_hover', [
                'label' => __('Icon color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '#dce-popup-{{ID}} button.close:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'close_type!' => 'image',
                    'enable_close_button' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'close_text_color_hover', [
                'label' => __('Text color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '#dce-popup-{{ID}} button.close:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'close_type' => 'text',
                    'close_text!' => '',
                    'enable_close_button' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'close_background_color_hover', [
                'label' => __('Background color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '#dce-popup-{{ID}} button.close:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'close_type!' => 'image',
                    'enable_close_button' => 'yes',
                    
                ]
            ]
        );
        $this->add_control(
            'close_bg_color_hover', [
                'label' => __('Background color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '#dce-popup-{{ID}} button.close:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_close_button' => 'yes',
                    'close_bg_border_border!' => ''
                ]
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();



        $this->add_control(
            'close_bg_radius', [
                'label' => __('Border Radius', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em'],

                'selectors' => [
                    '#dce-popup-{{ID}} button.close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                        'enable_close_button' => 'yes'
                    ]
            ]
        );
        

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'close_typography',
                'label' => __('Close Typography', DCE_TEXTDOMAIN),
                'selector' => '#dce-popup-{{ID}} button.close:not(i)',
                'condition' => [
                    'close_type' => 'text',
                    'close_text!' => '',
                    'enable_close_button' => 'yes'
                ]
            ]
        );


        $this->add_responsive_control(
            'close_size', [
                'label' => __('Icon Size', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'default' => [
                'size' => 20,
                'unit' => 'px',
                ],
                'selectors' => [
                    '#dce-popup-{{ID}} button.close' => 'font-size: {{SIZE}}{{UNIT}};',
                    '#dce-popup-{{ID}} button.close .close-img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ],
                'condition' => [
                    'close_type!' => 'image',
                    'enable_close_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'close_align', [
                'label' => __('Close button horizontal position', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
                'toggle' => false,
                'options' => [
                    'left' => [
                        'title' => __('Left', DCE_TEXTDOMAIN),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', DCE_TEXTDOMAIN),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', DCE_TEXTDOMAIN),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'default' => 'right',
                'condition' => [
                        'enable_close_button' => 'yes'
                    ]
            ]
        );
        $this->add_control(
            'close_valign', [
                'label' => __('Close button vertical position', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'options' => [
                    'bottom' => [
                        'title' => __('Bottom', DCE_TEXTDOMAIN),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'top' => [
                        'title' => __('Top', DCE_TEXTDOMAIN),
                        'icon' => 'eicon-v-align-top',
                    ],
                ],
                'default' => 'top',
                'condition' => [
                        'enable_close_button' => 'yes'
                    ]
            ]
        );

        $this->add_control(
            'close_margin', [
                'label' => __('Close Margin', DCE_TEXTDOMAIN),
                'description' => __('Helpful to put close button external from modal putting negative values', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%'],
                'selectors' => [
                    '#dce-popup-{{ID}} button.close' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'enable_close_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'close_padding', [
                'label' => __('Close Padding', DCE_TEXTDOMAIN),
                'description' => __('Please note that padding bottom has no effect - Left/Right padding will depend on button position!', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%'],
                'selectors' => [
                    '#dce-popup-{{ID}} button.close' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'enable_close_button' => 'yes'
                ]
            ]
        );


        

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        //var_dump($settings); die();
        if ( $settings['trigger'] == 'button' && ($settings['button_type'] == 'text' || $settings['button_type'] == 'image') ) { ?>
            <div class=" dce-button-wrapper">
                <?php if ($settings['button_image']['id']) { ?>
                    <img class="button-img dce-button-img dce-button-<?php echo $settings['button_purpose']; ?>-modal dce-animation-<?php echo $settings['button_hover_animation']; ?>"
                         aria-hidden="true"
                         <?php if (in_array($settings['button_purpose'], array('open','next'))) { ?>data-target="dce-popup-<?php echo $this->get_id(); ?>"<?php } ?>
                         src="<?php echo $settings['button_image']['url']; ?>" />
                <?php } else { ?>
                    <button
                        class="dce-button-<?php echo $settings['button_purpose']; ?>-modal btn dce-button-popoup  dce-animation-<?php echo $settings['button_hover_animation']; ?>"
                        <?php if (in_array($settings['button_purpose'], array('open','next'))) { ?>data-target="dce-popup-<?php echo $this->get_id(); ?>"<?php } ?>
                    >
                        <?php if ($settings['button_icon']) { ?>
                                    <span class="dce-button-icon dce-align-icon-<?php echo $settings['button_icon_align']; ?>" style="float:<?php echo $settings['button_icon_align']; ?>">
                                        <i class="<?php echo esc_attr($settings['button_icon']); ?>"></i>
                                    </span>
                        <?php } ?>
                        <span class="dce-button-text"><?php echo $settings['button_text']; ?></span>
                    </button>
                <?php } ?>
            </div>
        <?php
        }
        //echo 'button_type: '.$settings['button_type'];
        if( $settings['trigger'] == 'button' && $settings['button_type'] == 'hamburger' ){
            ?>
             <div
                class="dce-button-<?php echo $settings['button_purpose']; ?>-modal btn dce-button-popoup  dce-animation-<?php echo $settings['button_hover_animation']; ?>"
                <?php if (in_array($settings['button_purpose'], array('open','next'))) { ?>data-target="dce-popup-<?php echo $this->get_id(); ?>"<?php } ?>
            >
            <div class=" dce-button-wrapper dce-popup-hamburger">
                <?php if($settings['hamburger_style'] == 'x'){ ?>
                        <div class="con">
                          <div class="bar top"></div>
                          <div class="bar middle"></div>
                          <div class="bar bottom"></div>
                        </div>
                <?php
                }else if($settings['hamburger_style'] == 'arrow_left'){ ?>
                        <div class="con">
                          <div class="bar arrow-top-r"></div>
                          <div class="bar arrow-middle-r"></div>
                          <div class="bar arrow-bottom-r"></div>
                        </div>
                <?php }else if($settings['hamburger_style'] == 'arrow_right'){ ?>
                        <div class="con">
                          <div class="bar arrow-top"></div>
                          <div class="bar arrow-middle"></div>
                          <div class="bar arrow-bottom"></div>
                        </div>
                <?php }else if($settings['hamburger_style'] == 'fall'){ ?>
                         <div class="special-con">
                          <div class="bar arrow-top-fall"></div>
                          <div class="bar arrow-middle-fall"></div>
                          <div class="bar arrow-bottom-fall"></div>
                        </div>
                <?php } ?>
                </div>
            </div>
            <?php
        }
        //add_action('wp_footer', array($this, 'generate_modals'));
        $this->generate_modals();



        //add_action( 'elementor/frontend/before_enqueue_scripts', array($this, 'generate_modals'));


    }
    public function generate_modals(){
        $settings = $this->get_settings_for_display();
        // var_dump(\Elementor\Plugin::$instance->editor->is_edit_mode());
        // var_dump($settings);
        if ((\Elementor\Plugin::$instance->editor->is_edit_mode() && $settings['show_popup_editor'] && $settings['button_purpose'] != 'close')
            || (!\Elementor\Plugin::$instance->editor->is_edit_mode() && !$this->checkCookie())
            || (!\Elementor\Plugin::$instance->editor->is_edit_mode() && $settings['trigger'] == 'button')) {
            //var_dump($this->checkCookie());

            $infinite = '';
            //if( $settings['show_popup_editor'] && $settings['playstop_animation'] == 'running' && \Elementor\Plugin::$instance->editor->is_edit_mode() ) $infinite = ' infinite';
            ?>
            <div class="dce-popup-container dce-popup-<?php echo $settings['trigger']; ?>">

            <?php if ($settings['background_layer']) { ?>
                    <div id="dce-popup-<?php echo $this->get_id(); ?>-background" class="animated dce-modal-background-layer<?php if ($settings['background_layer_close']) { ?> dce-modal-background-layer-close<?php } ?> modal-background-layer<?php if (\Elementor\Plugin::$instance->editor->is_edit_mode()) { ?> block-i<?php } ?>" data-dismiss="modal" data-target="dce-popup-<?php echo $this->get_id(); ?>"></div>
            <?php } ?>

                <div id="dce-popup-<?php echo $this->get_id(); ?>"
                     class="dce-modal modal<?php if ($settings['esc_hide'] && !\Elementor\Plugin::$instance->editor->is_edit_mode()) { ?> modal-hide-esc<?php } ?><?php if ($settings['scroll_hide'] && !\Elementor\Plugin::$instance->editor->is_edit_mode()) { ?> modal-hide-on-scroll<?php } ?> modal-<?php echo $settings['modal_align']; ?> modal-<?php echo $settings['modal_valign']; ?> <?php if (\Elementor\Plugin::$instance->editor->is_edit_mode()) { ?> block-i<?php } ?>"
                     tabindex="-1"
                     role="dialog"
                     >
                    <div class="modal-dialog<?php if( $settings['open_animation'] ) { ?> animated<?php echo $infinite; }?>" role="document" >
                        <div class="modal-content">

                            <div class="modal-body">
                                <?php
                                if ($settings['template']) {
                                    $modal_content = '[dce-elementor-template id="' . $settings['template'] . '"]';
                                } else {
                                    $modal_content = __($settings['modal_content'], DCE_TEXTDOMAIN.'_texts');
                                }

                                $modal_content = do_shortcode($modal_content);
                                $modal_content = \DynamicContentForElementor\DCE_Tokens::do_tokens($modal_content);
                                echo $modal_content;
                                ?>
                            </div>

                            

                            <?php if ($settings['enable_close_button']){ ?>
                                <button type="button" class="dce-close dce-modal-close close close-<?php echo $settings['close_align']; ?> close-<?php echo $settings['close_valign']; ?>" data-dismiss="modal" aria-label="Close">
                                    <?php if ($settings['close_type'] == 'text') { ?><span class="dce-button-text"><?php echo __($settings['close_text'], DCE_TEXTDOMAIN.'_texts'); ?></span><?php } ?>
                                    <?php if ($settings['close_type'] == 'icon') { ?><?php if ($settings['close_icon']) { ?><i class="<?php echo esc_attr($settings['close_icon']); ?>" aria-hidden="true"></i><?php } ?><?php } ?>
                                    <?php if ($settings['close_type'] == 'image') { ?><?php if ($settings['close_image']['id']) { ?><img class="close-img" aria-hidden="true" src="<?php echo $settings['close_image']['url']; ?>" /><?php } ?><?php } ?>
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php /* if ($settings['open_animation']) { ?></div><?php } */ ?>
            </div>
            <?php
        } else {
            //echo 'NO POPUP';
        }
    }
    protected function checkCookie() {

        $settings = $this->get_settings_for_display();
        if ($settings['always_visible']) {
            //var_dump($settings); die();
            return false;
        }

        $dce_cookie = false;
        if (!empty($_COOKIE) && isset($_COOKIE['dce-popup-' . $this->get_id()])) {
            $dce_cookie = true;
        }

        return $dce_cookie;
    }

}
