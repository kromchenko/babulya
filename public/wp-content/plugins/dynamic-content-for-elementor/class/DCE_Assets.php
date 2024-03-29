<?php
namespace DynamicContentForElementor;

use MatthiasMullie\Minify;

/**
 * Main Plugin Class
 *
 * Register new elementor widget.
 *
 * @since 0.0.1
 */
class DCE_Assets {

    public static $styles = array(
        //'dce-photoSwipe_default'=>'/assets/lib/photoSwipe/photoswipe.min.css',
        //'dce-photoSwipe_skin'=>'/assets/lib/photoSwipe/default-skin/default-skin.min.css',
        //'dce-file-icon'=>'/assets/css/file-icon-vivid.min.css',
        'dce-acf' => '/assets/css/elements-acf.css',
        'dce-pods' => '/assets/css/elements-pods.css',
        'dce-acfSlider' => '/assets/css/elements-acfSlider.css',
        'dce-acfGallery' => '/assets/css/elements-acfGallery.css',
        //'dce-acfGooglemap'=>'/assets/css/elements-googleMap.css',
        'dce-dynamicPosts' => '/assets/css/elements-dynamicPosts.css',
        'dce-dynamicPosts_slick' => '/assets/css/elements-dynamicPosts_slick.css',
        'dce-dynamicPosts_swiper' => '/assets/css/elements-dynamicPosts_swiper.css',
        'dce-dynamicPosts_timeline' => '/assets/css/elements-dynamicPosts_timeline.css',
        'dce-dynamicUsers' => '/assets/css/elements-dynamicUsers.css',
        'dce-featuredImage' => '/assets/css/elements-featuredImage.css',
        'dce-iconFormat' => '/assets/css/elements-iconFormat.css',
        'dce-nextPrev' => '/assets/css/elements-nextPrev.css',
        'dce-list' => '/assets/css/elements-list.css',
        'dce-modalWindowstyle' => '/assets/css/elements-modalWindow.css',
        //'dce-fullpage' => '/assets/css/elements-fullpage.css',
        //'dce-pageScroll' => '/assets/css/elements-pageScroll.css',
        //'dce-pagePiling' => '/assets/css/elements-pagePiling.css',
        //'dce-posterSlider' => '/assets/css/elements-posterSlider.css',
        'dce-swiper' => '/assets/css/elements-swiper.css',
        'dce-threesixtySlider' => '/assets/css/elements-threesixtySlider.css',
        'dce-twentytwenty' => '/assets/css/elements-twentytwenty.css',
        'dce-bubbles' => '/assets/css/elements-bubbles.css',
        'dce-tilt' => '/assets/css/elements-tilt.css',
        'dce-parallax' => '/assets/css/elements-parallax.css',
        'dce-filebrowser' => '/assets/css/elements-filebrowser.css',
        'dce-animatetext' => '/assets/css/elements-animateText.css',
        'dce-dualView' => '/assets/css/elements-dualView.css',
        'dce-modal' => '/assets/css/dce-modal.css',
        'dce-woocommerce' => '/assets/css/dce-woocommerce.css',
        //'dce-distortion' => '/assets/css/elements-distortion.css',
    );
    public static $minifyCss = 'assets/css/dce-all.min.css';
    
