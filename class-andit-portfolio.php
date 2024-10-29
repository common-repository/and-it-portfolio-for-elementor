<?php
namespace AndITPortfolioBuilder;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 0.0.1
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function widget_scripts() {
		
		// Load WP jQuery if not included
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-masonry');
		
		// Main
		wp_register_style( 'andit-portfolios-main-style', plugins_url( '/assets/css/style.css', __FILE__ ) );
		wp_register_style( 'fonts-andit',  plugins_url( 'assets/css/fonts.css', __FILE__ ));  
		wp_enqueue_style( 'andit-portfolios-main-style' );
		wp_register_script( 'anditportfoliogrid',  plugins_url( 'assets/js/anditportfolio-grid.js' , __FILE__ ), [ 'jquery' ], false, true );	
		wp_register_script( 'anditportoflio-carousel',  plugins_url( 'assets/js/anditportfolio-carousel.js' , __FILE__ ), [ 'jquery' ], false, true );	
		wp_register_script( 'mixitup',  plugins_url( 'assets/js/vendor/jquery.mixitup.js' , __FILE__ ), [ 'jquery' ], false, true );	
		
		// Carousel
		wp_register_style( 'owlcarousel',  plugins_url( 'assets/css/owl.carousel.css', __FILE__ ) );
		wp_register_style( 'owltheme',  plugins_url( 'assets/css/owl.theme.css', __FILE__ ) );
		wp_register_script( 'owlcarousel',  plugins_url( 'assets/js/vendor/owl.carousel.js' , __FILE__ ), [ 'jquery' ], false, true );
		
		wp_register_script( 'magnific-popup',  plugins_url( 'assets/js/vendor/jquery.magnific-popup.js' , __FILE__ ), [ 'jquery' ], false, true );
		wp_register_style( 'magnific-popup',  plugins_url( 'assets/css/magnific-popup.css', __FILE__  ) );

		// ANIMATE
		wp_register_style( 'animations',  plugins_url( 'assets/css/animations.min.css', __FILE__ ) );
		wp_register_script( 'appear',  plugins_url( 'assets/js/vendor/appear.min.js' , __FILE__ ), [ 'jquery' ], false, true );	
		wp_register_script( 'animate',  plugins_url( 'assets/js/vendor/animations.min.js' , __FILE__ ), [ 'jquery' ], false, true );		
			
		if(\Elementor\Plugin::$instance->preview->is_preview_mode()) {
			wp_enqueue_style( 'fonts-andit' );
			wp_enqueue_style( 'owlcarousel' );
			wp_enqueue_style( 'owltheme' );				
			wp_enqueue_script( 'owlcarousel' );
			wp_enqueue_style( 'animations' );
			wp_enqueue_script( 'appear' );			
			wp_enqueue_script( 'animate' );	
			wp_enqueue_script( 'mixitup' );	
			wp_enqueue_script( 'anditportfoliogrid' );	
			wp_enqueue_script( 'anditportfolio-carousel' );	
			wp_enqueue_style( 'elementor-icons' );
			wp_enqueue_style( 'font-awesome' );
			wp_enqueue_style( 'magnific-popup' );
			wp_enqueue_script( 'magnific-popup' );			
		}			
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 0.0.1
	 * @access private
	 */
	private function include_widgets_files() {
		require_once( __DIR__ . '/widgets/Portfolio/portfolio.php' );
		require_once( __DIR__ . '/widgets/Grid/grid.php' );
		require_once( __DIR__ . '/widgets/Carousel/carousel.php' );
		require_once( __DIR__ . '/widgets/widgets-andit-portfolio-functions.php' );
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\ANDIT_Portfolio() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\ANDIT_Grid() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\ANDIT_Carousel() );
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function __construct() {

		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}
}

// Instantiate Plugin Class
Plugin::instance();
