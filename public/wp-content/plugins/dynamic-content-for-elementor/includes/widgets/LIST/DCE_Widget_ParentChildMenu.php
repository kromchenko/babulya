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
class DCE_Widget_ParentChildMenu extends DCE_Widget_Prototype {

    public function get_name() {
            return 'parent-child-menu';
    }
    static public function is_enabled() {
        return true;
    }
    public function get_title() {
            return __( 'Parent Child Menu', DCE_TEXTDOMAIN );
    }
    public function get_description() {
        return __('Build a list of entries in horizontal or vertical mode where a parent element can be considered as a menu', DCE_TEXTDOMAIN);
    }
    public function get_docs() {
        return 'https://www.dynamic.ooo/widget/widget-parent-child-menu/';
    }
    public function get_icon() {
            return 'icon-dyn-parentchild';
    }
    /*public function get_style_depends() {
        return [ 'dce-list' ];
    }*/
    protected function _register_controls() {
        
        $this->start_controls_section(
            'section_content',
            [
                    'label' => __( 'Menu of pages from parent', DCE_TEXTDOMAIN ),
            ]
        );
        $this->add_control(
        'dynamic_parentchild',
            [
                'label' => __( 'Dynamic page parent/child', DCE_TEXTDOMAIN ),
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
                'default' => '0',
            ]
        );
        $this->add_control(
            'use_second_level', 
            [
                'label'         => __( 'Use second level', DCE_TEXTDOMAIN ),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'condition' => [
                    //'post_type' => 'page',
                ]
            ]
        );
        $this->add_control(
            'exclude_io', 
            [
                'label'         => __( 'Exclude myself', DCE_TEXTDOMAIN ),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
            ]
        );
        
        $this->add_control(
            'no_siblings', 
            [
                'label'         => __( 'Hide Siblings', DCE_TEXTDOMAIN ),
                'type'          => Controls_Manager::SWITCHER,
            ]
        );
        
        $this->add_control(
            'only_children', 
            [
                'label'         => __( 'Only children', DCE_TEXTDOMAIN ),
                'type'          => Controls_Manager::SWITCHER,
            'condition' => [
                    'no_siblings!' => '',
                ]
            ]
        );

        $this->add_control(
            'parentpage_select',
            [
                'label' => __( 'Parent Page', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SELECT,
                //'options' => DCE_Helper::get_parentpages(),
                'groups' => DCE_Helper::get_all_posts(get_the_ID(),true),
                'default' => '',
                'condition' => [
                    'dynamic_parentchild' => '0',
                ]
            ]
        );
        
        $this->add_control(
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
        'show_parent',
            [
                'label' => __( 'Show parent page Title', DCE_TEXTDOMAIN ),
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
                    'justify' => [
                            'title' => __('Justified', DCE_TEXTDOMAIN),
                            'icon' => 'fa fa-align-justify',
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
        $this->add_control(
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
                    'show_childlist' => '1',
                ],
            ]
        );
        $this->add_control(
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
        $this->add_control(
            'menu_indent',
            [
                'label' => __( 'Indent', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                        'size' => 10,
                ],
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
        $this->add_control(
            'heading_spaces_menu_2',
            [
                'label' => __( 'Space of level 2', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_childlist' => '1',
                    'use_second_level' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'menu_2_list_space',
            [
                'label' => __( 'List Space', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                        'size' => 10,
                ],
                'range' => [
                        'px' => [
                                'min' => 0,
                                'max' => 100,
                        ],
                ],
                'selectors' => [
                        '{{WRAPPER}} .dce-menu ul.second-level > li' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_childlist' => '1',
                    'use_second_level' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'menu_2_indent',
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
                        '{{WRAPPER}} .dce-menu ul.second-level > li' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_childlist' => '1',
                    'use_second_level' => 'yes',
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
            'heading_level_2',
            [
                'label' => __( 'Level 2', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_childlist' => '1',
                    'use_second_level' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'menu_color_2',
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
                    '{{WRAPPER}} .dce-menu ul.second-level a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_childlist' => '1',
                    'use_second_level' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'menu_color_hover_2',
            [
                'label' => __( 'Text Hover Color', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'condition' => [
                    'show_childlist' => '1',
                    'use_second_level' => 'yes',
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dce-menu ul.second-level a:hover' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_list_2',

                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .dce-menu ul.second-level li',
                'condition' => [
                    'show_childlist' => '1',
                    'use_second_level' => 'yes',
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
                    'show_parent' => '1',
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
                    'show_parent' => '1',
                ],
                'default' => '',
                'selectors' => [
                        '{{WRAPPER}} .dce-menu .dce-parent-title a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'menu_title_color_hover',
            [
                'label' => __( 'Title Hover Color', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'default' => '',
                'selectors' => [
                        '{{WRAPPER}} .dce-menu .dce-parent-title a:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_parent' => '1',
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
                    'show_parent' => '1',
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

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_active_settings();
        if ( empty( $settings ) )
            return;

            /*$args = array(
            'post_type'         => 'page',
            'posts_per_page'    => -1,
            'order'             => 'ASC',
            'orderby'           => 'menu_order',
            'page_id'			=>  $settings['parentpage_select']
        );
        $p_query = new \WP_Query( $args );

        $counter = 0;
            echo '<ul class="title">';
            if ( $p_query->have_posts() ) : 
                            echo '<li>';
                            echo $settings['parentpage_select'];
                            echo '</li>';

            // End post check
        endif;*/
            /*$args = array(
            'sort_order' => 'desc',
            'sort_column' => 'menu_order',
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'meta_key' => '',
            'meta_value' => '',
            'authors' => '',
            'child_of' => 0,
            'parent' => -1,
            'exclude_tree' => '',
            'number' => '',
            'offset' => 0,
            'post_type' => 'page',
            'post_status' => 'publish'
        ); 
        $pages = get_pages($args); 
        $listPage = [];


        foreach ( $pages as $page ) {

            $children = get_children( 'post_parent='.$page->ID );
            $parents = get_post_ancestors( $page->ID );
            //
            if( !$parents && count($children) > 0 ) $listPage[$page->ID] = $page->post_title ;
          }*/

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

        //echo 'ID_demo: '.$demoPage .' - ID_global: '.$global_ID .' - ID_page: '.$id_page;

        if( !$settings['dynamic_parentchild']){
            $id_page = $settings['parentpage_select']; 
        }else{
            // se sono dinamico

            // ..se ho figli
            $ppid = wp_get_post_parent_id($id_page);
            //var_dump($ppid);
            if($ppid != 0){
                //
                if($settings['use_second_level']){
                    $ancestors = get_post_ancestors($id_page);
                    $root = count($ancestors)-1;
                    $parent = $ancestors[$root];
                    $id_page = $parent;
                }else{
                    $id_page = wp_get_post_parent_id($id_page);
                }
            }
            /*if ($post->post_parent) {
                $ancestors=get_post_ancestors($post->ID);
                $root=count($ancestors)-1;
                $parent = $ancestors[$root];
            } else {
                $parent = $post->ID;
            }*/
            //echo $id_page;
            // .. Se ho genitore

        }
        
        //echo 'ID_demo: '.$demoPage .' - ID_global: '.$global_ID .' - ID_page: '.$id_page;
        
        //$children = get_children( 'post_parent='.$settings['parentpage_select'].'&post_status=publish&order=ASC' );
        $exclude_io = array( );
        if(is_singular()){
            //echo 'ei: '.$settings['exclude_io'].' '.count($exclude_io);
            if($settings['exclude_io']) {
                $exclude_io = array( $id_page );
            }
        }else if( is_home() || is_archive() ){
            $exclude_io = array();
        }

        $children = get_children( 'post_parent='.$id_page.'&post_status=publish&order=ASC&' );

        $styleMenu = $settings['menu_style'];
        $clssStyleMenu = $styleMenu; 

        echo '<div class="dce-menu '.$clssStyleMenu.'">';
        if( $settings['show_border'] == 2  ) echo '<div class="box">';
        if ( $settings['show_parent'] ) {

            echo '<h4 class="dce-parent-title"><a href="'.get_permalink( $id_page ).'">'.get_the_title( $id_page ).'</a></h4>';
            if( $settings['show_border']  ) echo '<hr />';

        }
        if ( $settings['show_childlist'] ) {
            
            echo '<ul class="first-level">';
                foreach ( $children as $page ) {
                    if( $global_ID == $page->ID ){
                        $linkActive = ' class="active"';
                    }else{
                        $linkActive = '';
                    }
                    //echo $page->ID.' '.get_the_id();
                    if( !$settings['exclude_io'] || $page->ID != $global_ID /*get_the_id()*/ ){
                        if (($linkActive) || (!$linkActive && !$settings['no_siblings'])) {
                            echo '<li class="item-'.$page->ID.'">';
                            //var_dump($settings['only_children']);
                            if (!$settings['only_children']) {
                                echo '<a href="'.get_permalink( $page->ID ).'"'.$linkActive.'>'.$page->post_title.'</a>';
                            }
                            if($settings['use_second_level']){
                                $children2 = get_children( 'post_parent='.$page->ID.'&post_status=publish&order=ASC&' );
                                if( count( $children2 ) > 0 ){
                                    echo '<ul class="second-level">';
                                    foreach ( $children2 as $page2 ) {
                                        if( $global_ID == $page2->ID ){
                                            $linkActive = ' class="active"';
                                        }else{
                                            $linkActive = '';
                                        }
                                        echo '<li class="item-'.$page2->ID.'"><a href="'.get_permalink( $page2->ID ).'"'.$linkActive.'>'.$page2->post_title.'</a></li>';
                                    }
                                    echo '</ul>';
                                }
                            }
                            if (($linkActive) || (!$linkActive && !$settings['no_siblings'])) {
                                echo '</li>';
                            }
                        }
                    }
                }
                echo '</ul>';

            }
            if( $settings['show_border'] == 2  ) echo '</div>';
            echo '</div>';
    }

}