    public static $scripts = array(
        'wow' => '/assets/lib/wow/wow.min.js',
        'isotope' => '/assets/lib/isotope/isotope.pkgd.min.js',
        'infinitescroll' => '/assets/lib/infiniteScroll/infinite-scroll.pkgd.min.js',
        'jquery-slick' => '/assets/lib/slick/slick.min.js',
        'jquery-swiper' => '/assets/lib/swiper/js/swiper.min.js',
        'velocity' => '/assets/lib/velocity/velocity.min.js',
        'velocity-ui' => '/assets/lib/velocity/velocity.ui.min.js',
        'diamonds' => '/assets/lib/diamonds/jquery.diamonds.js',
        'homeycombs' => '/assets/lib/homeycombs/jquery.homeycombs.js',
        'photoswipe' => '/assets/lib/photoSwipe/photoswipe.min.js',
        'photoswipe-ui' => '/assets/lib/photoSwipe/photoswipe-ui-default.min.js',
        'tilt-lib' => '/assets/lib/tilt/tilt.jquery.min.js',
        'scrollify' => '/assets/lib/scrollify/jquery.scrollify.js',
        'ajaxify' => '/assets/lib/ajaxify/ajaxify.min.js',

        // 'threejs' => '/assets/lib/threejs/three.min.js',
        // 'data-gui' => '/assets/lib/threejs/libs/dat.gui.min.js',
        // 'displacement-distortion' => '/assets/lib/threejs/displacement_distortion.js',

        'inertiaScroll' => '/assets/lib/inertiaScroll/jquery-inertiaScroll.js',
        'dce-googlemaps-api' => 'https://maps.googleapis.com/maps/api/js?key=dce_api_gmaps',
        'dce-parallaxjs-lib' => '/assets/lib/parallaxjs/parallax.min.js',
        'dce-rellaxjs-lib' => '/assets/lib/rellax/rellax.min.js',
        'dce-lax-lib' => '/assets/lib/lax/lax.min.js',
        'dce-threesixtyslider-lib' => '/assets/lib/threesixty-slider/threesixty.min.js',
        'dce-jqueryeventmove-lib' => '/assets/lib/twentytwenty/jquery.event.move.js',
        'dce-twentytwenty-lib' => '/assets/lib/twentytwenty/jquery.twentytwenty.js',
        'dce-anime-lib' => '/assets/lib/anime/anime.min.js',
        
        'dce-animatetext' => '/assets/js/elements-animateText.js',
        //'dce-charming-lib' => '/assets/lib/charming/charming.min.js',
        'dce-tweenMax-lib' => 'https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.2/TweenMax.min.js',//'/assets/lib/tweenMax/TweenMax.min.js',
        'dce-dualView' => '/assets/js/elements-dualView.js',
        'dce-reveal' => '/assets/js/elements-reveal.js',
        'dce-revealFx' => '/assets/lib/reveal/revealFx.js', 
        //'dce-pagepiling-lib' => '/assets/lib/pagepiling/jquery.pagepiling.min.js',
        //'dce-fullpage-lib' => '/assets/lib/fullpage/jquery.fullpage.min.js',
        'dce-extension-lib' => '/assets/lib/fullpage/jquery.fullpage.extensions.min.js',
        'dce_easing-lib' => '/assets/lib/fullpage/vendors/jquery.easings.min.js',
        'dce-fullpage_scrolloverflow-lib' => '/assets/lib/fullpage/vendors/scrolloverflow.min.js',
        'dce-aframe' => '/assets/lib/aframe/aframe-v0.8.2.min.js',
        'dce-visible' => '/assets/lib/visible/jquery.visible.min.js',
        'dce-popup' => '/assets/js/elements-popup.js',
        'dce-acfgallery' => '/assets/js/elements-acfgallery.js',
        'dce-acfslider' => '/assets/js/elements-acfslider.js',
        'dce-poster-slider' => '/assets/js/poster-slider.js',
        'dce-parallax' => '/assets/js/elements-parallax.js',
        'dce-fullpage' => '/assets/js/elements-fullpage.js',
        'dce-swiper' => '/assets/js/elements-swiper.js',
        //'dce-pagepiling' => '/assets/js/elements-pagepiling.js',
        //'dce-pagescroll' => '/assets/js/elements-pageScroll.js',
        'dce-threesixtyslider' => '/assets/js/elements-threesixtyslider.js',
        'dce-twentytwenty' => '/assets/js/elements-twentytwenty.js',
        'dce-rellax' => '/assets/js/elements-rellax.js',
        'dce-tilt' => '/assets/js/elements-tilt.js',
        'dce-acf_posts' => '/assets/js/elements-acfposts.js',
        'dce-content' => '/assets/js/elements-content.js',
        'dce-dynamic_users' => '/assets/js/elements-dynamicusers.js',
        'dce-acf_fields' => '/assets/js/elements-acf.js',
        'dce-google-maps' => '/assets/js/google-maps.js',
        'dce-modalwindow' => '/assets/js/elements-modalwindow.js',
        'dce-nextPrev' => '/assets/js/dce-nextprev.js',
        'dce-youtube' => '/assets/js/dce-youtube.js',
        // Document
        'dce-scrollify' => '/assets/js/elements-scrollify.js',
        'dce-inertiaScroll' => '/assets/js/elements-inertiaScroll.js',
        'dce-lax' => '/assets/js/elements-lax.js',

        'dce-barbajs-lib' => '/assets/lib/barbajs/barba.min.js',
        'dce-barbajs' => '/assets/js/global-barbajs.js',

        'dce-animsition-lib' => '/assets/lib/animsition/js/animsition.min.js',
        'dce-animsition' => '/assets/js/global-animsition.js',

        'kute-lib'  => '/assets/lib/kute/kute.js',
        'kute-css-lib'  => '/assets/lib/kute/kute-css.min.js',
        'kute-svg-lib'  => '/assets/lib/kute/kute-svg.min.js',
        'kute-text-lib'  => '/assets/lib/kute/kute-text.min.js',
        'kute-attr-lib'  => '/assets/lib/kute/kute-attr.min.js',
        //'kute-jquery-lib'  => '/assets/lib/kute/kute-jquery.js',
        //'kute-bezier-lib'  => '/assets/lib/kute/kute-bezier.js',
        
        'dce-svgmorph' => '/assets/js/dce-svgmorph.js',
        //'dce-distortion' => '/assets/js/elements-distortion.js',
        'dce-swup-lib' => '/assets/lib/swup/swup.js',
        'dce-swup-lib-swupMergeHeadPlugin' => '/assets/lib/swup/plugins/swupMergeHeadPlugin.js',
        'dce-swup-lib-swupGaPlugin' => '/assets/lib/swup/plugins/swupGaPlugin.min.js',
        'dce-swup-lib-swupGtmPlugin' => '/assets/lib/swup/plugins/swupGtmPlugin.min.js',

        'dce-swup' => '/assets/js/global-swup.js',
        
    );
    
