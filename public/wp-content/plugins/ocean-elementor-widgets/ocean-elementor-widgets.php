<?php
/**
 * Plugin Name:			Ocean Elementor Widgets
 * Plugin URI:			https://oceanwp.org/extension/ocean-elementor-widgets/
 * Description:			Add many new powerful and entirely customizable widgets to the popular free page builder - Elementor.
 * Version:				1.1.6
 * Author:				OceanWP
 * Author URI:			https://oceanwp.org/
 * Requires at least:	4.0.0
 * Tested up to:		5.0
 *
 * Text Domain: ocean-elementor-widgets
 * Domain Path: /languages/
 *
 * @package Ocean_Elementor_Widgets
 * @category Core
 * @author OceanWP
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the main instance of Ocean_Elementor_Widgets to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Ocean_Elementor_Widgets
 */
function Ocean_Elementor_Widgets() {
	return Ocean_Elementor_Widgets::instance();
} // End Ocean_Elementor_Widgets()

Ocean_Elementor_Widgets();

/**
 * Main Ocean_Elementor_Widgets Class
 *
 * @class Ocean_Elementor_Widgets
 * @version	1.0.0
 * @since 1.0.0
 * @package	Ocean_Elementor_Widgets
 */
final class Ocean_Elementor_Widgets {
	/**
	 * Ocean_Elementor_Widgets The single instance of Ocean_Elementor_Widgets.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $token;

	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $version;

	// Admin - Start
	/**
	 * The admin object.
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $admin;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct() {
		$this->token 			= 'ocean-elementor-widgets';
		$this->plugin_url 		= plugin_dir_url( __FILE__ );
		$this->plugin_path 		= plugin_dir_path( __FILE__ );
		$this->version 			= '1.1.6';

		define( 'OWP_ELEMENTOR__FILE__', __FILE__ );
		define( 'OWP_ELEMENTOR_PATH', $this->plugin_path );
		define( 'OWP_ELEMENTOR_VERSION', $this->version );

		register_activation_hook( __FILE__, array( $this, 'install' ) );

		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		add_action( 'plugins_loaded', array( $this, 'setup' ) );
		add_action( 'init', array( $this, 'updater' ), 1 );
	}

	/**
	 * Initialize License Updater.
	 * Load Updater initialize.
	 * @return void
	 */
	public function updater() {

		// Plugin Updater Code
		if ( class_exists( 'OceanWP_Plugin_Updater' ) ) {
			$license	= new OceanWP_Plugin_Updater( __FILE__, 'Elementor Widgets', $this->version, 'OceanWP' );
		}
	}

	/**
	 * Main Ocean_Elementor_Widgets Instance
	 *
	 * Ensures only one instance of Ocean_Elementor_Widgets is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Ocean_Elementor_Widgets()
	 * @return Main Ocean_Elementor_Widgets instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	} // End instance()

	/**
	 * Load the localisation file.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'ocean-elementor-widgets', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), '1.0.0' );
	}

	/**
	 * Installation.
	 * Runs on activation. Logs the version number and assigns a notice message to a WordPress option.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function install() {
		$this->_log_version_number();
	}

	/**
	 * Log the plugin version number.
	 * @access  private
	 * @since   1.0.0
	 * @return  void
	 */
	private function _log_version_number() {
		// Log the version number.
		update_option( $this->token . '-version', $this->version );
	}

	/**
	 * Setup all the things.
	 * Only executes if OceanWP or a child theme using OceanWP as a parent is active and the extension specific filter returns true.
	 * @return void
	 */
	public function setup() {
		$theme = wp_get_theme();

		if ( 'OceanWP' == $theme->name || 'oceanwp' == $theme->template ) {
			require( OWP_ELEMENTOR_PATH .'includes/plugin.php' );
			require_once( OWP_ELEMENTOR_PATH .'includes/helpers.php' );
			require_once( OWP_ELEMENTOR_PATH .'includes/class-instagram-api.php' );
			require_once( OWP_ELEMENTOR_PATH .'includes/class-integration.php' );
			require_once( OWP_ELEMENTOR_PATH .'includes/class-recaptcha.php' );
		}
	}

} // End Class