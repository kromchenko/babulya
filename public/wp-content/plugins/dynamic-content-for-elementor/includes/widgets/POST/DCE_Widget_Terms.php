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
 * Elementor Posts-Terms
 *
 * Elementor widget for Dynamic Content for Elementor
 *
 */
class DCE_Widget_Terms extends DCE_Widget_Prototype {

    public function get_name() {
        return 'dyncontel-terms';
    }
    
    static public function is_enabled() {
        return true;
    }

    public function get_title() {
        return __('Terms & Taxonomy', DCE_TEXTDOMAIN);
    }
    public function get_description() {
      return __('Write a taxonomy for your article', DCE_TEXTDOMAIN);
    }
    public function get_docs() {
        return 'https://www.dynamic.ooo/widget/terms-and-taxonomy/';
    }
    public function get_icon() {
        return 'icon-dyn-terms';
    }
    static public function get_position() {
        return 3;
    }
    protected function _register_controls() {

        $this->start_controls_section(
            'section_content', [
              'label' => __('Terms', DCE_TEXTDOMAIN),
            ]
        );
        $this->add_control(
            'taxonomy', [
              'label' => __('Taxonomy', DCE_TEXTDOMAIN),
              'type' => Controls_Manager::SELECT,
              //'options' => get_post_taxonomies( $post->ID ),
              'options' => [ 'auto' => __('Dynamic', DCE_TEXTDOMAIN)] + get_taxonomies(array('public' => true)),
              'default' => 'category',
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
              'default' => 'div',
            ]
        );
        $this->add_control(
          'separator', [
            'label' => __('Separator', DCE_TEXTDOMAIN),
            //'description' => __('Separator caracters.',DCE_TEXTDOMAIN),
            'type' => Controls_Manager::TEXT,
            'default' => ', ',
          ]
        );
        $this->add_responsive_control(
            'space', [
                'label' => __('Space', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'size_units' => [ 'px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .dce-separator' => 'padding: 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'text_before', [
                'label' => __('Text before', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );
        $this->add_control(
            'text_after', [
                'label' => __('Text after', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::TEXT,
                'default' => '',
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
                'term' => __('Term', DCE_TEXTDOMAIN),
            ],
          ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
          'section_style', [
            'label' => __('Terms', DCE_TEXTDOMAIN),
            'tab' => Controls_Manager::TAB_STYLE,
          ]
        );
        $this->add_control(
          'color', [
            'label' => __('Text Color', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::COLOR,
            
            'selectors' => [
                '{{WRAPPER}} .dce-terms' => 'color: {{VALUE}};',
                '{{WRAPPER}} .dce-terms a' => 'color: {{VALUE}};',
            ],
          ]
        );
        $this->add_control(
          'color_hover', [
            'label' => __('Text Color Hover', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::COLOR,
            
            'selectors' => [
                '{{WRAPPER}} .dce-terms a:hover' => 'color: {{VALUE}};',
            ],
          ]
        );
        $this->add_control(
          'color_separator', [
            'label' => __('Separator color', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::COLOR,
            
            'selectors' => [
                '{{WRAPPER}} .dce-separator' => 'color: {{VALUE}};',
            ],
          ]
        );
        $this->add_group_control(
          Group_Control_Typography::get_type(), [
            'name' => 'typography',
            'selector' => '{{WRAPPER}} .dce-terms',
            
          ]
        );
        $this->add_control(
          'hover_animation', [
            'label' => __('Hover Animation', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::HOVER_ANIMATION,
            'condition' => [
                'link_to!' => 'none',
            ],
          ]
        );

        /* ------------------ Text Before ------------ */
        $this->add_control(
            'txbefore_heading',
            [
                'label' => __( 'Text before', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'text_before!' => '',
                ]
            ]
        );
        $this->add_control(
            'tx_before_color', [
                'label' => __('Text Before Color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dce-terms span.tx-before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .dce-terms a span.tx-before' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'text_before!' => '',
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_tx_before',
                'label' => __('Font Before', DCE_TEXTDOMAIN),
                'selector' => '{{WRAPPER}} .dce-terms span.tx-before',
                'condition' => [
                    'text_before!' => '',
                ]
            ]
        );
        
        

        /* ------------------ Text After ------------ */
        $this->add_control(
            'txafter_heading',
            [
                'label' => __( 'Text after', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'text_after!' => '',
                ]
            ]
        );
        $this->add_control(
            'tx_after_color', [
                'label' => __('Text After Color', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .dce-terms span.tx-after' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .dce-terms a span.tx-after' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'text_after!' => '',
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'typography_tx_after',
                'label' => __('Font After', DCE_TEXTDOMAIN),
                'selector' => '{{WRAPPER}} .dce-terms span.tx-after',
                'condition' => [
                    'text_after!' => '',
                ]
            ]
        );
        $this->end_controls_section();
        // ------------------------------------------------ SETTINGS 
        $this->start_controls_section(
            'section_dce_settings', [
                'label' => __('Dynamic Content', DCE_TEXTDOMAIN),
                'tab' => Controls_Manager::TAB_SETTINGS,
            ]
        );
         $this->add_control(
            'data_source',
            [
              'label' => __( 'Source', DCE_TEXTDOMAIN ),
              'description' => __( 'Select the data source', DCE_TEXTDOMAIN ),
              'type' => Controls_Manager::SWITCHER,
              'default' => 'yes',
              'label_on' => __( 'Same', DCE_TEXTDOMAIN ),
              'label_off' => __( 'other', DCE_TEXTDOMAIN ),
              'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'other_post_source', [
              'label' => __('Select from other source post', DCE_TEXTDOMAIN),
              'type' => Controls_Manager::SELECT,
              
              'groups' => DCE_Helper::get_all_posts(get_the_ID(),true),
              'label_block' => true,
              'default' => '',
              'condition' => [
                'data_source' => '',
              ], 
            ]
        );
        /*$this->add_control(
          'go_to_page',
          [
             'type'    => Controls_Manager::RAW_HTML,
             'raw' => '<a target="_blank" class="dce-go-to-page-template dce-btn" href="#">
                <i class="fa fa-pencil"></i>'. __( 'Edit Page', DCE_TEXTDOMAIN ).'</a>',
             'content_classes' => 'dce-btn-go-page',
             'separator' => 'after',
             //'render_type' => 'template',
             'condition' => [
                    'other_post_source!' => '',
                ],
          ]
        );*/
        /*$this->add_control(
            'mod_page',
            [
                'type' => Controls_Manager::BUTTON,
                'label' => __( 'Modify', DCE_TEXTDOMAIN ),
                'label_block' => true,
                'show_label' => false,
                'text' => __( 'View page', DCE_TEXTDOMAIN ),
                'separator' => 'none',
                'event' => 'dceMain:previewPage',
                'condition' => [
                    'other_post_source!' => 0,
                    'data_source' => '',
                ],
            ]
        );*/
        $this->end_controls_section();
    }

    protected function render() {
      $settings = $this->get_settings_for_display();
      if ( empty( $settings ) )
          return;
      //
      // ------------------------------------------
      $dce_data = DCE_Helper::dce_dynamic_data($settings['other_post_source']);
      $id_page = $dce_data['id'];
      $global_is = $dce_data['is'];
      // ------------------------------------------

      $taxonomy = $settings['taxonomy'];
      $taxonomyAuto = [];

      if ( empty( $taxonomy ) )
        return;

      if( $taxonomy  == 'auto') {
      
        $taxonomyAuto = get_post_taxonomies($id_page);
      
      }else{

        $taxonomyAuto = $taxonomy;

      };
      $animation_class = ! empty( $settings['hover_animation'] ) ? 'elementor-animation-' . $settings['hover_animation'] : '';
      $html = '';
      if( is_array($taxonomyAuto) ) {
        
        /*$term_list = array();
        foreach ( $taxonomyAuto as $taxo ) {
         echo $taxo;
          $autoTerms = get_the_terms( $id_page, $taxo );
          $tmpTerm = $term_list;
          foreach ( $autoTerms as $t ) {
            $term_list = array_push($term_list, $t);
           }
          //$term_list = array_merge($autoTerms, $tmpTerm);
        }*/
        $term_list = \DynamicContentForElementor\DCE_Helper::get_the_terms_ordered( $id_page/*$post->ID*/, reset($taxonomyAuto) );

      }else{
        $term_list = \DynamicContentForElementor\DCE_Helper::get_the_terms_ordered( $id_page/*$post->ID*/, $taxonomyAuto );
      }
      if ( empty( $term_list ) || is_wp_error( $term_list ) ){
        if ( is_admin() ) {
          $html = sprintf( '<%1$s class="dce-terms %2$s">', $settings['html_tag'], $animation_class );
          $html .= '<a href="#">Term</a><span class="dce-separator">'.$settings['separator'].'</span>';
          $html .= '<a href="#">Term</a><span class="dce-separator">'.$settings['separator'].'</span>';
          $html .= '<a href="#">Term</a>';
          $html .= sprintf( '</%s>', $settings['html_tag'] );
          echo $html;
        }

        return;
      }else{
        //$html = sprintf( '<%1$s class="dce-terms %2$s">', $settings['html_tag'], $animation_class );
        
        
        $separator = '';
        $conta = 0;


        $html = sprintf( '<%1$s class="dce-terms %2$s">', $settings['html_tag'], $animation_class );

        if($settings['text_before'] != "" || $settings['text_after'] != "") $html .= '<span class="tx-before">'.__($settings['text_before'], DCE_TEXTDOMAIN.'_texts').'</span>';
        //echo 'terms: ';
        switch ( $settings['link_to'] ) {
          case 'term' :
            foreach ( $term_list as $term ) {

              if($conta > 0) $html .= '<span class="dce-separator">'.$settings['separator'].'</span>';
              $html .= sprintf( '<a href="%1$s" class="term%3$s">%2$s</a>', esc_url( get_term_link( $term ) ), $term->name, $term->term_id);
              $conta ++;
            }
            break;

          case 'none' :
          default:
            foreach ( $term_list as $term ) {
              if($conta > 0) $html .= '<span class="dce-separator">'.$settings['separator'].'</span>';
              $html .= sprintf( '<span class="term%1$s">%2$s</span>', $term->term_id, $term->name );

              $conta ++;
            }
            break;
        }
        $html .= sprintf( '</%s>', $settings['html_tag'] );
      }
      //$html = substr( $html, 0, -2);
      

      echo $html;
    //}
    }

    protected function _content_template() {
        global $post;
        /*
          ?>
          <#
          var taxonomy = settings.taxonomy;

          var all_terms = [];
          <?php
          $taxonomies = get_taxonomies( array( 'public' => true ) );
          foreach ( $taxonomies as $taxonomy ) {
          printf( 'all_terms["%1$s"] = [];', $taxonomy );
          $terms = get_the_terms( $post->ID, $taxonomy );
          if ( $terms ) {
          $i = 0;
          foreach ( $terms as $term ) {
          printf( 'all_terms["%1$s"][%2$s] = [];', $taxonomy, $i );
          printf( 'all_terms["%1$s"][%2$s] = { slug: "%3$s", name: "%4$s", url: "%5$s" };', $taxonomy, $i, $term->slug, $term->name, esc_url( get_term_link( $term ) ) );
          $i++;
          }
          }
          }
          ?>
          var post_terms = all_terms[ settings.taxonomy ];

          var terms = '';
          var i = 0;

          switch( settings.link_to ) {
          case 'term':
          while ( all_terms[ settings.taxonomy ][i] ) {
          terms += "<a href='" + all_terms[ settings.taxonomy ][i].url + "'>" + all_terms[ settings.taxonomy ][i].name + "</a>, ";
          i++;
          }
          break;
          case 'none':
          default:
          while ( all_terms[ settings.taxonomy ][i] ) {
          terms += all_terms[ settings.taxonomy ][i].name + ", ";
          i++;
          }
          break;
          }
          terms = terms.slice(0, terms.length-2);

          var animation_class = '';
          if ( '' !== settings.hover_animation ) {
          animation_class = 'elementor-animation-' + settings.hover_animation;
          }

          var html = '<' + settings.html_tag + ' class="dce-terms ' + animation_class + '">';
          html += terms;
          html += '</' + settings.html_tag + '>';

          print( html );
          #>

          <?php
         */
    }

}
