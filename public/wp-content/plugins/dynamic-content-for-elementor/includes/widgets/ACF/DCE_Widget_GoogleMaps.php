<?php
namespace DynamicContentForElementor\Widgets;

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use DynamicContentForElementor\DCE_Helper;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Elementor ACF-GoogleMaps
 *
 * Elementor widget for Dynamic Content for Elementor
 *
 */

class DCE_Widget_GoogleMaps extends DCE_Widget_Prototype {

   public function get_name() {
      return 'dyncontel-acf-google-maps';
   }
   static public function is_enabled() {
       return true;
   }
   public function get_title() {
      return __('ACF Google Maps', DCE_TEXTDOMAIN);
   }
   public function get_description() {
      return __('Build a map using data from a Google Maps ACF', DCE_TEXTDOMAIN);
    }
    public function get_docs() {
        return 'https://www.dynamic.ooo/widget/acf-maps/';
    }
   public function get_icon() {
      return 'icon-dyn-map';
   }
   public function get_script_depends() {
      return [ 'dce-google-maps', 'dce-googlemaps-api'];
   }
   static public function get_position() {
        return 4;
    }
   /*public function get_style_depends() {
        return [ 'dce-acfGooglemap' ];
   }*/
   public function get_plugin_depends() {
        return array('advanced-custom-fields' => 'acf');
   }
   protected function _register_controls() {

      $this->start_controls_section(
         'section_map', [
            'label' => __('ACF Google Maps', DCE_TEXTDOMAIN),
         ]
      );
      $this->add_control(
         'acf_mapfield', [
            'label' => __('Map (ACF)', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT,
            'options' => $this->get_acf_field_relations(),
            'default' => '0',
         ]
      );
      $this->add_control(
         'map_data_type', [
            'label' => __('Data Type', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT,
            'default' => 'address',
            'options' => [
               'address' => __('Address', DCE_TEXTDOMAIN),
               'latlng' => __('Latitude Longitude', DCE_TEXTDOMAIN),
            ],
            'frontend_available' => true,
         ]
      );
      //$default_location = get_field('map_location',$global_ID);
      //$default_address = "Venezia";
      //if( !empty($default_location) ) $default_address = $default_location['address'];
      $this->add_control(
         'address', [
            'label' => __('Manual address', DCE_TEXTDOMAIN),
            'description' => __('Only works if the ACF field is not set', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::TEXT,
            //'placeholder' => $default_address,
            'default' => 'Venice', //$default_address,
            'label_block' => true,
            'readonly' => true,
            'condition' => [
                  'map_data_type' => 'address',
                  'acf_mapfield' => '0',
            ],
         ]
      );
      $this->add_control(
         'latitudine', [
            'label' => __('Manual Latitude', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::TEXT,
            //'placeholder' => $default_address,
            'default' => '45.4371908', //$default_address,
            'readonly' => true,
            'condition' => [
                  'map_data_type' => 'latlng',
                  'acf_mapfield' => '0',
            ],
         ]
      );
      $this->add_control(
         'longitudine', [
            'label' => __('Manual Longitude', DCE_TEXTDOMAIN),
            'description' => __('Only works if the ACF field is not set', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::TEXT,
            //'placeholder' => $default_address,
            'default' => '12.3345898', //$default_address,
            'readonly' => true,
            'condition' => [
                  'map_data_type' => 'latlng',
                  'acf_mapfield' => '0',
            ],
         ]
      );
      $this->add_control(
         'zoom', [
            'label' => __('Zoom Level', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SLIDER,
            'default' => [
               'size' => 10,
            ],
            'range' => [
               'px' => [
                  'min' => 1,
                  'max' => 20,
               ],
            ],
         'frontend_available' => true,
         ]
      );

      $this->add_responsive_control(
         'height', [
            'label' => __('Height', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SLIDER,
            'default' => [
               'unit' => 'px',
               'size' => 300,
            ],
            'tablet_default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'mobile_default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
               'px' => [
                  'min' => 40,
                  'max' => 1440,
               ],
            ],
            'selectors' => [
               '{{WRAPPER}} #el-wgt-map-{{ID}}' => 'height: {{SIZE}}{{UNIT}};',
            ],
            'frontend_available' => true,
         ]
      );

      $this->add_control(
         'prevent_scroll', [
            'label' => __('Scroll', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Yes', DCE_TEXTDOMAIN),
            'label_off' => __('No', DCE_TEXTDOMAIN),
            'render_type' => 'template',
            'frontend_available' => true,
         ]
      );

      $this->add_control(
         'view', [
            'label' => __('View', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::HIDDEN,
            'default' => 'traditional',
         ]
      );
      $this->end_controls_section();
      $this->start_controls_section(
         'section_mapMarker', [
            'label' => __('Marker', DCE_TEXTDOMAIN),
         ]
      );
      $this->add_control(
         'acf_markerfield', [
            'label' => __('Map (ACF)', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT,
            'options' => $this->get_acf_field_image(),
            'default' => '0',
         ]
      );
      $this->add_control(
         'imageMarker', [
            'label' => __('Marker Image', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => '', //'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
            ],
            'frontend_available' => true,
         ]
      );

      $this->end_controls_section();
      $this->start_controls_section(
         'section_mapStyles', [
            'label' => __('Styles', DCE_TEXTDOMAIN),
         ]
      );
      $this->add_control(
         'map_type', [
            'label' => __('Map Type', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT,
            'default' => 'roadmap',
            'options' => [
               'roadmap' => __('Roadmap', DCE_TEXTDOMAIN),
               'satellite' => __('Satellite', DCE_TEXTDOMAIN),
               'hybrid' => __('Hybrid', DCE_TEXTDOMAIN),
               'terrain' => __('Terrain', DCE_TEXTDOMAIN),
            ],
            'frontend_available' => true,
         ]
      );
      // --------------------------------- [ ACF Type of style ]
      $this->add_control(
         'style_select', [
            'label' => __('Style', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT,
            'options' => [
               '' => __('None', DCE_TEXTDOMAIN),
               'custom' => __('Custom', DCE_TEXTDOMAIN),
               'prestyle' => __('Snazzy Style', DCE_TEXTDOMAIN),
            ],
            'default' => '',
            'frontend_available' => true,
            'condition' => [
                  'map_type' => 'roadmap',
            ],
         ]
      );
      $this->add_control(
         'snazzy_select', [
            'label' => __('Snazzy Style', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT2,
            'options' => $this->snazzymaps(),
            'frontend_available' => true,
            'condition' => [
                  'map_type' => 'roadmap',
                  'style_select' => 'prestyle',
            ],
         ]
      );
      $this->add_control(
         'style_map', [
            'label' => __('Copy Snazzy Json Style Map', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('', DCE_TEXTDOMAIN),
            'description' => 'To better manage the graphic styles of the map go to: <a href="https://snazzymaps.com/" target="_blank">snazzymaps.com</a>',
            'frontend_available' => true,
            'condition' => [
                  'map_type' => 'roadmap',
                  'style_select' => 'custom',
            ],
         ]
      );
      $this->end_controls_section();
      $this->start_controls_section(
         'section_mapControls', [
            'label' => __('Controls', DCE_TEXTDOMAIN),
         ]
      );
      $this->add_control(
         'maptypecontrol', [
            'label' => __('Map Type Control', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Yes', DCE_TEXTDOMAIN),
            'label_off' => __('No', DCE_TEXTDOMAIN),
            'frontend_available' => true,
         ]
      );
      $this->add_control(
         'pancontrol', [
            'label' => __('Pan Control', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Yes', DCE_TEXTDOMAIN),
            'label_off' => __('No', DCE_TEXTDOMAIN),
            'frontend_available' => true,
            ]
        );

      $this->add_control(
         'rotatecontrol', [
            'label' => __('Rotate Control', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Yes', DCE_TEXTDOMAIN),
            'label_off' => __('No', DCE_TEXTDOMAIN),
            'frontend_available' => true,
         ]
      );
      $this->add_control(
         'scalecontrol', [
            'label' => __('Scale Control', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Yes', DCE_TEXTDOMAIN),
            'label_off' => __('No', DCE_TEXTDOMAIN),
            'frontend_available' => true,
         ]
      );
      $this->add_control(
         'streetviewcontrol', [
            'label' => __('Street View Control', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Yes', DCE_TEXTDOMAIN),
            'label_off' => __('No', DCE_TEXTDOMAIN),
            'frontend_available' => true,
         ]
      );
      $this->add_control(
         'zoomcontrol', [
            'label' => __('Zoom Control', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Yes', DCE_TEXTDOMAIN),
            'label_off' => __('No', DCE_TEXTDOMAIN),
            'frontend_available' => true,
         ]
      );
      $this->add_control(
         'fullscreenControl', [
            'label' => __('Full Screen Control', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Yes', DCE_TEXTDOMAIN),
            'label_off' => __('No', DCE_TEXTDOMAIN),
            'frontend_available' => true,
         ]
      );
      $this->end_controls_section();
      $this->start_controls_section(
         'section_cpt', [
            'label'         => __( 'Post Type Query', DCE_TEXTDOMAIN ),
         ]
      );
      // --------------------------------- [ Use Query post ]
      $this->add_control(
         'use_query', [
            'label'         => __( 'Use Query', DCE_TEXTDOMAIN ),
            'type'          => Controls_Manager::SWITCHER,
            'default'       => '',
            'label_on'      => __( 'Yes', DCE_TEXTDOMAIN ),
            'label_off'     => __( 'No', DCE_TEXTDOMAIN ),
            'return_value'  => 'yes',
            'frontend_available' => true,
         ]
      );
      // --------------------------------- [ Query Type ]
      $this->add_control(
         'query_type', [
            'label' => __( 'Query Type', DCE_TEXTDOMAIN ),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
               'get_cpt' => [
               'title' => 'Custom Post Type',
               'icon' => 'fa fa-files-o',
               ],
               'acf_relations' => [
                  'title' => 'ACF Relations',
                  'icon' => 'fa fa-american-sign-language-interpreting',
               ],
               'specific_posts' => [
                  'title' => 'From Specific Post',
                  'icon' => 'fa fa-list-ul',
               ]
            ],
            'default' => 'get_cpt',
            'condition' => [
               'use_query' => 'yes',
            ],
         ]
      );
      // --------------------------------- [ Custom Post Type ]
      $this->add_control(
         'post_type', [
            'label' => __('Post Type', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT,
            'options' => DCE_Helper::get_post_types(),
            'multiple' => true,
            'label_block' => true,
            'default' => 'post',
            'condition' => [
               'use_query' => 'yes',
               'query_type' => 'get_cpt',
            ],
         ]
      );
      $this->add_control(
            'taxonomy', [
                'label' => __('Taxonomy', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SELECT,
                //'options' => get_post_taxonomies( $post->ID ),
                'options' => [ '' => __('None', DCE_TEXTDOMAIN)] + get_taxonomies(array('public' => true)),
                'default' => '',
                'condition' => [
                   'use_query' => 'yes',
                   'query_type' => 'get_cpt',
                ],
            ]
        );
      $this->add_control(
            'category', [
                'label' => __('Terms ID', DCE_TEXTDOMAIN),
                'description' => __('Comma separated list of category ids', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                   'use_query' => 'yes',
                   'query_type' => 'get_cpt',
                ],
            ]
        );
      // --------------------------------- [ ACF relations ]
      $this->add_control(
         'acf_relationship', [
            'label' => __('Relations (ACF)', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT,
            //'options' => get_post_taxonomies( $post->ID ),
            'options' => $this->get_acf_field_relations(),
            'default' => '0',
            'condition' => [
                  'query_type' => 'acf_relations',
            ],
         ]
      );
      // --------------------------------- [ Specific Pages ]
      $this->add_control(
         'specific_pages', [
            'label' => __('Pages', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT2,
            'options' => DCE_Helper::get_pages(),
            'multiple' => true,
            'label_block' => true,
            'condition' => [
               'query_type' => 'specific_posts',
            ],
         ]
      );
      $this->end_controls_section();

      $this->start_controls_section(
            'section_dce_settings', [
                'label' => __('Dynamic content', DCE_TEXTDOMAIN),
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

              'options' => DCE_Helper::get_all_posts(),
              'default' => '',
              'condition' => [
                'data_source' => '',
              ],
            ]
        );
        $this->end_controls_section();
   }

   protected function render() {
      $settings = $this->get_settings_for_display();
      if (empty($settings))
         return;
      //
      // ------------------------------------------
        $demoPage = get_post_meta(get_the_ID(), 'demo_id', true);
        //
        $id_page = ''; //get_the_ID();
        $type_page = '';
        //
        if( $settings['data_source'] == 'yes' ){
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
        }else{
            $id_page = $settings['other_post_source'];
            $type_page = get_post_type($id_page);
        }
        // ------------------------------------------
      //

      $imageMarker = $settings['imageMarker'];
      //var_dump( $imageMarker );

      if( $settings['use_query'] == '' ){



        $map_data_type = $settings['map_data_type'];
        $indirizzo = $settings['address'];
        $lat = $settings['latitudine'];
        $lng = $settings['longitudine'];

        $location = get_field($settings['acf_mapfield'], $id_page);

        //$location = unserialize(get_post_meta( $id_page, $settings['acf_mapfield'], true ));
        //var_dump($location);
        //echo $id_page;
        if (!empty($location)){
           $indirizzo = $location['address'];
           $lat =  $location['lat'];
           $lng =  $location['lng'];
        }
        //$indirizzo = $location['address'];

        //echo $indirizzo;
        /*
           echo $settings['height']['size'];
           echo $settings['zoom']['size'];
        */
        //$location['address'] = $indirizzo;

        //echo $indirizzo;
        if (0 === absint($settings['zoom']['size']))
           $settings['zoom']['size'] = 10;

      }else{
        /* -------------------------- Query ------------------------ */
        // ARGS
        if( $settings['query_type'] == 'specific_posts'){
           $args = array(
              'post_type' => 'any',
              //'posts_per_page'    => -1,
              'post__in' => $settings['specific_pages'],
              'post_status'       => 'publish',
              'order_by' => 'post__in',
           );
           //acf_relationship
        }else if( $settings['query_type'] == 'acf_relations' ){
           $relations_ids = get_field($settings['acf_relationship'], $id_page, false);
           //$relations_ids = unserialize(get_post_meta( $id_page, $settings['acf_relationship'] ));
           if( !empty($relations_ids) ){
              $relations_type = get_post_type($relations_ids[0]);
              //echo $relations_type;
              $args = array(
                 'post_type'         => $relations_type,
                 'posts_per_page'    => -1,
                 'post__in'          => $relations_ids,
                 'post_status'       => 'publish',
                 'orderby'           => 'menu_order',
              );
           }
        }else if( $settings['query_type'] == 'get_cpt'){

          $terms_query = 'all';
          $taxquery =  array();
          if( $settings['category'] != '' ){
              $terms_query = explode( ',', $settings['category'] );
          }

          if( $settings['taxonomy'] != "" ) $taxquery =  array(
                                                              array(
                                                                  'taxonomy' => $settings['taxonomy'],
                                                                  'field' => 'id',
                                                                  'terms' => $terms_query
                                                              )
                                                          );


           $args = array(
              'post_type'         => $settings['post_type'],
              'posts_per_page'    => -1,
              'post_status'       => 'publish',
              'tax_query'         => $taxquery,
           );
        }
        // QUERY

        $p_query = new \WP_Query( $args );
        $counter = 0;
        //var_dump($args);
        if ( $p_query->have_posts() ) :


           /*while ( $p_query->have_posts() ) : $p_query->the_post();
            $id_page = get_the_ID();
            $map_field = get_field($settings['acf_mapfield']);

            echo '<br> a '.$map_field['address'];;

             endwhile;
           wp_reset_postdata();*/
           ?>
           <script>
           <?php
              echo 'var address_list = [';
              $separ = '';
              while ( $p_query->have_posts() ) : $p_query->the_post();

              $id_page = get_the_ID();

              $map_field = get_field($settings['acf_mapfield']);

              $indirizzo = $map_field['address'];
              $lat =  $map_field['lat'];
              $lng =  $map_field['lng'];
              //$map_field = get_post_meta( $id_page, $settings['acf_mapfield'] );
              $marker_img = get_field($settings['acf_markerfield']);
              if($marker_img == '') $marker_img = $imageMarker['url'];
              //$marker_img = get_post_meta( $id_page, $settings['acf_markerfield'] );

              if( $counter > 0 ) $separ = ', ';
              if( !empty($map_field) ){
                 echo $separ;
                 echo '{"address":"'.$indirizzo.'",';
                 echo '"lat":"'.$lat.'",';
                 echo '"lng":"'.$lng.'",';
                 echo '"marker":"'.$marker_img.'"}';
                 //var_dump($map_field);
                 $counter++;
              }
              endwhile;
              echo '];'
              ?>
           </script>
           <?php
              // Reset the post data to prevent conflicts with WP globals
              wp_reset_postdata();
           endif;
           /* ----------------------------------------------------------------- END Query */
        } // end if use_query
         ?>

      <style>
         #el-wgt-map-<?php echo $this->get_id(); ?>{
            width: 100%;
            background-color: #ccc;
         }
      </style>
      <span id="debug"></span>

      <div id="el-wgt-map-<?php echo $this->get_id(); ?>" data-address="<?php echo $indirizzo; ?>" data-lat="<?php echo $lat; ?>" data-lng="<?php echo $lng; ?>" data-imgmarker="<?php echo $imageMarker['url']; ?>">
      </div>
   <?php
   }
   protected function _content_template() {

   }
   protected function get_acf_field_relations() {
      $acfList = [];
      $acfList[0] = 'Select the Field';
      $tipo = 'acf-field';
      $get_templates = get_posts(array('post_type' => $tipo, 'numberposts' => -1, 'post_status' => 'publish'));
      if (!empty($get_templates)) {
         foreach ($get_templates as $template) {
            $gruppoAppartenenza = $template->post_parent;
            $arrayField = maybe_unserialize($template->post_content);
            if ($arrayField['type'] == 'google_map') {
               $acfList[$template->post_excerpt] = $template->post_title . '(' . $arrayField['type'] . ')'; //.$template->post_content; //post_name,
            }
         }
      }
      return $acfList;
   }
   protected function get_acf_field_image() {
      $acfList = [];
      $acfList[0] = 'Select the Field';
      $tipo = 'acf-field';
      $get_templates = get_posts(array('post_type' => $tipo, 'numberposts' => -1, 'post_status' => 'publish'));
      if (!empty($get_templates)) {
         foreach ($get_templates as $template) {
            $gruppoAppartenenza = $template->post_parent;
            $arrayField = maybe_unserialize($template->post_content);
            if ($arrayField['type'] == 'image') {
               $acfList[$template->post_excerpt] = $template->post_title . '(' . $arrayField['type'] . ')'; //.$template->post_content; //post_name,
            }
         }
      }
      return $acfList;
   }
   protected function snazzymaps(){
      $snazzy_list = [];
      $snazzy_styles = glob(DCE_PATH.'assets/maps_style/*.json');
      if (!empty($snazzy_styles)) {
        foreach ($snazzy_styles as $key => $value) {
          $snazzy_name = basename($value);
          $snazzy_name = str_replace('.json', '', $snazzy_name);
          $snazzy_name = str_replace('_', ' ', $snazzy_name);
          $snazzy_name = ucfirst($snazzy_name);
          $snazzy_url = str_replace('.json', '', $value);
          $snazzy_url = str_replace(DCE_PATH, DCE_URL, $snazzy_url);
          $snazzy_list[$snazzy_url] = $snazzy_name;
        }
      }
      // ciclo la cartellina maps_style in assets e ricavo la lista dei files ....
      //$snazzy_list[DCE_URL.'assets/maps_style/extra_light'] = 'Extra Light';
      //$snazzy_list[DCE_URL.'assets/maps_style/extra_black'] = 'Extra black';

      return $snazzy_list;

   }
}