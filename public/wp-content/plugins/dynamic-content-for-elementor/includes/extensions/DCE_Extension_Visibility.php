<?php

namespace DynamicContentForElementor\Extensions;

use Elementor\Controls_Manager;
use DynamicContentForElementor\DCE_Helper;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Visibility extenstion
 *
 * Conditional Visibility Widgets & Rows/Sections
 *
 * @since 1.0.1
 */

class DCE_Extension_Visibility extends DCE_Extension_Prototype 
{

    public $name = 'Visibility';
    public $common_sections_actions = array(
        array(
            'element' => 'common',
            'action' => '_section_style',
        ),
        array(
            'element' => 'section',
            'action' => 'section_advanced',
        )
    );

    /**
     * The description of the current extension
     *
     * @since 0.5.4
     * */
    public static function get_description() {
        return __('Visibility rules for Widgets and Rows');
    }

    /**
     * Add Actions
     *
     * @since 0.5.5
     *
     * @access private
     */
    protected function add_actions() {

        // Activate controls for widgets
        add_action('elementor/element/common/dce_section_visibility_advanced/before_section_end', function( $element, $args ) {
            $this->add_controls($element, $args);
        }, 10, 2);

        //add_filter('elementor/widget/print_template', array($this, 'visibility_print_widget'), 10, 2);
        add_filter('elementor/widget/render_content', array($this, 'visibility_render_widget'), 10, 2);

        // Activate controls for sections
        add_action('elementor/element/section/dce_section_visibility_advanced/before_section_end', function( $element, $args ) {
            $this->add_controls($element, $args);
        }, 10, 2);
        add_action('elementor/frontend/section/before_render', function( $element ) {
            $element_type = $element->get_type();
            $element_name = $element->get_unique_name();
            $element_id = $element->get_id();
            $settings = $element->get_settings();
            if (isset($settings['enabled_visibility']) && $settings['enabled_visibility']) {
                //var_dump($this->is_hidden($settings));
                if ($this->is_hidden($element)) {
                    $element->add_render_attribute('_wrapper', 'class', 'dce-visibility-section-hidden');
                }
            }
        }, 10, 1);
        
        
        // filter sections
        add_action( "elementor/frontend/section/before_render", function( $element ) {
            $settings = $element->get_settings();
            if (isset($settings['enabled_visibility']) && $settings['enabled_visibility']) {
                if ($this->is_hidden($element)) {
                    echo '<!--DCE VISIBILITY HIDDEN SECTION START-->';
                    ob_start();
                }
            }
        }, 10, 1);
        add_action( "elementor/frontend/section/after_render", function( $element ) {
            $settings = $element->get_settings();
            if (isset($settings['enabled_visibility']) && $settings['enabled_visibility']) {
                if ($this->is_hidden($element)) {
                    ob_end_clean();
                    $fallback = $this->get_fallback($settings, $element);
                    if ($fallback) {
                        echo $fallback;
                    }
                    echo '<!--DCE VISIBILITY HIDDEN SECTION END-->';
                }
            }
        }, 10, 1);
        
        // filter columns
        //addAction( "elementor/frontend/column/before_render", 'filterSectionContentBefore', 10, 1 );
        //addAction( "elementor/frontend/column/after_render", 'filterSectionContentAfter', 10, 1 );
    }