    public function __construct() {
        $this->init();
    }
    
    public function init() {
        
        // Admin Style
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
        
        // REGENERATE STYLE
        add_action( 'elementor/core/files/clear_cache', array($this, 'regenerate_style') );
        
        // -------------------- SCRIPT
        add_action('elementor/frontend/after_enqueue_scripts', function() {
            $theme = wp_get_theme();
            if ('OceanWP' == $theme->name || 'oceanwp' == $theme->template) {
                $dir = OCEANWP_JS_DIR_URI;
                $theme_version = OCEANWP_THEME_VERSION;
                wp_enqueue_script('oceanwp-main', $dir . 'main.min.js', array('jquery'), $theme_version, true);
            }
            wp_enqueue_script('dce-main', DCE_URL . 'assets/js/main.js', array('jquery'), DCE_VERSION, true);
            wp_enqueue_script('kute-lib', DCE_URL . '/assets/lib/kute/kute.min.js', array('jquery'), DCE_VERSION, true);
            wp_enqueue_script('kute-svg-lib', DCE_URL . '/assets/lib/kute/kute-svg.min.js', array('kute-lib'), DCE_VERSION, true);
            wp_enqueue_script('kute-attr-lib', DCE_URL . '/assets/lib/kute/kute-svg.min.js', array('kute-lib'), DCE_VERSION, true);
            wp_enqueue_script('kute-css-lib', DCE_URL . '/assets/lib/kute/kute-css.min.js', array('kute-lib'), DCE_VERSION, true);
            wp_enqueue_script('dce-ajaxmodal', DCE_URL . 'assets/js/ajaxmodal.js', array('jquery'), DCE_VERSION, true);
        });

        //
        add_action('elementor/frontend/before_register_scripts', array($this, 'dce_register_script'));
        add_action('elementor/frontend/after_enqueue_scripts', [ $this, 'dce_enqueue_frontend_scripts']);

        //add_action( 'elementor/preview/enqueue_styles', array( $this, 'dce_preview_style') );
        add_action('elementor/frontend/after_register_styles', array($this, 'dce_register_style'));
        add_action('elementor/frontend/after_enqueue_styles', array($this, 'dce_preview_style'));

        //
        // -------------------- STYLE
        // Basic Style
        add_action('wp_enqueue_scripts', array($this, 'enqueue_base_styles'), 100);
        // DCE Custom Icons - in Elementor Editor
        add_action('elementor/editor/after_enqueue_scripts', array($this, 'dce_editor'));
        add_action('elementor/preview/enqueue_styles', array($this, 'dce_preview'));
        // ELEMENTOR Style
        add_action('elementor/frontend/after_register_styles', function() {
            //wp_register_style( 'dynamic-content-elements-style', plugins_url( '/assets/css/dynamic-content-elements.css', DCE__FILE__ ) );

            wp_register_style('dce-style', plugins_url('/assets/css/style.css', DCE__FILE__));
            wp_register_style('animatecss', plugins_url('/assets/lib/animate/animate.min.css', DCE__FILE__));


            // photoswipe
            //wp_register_style( 'photoswipe', plugins_url( '/assets/css/photoSwipe/photoswipe.min.css.css', DCE__FILE__ ) );
            //wp_register_style( 'photoswipe-default-skin', plugins_url( '/assets/photoSwipe/default-skin/default-skin.min.css', DCE__FILE__ ) );
        });

        add_action('elementor/frontend/after_enqueue_styles', function() {
            wp_enqueue_style('dashicons');
            wp_enqueue_style('animatecss');
            wp_enqueue_style('dce-style');
        });
    }
    
