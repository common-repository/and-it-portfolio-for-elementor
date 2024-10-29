<?php
namespace AndITPortfolioBuilder\Widgets;

use \Elementor\Controls_Manager as Controls_Manager;
use \Elementor\Frontend;
use \Elementor\Group_Control_Border as Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow as Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography as Group_Control_Typography;
use \Elementor\Utils as Utils;
use \Elementor\Widget_Base as Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * And IT Portfolio for Elementor
 *
 * @since 1.0.0
 */
class ANDIT_Carousel extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'andit-carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'And IT Carousel', 'anditportfolio' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-carousel';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'anditportfolio' ];
	}

	/**
	 * Get post type categories.
	 */
	private function grid_get_all_post_type_categories( $post_type ) {
		$options = array();

		if ( $post_type == 'post' ) {
			$taxonomy = 'category';
		} else {
			$taxonomy = $post_type;
		}

		if ( ! empty( $taxonomy ) ) {
			// Get categories for post type.
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				)
			);
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( isset( $term ) ) {
						if ( isset( $term->slug ) && isset( $term->name ) ) {
							$options[ $term->slug ] = $term->name;
						}
					}
				}
			}
		}

		return $options;
	}

	/**
	 * Get post type categories.
	 */
	private function grid_get_all_custom_post_types() {
		$options = array();

		$args = array( '_builtin' => false );
		$post_types = get_post_types( $args, 'objects' ); 

		foreach ( $post_types as $post_type ) {
			if ( isset( $post_type ) ) {
					$options[ $post_type->name ] = $post_type->label;
			}
		}

		return $options;
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'anditportfolio' ),
			]
		);

		$this->add_control(
			'skin',
			[
				'label' => esc_html__( 'Skin', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'carouselstyle1',
				'options' => [
					'carouselstyle1' 			=> esc_html__('Carousel Style 1', 'anditportfolio' ),
					'carouselstyle2' 			=> esc_html__('Carousel Style 2', 'anditportfolio' ),
					'carouselstyle3' 			=> esc_html__('Carousel Style 3', 'anditportfolio' ),
					'carouselstyle4' 			=> esc_html__('Carousel Style 4', 'anditportfolio' ),
					'carouselstyle5' 			=> esc_html__('Carousel Style 5', 'anditportfolio' ),
					'carouselstyle6' 			=> esc_html__('Carousel Style 6', 'anditportfolio' ),
					'carouselstyle7' 			=> esc_html__('Carousel Style 7', 'anditportfolio' ),
					'carouselstyle8' 			=> esc_html__('Carousel Style 8', 'anditportfolio' )
				]
			]
		);
		
		$this->end_controls_section();

  		$this->start_controls_section(
  			'section_settings',
  			[
  				'label' => esc_html__( 'Settings', 'anditportfolio' )
  			]
		);

		$this->add_control(
			'item_show',
			[
				'label' => esc_html__( 'Number Item Show', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5'
				]
			]
		);

		$this->add_control(
			'item_show_900',
			[
				'label' => esc_html__( 'Item Show for content between 600px to 900px', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => '4',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5'
				]
			]
		);
		
		$this->add_control(
			'item_show_600',
			[
				'label' => esc_html__( 'Item Show for content between 0px to 599px', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'label_block' => true,
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5'
				]
			]
		);		

		$this->add_control(
			'loop',
			[
				'label' => esc_html__( 'Loop', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'true' 		=> esc_html__( 'On', 'anditportfolio' ),
					'false' 	=> esc_html__( 'Off', 'anditportfolio' )
				]
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay (ms) - ex 2000 or leave empty for default', 'anditportfolio' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => '2000'
			]
		);

		$this->add_control(
			'smart_speed',
			[
				'label' => esc_html__( 'Speed (ms) - ex 2000 or leave empty for default', 'anditportfolio' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => '2000'
			]
		);
		
		$this->add_control(
			'margin',
			[
				'label' => esc_html__( 'Margin between Items - empty to disable. Or for example: 10', 'anditportfolio' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => ''
			]
		);		

		$this->add_control(
			'navigation',
			[
				'label' => esc_html__( 'Navigation', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'true' 		=> esc_html__( 'Show', 'anditportfolio' ),
					'false' 	=> esc_html__( 'Hidden', 'anditportfolio' )
				]
			]
		);
		
		$this->add_control(
			'pagination',
			[
				'label' => esc_html__( 'Pagination', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'true' 		=> esc_html__( 'Show', 'anditportfolio' ),
					'false' 	=> esc_html__( 'Hidden', 'anditportfolio' )
				]
			]
		);

		$this->add_control(
			'rtl',
			[
				'label' => esc_html__( 'RTL', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'false',
				'options' => [
					'true' 		=> esc_html__( 'On', 'anditportfolio' ),
					'false' 	=> esc_html__( 'Off', 'anditportfolio' )
				]
			]
		);

		$this->end_controls_section();

  		$this->start_controls_section(
  			'section_query',
  			[
  				'label' => esc_html__( 'QUERY', 'anditportfolio' )
  			]
		);

		$this->add_control(
			'source',
			[
				'label' => esc_html__( 'Source', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'wp_posts',
				'options' => [
					'wp_posts' 				=> esc_html__( 'Wordpress Posts', 'anditportfolio' ),
					'post_type' 	=> esc_html__( 'Custom Posts Type', 'anditportfolio' )
				]
			]
		);

		$this->add_control(
			'posts_source',
			[
				'label' => esc_html__( 'All Posts/Sticky posts', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'all_posts',
				'options' => [ 
					'all_posts' 			=> esc_html__( 'All Posts', 'anditportfolio' ),
					'onlystickyposts'	=> esc_html__( 'Only Sticky Posts', 'anditportfolio' )
				],
				'condition'	=> [
					'source'	=> 'wp_posts'
				]
			]
		);

		$this->add_control(
			'posts_type',
			[
				'label' => esc_html__( 'Select Post Type Source', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->grid_get_all_custom_post_types(),
				'condition'	=> [
					'source'	=> 'post_type'
				]
			]
		);

		$this->add_control(
			'categories',
			[
				'label' => esc_html__( 'Categories', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->grid_get_all_post_type_categories('post'),
				'condition'	=> [
					'source'	=> 'wp_posts'
				]				
			]
		);

		$this->add_control(
			'order',
			[
				'label' => esc_html__( 'Order', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC'	=> 'DESC',
					'ASC' 	=> 'ASC'					
				]
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => esc_html__( 'Order By', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'			=> 'Date',
					'ID' 			=> 'ID',					
					'author' 		=> 'Author',					
					'title' 		=> 'Title',					
					'name' 			=> 'Name',
					'modified'		=> 'Modified',
					'parent' 		=> 'Parent',					
					'rand' 			=> 'Rand',					
					'comment_count' => 'Comments Count',					
					'none' 			=> 'None'						
				]
			]
		);

		$this->add_control(
			'num_posts',
			[
				'label' => esc_html__( 'Number Posts', 'anditportfolio' ),
				'type' => Controls_Manager::TEXT,
				'default' => '10'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_animation',
			[
				'label' => esc_html__( 'Animations', 'anditportfolio' )
			]
		);
		
		$this->add_control(
			'addon_animate',
			[
				'label' => esc_html__( 'Animate', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'off',
				'options' => [
					'off'	=> 'Off',
					'on' 	=> 'On'					
				]
			]
		);		

		$this->add_control(
			'effect',
			[
				'label' => esc_html__( 'Animate Effects', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fade-in',
				'options' => [
							'fade-in'			=> esc_html__( 'Fade In', 'anditportfolio' ),
							'fade-in-up' 		=> esc_html__( 'fade in up', 'anditportfolio' ),					
							'fade-in-down' 		=> esc_html__( 'fade in down', 'anditportfolio' ),					
							'fade-in-left' 		=> esc_html__( 'fade in Left', 'anditportfolio' ),					
							'fade-in-right' 	=> esc_html__( 'fade in Right', 'anditportfolio' ),					
							'fade-out'			=> esc_html__( 'Fade In', 'anditportfolio' ),
							'fade-out-up' 		=> esc_html__( 'Fade Out up', 'anditportfolio' ),					
							'fade-out-down' 	=> esc_html__( 'Fade Out down', 'anditportfolio' ),					
							'fade-out-left' 	=> esc_html__( 'Fade Out Left', 'anditportfolio' ),					
							'fade-out-right' 	=> esc_html__( 'Fade Out Right', 'anditportfolio' ),
							'bounce-in'			=> esc_html__( 'Bounce In', 'anditportfolio' ),
							'bounce-in-up' 		=> esc_html__( 'Bounce in up', 'anditportfolio' ),					
							'bounce-in-down' 	=> esc_html__( 'Bounce in down', 'anditportfolio' ),					
							'bounce-in-left' 	=> esc_html__( 'Bounce in Left', 'anditportfolio' ),					
							'bounce-in-right' 	=> esc_html__( 'Bounce in Right', 'anditportfolio' ),					
							'bounce-out'		=> esc_html__( 'Bounce In', 'anditportfolio' ),
							'bounce-out-up' 	=> esc_html__( 'Bounce Out up', 'anditportfolio' ),					
							'bounce-out-down' 	=> esc_html__( 'Bounce Out down', 'anditportfolio' ),					
							'bounce-out-left' 	=> esc_html__( 'Bounce Out Left', 'anditportfolio' ),					
							'bounce-out-right' 	=> esc_html__( 'Bounce Out Right', 'anditportfolio' ),	
							'zoom-in'			=> esc_html__( 'Zoom In', 'anditportfolio' ),
							'zoom-in-up' 		=> esc_html__( 'Zoom in up', 'anditportfolio' ),					
							'zoom-in-down' 		=> esc_html__( 'Zoom in down', 'anditportfolio' ),					
							'zoom-in-left' 		=> esc_html__( 'Zoom in Left', 'anditportfolio' ),					
							'zoom-in-right' 	=> esc_html__( 'Zoom in Right', 'anditportfolio' ),					
							'zoom-out'			=> esc_html__( 'Zoom In', 'anditportfolio' ),
							'zoom-out-up' 		=> esc_html__( 'Zoom Out up', 'anditportfolio' ),					
							'zoom-out-down' 	=> esc_html__( 'Zoom Out down', 'anditportfolio' ),					
							'zoom-out-left' 	=> esc_html__( 'Zoom Out Left', 'anditportfolio' ),					
							'zoom-out-right' 	=> esc_html__( 'Zoom Out Right', 'anditportfolio' ),
							'flash' 			=> esc_html__( 'Flash', 'anditportfolio' ),
							'strobe'			=> esc_html__( 'Strobe', 'anditportfolio' ),
							'shake-x'			=> esc_html__( 'Shake X', 'anditportfolio' ),
							'shake-y'			=> esc_html__( 'Shake Y', 'anditportfolio' ),
							'bounce' 			=> esc_html__( 'Bounce', 'anditportfolio' ),
							'tada'				=> esc_html__( 'Tada', 'anditportfolio' ),
							'rubber-band'		=> esc_html__( 'Rubber Band', 'anditportfolio' ),
							'swing' 			=> esc_html__( 'Swing', 'anditportfolio' ),
							'spin'				=> esc_html__( 'Spin', 'anditportfolio' ),
							'spin-reverse'		=> esc_html__( 'Spin Reverse', 'anditportfolio' ),
							'slingshot'			=> esc_html__( 'Slingshot', 'anditportfolio' ),
							'slingshot-reverse'	=> esc_html__( 'Slingshot Reverse', 'anditportfolio' ),
							'wobble'			=> esc_html__( 'Wobble', 'anditportfolio' ),
							'pulse' 			=> esc_html__( 'Pulse', 'anditportfolio' ),
							'pulsate'			=> esc_html__( 'Pulsate', 'anditportfolio' ),
							'heartbeat'			=> esc_html__( 'Heartbeat', 'anditportfolio' ),
							'panic' 			=> esc_html__( 'Panic', 'anditportfolio' )				
				],
				'condition'	=> [
					'addon_animate'	=> 'on'
				]
			]
		);			

		$this->add_control(
			'delay',
			[
				'label' => esc_html__( 'Animate Delay (ms)', 'anditportfolio' ),
				'type' => Controls_Manager::TEXT,
				'default' => '1000',
				'condition'	=> [
					'addon_animate'	=> 'on'
				]
			]
		);	
		
		$this->end_controls_section();


		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'anditportfolio' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'custom_style',
			[
				'label' => esc_html__( 'Custom Style', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'off',
				'options' => [
					'off'	=> 'Off',
					'on' 	=> 'On'					
				]
			]
		);

		$this->add_control(
			'title_fs',
			[
				'label' => esc_html__( 'Title Font Size (px)', 'anditportfolio' ),
				'type' => Controls_Manager::TEXT,
				'default' => '25',
				'condition'	=> [
					'custom_style'	=> 'on'
				]
			]
		);

		$this->add_control(
			'content_fs',
			[
				'label' => esc_html__( 'Content Font Size (px)', 'anditportfolio' ),
				'type' => Controls_Manager::TEXT,
				'default' => '20',
				'condition'	=> [
					'custom_style'	=> 'on'
				]
			]
		);	

		$this->add_control(
			'main_color',
			[
				'label' => esc_html__( 'Main Color', 'anditportfolio' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#333333',
				'condition'	=> [
					'custom_style'	=> 'on'
				]
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label' => esc_html__( 'Second Color', 'anditportfolio' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#747474',
				'condition'	=> [
					'custom_style'	=> 'on'
				]
			]
		);
		
		$this->add_control(
			'font_color',
			[
				'label' => esc_html__( 'Font Color', 'anditportfolio' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#AAAAAA',
				'condition'	=> [
					'custom_style'	=> 'on'
				]
			]
		);

		$this->add_control(
			'a_color',
			[
				'label' => esc_html__( 'Link Color', 'anditportfolio' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'condition'	=> [
					'custom_style'	=> 'on'
				]
			]
		);

		$this->add_control(
			'over_color',
			[
				'label' => esc_html__( 'Hover Color', 'anditportfolio' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000000',
				'condition'	=> [
					'custom_style'	=> 'on'
				]
			]
		);
		
		$this->end_controls_section();
		
	}

	 
	 /**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		static $instance = 0;
		$instance++;		
		$settings = $this->get_settings_for_display();
	
        $skin					= esc_html($settings['skin']);
		$grid_masonry			= 'anditwp_grid';
		$columns 				= '1'; 
		$item_show				= esc_html($settings['item_show']);
		$item_show_900			= esc_html($settings['item_show_900']);
		$item_show_600			= esc_html($settings['item_show_600']);
		$loop					= esc_html($settings['loop']);
		$autoplay				= esc_html($settings['autoplay']);
		$smart_speed			= esc_html($settings['smart_speed']);
		$navigation				= esc_html($settings['navigation']);
		$c_pagination			= esc_html($settings['pagination']);
		$margin					= esc_html($settings['margin']);
		$rtl					= esc_html($settings['rtl']);
		
		// Query
		$source					= esc_html($settings['source']);
		$posts_source			= esc_html($settings['posts_source']);
		$posts_type				= esc_html($settings['posts_type']);
		$categories				= '';
		if(!empty($settings['categories'])) {
			$num_cat = count($settings['categories']);
			$i = 1;
			foreach ( $settings['categories'] as $element ) {
				$categories .= $element;
				if($i != $num_cat) {
					$categories .= ',';
				}
				$i++;
			}		
		}		
		$categories_post_type	= '';
		$pagination				= '';
		$pagination_type		= '';
		$num_posts_page			= '';
		$num_posts				= esc_html($settings['num_posts']);	
		$orderby				= esc_html($settings['orderby']);
		$order					= esc_html($settings['order']);
					
		// Style
        $custom_style			= esc_html($settings['custom_style']);
        $title_fs				= esc_html($settings['title_fs']);
        $content_fs				= esc_html($settings['content_fs']);
        $main_color				= esc_html($settings['main_color']);
        $secondary_color		= esc_html($settings['secondary_color']);
        $font_color				= esc_html($settings['font_color']);
        $a_color				= esc_html($settings['a_color']);
        $over_color				= esc_html($settings['over_color']);
        $margin_right			= '0';
        $margin_bottom			= '0';
		
		// Animations
		$addon_animate			= esc_html($settings['addon_animate']);
		$effect					= esc_html($settings['effect']);
		$delay					= esc_html($settings['delay']);
			
		wp_enqueue_style( 'animations' );
		wp_enqueue_script( 'appear' );			
		wp_enqueue_script( 'animate' );
		wp_enqueue_style( 'elementor-icons' );
		wp_enqueue_style( 'font-awesome' );	
		wp_enqueue_style( 'magnific-popup' );
		wp_enqueue_script( 'magnific-popup' );
		wp_enqueue_style( 'owlcarousel' );
		wp_enqueue_style( 'owltheme' );				
		wp_enqueue_script( 'owlcarousel' );
		wp_enqueue_script( 'anditportfolio-carousel' );
		
		// LOOP QUERY
		$query = andit_query( $source,
							$posts_source, 
							$posts_type, 
							$categories,
							$categories_post_type, 
							$order, 
							$orderby, 
							$pagination, 
							$pagination_type,
							$num_posts, 
							$num_posts_page );

		echo '<div class="clearfix"></div>';
		
		$count = 0;
		
		echo '<style type="text/css">';
		
			if($custom_style == 'off') :
				if($skin == 'carouselstyle1') {$fonts = 'google_fonts'; $gfonts = 'Open Sans'; 	$title_fs = '30';
					$content_fs = '15';	$main_color = 'rgba(41,128,185,0.3)';$secondary_color = 'rgba(255,255,255,1)';
					$font_color = 'rgba(255,255,255,1)'; $a_color = 'rgba(255,255,255,1)';
					$over_color = 'rgba(41,128,185,1)';$margin_right = '0'; $margin_bottom = '0';	
				}
				if($skin == 'carouselstyle2') {$fonts = 'google_fonts'; $gfonts = 'Open Sans'; 	$title_fs = '30';
					$content_fs = '15';	$main_color = 'rgba(142,68,173,0.8)';$secondary_color = 'rgba(255,255,255,1)';
					$font_color = 'rgba(255,255,255,1)'; $a_color = 'rgba(255,255,255,1)';
					$over_color = 'rgba(255,255,255,1)';$margin_right = '0'; $margin_bottom = '0';	
				}	
				if($skin == 'carouselstyle3') {$fonts = 'google_fonts'; $gfonts = 'Open Sans'; 	$title_fs = '30';
					$content_fs = '20';	$main_color = 'rgba(255,255,255,1)';$secondary_color = 'rgba(255,255,255,1)';
					$font_color = 'rgba(243,156,18,1)'; $a_color = 'rgba(243,156,18,1)';
					$over_color = 'rgba(0,0,0,1)';$margin_right = '0'; $margin_bottom = '0';	
				}	
				if($skin == 'carouselstyle4') {$fonts = 'google_fonts'; $gfonts = 'Open Sans'; 	$title_fs = '32';
					$content_fs = '15';	$main_color = 'rgba(0,0,0,0.8)';$secondary_color = 'rgba(255,255,255,1)';
					$font_color = 'rgba(255,255,255,1)'; $a_color = 'rgba(255,255,255,1)';
					$over_color = 'rgba(143,143,143,1)';$margin_right = '0'; $margin_bottom = '0';	
				}
				if($skin == 'carouselstyle5') {$fonts = 'google_fonts'; $gfonts = 'Open Sans'; 	$title_fs = '22';
					$content_fs = '12';	$main_color = 'rgba(22,160,133,1)';$secondary_color = 'rgba(255,255,255,1)';
					$font_color = 'rgba(255,255,255,1)'; $a_color = 'rgba(255,255,255,1)';
					$over_color = 'rgba(0,0,0,1)';$margin_right = '0'; $margin_bottom = '0';	
				}
				if($skin == 'carouselstyle6') {$fonts = 'google_fonts'; $gfonts = 'Open Sans'; 	$title_fs = '30';
					$content_fs = '16';	$main_color = 'rgba(41,128,185,1)';$secondary_color = 'rgba(41,128,185,0.5)';
					$font_color = 'rgba(255,255,255,1)'; $a_color = 'rgba(41,128,185,1)';
					$over_color = 'rgba(181,212,233,1)';$margin_right = '0'; $margin_bottom = '0';	
				}
				if($skin == 'carouselstyle7') {$fonts = 'google_fonts'; $gfonts = 'Open Sans'; 	$title_fs = '32';
					$content_fs = '16';	$main_color = 'rgba(0,0,0,1)';$secondary_color = 'rgba(0,0,0,1)';
					$font_color = 'rgba(0,0,0,1)'; $a_color = 'rgba(255,255,255,1)';
					$over_color = 'rgba(0,0,0,1)';$margin_right = '0'; $margin_bottom = '0';	
				}
				if($skin == 'carouselstyle8') {$fonts = 'google_fonts'; $gfonts = 'Open Sans'; 	$title_fs = '30';
					$content_fs = '14';	$main_color = 'rgba(75,75,75,1)';$secondary_color = 'rgba(75,75,75,1)';
					$font_color = 'rgba(75,75,75,1)'; $a_color = 'rgba(75,75,75,1)';
					$over_color = 'rgba(0,0,0,1)';$margin_right = '0'; $margin_bottom = '0';	
				}				
			endif;
			echo andit_custom_style($instance,
											'andit-type-carousel',
											$grid_masonry,
											$columns,
											$settings_type,
											$skin,
											$fonts,
											$gfonts,
											$title_fs,
											$content_fs,
											$main_color,
											$secondary_color,
											$font_color,
											$a_color,
											$over_color,
											$margin_right,
											$margin_bottom);
			
		echo '</style>';

		echo '<div class="andit-general-container andit-container-number-'.esc_html($instance).' '.esc_html($skin).'">';
		
		echo '<div 
							data-andit-carousel-owl-items="'.esc_html($item_show).'" 
							data-andit-carousel-owl-items-900="'.esc_html($item_show_900).'" 
							data-andit-carousel-owl-items-600="'.esc_html($item_show_600).'" 
							data-andit-carousel-owl-loop="'.esc_html($loop).'" 
							data-andit-carousel-owl-autoplay="'.esc_html($autoplay).'" 
							data-andit-carousel-owl-smart-speed="'.esc_html($smart_speed).'" 
							data-andit-carousel-owl-navigation="'.esc_html($navigation).'" 
							data-andit-carousel-owl-pagination="'.esc_html($c_pagination).'" 
							data-andit-carousel-owl-margin="'.esc_html($margin).'" 
							data-andit-carousel-owl-rtl="'.esc_html($rtl).'"	
		class="andit-container andit-type-carousel grid-columns-'.esc_html($columns).' andit-grid andit-icon  andit-'.esc_html($instance).' '.esc_html($skin).' '.esc_html($grid_masonry).' '.andit_animate_class($addon_animate,$effect,$delay).'>';
		
		$numthumbs = 1;
		// Start Query Loop
		$loop = new \WP_Query($query);		

		
		if($loop) :
			while ( $loop->have_posts() ) : $loop->the_post();
		
				$id_post = get_the_id();
				$link = get_permalink(); 
				$pinterestimage = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

				echo '<figure class="andit-grid-item">';
		
			if($skin == 'carouselstyle1' || $skin == 'carouselstyle2' || $skin == 'carouselstyle3' || $skin == 'carouselstyle4') {
				echo andit_get_thumb($grid_masonry);
				echo '<div class="ac-container">';
				echo '	<h1 class="title">'.get_the_title().'</h1>
								<div class="ac-icon">';
									echo '<a target="_blank" class="icon-facebook fa fa-facebook" href="http://www.facebook.com/sharer.php?u='.get_the_permalink().'&amp;t='.get_the_title().'" title="'.esc_html__('Click to share this post on Facebook','anditportfolio').'"></a>
												<a target="_blank" class="icon-twitter fa fa-twitter" href="http://twitter.com/home?status='.get_the_permalink().'" title="'.esc_html__('Click to share this post on Twitter','anditportfolio').'"></a>
        										<a target="_blank" class="icon-pinterest fa fa-pinterest" href="http://pinterest.com/pin/create/button/?url='.urlencode(get_permalink()).'&media='.esc_url($pinterestimage[0]).'&description='.get_the_title().'" title="'.esc_html__('Click to share this post on Pinterest','anditportfolio').'"></a>';
								echo '</div>
						   </div>';
			}
			if($skin == 'carouselstyle5') {
				echo andit_get_thumb($grid_masonry);
				echo '<div class="ac-container">';
				echo '	<h1 class="title">'.get_the_title().'</h1>
								<div class="ac-icon">
                           			<div class="line-top"></div>
                            		<div class="text">'.andit_get_blogs_excerpt(200,'no','').'</div>
                            		<div class="line-bottom"></div>
									<div class="ac-social-container">';								
									echo '<a target="_blank" class="icon-facebook fa fa-facebook" href="http://www.facebook.com/sharer.php?u='.get_the_permalink().'&amp;t='.get_the_title().'" title="'.esc_html__('Click to share this post on Facebook','anditportfolio').'"></a>
												<a target="_blank" class="icon-twitter fa fa-twitter" href="http://twitter.com/home?status='.get_the_permalink().'" title="'.esc_html__('Click to share this post on Twitter','anditportfolio').'"></a>
        										<a target="_blank" class="icon-pinterest fa fa-pinterest" href="http://pinterest.com/pin/create/button/?url='.urlencode(get_permalink()).'&media='.esc_url($pinterestimage[0]).'&description='.get_the_title().'" title="'.esc_html__('Click to share this post on Pinterest','anditportfolio').'"></a>';
							echo	'</div>
								</div>
						   </div>';
			}	
			if($skin == 'carouselstyle6') {
				echo '<div class="container-top">';
				echo andit_get_thumb($grid_masonry);
				echo '<div class="hover-img">
                  				<a href="'.esc_url($link).'" class="icon-plus fa fa-plus"></a>
                  			</div></div>';
				echo '<div class="ac-container">';
				echo '	<h1 class="title">'.get_the_title().'</h1>
								<div class="ac-icon">
                            		
									<div class="ac-social-container">';
									echo '<a target="_blank" class="icon-facebook fa fa-facebook" href="http://www.facebook.com/sharer.php?u='.get_the_permalink().'&amp;t='.get_the_title().'" title="'.esc_html__('Click to share this post on Facebook','anditportfolio').'"></a>
												<a target="_blank" class="icon-twitter fa fa-twitter" href="http://twitter.com/home?status='.get_the_permalink().'" title="'.esc_html__('Click to share this post on Twitter','anditportfolio').'"></a>
        										<a target="_blank" class="icon-pinterest fa fa-pinterest" href="http://pinterest.com/pin/create/button/?url='.urlencode(get_permalink()).'&media='.esc_url($pinterestimage[0]).'&description='.get_the_title().'" title="'.esc_html__('Click to share this post on Pinterest','anditportfolio').'"></a>';

							echo	'</div>								
								</div>
								<div class="text">'.andit_get_blogs_excerpt(200,'no','').'</div>
						   </div>';
			}	
			if($skin == 'carouselstyle7') {
				echo andit_get_thumb($grid_masonry);
				echo '<div class="ac-container">';
				echo '	<h1 class="title">'.get_the_title().'</h1>
								<div class="ac-icon">                            		
									<div class="ac-social-container">';	
									echo '<a target="_blank" class="icon-facebook fa fa-facebook" href="http://www.facebook.com/sharer.php?u='.get_the_permalink().'&amp;t='.get_the_title().'" title="'.esc_html__('Click to share this post on Facebook','anditportfolio').'"></a>
												<a target="_blank" class="icon-twitter fa fa-twitter" href="http://twitter.com/home?status='.get_the_permalink().'" title="'.esc_html__('Click to share this post on Twitter','anditportfolio').'"></a>
        										<a target="_blank" class="icon-pinterest fa fa-pinterest" href="http://pinterest.com/pin/create/button/?url='.urlencode(get_permalink()).'&media='.esc_url($pinterestimage[0]).'&description='.get_the_title().'" title="'.esc_html__('Click to share this post on Pinterest','anditportfolio').'"></a>';

							echo	'</div>								
								</div>
								<div class="text">'.andit_get_blogs_excerpt(200,'no','').'</div>
						   </div>';
			}
			if($skin == 'carouselstyle8') {
				echo andit_get_thumb($grid_masonry);
				echo '<div class="ac-container">';
				echo '	<h1 class="title">'.get_the_title().'</h1>
								<div class="text">'.andit_get_blogs_excerpt(200,'no','').'</div>
								<div class="ac-icon">                            		
									<div class="ac-social-container">';	
									echo '<a target="_blank" class="icon-facebook fa fa-facebook" href="http://www.facebook.com/sharer.php?u='.get_the_permalink().'&amp;t='.get_the_title().'" title="'.esc_html__('Click to share this post on Facebook','anditportfolio').'"></a>
												<a target="_blank" class="icon-twitter fa fa-twitter" href="http://twitter.com/home?status='.get_the_permalink().'" title="'.esc_html__('Click to share this post on Twitter','anditportfolio').'"></a>
        										<a target="_blank" class="icon-pinterest fa fa-pinterest" href="http://pinterest.com/pin/create/button/?url='.urlencode(get_permalink()).'&media='.esc_url($pinterestimage[0]).'&description='.get_the_title().'" title="'.esc_html__('Click to share this post on Pinterest','anditportfolio').'"></a>';
								
							echo	'<a href="'.esc_url($link).'" class="icon-plus fa fa-plus"></a></div>								
								</div>
								
						   </div>';
			}					
						
				echo '</figure>'; // CLOSE FIGURE
		
				$numthumbs++;	
			endwhile;
		endif;	
		
		echo '</div>';		
		wp_reset_query();
		echo '</div>';
		

		
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {}
}