    /**
     * Add Controls
     *
     * @since 0.5.5
     *
     * @access private
     */
    private function add_controls($element, $args) {

        $element_type = $element->get_type();

        $element->add_control(
                'enabled_visibility', [
            'label' => __('Enable Visibility', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'frontend_available' => true,
                ]
        );

        $element->add_control(
                'dce_visibility_hidden', [
            'label' => __('HIDE this block', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Hidden', DCE_TEXTDOMAIN),
            'label_off' => __('Show', DCE_TEXTDOMAIN),
            'description' => __('This hides the widget on the frontend until it is enabled', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
            ],
            'separator' => 'before',
                ]
        );

        $element->add_control(
                'role_visibility_heading', [
            'label' => __('Users & Roles', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::HEADING,
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
            ],
            'separator' => 'before',
                ]
        );
        $element->add_control(
                'dce_visibility_everyone', [
            'label' => __('Visible by EveryONE', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'description' => __('If enabled every user, also visitors, can view the widget', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
            ],
                ]
        );

        $roles = \DynamicContentForElementor\DCE_Helper::get_roles(false);
        $roles = array_reverse($roles, true);
        $roles['users'] = 'Selected User';
        $roles['visitor'] = 'Visitor (non logged User)';
        $roles = array_reverse($roles, true);

        $element->add_control(
                'dce_visibility_role', [
            'label' => __('Users & Roles', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT2,
            'options' => $roles,
            'default' => 'everyone',
            'description' => __('If you want limit visualization to specific user roles', DCE_TEXTDOMAIN),
            'multiple' => true,
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_everyone' => '',
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_users', [
            'label' => __('Selected Users', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::TEXT,
            'default' => '1',
            'description' => __('Write here the list of user who will be able to view this element.<br>You can use their ID, email or username.<br>Simply separate them by a comma. (ex. "23, info@dynamic.ooo, dynamicooo")', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_role' => 'users',
                'dce_visibility_everyone' => '',
                'dce_visibility_hidden' => '',
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_ip', [
            'label' => __('Remote IP', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __('Write here the list of IP who will be able to view this element.<br>Separate IPs by comma. (ex. "123.123.123.123, 8.8.8.8, 4.4.4.4")', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_everyone' => '',
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_browser', [
            'label' => __('Browser', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT2,
            'options' => array(
                'is_chrome' => 'Google Chrome',
                'is_gecko' => 'FireFox',
                'is_safari' => 'Safari',
                'is_IE' => 'Internet Explorer',
                'is_edge' => 'Microsoft Edge',
                'is_NS4' => 'Netscape',
                'is_opera' => 'Opera',
                'is_lynx' => 'Lynx',
                'is_iphone' => 'iPhone Safari'
            ),
            'default' => '',
            'description' => __('Filter visibility for a specific browser.', DCE_TEXTDOMAIN),
            'multiple' => true,
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_everyone' => '',
            ]
                ]
        );
        $element->add_control(
                'dce_visibility_referrer', [
            'label' => __('Enable Referrer', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'description' => __('Visible only if previous page is a specific page.', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_everyone' => '',
            ]
                ]
        );
        $element->add_control(
                'dce_visibility_referrer_list', [
            'label' => __('Specific referral site authorized:', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::TEXTAREA,
            'default' => '',
            'placeholder' => 'facebook.com' . PHP_EOL . 'google.com',
            'description' => __('Only selected referral, once per line. If empty is visible for all external site.', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_referrer' => 'yes',
                'dce_visibility_everyone' => '',
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_referrer_selected', [
            'label' => __('Hide/Show only for selected', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Show', DCE_TEXTDOMAIN),
            'label_off' => __('Hide', DCE_TEXTDOMAIN),
            'description' => __('Visible or hidden by selected referrers.', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_referrer' => 'yes',
                'dce_visibility_referrer_list!' => '',
                'dce_visibility_everyone' => '',
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_user_selected', [
            'label' => __('Hide/Show only for selected', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Show', DCE_TEXTDOMAIN),
            'label_off' => __('Hide', DCE_TEXTDOMAIN),
            'return_value' => 'yes',
            'description' => __('Visible or hidden for selected users.', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_everyone' => '',
            ],
                ]
        );


        $element->add_control(
                'date_visibility_heading', [
            'label' => __('Date & Time', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::HEADING,
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
            ],
            'separator' => 'before',
                ]
        );

        $element->add_control(
                'dce_visibility_datetime', [
            'label' => __('Visible EveryTIME', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'description' => __('If enabled you can show the widget for a specific period.', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
            ],
                ]
        );

        if (time() != current_time('timestamp')) {
            $element->add_control(
                    'dce_visibility_datetime_important_note', [
                'label' => '<strong><i class="elementor-dce-datetime-icon eicon-warning"></i> ' . __('ATTENTION', DCE_TEXTDOMAIN) . '</strong>',
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<small><br>' . __('Server time and Wordpress time are different.', DCE_TEXTDOMAIN) . '<br>'
                . __('Will be used the Wordpress time you set in', DCE_TEXTDOMAIN)
                . ' <a target="_blank" href="' . admin_url('options-general.php') . '">' . __('Wordpress General preferences', DCE_TEXTDOMAIN) . '</a>.<br>'
                //.__( 'Here actual time on this page load:', DCE_TEXTDOMAIN ).'<br>'
                . '<br>'
                . '<strong>SERVER time:</strong><br>' . date('r') . '<br><br>'
                . '<strong>WORDPRESS time:</strong><br>' . current_time('r')
                . '</small>'
                ,
                'content_classes' => 'dce-datetime-notice',
                'condition' => [
                    'enabled_visibility' => 'yes',
                    'dce_visibility_hidden' => '',
                    'dce_visibility_datetime' => ''
                ],
                    ]
            );
        }

        $element->add_control(
                'dce_visibility_date_from', [
            'label' => __('Visible Date FROM', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::DATE_TIME,
            'description' => __('If set the widget will appear after this date', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_datetime' => ''
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_date_to', [
            'label' => __('Visible Date TO', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::DATE_TIME,
            'description' => __('If set the widget will be visible until this date', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_datetime' => ''
            ],
                ]
        );

        global $wp_locale;
        $week = array();
        for ($day_index = 0; $day_index <= 6; $day_index++) {
            $week[esc_attr($day_index)] = $wp_locale->get_weekday($day_index);
        }
        $element->add_control(
                'dce_visibility_time_week', [
            'label' => __('Days of the WEEK', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT2,
            'options' => $week,
            'default' => '',
            'description' => __('Select days in the week.', DCE_TEXTDOMAIN),
            'multiple' => true,
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_datetime' => '',
            ],
                ]
        );


        $element->add_control(
                'dce_visibility_time_from', [
            'label' => __('Visible Time FROM', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'placeholder' => 'HH:mm',
            'description' => __('If setted (in H:m format) the widget will appear after this time.', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_datetime' => ''
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_time_to', [
            'label' => __('Visible Time TO', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'placeholder' => 'HH:mm',
            'description' => __('If setted (in H:m format) the widget will be visible until this time', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_datetime' => ''
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_datetime_selected', [
            'label' => __('Hide/Show only for selected', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Show', DCE_TEXTDOMAIN),
            'label_off' => __('Hide', DCE_TEXTDOMAIN),
            'return_value' => 'yes',
            'description' => __('Visible or hidden for selected datetime.', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_datetime' => '',
            ],
                ]
        );

        $element->add_control(
                'post_visibility_heading', [
            'label' => __('Context', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::HEADING,
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
            ],
            'separator' => 'before',
                ]
        );
        $element->add_control(
                'dce_visibility_context', [
            'label' => __('Visible EveryWHERE', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'description' => __("If you want show something only when it's in a specific page.", DCE_TEXTDOMAIN) . '<br><strong>' . __("Very useful if you are using a Template System.", DCE_TEXTDOMAIN) . '</strong>',
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_cpt', [
            'label' => __('CPT', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT2,
            'options' => \DynamicContentForElementor\DCE_Helper::get_post_types(),
            'default' => '',
            'description' => __('Visible if current post is one of this Custom Post Type.', DCE_TEXTDOMAIN),
            'multiple' => true,
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_context' => '',
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_post', [
            'label' => __('Page/Post', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT2,
            'options' => \DynamicContentForElementor\DCE_Helper::get_all_posts(),
            'default' => '',
            'description' => __('Visible if current post is one of this Page/Posts.', DCE_TEXTDOMAIN),
            'multiple' => true,
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_context' => '',
            ],
                ]
        );

        $taxonomies = \DynamicContentForElementor\DCE_Helper::get_taxonomies();
        $element->add_control(
                'dce_visibility_tax', [
            'label' => __('Taxonomy', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT2,
            'options' => $taxonomies,
            'default' => '',
            'description' => __('Visible if current post is related with this Taxonomy.', DCE_TEXTDOMAIN),
            'multiple' => false,
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_context' => '',
            ],
                ]
        );

        foreach ($taxonomies as $tkey => $atax) {
            if ($tkey) {
                $element->add_control(
                        'dce_visibility_term_' . $tkey, [
                    'label' => __('Terms', DCE_TEXTDOMAIN), //.' '.$atax,
                    'type' => Controls_Manager::SELECT2,
                    //'groups' => \DynamicContentForElementor\DCE_Helper::get_taxonomies_terms(),
                    'options' => \DynamicContentForElementor\DCE_Helper::get_taxonomy_terms($tkey),
                    'default' => '',
                    'description' => __('Visible if current post is related with this Terms.', DCE_TEXTDOMAIN),
                    'multiple' => true,
                    'condition' => [
                        'enabled_visibility' => 'yes',
                        'dce_visibility_hidden' => '',
                        'dce_visibility_context' => '',
                        'dce_visibility_tax' => $tkey,
                    ],
                        ]
                );
            }
        }


        $metas = \DynamicContentForElementor\DCE_Helper::get_post_metas();
        $element->add_control(
                'dce_visibility_meta', [
            'label' => __('Meta', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT2,
            'options' => $metas,
            'default' => '',
            'description' => __('If you want limit visualization by specific meta fields value.', DCE_TEXTDOMAIN),
            'multiple' => true,
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_context' => '',
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_meta_operator', [
            'label' => __('Meta conditions', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('And', DCE_TEXTDOMAIN),
            'label_off' => __('Or', DCE_TEXTDOMAIN),
            'description' => __('How post meta have to satisfy this conditions.', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_meta!' => '',
                'dce_visibility_context' => '',
            ],
                ]
        );
        /* $element->add_control(
          'dce_visibility_meta_selected', [
          'label' => __('Hide/Show only for selected', DCE_TEXTDOMAIN),
          'type' => Controls_Manager::SWITCHER,
          'default' => 'yes',
          'label_on' => __('Hide', DCE_TEXTDOMAIN),
          'label_off' => __('Show', DCE_TEXTDOMAIN),
          'return_value' => 'yes',
          'description' => __('Visible or hidden by selected meta.', DCE_TEXTDOMAIN),
          'condition' => [
          'enabled_visibility' => 'yes',
          'dce_visibility_hidden' => '',
          'dce_visibility_meta!' => '',
          ],
          ]
          ); */

        // https://codex.wordpress.org/Conditional_Tags
        $element->add_control(
                'dce_visibility_conditional_tags_post', [
            'label' => __('Conditional Tags for Post', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT2,
            //'default' => '',
            'options' => [
                'is_sticky' => __('Is Sticky', DCE_TEXTDOMAIN),
                'is:post_type_hierarchical' => __('Has Hierarchical Post Type', DCE_TEXTDOMAIN),
                'is_post_type_archive' => __('Has a Post Type Archive', DCE_TEXTDOMAIN),
                'comments_open' => __('Comments open', DCE_TEXTDOMAIN),
                'pings_open' => __('Pings open', DCE_TEXTDOMAIN),
                'has_tag' => __('Has Tags', DCE_TEXTDOMAIN),
                'has_term' => __('Has Terms', DCE_TEXTDOMAIN),
                'has_excerpt' => __('Has Excerpt', DCE_TEXTDOMAIN),
                'has_post_thumbnail' => __('Has Post Thumbnail', DCE_TEXTDOMAIN),
                'has_nav_menu' => __('Has Nav menu', DCE_TEXTDOMAIN),
            ],
            'multiple' => true,
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_context' => '',
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_conditional_tags_site', [
            'label' => __('Conditional Tags for Site', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT2,
            //'default' => '',
            'options' => [
                'is_dynamic_sidebar' => __('Dynamic sidebar', DCE_TEXTDOMAIN),
                'is_active_sidebar' => __('Active sidebar', DCE_TEXTDOMAIN),
                'is_rtl' => __('RTL', DCE_TEXTDOMAIN),
                'is_multisite' => __('Multisite', DCE_TEXTDOMAIN),
                'is_main_site' => __('Main site', DCE_TEXTDOMAIN),
                'is_child_theme' => __('Child theme', DCE_TEXTDOMAIN),
                'is_customize_preview' => __('Customize preview', DCE_TEXTDOMAIN),
                'is_multi_author' => __('Multi author', DCE_TEXTDOMAIN),
                'is feed' => __('Feed', DCE_TEXTDOMAIN),
                'is_trackback' => __('Trackback', DCE_TEXTDOMAIN),
            ],
            'multiple' => true,
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_context' => '',
            ],
                ]
        );
        // https://codex.wordpress.org/Special:SpecialPages
        $element->add_control(
                'dce_visibility_special', [
            'label' => __('Special Pages', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT2,
            //'default' => '',
            'options' => [
                'is_front_page' => __('Homepage', DCE_TEXTDOMAIN),
                'is_404' => __('404 Not Found', DCE_TEXTDOMAIN),
                'is_single' => __('Single page', DCE_TEXTDOMAIN),
                'is_page' => __('Page', DCE_TEXTDOMAIN),
                'is_attachment' => __('Attachment', DCE_TEXTDOMAIN),
                'is_preview' => __('Preview', DCE_TEXTDOMAIN),
                'is_admin' => __('Admin', DCE_TEXTDOMAIN),
                'is_page_template' => __('Page Template', DCE_TEXTDOMAIN),
                'is_comments_popup' => __('Comments Popup', DCE_TEXTDOMAIN),
                /*
                  'static' => __('Static', DCE_TEXTDOMAIN),
                  'login' => __('Login', DCE_TEXTDOMAIN),
                  'registration' => __('Registration', DCE_TEXTDOMAIN),
                  'profile' => __('Profile', DCE_TEXTDOMAIN),
                 */
                // woocommerce
                'is_woocommerce' => __('A Woocommerce Page', DCE_TEXTDOMAIN),
                'is_shop' => __('Shop', DCE_TEXTDOMAIN),
                'is_product' => __('Product', DCE_TEXTDOMAIN),
                'is_product_taxonomy' => __('Product Taxonomy', DCE_TEXTDOMAIN),
                'is_product_category' => __('Product Category', DCE_TEXTDOMAIN),
                'is_product_tag' => __('Product Tag', DCE_TEXTDOMAIN),
                'is_cart' => __('Cart', DCE_TEXTDOMAIN),
                'is_checkout' => __('Checkout', DCE_TEXTDOMAIN),
                'is_add_payment_method_page' => __('Add Payment method', DCE_TEXTDOMAIN),
                'is_checkout_pay_page' => __('Checkout Pay', DCE_TEXTDOMAIN),
                'is_account_page' => __('Account page', DCE_TEXTDOMAIN),
                'is_edit_account_page' => __('Edit Account', DCE_TEXTDOMAIN),
                'is_lost_password_page' => __('Lost password', DCE_TEXTDOMAIN),
                'is_view_order_page' => __('Order summary', DCE_TEXTDOMAIN),
                'is_order_received_page' => __('Order complete', DCE_TEXTDOMAIN),
            ],
            'multiple' => true,
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_context' => '',
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_archive', [
            'label' => __('Archive', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT2,
            //'default' => '',
            'options' => [
                'is_blog' => __('Home blog (latest posts)', DCE_TEXTDOMAIN),
                'posts_page' => __('Posts page', DCE_TEXTDOMAIN),
                //'post_type_archive' => __('Post type', DCE_TEXTDOMAIN),
                'is_tax' => __('Taxonomy', DCE_TEXTDOMAIN),
                'is_category' => __('Category', DCE_TEXTDOMAIN),
                'is_tag' => __('Tag', DCE_TEXTDOMAIN),
                'is_author' => __('Author', DCE_TEXTDOMAIN),
                'is_date' => __('Date', DCE_TEXTDOMAIN),
                'is_year' => __('Year', DCE_TEXTDOMAIN),
                'is_month' => __('Month', DCE_TEXTDOMAIN),
                'is_day' => __('Day', DCE_TEXTDOMAIN),
                'is_time' => __('Time', DCE_TEXTDOMAIN),
                'is_new_day' => __('New Day', DCE_TEXTDOMAIN),
                'is_search' => __('Search', DCE_TEXTDOMAIN),
                'is_paged' => __('Paginated', DCE_TEXTDOMAIN),
                'is_main_query' => __('Main Query', DCE_TEXTDOMAIN),
                'in_the_loop' => __('In the Loop', DCE_TEXTDOMAIN),
            ],
            'multiple' => true,
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_context' => '',
            ],
                ]
        );

        $element->add_control(
                'dce_visibility_context_selected', [
            'label' => __('Hide/Show only in selected', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Show', DCE_TEXTDOMAIN),
            'label_off' => __('Hide', DCE_TEXTDOMAIN),
            'description' => __('Hide or show in selected context.', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_context' => '',
            ],
                ]
        );

        $element->add_control(
                'php_visibility_heading', [
            'label' => __('Custom Condition', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::HEADING,
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
            ],
            'separator' => 'before',
                ]
        );
        $element->add_control(
                'dce_visibility_custom_condition', [
            'label' => __('Visible Always', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'description' => __("By a your handwritten advanced custom condition.", DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_custom_condition_php', [
            'label' => __('Custom PHP condition', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::CODE,
            'placeholder' => 'return true;',
            'description' => __('Write here a function that return a boolean value. You can use all WP variabile and functions.', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_custom_condition' => '',
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_custom_condition_secure', [
            'label' => __('Prevent errors', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'description' => __('Execute code in secure mode without throw possible error.', DCE_TEXTDOMAIN). '<br><strong>' . __("WARNING: if it's disabled a wrong code can broke this page, check if code is correct before saving.", DCE_TEXTDOMAIN) . '</strong>',
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_custom_condition' => '',
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_custom_condition_selected', [
            'label' => __('Hide/Show only in selected', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Show', DCE_TEXTDOMAIN),
            'label_off' => __('Hide', DCE_TEXTDOMAIN),
            'description' => __('Hide or show by custom condition.', DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_hidden' => '',
                'dce_visibility_custom_condition' => '',
            ],
                ]
        );



        $element->add_control(
                'fallback_visibility_heading', [
            'label' => __('Fallback', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'enabled_visibility' => 'yes',
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_fallback', [
            'label' => __('Enable a Fallback Content', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SWITCHER,
            'description' => __("If you want to show something when the element is hidden", DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
            ],
                ]
        );
        if ($element_type == 'widget') {
            $element->add_control(
                    'dce_visibility_fallback_type', [
                'label' => __('Content type', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'text' => [
                        'title' => __('Text', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-align-left',
                    ],
                    'template' => [
                        'title' => __('Template', DCE_TEXTDOMAIN),
                        'icon' => 'fa fa-th-large',
                    ]
                ],
                'default' => 'text',
                'condition' => [
                    'enabled_visibility' => 'yes',
                    'dce_visibility_fallback' => 'yes',
                ],
                    ]
            );
        } else {
            $element->add_control(
                    'dce_visibility_fallback_type', [
                'label' => __('Content type', DCE_TEXTDOMAIN),
                'type' => \Elementor\Controls_Manager::HIDDEN,
                'default' => 'text',
                    ]
            );
        }
        $element->add_control(
                'dce_visibility_fallback_template', [
            'label' => __('Render Template', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::SELECT2,
            //'options' => get_post_taxonomies( $post->ID ),
            'options' => DCE_Helper::get_all_template(),
            'description' => 'Use a Elementor Template as content of popup, useful for complex structure.',
            'default' => '',
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_fallback' => 'yes',
                'dce_visibility_fallback_type' => 'template',
            ],
                ]
        );
        $element->add_control(
                'dce_visibility_fallback_text', [
            'label' => __('Text Fallback', DCE_TEXTDOMAIN),
            'type' => Controls_Manager::WYSIWYG,
            'default' => "This element is currently hidden.",
            'description' => __("Insert here some content showed if the widget is not visible", DCE_TEXTDOMAIN),
            'condition' => [
                'enabled_visibility' => 'yes',
                'dce_visibility_fallback' => 'yes',
                'dce_visibility_fallback_type' => 'text',
            ],
                ]
        );
        if ($element_type == 'section') {
            $element->add_control(
                    'dce_visibility_fallback_section', [
                'label' => __('Use section wrapper', DCE_TEXTDOMAIN),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => __('Mantain original section wrapper.', DCE_TEXTDOMAIN),
                'condition' => [
                    'enabled_visibility' => 'yes',
                    'dce_visibility_fallback' => 'yes',
                //'dce_visibility_fallback_type' => 'text',
                //'dce_visibility_fallback_text!' => '',
                ],
                    ]
            );
        }
    }

    public function visibility_print_widget($content, $widget) {
        if (!$content)
            return '';

        $notice = '<div class="dce-visibility-warning"><i class="fa fa-eye-slash"></i> Hidden</div>'; // nascondo il widget
        $content = "<# if ( '' !== settings.enabled_visibility ) { if ( '' !== settings.dce_visibility_hidden ) { #>" . $notice . "<# } #><div class=\"dce-visibility-hidden-outline\">" . $content . "</div><# } else { #>" . $content . "<# } #>";
        return $content;
    }

    public function visibility_render_widget($content, $widget) {
        $settings = $widget->get_settings();

        if (isset($settings['enabled_visibility']) && $settings['enabled_visibility']) {
            $hidden = $this->is_hidden($widget);
            
            // show element in backend
            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                $notice = '';
                if ($hidden) {
                    $widget->add_render_attribute('_wrapper', 'class', 'dce-visibility-hidden');
                    $notice = '<div class="dce-visibility-warning"><i class="fa fa-eye-slash"></i> Hidden</div>'; // nascondo il widget
                    //return $notice . '<div class="dce-visibility-hidden dce-visibility-hidden-outline">' . $content . '</div>'; // mostro il widget
                    //return $notice .  $content ; // mostro il widget
                }

                //return '<div class="dce-visibility-hidden-outline">' . $content . '</div>';
                return $content;
            }

            if ($hidden) {
                $fallback = $this->get_fallback($settings, $widget);
                if ($fallback) {
                    return $fallback;
                }

                return '<style>' . $widget->get_unique_selector() . '{display:none !important;}</style>'; // nascondo il widget
            }
        }
        return $content; // mostro il widget
    }

    public function get_fallback($settings, $element = null) {

        if (isset($settings['dce_visibility_fallback']) && $settings['dce_visibility_fallback']) {
            if (isset($settings['dce_visibility_fallback_type']) && $settings['dce_visibility_fallback_type'] == 'template') {
                $fallback_content = '[dce-elementor-template id="' . $settings['dce_visibility_fallback_template'] . '"]';
            } else { //if ($settings['dce_visibility_fallback_type'] == 'text') {
                $fallback_content = __($settings['dce_visibility_fallback_text'], DCE_TEXTDOMAIN . '_texts');
            }
            $fallback_content = do_shortcode($fallback_content); // TODO FIX
            $fallback_content = \DynamicContentForElementor\DCE_Tokens::do_tokens($fallback_content);
            
            
            if ($fallback_content && (!isset($settings['dce_visibility_fallback_section']) || $settings['dce_visibility_fallback_section'] == 'yes')) { // BUG - Fix it
                $fallback_content = '
                                <div class="elementor-element elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
                                    <div class="elementor-column-wrap elementor-element-populated">
                                        <div class="elementor-widget-wrap">
                                            <div class="elementor-element elementor-widget">
                                                <div class="elementor-widget-container dce-visibility-fallback">'
                                                . $fallback_content .
                        '</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                
                ob_start();
                    $element->before_render();
                        echo $fallback_content;
                    $element->after_render();
                $fallback_content = ob_get_contents();
                ob_end_clean();
            }
            
            return $fallback_content;
        }
        return '';
    }

    public function is_hidden($element = null) {
        $settings = $element->get_settings();
        global $global_ID;
        $hidden = FALSE;
        $conditions = array();

        if (isset($settings['enabled_visibility']) && $settings['enabled_visibility']) {

            // FORCED HIDDEN
            if (isset($settings['dce_visibility_hidden']) && $settings['dce_visibility_hidden']) {
                $conditions[] = __('Always Hidden', DCE_TEXTDOMAIN);
                $hidden = TRUE;
            }

            // DATETIME
            if (isset($settings['dce_visibility_datetime']) && !$settings['dce_visibility_datetime']) {
                $everytimehidden = false;
                
                if ($settings['dce_visibility_date_from'] && $settings['dce_visibility_date_to']) {
                    // between
                    $dateTo = strtotime($settings['dce_visibility_date_to']);
                    $dateFrom = strtotime($settings['dce_visibility_date_from']);
                    if (current_time('timestamp') >= $dateFrom && current_time('timestamp') <= $dateTo) {
                        $conditions[] = __('Date', DCE_TEXTDOMAIN);
                        $everytimehidden = TRUE;
                    }
                } else {
                    if ($settings['dce_visibility_date_from']) {
                        $dateFrom = strtotime($settings['dce_visibility_date_from']);
                        if (current_time('timestamp') >= $dateFrom) {
                            $conditions[] = __('Date From', DCE_TEXTDOMAIN);
                            $everytimehidden = TRUE;
                        }
                    }
                    if ($settings['dce_visibility_date_to']) {
                        $dateTo = strtotime($settings['dce_visibility_date_to']);
                        if (current_time('timestamp') <= $dateTo) {
                            $conditions[] = __('Date To', DCE_TEXTDOMAIN);
                            $everytimehidden = TRUE;
                        }
                    }
                }

                if ($settings['dce_visibility_time_week'] && !empty($settings['dce_visibility_time_week'])) {
                    $timeFrom = $settings['dce_visibility_time_from'];
                    if (in_array(current_time('w'), $settings['dce_visibility_time_week'])) {
                        $conditions[] = __('Day of Week', DCE_TEXTDOMAIN);
                        $everytimehidden = TRUE;
                    }
                }

                if ($settings['dce_visibility_time_from'] && $settings['dce_visibility_time_from'] != '00:00'
                    && $settings['dce_visibility_time_to'] && $settings['dce_visibility_time_to'] != '00:00') {
                    $timeFrom = $settings['dce_visibility_time_from'];
                    $timeTo = strtotime($settings['dce_visibility_time_to']);
                    if (current_time('H:m') >= $timeFrom && current_time('H:m') <= $timeTo) {
                        $conditions[] = __('Time', DCE_TEXTDOMAIN);
                        $everytimehidden = TRUE;
                    }
                } else {
                    if ($settings['dce_visibility_time_from'] && $settings['dce_visibility_time_from'] != '00:00') {
                        $timeFrom = $settings['dce_visibility_time_from'];
                        if (current_time('H:m') >= $timeFrom) {
                            $conditions[] = __('Time From', DCE_TEXTDOMAIN);
                            $everytimehidden = TRUE;
                        }
                    }
                    if ($settings['dce_visibility_time_to'] && $settings['dce_visibility_time_to'] != '00:00') {
                        $timeTo = strtotime($settings['dce_visibility_time_to']);
                        if (current_time('H:m') <= $timeTo) {
                            $conditions[] = __('Time To', DCE_TEXTDOMAIN);
                            $everytimehidden = TRUE;
                        }
                    }
                }

                if (self::check_visibility_condition($everytimehidden, $settings['dce_visibility_datetime_selected'])) {
                    $hidden = TRUE;
                }
            }

            // USER & ROLES
            if (isset($settings['dce_visibility_everyone']) && !$settings['dce_visibility_everyone']) {
                $everyonehidden = FALSE;

                //roles
                if (isset($settings['dce_visibility_role']) && !empty($settings['dce_visibility_role'])) {
                    $current_user = wp_get_current_user();
                    //return var_export($current_user, true);
                    $current_user_id = $current_user->ID;
                    if ($current_user && $current_user_id) {
                        $user_roles = $current_user->roles; // possibile avere più ruoli
                        if (!is_array($user_roles)) {
                            $user_roles = array($user_roles);
                        }
                        if (is_array($settings['dce_visibility_role'])) {
                            $tmp_role = array_intersect($user_roles, $settings['dce_visibility_role']);
                            if (!empty($tmp_role)) {
                                $conditions[] = __('User Role', DCE_TEXTDOMAIN);
                                $everyonehidden = TRUE;
                            }
                        }
                    } else {
                        if (in_array('visitor', $settings['dce_visibility_role'])) {
                            $conditions[] = __('User not logged', DCE_TEXTDOMAIN);
                            $everyonehidden = TRUE;
                        }
                    }
                }

                // user
                if (isset($settings['dce_visibility_users']) && is_array($settings['dce_visibility_users'])
                        //&& in_array('users', $settings['dce_visibility_role'])
                        && $current_user_id) {
                    $users = explode(',', $settings['dce_visibility_users']);
                    $users = array_map('trim', $users);
                    $users = array_filter($users);
                    $is_user = false;
                    if (!empty($users)) {
                        foreach ($users as $key => $value) {
                            //var_dump($value); die();
                            if (is_numeric($value)) {
                                if ($value == $current_user_id) {
                                    $is_user = true;
                                }
                            }
                            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                if ($value == $current_user->user_email) {
                                    $is_user = true;
                                }
                            }
                            if ($value == $current_user->username) {
                                $is_user = true;
                            }
                        }
                    }
                    if ($is_user) {
                        $conditions[] = __('Specific User', DCE_TEXTDOMAIN);
                        $everyonehidden = TRUE;
                    }
                }

                // referrer
                if (isset($settings['dce_visibility_referrer']) && $settings['dce_visibility_referrer'] && $settings['dce_visibility_referrer_list']) {
                    if ($_SERVER['HTTP_REFERER']) {
                        $pieces = explode('/', $_SERVER['HTTP_REFERER']);
                        $referrer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST); //$pieces[2];
                        $referrers = explode(PHP_EOL, $settings['dce_visibility_referrer_list']);
                        $referrers = array_map('trim', $referrers);
                        $ref_found = false;
                        foreach ($referrers as $aref) {
                            if ($aref == $referrer || $aref == str_replace('www.', '', $referrer)) {
                                $ref_found = true;
                            }
                        }
                        if ($ref_found) {
                            $everyonehidden = TRUE;
                        }
                    }/* else {
                        $everyonehidden = TRUE;
                    }*/
                }

                if (isset($settings['dce_visibility_ip']) && $settings['dce_visibility_ip']) {
                    $ips = explode(',', $settings['dce_visibility_ip']);
                    $ips = array_map('trim', $ips);
                    if (in_array($_SERVER['REMOTE_ADDR'], $ips)) {
                        $conditions[] = __('Remote IP', DCE_TEXTDOMAIN);
                        $everyonehidden = TRUE;
                    }
                }

                if (isset($settings['dce_visibility_browser']) && is_array($settings['dce_visibility_browser']) && !empty($settings['dce_visibility_browser'])) {
                    $is_browser = false;
                    foreach ($settings['dce_visibility_browser'] as $browser) {
                        if (isset($$browser) && $$browser) {
                            $is_browser = true;
                        }
                    }
                    $hidden_browser = false;
                    if ($hidden_browser) {
                        $conditions[] = __('Browser', DCE_TEXTDOMAIN);
                        $everyonehidden = TRUE;
                    }
                }

                if (self::check_visibility_condition($everyonehidden, $settings['dce_visibility_user_selected'])) {
                    $hidden = TRUE;
                }

                // hidden in editor mode only to force that is enable this conditions
                if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
                    $hidden = TRUE;
                }
            }

            // CONTEXT
            if (isset($settings['dce_visibility_context']) && !$settings['dce_visibility_context']) {
                $contexthidden = false;

                // cpt
                if (!empty($settings['dce_visibility_cpt']) && is_array($settings['dce_visibility_cpt'])) {
                    $cpt = get_post_type();
                    if (in_array($cpt, $settings['dce_visibility_cpt'])) {
                        $conditions[] = __('CPT', DCE_TEXTDOMAIN);
                        $contexthidden = true;
                    }
                }

                // post
                //var_dump($settings['dce_visibility_post']);
                if (!empty($settings['dce_visibility_post']) && is_array($settings['dce_visibility_post'])) {
                    //$id = $global_ID; get_the_ID();
                    $id = 0;
                    $queried_object = get_queried_object();
                    //if ( $queried_object instanceof WP_Post ) {
                    if (get_class($queried_object) == 'WP_Post') {
                        $id = $queried_object->ID;
                    }
                    if (in_array($id, $settings['dce_visibility_post'])) {
                        $conditions[] = __('Post', DCE_TEXTDOMAIN);
                        $contexthidden = true;
                    }
                }

                // taxonomy
                /* if (!empty($settings['dce_visibility_tax']) && is_array($settings['dce_visibility_tax'])) {
                  $tax = get_post_taxonomies();
                  //return $tax;
                  if (!array_intersect($tax, $settings['dce_visibility_tax'])) {
                  $conditions[] = __('Taxonomy', DCE_TEXTDOMAIN);
                  $contexthidden = true;
                  }
                  } */
                if (isset($settings['dce_visibility_tax']) && $settings['dce_visibility_tax']) {
                    //return $settings['dce_visibility_tax'];
                    $tax = get_post_taxonomies();
                    //return $tax;
                    if (!in_array($settings['dce_visibility_tax'], $tax)) {
                        $conditions[] = __('Taxonomy', DCE_TEXTDOMAIN);
                        $contexthidden = true;
                    } else {
                        // term
                        $terms = get_the_terms(get_the_ID(), $settings['dce_visibility_tax']);
                        //return $terms;
                        $tkey = 'dce_visibility_term_' . $settings['dce_visibility_tax'];
                        //return $settings[$tkey];
                        if (!empty($settings[$tkey]) && is_array($settings[$tkey])) {
                            if (array_intersect($terms, $settings[$tkey])) {
                                $conditions[] = __('Terms', DCE_TEXTDOMAIN);
                                $contexthidden = true;
                                //return $tax;
                            }
                        } else {
                            if (!empty($terms)) {
                                $conditions[] = __('Terms', DCE_TEXTDOMAIN);
                                $contexthidden = true;
                            }
                        }
                    }
                }

                // meta
                if (isset($settings['dce_visibility_meta']) && is_array($settings['dce_visibility_meta']) && !empty($settings['dce_visibility_meta'])) {
                    $post_metas = $settings['dce_visibility_meta'];
                    //var_dump($settings['dce_visibility_meta_operator']);
                    if ($settings['dce_visibility_meta_operator']) { // AND
                        $metavalued = TRUE;
                    } else { // OR
                        $metavalued = FALSE;
                    }
                    foreach ($post_metas as $ameta) {
                        //var_dump($ameta);
                        if (is_author()) {
                            $author_id = get_the_author_meta('ID');
                            //var_dump($author_id);
                            $mvalue = get_user_meta($author_id, $ameta, true);
                        } else {
                            //var_dump(get_the_ID());
                            $mvalue = get_post_meta(get_the_ID(), $ameta, true);
                            if (is_array($mvalue) && empty($mvalue)) {
                                $mvalue = false;
                            }
                        }
                        if ($settings['dce_visibility_meta_operator']) { // AND
                            if (!$metavalued || !$mvalue) {
                                $metavalued = FALSE;
                            }
                        } else { // OR
                            if ($metavalued || $mvalue) {
                                $metavalued = TRUE;
                            }
                        }
                    }

                    if ($metavalued) {
                        $conditions[] = __('Meta', DCE_TEXTDOMAIN);
                        $contexthidden = TRUE;
                    }
                }

                // conditional tags
                if (isset($settings['dce_visibility_conditional_tags_post']) && is_array($settings['dce_visibility_conditional_tags_post']) && !empty($settings['dce_visibility_conditional_tags_post'])) {
                    $context_conditional_tags = false;
                    $post_type = get_post_type();
                    foreach ($settings['dce_visibility_conditional_tags_post'] as $conditional_tags) {
                        if (!$context_conditional_tags) {
                            switch ($conditional_tags) {
                                case 'is_post_type_hierarchical':
                                case 'is_post_type_archive':
                                    if (is_callable($conditional_tags)) {
                                        $context_conditional_tags = call_user_func($conditional_tags, $post_type);
                                    }
                                    break;
                                case 'has_post_thumbnail':
                                    if (is_callable($conditional_tags)) {
                                        $context_conditional_tags = call_user_func($conditional_tags, get_the_ID());
                                    }
                                    break;
                                default:
                                    if (is_callable($conditional_tags)) {
                                        $context_conditional_tags = call_user_func($conditional_tags);
                                    }
                            }
                        }
                    }
                    if ($context_conditional_tags) {
                        $conditions[] = __('Conditional tags for Post', DCE_TEXTDOMAIN);
                        $contexthidden = TRUE;
                    }
                }
                if (isset($settings['dce_visibility_conditional_tags_site']) && is_array($settings['dce_visibility_conditional_tags_site']) && !empty($settings['dce_visibility_conditional_tags_site'])) {
                    $context_conditional_tags = false;
                    foreach ($settings['dce_visibility_conditional_tags_site'] as $conditional_tags) {
                        if (!$context_conditional_tags) {
                            switch ($conditional_tags) {
                                default:
                                    if (is_callable($conditional_tags)) {
                                        $context_conditional_tags = call_user_func($conditional_tags);
                                    }
                            }
                        }
                    }
                    if ($context_conditional_tags) {
                        $conditions[] = __('Conditional tags for Site', DCE_TEXTDOMAIN);
                        $contexthidden = TRUE;
                    }
                }

                // specials
                if (isset($settings['dce_visibility_special']) && is_array($settings['dce_visibility_special']) && !empty($settings['dce_visibility_special'])) {
                    $context_special = false;
                    foreach ($settings['dce_visibility_special'] as $special) {
                        if (!$context_special) {
                            switch ($special) {
                                default:
                                    if (is_callable($special)) {
                                        $context_special = call_user_func($special);
                                    }
                            }
                        }
                    }
                    if ($context_special) {
                        $conditions[] = __('Special', DCE_TEXTDOMAIN);
                        $contexthidden = TRUE;
                    }
                }

                // archive
                if (isset($settings['dce_visibility_archive']) && is_array($settings['dce_visibility_archive']) && !empty($settings['dce_visibility_archive'])) {
                    $context_archive = false;
                    foreach ($settings['dce_visibility_archive'] as $archive) {
                        if (!$context_archive) {
                            switch ($archive) {
                                case 'is_post_type_archive':
                                case 'is_tax':
                                case 'is_taxonomy':
                                case 'is_category':
                                case 'is_tag':
                                case 'is_author':
                                case 'is_date':
                                case 'is_year':
                                case 'is_month':
                                case 'is_day':
                                case 'is_search':
                                    if (is_callable($archive)) {
                                        $context_archive = call_user_func($archive);
                                    }
                                    break;
                                default:
                                    $context_archive = is_archive();
                            }
                        }
                    }
                    if ($context_archive) { // || ($context_archive && !$settings['dce_visibility_context_selected'])) {
                        $conditions[] = __('Archive', DCE_TEXTDOMAIN);
                        $contexthidden = TRUE;
                    }
                }

                if (self::check_visibility_condition($contexthidden, $settings['dce_visibility_context_selected'])) {
                    $hidden = TRUE;
                }
            }

            // CUSTOM CONDITION
            if (isset($settings['dce_visibility_custom_condition']) && !$settings['dce_visibility_custom_condition']) {
                $customhidden = false;
                if (isset($settings['dce_visibility_custom_condition_php']) && $settings['dce_visibility_custom_condition_php']) {
                    $customhidden = $this->check_custom_condition($settings, $element->get_id());
                }
                if (self::check_visibility_condition($customhidden, $settings['dce_visibility_custom_condition_selected'])) {
                    $hidden = TRUE;
                }
            }
        }

        return $hidden;
    }

    static public function check_visibility_condition($condition, $visibility) {
        $ret = $condition;
        if ($visibility) {
            if ($condition) {
                $ret = false; // mostro il widget
            } else {
                $ret = true; // nascondo il widget
            }
        } else {
            if ($condition) {
                $ret = true; // nascondo il widget
            } else {
                $ret = false; // mostro il widget
            }
        }
        return $ret;
    }

    public function check_custom_condition($settings, $eid = null) {
        $php_code = $settings['dce_visibility_custom_condition_php'];
        if ($php_code) {
            if (strpos($php_code, 'return ') !== false) {
                if ($settings['dce_visibility_custom_condition_secure']) {
                    $url = DCE_URL.'assets/condition.php?pid=' .  get_the_ID() .'&eid=' . $eid;
                    $custom_condition_result = wp_remote_get($url);
                    if ($custom_condition_result['body'] == '1') {
                        return true;
                    }
                } else {
                    // it may cause fatal error
                    $return = eval($php_code);
                    if ($return) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

}