    static public function dce_preview_style() {

        if (file_exists(DCE_PATH . self::$minifyCss) && !WP_DEBUG) {
            //echo 'css minimizzato'; die();
            wp_enqueue_style('dce-all-css');
        } else {
            foreach (self::$styles as $key => $value) {
                wp_enqueue_style($key);
            }
        }

        wp_enqueue_style('dce-photoSwipe_default');
        wp_enqueue_style('dce-photoSwipe_skin');
        //
        wp_enqueue_style('dce-file-icon');
        //wp_enqueue_style('dce-pageanimations');

        wp_enqueue_style('woocommerce-layout');
        wp_enqueue_style('woocommerce-smallscreen');
        wp_enqueue_style('woocommerce-general');
        wp_enqueue_style('woocommerce_prettyPhoto_css');

        //wp_enqueue_script('oceanwp-woocommerce');
    }
    
    public function regenerate_style($cache = true) {            
        if (file_exists(DCE_PATH . self::$minifyCss)) {
            if ($cache) {
                return true;
            }
            unlink(DCE_PATH . self::$minifyCss);
            //echo 'Deleted '.DCE_PATH . self::$minifyCss; die();
        }
        if (!file_exists(DCE_PATH . self::$minifyCss)) {
            // MINIFY CSS
            foreach (self::$styles as $key => $value) {
                $fileName = basename($value);
                $pezzi = explode('.', $fileName);
                array_pop($pezzi);
                $fileName = implode('.', $pezzi);
                $minifier = new Minify\CSS();
                $minifier->add(DCE_PATH . $value);
                // save minified file to disk
                $minifier->minify(DCE_PATH . 'assets/css/min/' . $fileName . '.min.css');
            }
            touch(DCE_PATH . self::$minifyCss);
            $mins = glob(DCE_PATH . 'assets/css/min/*');
            //var_dump($mins);
            foreach ($mins as $amin) {
                file_put_contents(DCE_PATH . self::$minifyCss, PHP_EOL . '/*' . basename($amin) . '*/' . PHP_EOL, FILE_APPEND | LOCK_EX);
                file_put_contents(DCE_PATH . self::$minifyCss, file_get_contents(DCE_PATH . 'assets/css/min/' . basename($amin)), FILE_APPEND | LOCK_EX);
            }
        }
    }
    
    public function dce_register_style() {

        foreach (self::$styles as $key => $value) {
            wp_register_style($key, plugins_url($value, DCE__FILE__));
        }

        if (!file_exists(DCE_PATH . self::$minifyCss)) {
            // MINIFY
            foreach (self::$styles as $key => $value) {
                $fileName = basename($value);
                $pezzi = explode('.', $fileName);
                array_pop($pezzi);
                $fileName = implode('.', $pezzi);
                $minifier = new Minify\CSS();
                $minifier->add(DCE_PATH . $value);
                // save minified file to disk
                $minifier->minify(DCE_PATH . 'assets/css/min/' . $fileName . '.min.css');
            }
            touch(DCE_PATH . self::$minifyCss);
            $mins = glob(DCE_PATH . 'assets/css/min/*');
            foreach ($mins as $amin) {
                file_put_contents(DCE_PATH . self::$minifyCss, PHP_EOL . '/*' . basename($amin) . '*/' . PHP_EOL, FILE_APPEND | LOCK_EX);
                file_put_contents(DCE_PATH . self::$minifyCss, file_get_contents(DCE_PATH . 'assets/css/min/' . basename($amin)), FILE_APPEND | LOCK_EX);
            }
        }

        wp_register_style('dce-all-css', DCE_URL . self::$minifyCss);

        wp_register_style('dce-photoSwipe_default', plugins_url('/assets/lib/photoSwipe/photoswipe.min.css', DCE__FILE__));
        wp_register_style('dce-photoSwipe_skin', plugins_url('/assets/lib/photoSwipe/default-skin/default-skin.min.css', DCE__FILE__));
        wp_register_style('dce-file-icon', plugins_url('/assets/css/file-icon-vivid.min.css', DCE__FILE__));
    }
    
