<?php
namespace DynamicContentForElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use DynamicContentForElementor\DCE_Helper;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Dynamic Content Title
 *
 * Elementor widget for Dynamic Content for Elementor
 *
 */
class DCE_Widget_TitleTaxonomy extends DCE_Widget_Prototype {

    public function get_name() {
        return 'dyncontel-titleTaxonomy';
    }
    
    static public function is_enabled() {
        return true;
    }

    public function get_title() {
        return __('Title Taxonomy', DCE_TEXTDOMAIN);
    }
    public function get_icon() {
        return 'eicon-type-tool';
    }

    protected function _register_controls() {

        $post_type_object = get_post_type_object(get_post_type());

        $this->start_controls_section(
            'section_titleTaxonomy', [
                'label' => __('Taxonomy Title', DCE_TEXTDOMAIN),
            ]
        );
        $this->add_control(
            'titleTaxonomy_text_before', [
                'label' => __('Text Before', DCE_TEXTDOMAIN),
                'description' => __('Un testo prima dell\'elemento', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );
        
        $this->add_control(
            'html_tag', [
                'label' => __('HTML Tag', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => __('H1', DCE_TEXTDOMAIN),
                    'h2' => __('H2', DCE_TEXTDOMAIN),
                    'h3' => __('H3', DCE_TEXTDOMAIN),
                    'h4' => __('H4', DCE_TEXTDOMAIN),
                    'h5' => __('H5', DCE_TEXTDOMAIN),
                    'h6' => __('H6', DCE_TEXTDOMAIN),
                    'p' => __('p', DCE_TEXTDOMAIN),
                    'div' => __('div', DCE_TEXTDOMAIN),
                    'span' => __('span', DCE_TEXTDOMAIN),
                ],
                'default' => 'h2',
            ]
        );

        $this->add_responsive_control(
            'align', [
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
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link_to', [
                'label' => __('Link to', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => __('None', DCE_TEXTDOMAIN),
                    'home' => __('Home URL', DCE_TEXTDOMAIN),
                    'archive' => 'Archive URL',
                    'custom' => __('Custom URL', DCE_TEXTDOMAIN),
                ],
            ]
        );

        $this->add_control(
            'link', [
                'label' => __('Link', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::URL,
                'placeholder' => __('http://your-link.com', DCE_TEXTDOMAIN),
                'condition' => [
                    'link_to' => 'custom',
                ],
                'default' => [
                    'url' => '',
                ],
                'show_label' => false,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style', [
                'label' => __('Title', DCE_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'color', [
                'label' => __('Text Color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dynamic-content-for-elementor-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .dynamic-content-for-elementor-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'scheme' => Scheme_Typography::TYPOGRAPHY_1,
            'selector' => '{{WRAPPER}} .dynamic-content-for-elementor-title',
                ]
        );

        $this->add_control(
                'hover_animation', [
            'label' => __('Hover Animation', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::HOVER_ANIMATION,
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if ( empty( $settings ) )
            return;

        $id_title = '';
        $titolo = '';
        $title = '';
        //
		if (!empty($global_ID)) {
            $id_title = $global_ID;
        }

        
        
        //--------------------------------------------
        //
		


        if (is_single() || is_page()) {
            $titolo = get_the_title($id_title);
            //$titolo = 'A';
        }else if (is_archive()) {
            // Archives
            //$titolo = get_the_archive_title($id_title);

            /*
            */

            /*$cptype_archive = get_post_type();
            $object_t = get_post_type_object( $cptype_archive )->labels;
            $label_t = $object_t->taxonomy;
            $titolo = $label_t;*/

            //$titolo = 'B';
            $queried_object = get_queried_object();
            //var_dump( $queried_object );
            //
            $titolo = $queried_object->taxonomy;

            /*$queried_object = get_queried_object();
            if( isset( $queried_object->taxonomy ){
                $titolo = $queried_object->taxonomy;
            }*/
        }

        // All other Taxonomies
        else if (is_tax()) {
            $titolo = single_term_title();
            //$titolo = 'C';
        } else {
            $titolo = get_the_title($id_title);
            //$titolo = 'D';
        }
        
        //$postTypeObj = get_post_type_object( $type_p );
        if ($settings['titleTaxonomy_text_before'] != "")
            $title .= '<span>' . __($settings['titleTaxonomy_text_before'], DCE_TEXTDOMAIN.'_texts') . '</span>';
        $title .= $titolo;
        

        // ----------------------------------------
        if (empty($title))
            return;



        switch ($settings['link_to']) {
            case 'custom' :
                if (!empty($settings['link']['url'])) {
                    $link = esc_url($settings['link']['url']);
                } else {
                    $link = false;
                }
                break;

            case 'archive' :
                //$link = esc_url(get_the_permalink($id_title));
                /*if ( is_tax() ) { 
                    $link = get_term_link( get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                }
                elseif( is_post_type_archive() ) {
                    $link = get_post_type_archive_link( get_query_var('post_type') );
                }
                else {
                    $link = get_permalink();
                }*/
                $link = get_post_type_archive_link( 'uomo' );
                break;

            case 'home' :
                $link = esc_url(get_home_url());
                break;

            case 'none' :
            default:
                $link = false;
                break;
        }



        $target = $settings['link']['is_external'] ? 'target="_blank"' : '';

        $animation_class = !empty($settings['hover_animation']) ? 'elementor-animation-' . $settings['hover_animation'] : '';

        $html = sprintf('<%1$s class="dynamic-content-for-elementor-title %2$s">', $settings['html_tag'], $animation_class);
        if ($link) {
            $html .= sprintf('<a href="%1$s" %2$s>%3$s</a>', $link, $target, $title);
        } else {
            $html .= $title;
        }
        $html .= sprintf('</%s>', $settings['html_tag']);

        echo $html;
    }

    protected function _content_template() {
        
    }

}
