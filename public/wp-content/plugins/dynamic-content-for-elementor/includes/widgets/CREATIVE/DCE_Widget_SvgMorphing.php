<?php
namespace DynamicContentForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Repeater;
use DynamicContentForElementor\DCE_Helper;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Elementor SVG Morphing
 *
 * Elementor widget for Dynamic Content Elements
 *
 */
class DCE_Widget_SvgMorphing extends DCE_Widget_Prototype {

    public function get_name() {
        return 'dyncontel-svgmorphing';
    }
    static public function is_enabled() {
        return false;
    }
    public function get_title() {
        return __('SVG Morphing', DCE_TEXTDOMAIN);
    }
    public function get_icon() {
        return 'icon-dyn-svgmorph';
    }
    public function get_script_depends() {
        return [ 'dce-svgmorph' ];
    }
    public function get_style_depends() {
        return [ ];
    }
    static public function get_position() {
        return 7;
    }
    protected function _register_controls() {
        $this->start_controls_section(
                'section_creative_svg', [
                'label' => __('SVG', DCE_TEXTDOMAIN),
            ]
        );
        

        $svg_shapes = array(
            'path'      =>  'path',
            //'polygon'   =>  'polygon',
            'polyline'  =>  'polyline',
        );
        $this->add_control(
            'type_of_shape', [
                'label' => __('Type of Shape', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'options' => $svg_shapes, //get_taxonomies(array('public' => true)),
                'default' => 'path',
                'description' => __('Type of SVG sequence', DCE_TEXTDOMAIN),
                'frontend_available' => true,
                'label_block' => true,
            ]
        );
        $this->add_control(
            'viewBox_heading',
            [
                'label' => __( 'SVG ViewBox', DCE_TEXTDOMAIN ),
                'description' => __( 'La dimensione in PIXEL del documento su cui hai disegnato le forme', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
          'viewbox_width',
          [
            'label'   => __( 'Width', DCE_TEXTDOMAIN ),
            'type'    => Controls_Manager::NUMBER,
            'label_block' => false,
            'default' => 600,
            'min'     => 100,
            'max'     => 2000,
            'step'    => 1,
          ]
        );
        $this->add_control(
          'viewbox_height',
          [
            'label'   => __( 'Height', DCE_TEXTDOMAIN ),
            'type'    => Controls_Manager::NUMBER,
            'label_block' => false,
            'default' => 600,
            'min'     => 100,
            'max'     => 2000,
            'step'    => 1,
             
          ]
        );
        $this->add_responsive_control(
            'svg_width', [
                'label' => __('Content Width', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'separator' => 'before',
                'default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'size_units' => ['px', '%'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 0.1
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 3500,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} svg.dce-svg-morph' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'svg_height', [
                'label' => __('Content Height', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'size_units' => ['px', '%'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 0.1
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 2000,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} svg.dce-svg-morph' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
        'svg_align',
            [
                'label' => __( 'Alignment', DCE_TEXTDOMAIN ),
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
                'prefix_class' => 'align-',
                'default' => 'left',
                'selectors' => [
                     '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        // Loop
        // Direction
        // easing

        $repeater = new \Elementor\Repeater();
        $chid = $repeater->get_name();

        //$rrr = $repeater->get_name();
        
        $repeater->add_control(
            'id_shape', [
                'label' => 'ID',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'shape-',
              
            ]
        );
         $repeater->add_control(
          'shape_numbers',
          [
             'label'   => __( 'Numbers', DCE_TEXTDOMAIN ),
             'type'    => Controls_Manager::TEXTAREA,
             'default' => '',

          ]
        );
        $repeater->add_control(
            'fill_color',
            [
                'label' => __( 'Fill Color', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'default' => '#CCCCCC',
                'separator' => 'before',
                
                
            ]
        );
        $repeater->add_control(
            'stroke_color',
            [
                'label' => __( 'Stroke Color', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'separator' => 'before',
                
            ]
        );
        $repeater->add_control(
            'stroke_width',
            [
                'label' => __( 'Stroke Width', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                        'step' => 1,
                    ],
                ],
                'separator' => 'before',
                'label_block' => false,
            ]
        );
        /*$repeater->add_control(
            'x_position',
            [
                'label' => __( 'X position', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => [ 'px', '%' ],
                'separator' => 'before'
                
            ]
        );
         $repeater->add_control(
            'y_position',
            [
                'label' => __( 'Y position', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => [ 'px', '%' ],
                
            ]
        );
        $repeater->add_control(
            'scale',
            [
                'label' => __( 'Scale', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'min' => 0.01,
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'render_type' => 'none',
                'separator' => 'before',
                
            ]
        );
        $repeater->add_control(
            'rotate',
            [
                'label' => __( 'Rotate', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 360,
                        'step' => 1,
                    ],
                ],
                'separator' => 'before',
                
            ]
        );*/
        
        $this->end_controls_section();

        $this->start_controls_section(
                    'section_svg_animations', [
                    'label' => __( 'Animations', DCE_TEXTDOMAIN ),
                ]
            );
        $this->add_control(
            'playpause_control',
            [
                'label' => __('Animation Controls', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'running',
                'description' => __('In pause mode it is possible to shape the shapes. In Play you can manage the animation between one scene and another.', DCE_TEXTDOMAIN),
                'toggle' => false,
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
                'frontend_available' => true,
                'separator' => 'before',
                'render_type' => 'template'
            ]
        );
        $this->add_control(
            'speed_morph',
            [
                'label' => __( 'Speed', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 2000,
                ],
                'range' => [
                    'px' => [
                        'min' => 500,
                        'max' => 5000,
                        'step' => 1,
                    ],
                ],
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'duration_morph',
            [
                'label' => __( 'Duration of morphing', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1000,
                ],
                'range' => [
                    'px' => [
                        'min' => 300,
                        'max' => 5000,
                        'step' => 1,
                    ],
                ],
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'delay_morph',
            [
                'label' => __( 'Delay animation', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                        'step' => 1,
                    ],
                ],
                'frontend_available' => true,
            ]
        );
         $this->add_control(
            'easing_kute', [
                'label' => __('Easing function', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'options' => DCE_Helper::get_kute_timingFunctions(),
                'default' => 'easingQuinticInOut',
                'description' => __('Animation Equation', DCE_TEXTDOMAIN),
                'frontend_available' => true,
                'label_block' => true,
                'condition' => [
                    'type_of_shape' => 'path',
                ],
            ]
        );
        $this->add_control(
            'easing_morph', [
                'label' => __('Easing function', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'options' => DCE_Helper::get_ease_timingFunctions(),
                'default' => 'easeInOutQuint',
                'description' => __('Animation Equation', DCE_TEXTDOMAIN),
                'frontend_available' => true,
                'label_block' => true,
                'condition' => [
                    'type_of_shape' => ['polygon','polyline'],
                ],
            ]
        );
        $this->end_controls_section();
        // var_dump( $repeater->get_controls() );
        //
        $count = 0;
        foreach ($svg_shapes as $svgs) {
            //
            if( $svgs == 'polygon' ){
                $default_shape = [
                            [
                                'id_shape' => __( $svgs.'_1', DCE_TEXTDOMAIN ),
                                'shape_numbers' => '700,84.4 1047.1,685.6 352.9,685.6 352.9,685.6 352.9,685.6 352.9,685.6'
                            ],
                            [
                                'id_shape' => __( $svgs.'_2', DCE_TEXTDOMAIN ),
                                'shape_numbers' => '983.4,101.6 983.4,668.4 416.6,668.4 416.6,101.9 416.6,101.9 416.6,101.9'
                            ],
                            [
                                'id_shape' => __( $svgs.'_3', DCE_TEXTDOMAIN ),
                                'shape_numbers' => '890.9,54.3 1081.8,385 890.9,715.7 509.1,715.7 318.2,385 509.1,54.3'
                            ],
                            [
                                'id_shape' => __( $svgs.'_4', DCE_TEXTDOMAIN ),
                                'shape_numbers' => '983.4,101.6 779,385 983.4,668.4 416.6,668.4 611,388 416.6,101.9'
                            ],
                        ];
            }else if( $svgs == 'path' ){
                $default_shape = [
                            [
                                'id_shape' => __( $svgs.'_1', DCE_TEXTDOMAIN ),
                                'shape_numbers' => 'M438.7,254.2L587,508.4H293.5H0l148.3-254.2L293.5,0L438.7,254.2z'
                            ],
                            [
                                'id_shape' => __( $svgs.'_2', DCE_TEXTDOMAIN ),
                                'shape_numbers' => 'M600,259.8L450,519.6H150L0,259.8L150,0h300L600,259.8z'
                            ],
                            [
                                'id_shape' => __( $svgs.'_3', DCE_TEXTDOMAIN ),
                                'shape_numbers' => 'M568,568H0l172.5-284L0,0h568L395.5,287L568,568z'
                            ],
                            [
                                'id_shape' => __( $svgs.'_4', DCE_TEXTDOMAIN ),
                                'shape_numbers' => 'M568,568H0l1.7-284L0,0h568l-1.7,287L568,568z'
                            ],
                        ];
            }else if( $svgs == 'polyline' ){
                $default_shape = [
                            [
                                'id_shape' => __( $svgs.'_1', DCE_TEXTDOMAIN ),
                                'shape_numbers' => '0.3,131.7 142.3,42.7 210.3,239.7 265.3,8.7 307.3,220.7 378.3,1.7 443.3,232.7 554.3,175.7 '
                            ],
                            [
                                'id_shape' => __( $svgs.'_2', DCE_TEXTDOMAIN ),
                                'shape_numbers' => '0.2,103.2 157.2,190.2 211.2,65.2 269.2,160.2 361.2,1.2 438.2,227.2 488.2,30.2 554.2,147.2 '
                            ],
                            
                        ];
            }
            $this->start_controls_section(
                    'section_svg_'.$svgs, [
                    'label' => $svgs,
                    'condition' => [
                        'type_of_shape' => $svgs,
                    ],
                ]
            );
            $this->add_control(
                'repeater_shape_'.$svgs,
                [
                    'label' => __( 'Shape '.$svgs, DCE_TEXTDOMAIN ),
                    'type' => Controls_Manager::REPEATER,
                    'default' => $default_shape,
                    'fields' => $repeater->get_controls(),
                    'title_field' => '{{{ id_shape }}}',
                    'frontend_available' => true,
                    
                ]
            );
            $this->end_controls_section();
            $count ++;
        } // end foreach
        
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if ( empty( $settings ) )
            return;
        //echo $settings['type_of_shape'];

        $keyVector = 'd'; //'d' -> path, 'points' -> polyline
        if($settings['type_of_shape'] == 'polygon' || $settings['type_of_shape'] == 'polyline') $keyVector = 'points'; // -> Polygon

        ?>
        <div class="dce-svg-morph-wrap">

             <svg id="dce-svg-<?php echo $this->get_id(); ?>" class="dce-svg-morph" data-morphid="0" data-run="<?php echo $settings['playpause_control'] ?>" version="1.1" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 <?php echo $settings['viewbox_width']; ?> <?php echo $settings['viewbox_height']; ?>" preserveAspectRatio="xMidYMid meet">
            <!-- <svg id="dce-svg" class="dce-svg-morph"> -->
                <<?php echo $settings['type_of_shape'] ?> id="forma-<?php echo $this->get_id(); ?>" fill="<?php echo $settings['repeater_shape_'.$settings['type_of_shape']][0]['fill_color'] ?>" stroke-width="<?php echo $settings['repeater_shape_'.$settings['type_of_shape']][0]['stroke_width']['size']; ?>" stroke="<?php echo $settings['repeater_shape_'.$settings['type_of_shape']][0]['stroke_color']; ?>" stroke-miterlimit="10" <?php echo $keyVector ?>="<?php echo $settings['repeater_shape_'.$settings['type_of_shape']][0]['shape_numbers']; ?>"/>
                Sorry, your browser does not support inline SVG.
            </svg>
            <?php 
            //var_dump($settings['repeater_shape_'.$settings['type_of_shape']][0]); ?>
        </div>
        <style>
        .dce-svg-morph{
            width: 100%;
        }
        </style>
        <?php
        //viewBox="0 0 100 100" preserveAspectRatio="xMidYMin slice"
        /*$fileSvg = $settings['svg_file'];
        $fileSvg_url = $fileSvg['url'];
        $tag = 'div';

        echo $fileSvg_url;
        $this->add_render_attribute( 'wrapper', 'class', 'dce-creative-svg' );
        $this->add_render_attribute( 'svg', 'class', 'dce-svg' );

        printf( '<div %1$s>', $this->get_render_attribute_string( 'wrapper' ) );
        if ( ! empty( $fileSvg_url ) ) { 
            echo 'ok svg';
            ?>
           <<?php echo $tag ?> <?php echo $this->get_render_attribute_string( 'svg' ); ?>></<?php echo $tag; ?>>
        <?php } 
        */
    }
    protected function _content_template() {
        ?>
        <#
        //console.log(editSettings);
        var currentItem     = ( editSettings.activeItemIndex >= 0 ) ? editSettings.activeItemIndex : false;
        
        //alert(currentItem);

        //var widgetId = view.$el.data('morphid');
        var morphid = ( currentItem ) ? currentItem-1 : 0; 
        //alert('-> '+morphid);

        var idWidget = id;
        
        var viewBoxW = settings.viewbox_width;
        var viewBoxH = settings.viewbox_height;
        var typeShape = settings.type_of_shape;
        var runAnimation = settings.playpause_control;
        
        //alert(idWidget);
        eval('var shapeNumbers = settings.repeater_shape_'+typeShape+';'); 

        var indexShape = 0;
        if(morphid){
            indexShape = morphid;
        }
        //alert(shapeNumbers.length);
        if(shapeNumbers != undefined && shapeNumbers.length){
            var firstShape = shapeNumbers[indexShape]['shape_numbers'] || '';
            var firstFill = shapeNumbers[indexShape]['fill_color'] || '#ccc';
            var firstStrokeColor = shapeNumbers[indexShape]['stroke_color'] || '#000';
            var firstStrokeWidth = shapeNumbers[indexShape]['stroke_width']['size'] || 0;

            var keyVector = 'd';
            if(typeShape == 'polygon' || typeShape == 'polyline') keyVector = 'points';
            //alert(firstStrokeWidth);
            #>
            <div class="dce-svg-morph-wrap">
               <!--  <div>{{morphid}}</div> -->
                 <svg id="dce-svg-{{idWidget}}" class="dce-svg-morph" data-run="{{runAnimation}}" data-morphid="{{morphid}}" version="1.1" xmlns="http://www.w3.org/2000/svg" stroke-miterlimit="10" viewBox="0 0 {{viewBoxW}} {{viewBoxW}}" preserveAspectRatio="xMidYMid meet">
                <!-- <svg id="dce-svg" class="dce-svg-morph"> -->
                    <{{typeShape}} id="forma-{{idWidget}}" fill="{{firstFill}}" stroke-width="{{firstStrokeWidth}}" stroke="{{firstStrokeColor}}" {{keyVector}}="{{firstShape}}"/>
                    Sorry, your browser does not support inline SVG.
                </svg>
            </div>
        <# } #>
        <?php /* ?>
        <# if ( settings.list.length ) { #>
        <dl>
            <# _.each( settings.list, function( item ) { #>
                <dt class="elementor-repeater-item-{{ item._id }}">{{{ item.list_title }}}</dt>
                <dd>{{{ item.list_content }}}</dd>
            <# }); #>
            </dl>
        <# } #>
        <?php */
    }
}