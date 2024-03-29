<?php
namespace DynamicContentForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use DynamicContentForElementor\DCE_Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Parent Child Menu
 *
 * Elementor widget for Linkness Elements
 *
 */
class DCE_Widget_SinglePostsMenu extends DCE_Widget_Prototype {

    public function get_name() {
            return 'single-posts-menu';
    }
    static public function is_enabled() {
        return true;
    }
    public function get_title() {
            return __( 'Single Posts List', DCE_TEXTDOMAIN );
    }
    public function get_description() {
        return __('Create a custom menu from single pages', DCE_TEXTDOMAIN);
    }
    public function get_docs() {
        return 'https://www.dynamic.ooo/widget/single-posts-list/';
    }
    public function get_icon() {
            return 'icon-dyn-listsingle';
    }
    /*public function get_style_depends() {
        return [ 'dce-list' ];
    }*/
    protected function _register_controls() {
        
        $this->start_controls_section(
            'section_content',
            [
                    'label' => __( 'Custom menu from single pages', DCE_TEXTDOMAIN ),
            ]
        );
        

        $this->add_control(
            'singlepage_select',
            [
                'label' => __( 'Select Single Posts', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => DCE_Helper::get_all_posts(null,false,'menu_order'),
                //'groups' => DCE_Helper::get_all_posts(get_the_ID(),true),
                'default' => ''
            ]
        );
        
        $this->add_responsive_control(
            'menu_style',
            [
                'label' => __( 'Style', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'horizontal' => __( 'Horizontal', DCE_TEXTDOMAIN ),
                    'vertical' => __( 'Vertical', DCE_TEXTDOMAIN )
                ],
                'default' => 'vertical',
            ]
        );
        $this->add_control(
            'heading_options_menu',
            [
                    'label' => __( 'Options', DCE_TEXTDOMAIN ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
            ]
        );
        $this->add_control(
        'show_title',
            [
                'label' => __( 'Show Title', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'title' => __( 'Yes', DCE_TEXTDOMAIN ),
                        'icon' => 'fa fa-check',
                    ],
                    '0' => [
                        'title' => __( 'No', DCE_TEXTDOMAIN ),
                        'icon' => 'fa fa-ban',
                    ]
                ],
                'default' => '1'
            ]
        );
        $this->add_control(
            'title_text',
            [
                'label' => __( 'Title text', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                    'show_title' => '1',
                ],
            ]
        );
        $this->add_control(
            'show_childlist',
            [
                'label' => __( 'Show Child List', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'title' => __( 'Yes', DCE_TEXTDOMAIN ),
                        'icon' => 'fa fa-check',
                    ],
                    '0' => [
                        'title' => __( 'No', DCE_TEXTDOMAIN ),
                        'icon' => 'fa fa-ban',
                    ]
                ],
                'default' => '1'
            ]
        );
        $this->add_control(
        'show_border',
            [
                'label' => __( 'Show Border', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '1' => [
                        'title' => __( 'Yes', DCE_TEXTDOMAIN ),
                        'icon' => 'fa fa-check',
                    ],
                    '0' => [
                        'title' => __( 'No', DCE_TEXTDOMAIN ),
                        'icon' => 'fa fa-ban',
                    ],
                    '2' => [
                        'title' => __( 'Any', DCE_TEXTDOMAIN ),
                        'icon' => 'fa fa-square-o',
                    ]
                ],
                'condition' => [
                    'menu_style' => 'vertical',
                ],
                'default' => '1'
            ]
        );

        $this->add_control(
        'blockwidth_enable',
            [
                'label'         => __( 'Force Block width', DCE_TEXTDOMAIN ),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => '',
                'label_on'      => __( 'Yes', DCE_TEXTDOMAIN ),
                'label_off'     => __( 'No', DCE_TEXTDOMAIN ),
                'return_value'  => 'yes'
            ]
        );
        $this->add_control(
            'menu_width',
            [
                'label' => __( 'Box Width', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 120,
                ],
                'range' => [
                    'px' => [
                            'min' => 0,
                            'max' => 400,
                    ],
                ],
                'condition' => [
                    'blockwidth_enable' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dce-menu .box' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
        'show_separators',
            [
                'label' => __( 'Show Separator', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'solid' => [
                        'title' => __( 'Yes', DCE_TEXTDOMAIN ),
                        'icon' => 'fa fa-check',
                    ],
                    'none' => [
                        'title' => __( 'No', DCE_TEXTDOMAIN ),
                        'icon' => 'fa fa-ban',
                    ],
                ],
                'toggle' => true,
                'default' => 'solid',
                'selectors' => [
                            '{{WRAPPER}} .dce-menu.horizontal li' => 'border-left-style: {{VALUE}};',
                                ],
                'condition' => [
                    'menu_style' => 'horizontal',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'menu_size_separator',
            [
                'label' => __( 'Height', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                    'unit' => 'px',
                ],
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .dce-menu.horizontal li' => 'border-left-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_separators' => 'solid',
                    'menu_style' => 'horizontal',
                ],
            ]
        );
        $this->add_responsive_control(
        'menu_align',
            [
                'label' => __( 'Text Alignment', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', DCE_TEXTDOMAIN ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', DCE_TEXTDOMAIN ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', DCE_TEXTDOMAIN ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'prefix_class' => 'menu-align-',
                'default' => 'left',
                'selectors' => [
                     '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'heading_spaces_menu',
            [
                'label' => __( 'Space', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_childlist' => '1',
                ],
            ]
        );
        $this->add_responsive_control(
            'menu_space',
            [
                'label' => __( 'Header Space', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                        'size' => 0,
                ],
                'range' => [
                        'px' => [
                                'min' => 0,
                                'max' => 100,
                        ],
                ],
                'selectors' => [
                        '{{WRAPPER}} .dce-menu .dce-parent-title' => 'margin-bottom: calc( {{SIZE}}{{UNIT}} / 2);',
                        '{{WRAPPER}} .dce-menu hr' => 'margin-bottom: calc( {{SIZE}}{{UNIT}} / 2);',
                        '{{WRAPPER}} .dce-menu div.box' => 'padding: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_title' => '1',
                ],
            ]
        );
        $this->add_responsive_control(
            'menu_list_space',
            [
                'label' => __( 'List Space', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                        'size' => 0,
                ],
                'range' => [
                        'px' => [
                                'min' => 0,
                                'max' => 100,
                        ],
                ],
                'selectors' => [
                        '{{WRAPPER}} .dce-menu ul.first-level > li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_childlist' => '1',
                ],
            ]
        );
        $this->add_responsive_control(
            'menu_indent',
            [
                'label' => __( 'Indent', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                        'px' => [
                                'min' => 0,
                                'max' => 100,
                        ],
                ],
                'selectors' => [
                        '{{WRAPPER}} .dce-menu ul.first-level > li' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_childlist' => '1',
                ],
            ]
        );
        
        $this->end_controls_section();
        // ---------------------------------- STYLE
        $this->start_controls_section(
            'section_style',
            [
                    'label' => __( 'Style', DCE_TEXTDOMAIN ),
                    'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'heading_colors',
            [
                    'label' => __( 'List items', DCE_TEXTDOMAIN ),
                    'type' => Controls_Manager::HEADING,
                    'separator' => 'before',
                    'condition' => [
                        'show_childlist' => '1',
                    ],
            ]
        );
        $this->add_control(
            'menu_color',
            [
                'label' => __( 'Text Color', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'condition' => [
                    'show_childlist' => '1',
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dce-menu a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'menu_color_hover',
            [
                'label' => __( 'Text Hover Color', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'condition' => [
                    'show_childlist' => '1',
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dce-menu a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'menu_color_active',
            [
                'label' => __( 'Text Active Color', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'condition' => [
                    'show_childlist' => '1',
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dce-menu ul li a.active' => 'color: {{VALUE}};',
                ],
            ]
        );   
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_list',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .dce-menu ul.first-level li',
                'condition' => [
                    'show_childlist' => '1',
                ],
            ]
        );
        $this->add_control(
            'heading_title',
            [
                'label' => __( 'Title', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_title' => '1',
                ],
            ]
        );
        $this->add_control(
            'menu_title_color',
            [
                'label' => __( 'Title Color', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'condition' => [
                    'show_title' => '1',
                ],
                'default' => '',
                'selectors' => [
                        '{{WRAPPER}} .dce-menu .dce-parent-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_tit',

                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .dce-menu .dce-parent-title',
                'condition' => [
                    'show_title' => '1',
                ],
            ]
        );

        $this->add_control(
            'heading_border',
            [
                'label' => __( 'Border', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_border' => ['1','2'],
                ],
            ]
        );
        $this->add_control(
            'menu_border_color',
            [
                'label' => __( 'Border Color', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'default' => '',
                'condition' => [
                    'show_border' => ['1','2'],
                ],
                'selectors' => [
                        '{{WRAPPER}} .dce-menu hr' => 'border-color: {{VALUE}};',
                        '{{WRAPPER}} .dce-menu.horizontal li' => 'border-left-color: {{VALUE}};',
                        '{{WRAPPER}} .dce-menu .box' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'menu_border_size',
            [
                'label' => __( 'Height', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                    'unit' => 'px',
                ],
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .dce-menu hr' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_border' => ['1','2'],
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_active_settings();
        if ( empty( $settings ) )
            return;

        

        // ------------------------------------------
        $demoPage = get_post_meta(get_the_ID(), 'demo_id', true);
        //
        $id_page = ''; //get_the_ID();
        $type_page = '';

        global $global_ID;
        global $global_TYPE;
        global $is_blocks;
        global $global_is;
        //
        if(!empty($demoPage)){
            $id_page = $demoPage;
            $type_page = get_post_type($demoPage);
            //echo 'DEMO ...';
        } 
        else if (!empty($global_ID)) {
            $id_page = $global_ID;
            $type_page = get_post_type($id_page);
            //echo 'global ...';
        } else {
            $id_page = get_the_id();
            $type_page = get_post_type();
            //echo 'natural ...';
        }


        // ------------------------------------------

      
        $children = $settings['singlepage_select'];

        $styleMenu = $settings['menu_style'];
        $clssStyleMenu = $styleMenu; 

        echo '<div class="dce-menu '.$clssStyleMenu.'">';
        if( $settings['show_border'] == 2  ) echo '<div class="box">';
        if ( $settings['show_title'] != 0 ) {

            echo '<h4 class="dce-parent-title">'.__($settings['title_text'], DCE_TEXTDOMAIN.'_texts').'</h4>';
            if( $settings['show_border'] == 1  ) echo '<hr />';

        }
        if ( $settings['show_childlist'] != 0 ) {
            
            echo '<ul class="first-level">';
                foreach ( $children as $pageid ) {
                    if( $id_page == $pageid ){
                        $linkActive = ' class="active"';
                    }else{
                        $linkActive = '';
                    }
                    //echo $page->ID.' '.get_the_id();
                    
                        echo '<li class="item-'.$pageid.'"><a href="'.get_permalink( $pageid ).'"'.$linkActive.'>'.get_the_title( $pageid ).'</a>';
                        
                        echo '</li>';
                  
                    
                }
                echo '</ul>';

            }
            if( $settings['show_border'] == 2  ) echo '</div>';
            //var_dump(DCE_Helper::get_all_posts(null,false,'menu_order'));
            echo '</div>';
    }

}
