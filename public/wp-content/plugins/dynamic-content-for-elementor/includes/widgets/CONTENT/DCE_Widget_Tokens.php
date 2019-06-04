<?php

namespace DynamicContentForElementor\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;

use Elementor\Controls_Manager;

use DynamicContentForElementor\DCE_Helper;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Elementor Tokens
 *
 * Elementor widget for Dinamic Content Elements
 *
 */

class DCE_Widget_Tokens extends DCE_Widget_Prototype {

    public function get_name() {
        return 'dce-tokens';
    }
    
    static public function get_position() {
        return 6;
    }

    static public function is_enabled() {
        return true;
    }

    public function get_title() {
        return __('Tokens', DCE_TEXTDOMAIN);
    }
    public function get_description() {
        return __('Add shortcode into the post text to show every value from Post, User e Option', DCE_TEXTDOMAIN);
    }
    public function get_docs() {
        return 'https://www.dynamic.ooo/widget/tokens/';
    }
    public function get_icon() {
        return 'icon-dyn-tokens';
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_tokens', [
                'label' => __('Tokens', DCE_TEXTDOMAIN),
            ]
        );
        
        
        $postFields = DCE_Helper::get_post_fields();        
        $userFields = DCE_Helper::get_user_fields();
        //var_dump($postProp);
        
        
        $this->add_control(
          'text_w_tokens',
          [
             'label'   => __( 'Text with Tokens', DCE_TEXTDOMAIN ),
             'type'    => Controls_Manager::WYSIWYG,
             'default' => 'Hello [user:nicename], you are using Elementor [option:elementor_version]',
             'description' => 'Add shortcode into the post text to show every value from <abbr title="'.  implode(', ', $postFields). '">Post</abbr>, <abbr title="'.  implode(', ', $userFields). '">User</abbr> e <a href="options.php" target="_blank">Option</a>. Here some examples:<ul>'
              . '<li>[user:email]</li>'
              . '<li>[user:registered|5]</li>'
              . '<li>[post:title|12]</li>'
              . '<li>[post:title|1?A title]</li>'
              . '<li>[post:_elementor_version:0]</li>'
              . '<li>[option:elementor_version]</li>'
              . '<li>[option:sidebars_widgets:wp_inactive_widgets]</li>'
              . '</ul><br><br>Shortcode composition:<br>
                  - <b>[</b> (open tag)<br>
                  - <b>post</b> (or <b>user</b> or <b>option</b>, required)<br>
                  - <b>: field name</b> (required, native fields and meta are supported)<br>
                  - <b>: sub field key</b> (optional and multiple, if field is array)<br>
                  - <b>| ID</b> (optional, if omitted will take the current)<br>
                  - <b>? Fallback text</b> (optional, shown if field value is null)<br>
                  - <b>]</b> (close tag)'
          ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Text Editor', DCE_TEXTDOMAIN ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'align',
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
                    'justify' => [
                        'title' => __( 'Justified', DCE_TEXTDOMAIN ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .dce-tolkens' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .dce-tolkens' => 'color: {{VALUE}};',
                ],
                
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .dce-tolkens',
            ]
        );
        $this->add_control(
            'tolken_heading',
            [
                'label' => __( 'Tolken style', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'tolken_text_color',
            [
                'label' => __( 'Tolken Color', DCE_TEXTDOMAIN ),
                'type' => Controls_Manager::COLOR,
                'default' => '#999999',
                'selectors' => [
                    '{{WRAPPER}} .dce-tolkens span' => 'color: {{VALUE}};',
                ],
                
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tolken_typography',
                'label' => __( 'Tolken Typography', DCE_TEXTDOMAIN ),
                'selector' => '{{WRAPPER}} .dce-tolkens span',
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'tolkens', 'class', [ 'dce-tolkens' ] );
        ?>
        <div <?php echo $this->get_render_attribute_string( 'tolkens' ); ?>>
        <?php
        if( $settings['text_w_tokens'] != '' ){
            echo \DynamicContentForElementor\DCE_Tokens::do_tokens($settings['text_w_tokens']);
        }else{
            echo __('Add text to the widget and fill it by Tokens', DCE_TEXTDOMAIN);
        }
        ?>
        </div>
        <?php
    }

/*    
    public function replaceAllTokens($text) {
        $text = $this->replaceUserTokens($text);
        $text = $this->replacePostTokens($text);
        //$text = $this->replaceTermTokens($text); // TODO?!
        $text = $this->replaceOptionTokens($text);

        return $text;
    }

    public function replaceUserTokens($text) {

        $current_user = wp_get_current_user();
        $current_user_id = 0;
        if ($current_user) {
            $current_user_id = $current_user->ID;
        }

        // poi gli user field
        $pezzi = explode('[user:', $text);
        if (count($pezzi) > 1) {
            foreach ($pezzi as $key => $avalue) {
                if ($key) {
                    $metaTmp = explode(']', $avalue);
                    $metaParams = reset($metaTmp);

                    $morePezzi = explode('?', $metaParams, 2);
                    $fallback = '';
                    if (count($morePezzi) == 2) {
                        $fallback = end($morePezzi);
                    }
                    $pezzoTmp = reset($morePezzi);
                    $altriPezzi = explode('|', $pezzoTmp, 2);
                    if (count($altriPezzi) == 2) {
                        $user_id = end($altriPezzi);
                    } else {
                        $user_id = $current_user_id;
                    }
                    //echo $user_id;
                    $metaName = reset($altriPezzi);
                    $metaKey = explode(':', $metaName);
                    //echo $metaKey[0];
                    $metaValue = '';
                    if ($user_id) {
                        $userTmp = get_user_by('ID', $user_id);
                        //var_dump($userTmp);die();
                        if ($userTmp) {
                            //if (property_exists('WP_User', $metaKey[0])) {
                            // campo nativo
                            if (@$userTmp->data->{$metaKey[0]}) {
                                //$userTmp = get_user_by('ID', $user_id);
                                $metaValue = $userTmp->data->{$metaKey[0]};
                            }
                            if (!$metaValue) {
                                //echo 'ancora nulla';
                                //var_dump($userTmp->data);
                                if (@$userTmp->data->{'user_'.$metaKey[0]}) {
                                //if (property_exists('WP_User', 'user_'.$metaKey[0])) {
                                    //$userTmp = get_user_by('ID', $user_id);
                                    //var_dump($userTmp);
                                    $metaValue = $userTmp->data->{'user_'.$metaKey[0]};
                                    //var_dump($metaName); die();
                                }
                            }
                            // altri campi nativi
                            if (!$metaValue) {
                                $userInfo = get_userdata($user_id);
                                if (@$userInfo->{$metaKey[0]}) {
                                    $metaValue = $userInfo->{$metaKey[0]};
                                }
                                if (!$metaValue) {
                                    if (@$userInfo->{'user_'.$metaKey[0]}) {
                                        $metaValue = $userInfo->{'user_'.$metaKey[0]};
                                    }
                                }
                            }
                            // campo meta
                            if (!$metaValue) {
                                if (metadata_exists('user', $user_id, $metaKey[0])) {
                                  $metaValue = get_user_meta($user_id, $metaKey[0], true);
                                }
                                if (!$metaValue) {
                                    // meta from module user_registration
                                    if (metadata_exists('user', $user_id, 'user_registration_'.$metaKey[0])) {
                                      $metaValue = get_user_meta($user_id, 'user_registration_'.$metaKey[0], true);
                                    }
                                }
                            }
                        }
                    }
                    //var_dump($metaValue);
                    $replaceValue = $this->checkArrayValue($metaValue, $metaKey);
                    if ($replaceValue == '') {
                        $replaceValue = $fallback;
                    }
                    $text = str_replace('[user:'.$metaParams.']', $replaceValue, $text);
                }
            }
        }

        return $text;
    }

    public function replacePostTokens($text) {
        $current_post_id = 0;
        $current_post = get_post();
        if ($current_post) {
            $current_post_id = $current_post->ID;
        }

       
        // prima i post meta
        // poi i post field
        $pezzi = explode('[post:', $text);
        if (count($pezzi) > 1) {
            foreach ($pezzi as $key => $avalue) {
                if ($key) {
                    $metaTmp = explode(']', $avalue);
                    $metaParams = reset($metaTmp);
                    $morePezzi = explode('?', $metaParams, 2);
                    $fallback = '';
                    if (count($morePezzi) == 2) {
                        $fallback = end($morePezzi);
                    }
                    $pezzoTmp = reset($morePezzi);
                    $altriPezzi = explode('|', $pezzoTmp, 2);
                    if (count($altriPezzi) == 2) {
                        $post_id = end($altriPezzi);
                    } else {
                        $post_id = $current_post_id;
                    }
                    $metaName = reset($altriPezzi);
                    $metaKey = explode(':', $metaName);
                    $metaValue = '';
                    if ($post_id) {
                        if (property_exists('WP_Post', $metaKey[0])) {
                            $postTmp = get_post($post_id);
                            $metaValue = $postTmp->{$metaKey[0]};
                        }
                        if (!$metaValue) {
                            if (property_exists('WP_Post', 'post_'.$metaKey[0])) {
                                $postTmp = get_post($post_id);
                                if ($postTmp) {
                                    $metaValue = $postTmp->{'post_'.$metaKey[0]};
                                }
                            }
                        }
                        if (!$metaValue) {
                          if (metadata_exists('post', $post_id, $metaKey[0])) {
                            $metaValue = get_post_meta($post_id, $metaKey[0], true);
                          }
                        }
                        if (!$metaValue) { // fot meta created with Toolset plugin
                          if (metadata_exists('post', $post_id, 'wpcf-'.$metaKey[0])) {
                            $metaValue = get_post_meta($post_id, 'wpcf-'.$metaKey[0], true);
                          }
                        }
                        
                    }
                    $replaceValue = $this->checkArrayValue($metaValue, $metaKey);
                    if ($replaceValue == '') {
                        $replaceValue = $fallback;
                    }
                    $text = str_replace('[post:'.$metaParams.']', $replaceValue, $text);
                }
            }
        }

        return $text;
    }

    public function replaceOptionTokens($text) {
        // /wp-admin/options.php
        $pezzi = explode('[option:', $text);
        if (count($pezzi) > 1) {
            foreach ($pezzi as $key => $avalue) {
                if ($key) {
                    $pezzo = explode(']', $avalue);
                    $metaParams = reset($pezzo);

                    $morePezzi = explode('?', $metaParams, 2);
                    $fallback = '';
                    if (count($morePezzi) == 2) {
                        $fallback = end($morePezzi);
                    }
                    $pezzoTmp = reset($morePezzi);

                    $optionParams = explode(':', $pezzoTmp);
                    $optionName = $optionParams[0];
                    //var_dump( $optionName);
                    $optionValue = get_option($optionName);
                    //var_dump($optionValue);
                    $replaceValue = $this->checkArrayValue($optionValue, $optionParams);
                    if ($replaceValue == '') {
                        $replaceValue = $fallback;
                    }
                    $text = str_replace('[option:'.$metaParams.']', $replaceValue, $text);
                }
            }
        }

        return $text;
    }


    private function checkArrayValue($optionValue = array(), $optionParams = array()) {
        if (is_array($optionValue)){
          if (count($optionValue) == 1) {
            $tmpValue = reset($optionValue);
            if (!is_array($tmpValue)) {
              return $tmpValue;
            }
          }
            if (is_array($optionParams)) {
                $val = $optionValue;
                foreach ($optionParams as $key => $value) {
                    if (isset($val[$value])) {
                        $val = $val[$value];
                    }
                }
                if (is_array($val)) {
                    $val = var_export($val, true);
                }
                return $val;
            }
            if ($optionParams) {
                return $optionValue[$optionParams];
            }
            return var_export($optionValue, true);
        }
        return $optionValue;
    }
*/
    
}
