<?php
/**
 * Plugin Name: And IT Portfolio for Elementor
 * Description: Build your portfolio using Elementor Plugin.
 * Plugin URI: https://anditthemes.com/and-it-portfolio-for-elementor
 * Author: And IT Themes
 * Version: 0.0.1
 * Author URI: https://anditthemes.com/
 * Text Domain: anditportfolio
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'ANDIT_DIR', plugin_dir_path( __FILE__ ) );
define( 'ANDIT_URL', plugin_dir_url( __FILE__ ) );
/**
 * Main Elementor And IT Portfolio Class
 */
final class And_IT_Portfolio_Addons {

	/**
	 * Plugin Version
	 *
	 * @since 0.0.1
	 * @var string The plugin version.
	 */
	const VERSION = '0.0.1';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 0.0.1
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 0.0.1
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.3';

	/**
	 * Constructor
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function __construct() {

		// Load translation
		add_action( 'init', array( $this, 'i18n' ) );

		// Init Plugin
		add_action( 'plugins_loaded', array( $this, 'init' ) );
		
		add_action( 'init', array( $this, 'andit_portfolio_add_image_sizes' ) );
		
		add_filter( 'query_vars', array( $this, 'andit_portfolio_pagination') );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'anditportfolio' );
	}


	/**
	 * Add Image Sizes
	 *
	 * @since 1.0.0
	 * @access public
	 */
	 public function andit_portfolio_add_image_sizes() {

		add_image_size( 'anditwp_masonry', 700 );
		add_image_size( 'anditwp_zoom', 1200 , 800 , true);
		add_image_size( 'anditwp_grid', 800 , 500 , true);	
		
	 }

	/**
	 * Add Pagination Var
	 *
	 * @since 1.0.0
	 * @access public
	 */
	 public function andit_portfolio_pagination( $vars ){
		$vars[] = "anditthemes_page";
		return $vars;
	 }

	/**
	 * Initialize the plugin
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'class-andit-portfolio.php' );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'anditportfolio' ),
			'<strong>' . esc_html__( 'And IT Portfolio For Elementor', 'anditportfolio' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'anditportfolio' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'anditportfolio' ),
			'<strong>' . esc_html__( 'And IT Portfolio For Elementor', 'anditportfolio' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'anditportfolio' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'anditportfolio' ),
			'<strong>' . esc_html__( 'And IT Portfolio For Elementor', 'anditportfolio' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'anditportfolio' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}

// Instantiate And_IT_Portfolio_Addons.
new And_IT_Portfolio_Addons();
