<?php

namespace DynamicContentForElementor\Extensions;

use Elementor\Controls_Manager;
use DynamicContentForElementor\Controls\DCE_Group_Control_Animation_Element;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 *
 * Animations Effects
 *
 */

class DCE_Extension_Animations extends DCE_Extension_Prototype {
    
    public $name = 'Animations';

    protected $is_common = true;

    public static function get_description() {
        return __('Predefined CSS-Animations with keyframe.');
    }

    private function add_controls($element, $args) {

        $element_type = $element->get_type();

        $element->add_group_control(
                DCE_Group_Control_Animation_Element::get_type(), [
            'name' => 'animate_image',
            'selector' => '{{WRAPPER}} .elementor-widget-container',
                ]
        );
        
    }

    protected function add_actions() {

        // Activate controls for widgets
        add_action('elementor/element/common/dce_section_animations_advanced/before_section_end', function( $element, $args ) {
            $this->add_controls($element, $args);
        }, 10, 2);
        
    }

}