    public function dce_register_script() {
        $dce_apis = self::get_dce_apis();
        foreach (self::$scripts as $key => $value) {
            // setting configurated api key
            if (!empty($dce_apis)) {
                foreach ($dce_apis as $api_key => $api_value) {
                    $value = str_replace($api_key, $api_value, $value);
                }
            }
            if (substr($value, 0, 4) != 'http') {
                $value = plugins_url($value, DCE__FILE__);
            }
            wp_register_script($key, $value);
        }
    }
    
    //
    public function dce_enqueue_frontend_scripts() {
        wp_enqueue_script('wow');
        wp_enqueue_script('isotope');
        wp_enqueue_script('infinitescroll');
        
        wp_enqueue_script('velocity');

        wp_enqueue_script('dce-revealFx');
        
        wp_enqueue_script('dce-twentytwenty-lib');
        
        wp_enqueue_script('dce-acfgallery');
        wp_enqueue_script('dce-acfslider');
        wp_enqueue_script('dce-acf_posts');
        wp_enqueue_script('dce-content');
        wp_enqueue_script('dce-dynamic_users');
        wp_enqueue_script('dce-acf_fields');
        wp_enqueue_script('dce-google-maps');

        wp_enqueue_script('dce-twentytwenty');
        wp_enqueue_script('dce-rellax');
        wp_enqueue_script('dce-reveal');
        wp_enqueue_script('dce-animatetext');


        wp_enqueue_script('dce-modalWindow');
        wp_enqueue_script('homeycombs');
        wp_enqueue_script('diamonds');
        wp_enqueue_script('dce-popup');
        wp_enqueue_script('dce-threesixtyslider-lib');
        wp_enqueue_script('dce-threesixtyslider');

        //wp_enqueue_script('dce-aframe');

        wp_enqueue_script('dce-parallaxjs-lib');
        wp_enqueue_script('dce-parallax');
        //wp_enqueue_script('dce-distortion');
        wp_enqueue_script('dce-svgmorph');
        //wp_enqueue_script('dce-dualView');

        // Page settings
        wp_enqueue_script('dce-lax-lib');
        wp_enqueue_script('dce-scrollify');
        wp_enqueue_script('dce-inertiaScroll');
        //wp_enqueue_script('dce-pagescroll'); //il vecchio pageScroll

        //wp_enqueue_script('dce-barbajs-lib');
        //wp_enqueue_script('dce-barbajs');

        

        //wp_enqueue_script('dce-animsition-lib');
        //wp_enqueue_script('dce-animsition');
        
        /* wp_enqueue_script('photoswipe');
          wp_enqueue_script('photoswipe-ui');
          wp_enqueue_script('wow');
          wp_enqueue_script('isotope');

          wp_enqueue_script('dce-googlemaps-api');
          wp_enqueue_script('imagesloaded'); */
        if ( DCE_Helper::is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            //plugin is activated
            self::dce_wc_enqueue_scripts();
        }


        wp_enqueue_script('dce-swup-lib');
        wp_enqueue_script('dce-swup-lib-swupMergeHeadPlugin');
        
        wp_enqueue_script('dce-swup-lib-swupGaPlugin');
        wp_enqueue_script('dce-swup-lib-swupGtmPlugin');
        wp_enqueue_script('dce-swup');
    }

    // Woocommerce script
    public function dce_wc_enqueue_scripts() {
        // In preview mode it's not a real Product page - enqueue manually.
        /*if ( Plugin::elementor()->preview->is_preview_mode( $this->get_main_id() ) ) {*/

            if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) {
                wp_enqueue_script( 'zoom' );
            }
            if ( current_theme_supports( 'wc-product-gallery-slider' ) ) {
                wp_enqueue_script( 'flexslider' );
            }
            if ( current_theme_supports( 'wc-product-gallery-lightbox' ) ) {
                wp_enqueue_script( 'photoswipe-ui-default' );
                wp_enqueue_style( 'photoswipe-default-skin' );
                //add_action( 'wp_footer', 'woocommerce_photoswipe' );
            }
            wp_enqueue_script( 'wc-single-product' );
            wp_enqueue_script( 'woocommerce' );


            wp_enqueue_style( 'photoswipe' );
            wp_enqueue_style( 'photoswipe-default-skin' );
            wp_enqueue_style( 'photoswipe-default-skin' );
            wp_enqueue_style( 'woocommerce_prettyPhoto_css' );
        /*}*/
    }
    
    /**
     * Enqueue admin styles
     *
     * @since 0.0.3
     *
     * @access public
     */
    public function enqueue_base_styles() {
        // Register styles
        wp_register_style(
            'dce-style-base', plugins_url('/assets/css/base.css', DCE__FILE__), [], DCE_VERSION
        );
        // Enqueue styles
        wp_enqueue_style('dce-style-base');
    }

    /**
     * Enqueue admin styles
     *
     * @since 0.0.3
     *
     * @access public
     */
    public function enqueue_admin_styles($hook) {
        //var_dump($hook); die();
        //$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        // Register styles
        // prima o poi dobbiamo minimizzare tutto e fare così per gestire i files assets per bene ;)
        wp_register_style('dce-admin-css', DCE_URL . 'assets/css/admin.min.css', [], DCE_VERSION);
        //'dce-admin', plugins_url('/assets/css/admin' . $suffix . '.css', DCE__FILE__), [], DCE_VERSION
        wp_enqueue_script('dce-admin-js', DCE_URL . 'assets/js/admin.min.js', [], DCE_VERSION);

        // select2
        wp_enqueue_style('dce-select2', DCE_URL . 'assets/css/select2.min.css', [], '3.5.4'); // '4.0.5'); versione vecchia per compatibilità con wpml
        wp_enqueue_script('dce-select2', DCE_URL . 'assets/js/select2.min.js', array('jquery'), '3.5.4', true); // '4.0.5'); versione vecchia per compatibilità con wpml
        //echo 'in admin'; die();
        // Enqueue styles Admin
        wp_enqueue_style('dce-admin-css');
    }

    /**
     * Enqueue admin styles
     *
     * @since 0.7.0
     *
     * @access public
     */
    public function dce_editor() {
        // Register styles
        wp_register_style(
                'dce-style-icons', plugins_url('/assets/css/dce-icon.css', DCE__FILE__), [], DCE_VERSION
        );
        // Enqueue styles Icons
        wp_enqueue_style('dce-style-icons');

        // Register styles
        wp_register_style(
                'dce-style-editor', plugins_url('/assets/css/dce-editor.css', DCE__FILE__), [], DCE_VERSION
        );
        // Enqueue styles Icons
        wp_enqueue_style('dce-style-editor');

        wp_register_script(
                'dce-script-editor', plugins_url('/assets/js/dce-editor.js', DCE__FILE__), [], DCE_VERSION
        );
        wp_enqueue_script('dce-script-editor');

        //
        $this->dce_wc_enqueue_scripts();
    }

    /**
     * Enqueue admin styles
     *
     * @since 1.0.3
     *
     * @access public
     */
    public function dce_preview() {
        wp_register_style(
                'dce-preview', plugins_url('/assets/css/dce-preview.css', DCE__FILE__), [], DCE_VERSION
        );
        // Enqueue DCE Elementor Style
        wp_enqueue_style('dce-preview');
    }
    
    static public function dce_icon() {
        // Register styles
        wp_register_style(
                'dce-style-icons', plugins_url('/assets/css/dce-icon.css', DCE__FILE__), [], DCE_VERSION
        );
        // Enqueue styles Icons
        wp_enqueue_style('dce-style-icons');
    }
    
    static public function get_dce_apis() {
        return get_option(SL_PRODUCT_ID . '_apis', array());
    }
    
}
