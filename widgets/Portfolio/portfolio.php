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
 * @since 0.0.1
 */
class ANDIT_Portfolio extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 0.0.1
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'andit-portfolio';
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
		return esc_html__( 'And IT Portfolio', 'anditportfolio' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 0.0.1
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 0.0.1
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
	 * @since 0.0.1
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
				'default' => 'portfoliostyle1',
				'options' => [
					'portfoliostyle1' 			=> esc_html__('Style 1', 'anditportfolio' ),
					'portfoliostyle2' 	=> esc_html__('Style 2', 'anditportfolio' ),
					'portfoliostyle3' 		=> esc_html__('Style 3', 'anditportfolio' ),
					'portfoliostyle4' 	=> esc_html__('Style 4', 'anditportfolio' ),
					'portfoliostyle5' 	=> esc_html__('Style 5', 'anditportfolio' ),
					'portfoliostyle6' 	=> esc_html__('Style 6', 'anditportfolio' ),
					'portfoliostyle7' 		=> esc_html__('Style 7', 'anditportfolio' )
				]
			]
		);

		$this->add_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => '2',
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
			'show_date',
			[
				'label' => esc_html__( 'Show Date', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'true'  => esc_html__('Show', 'anditportfolio' ),
					'false' => esc_html__('Hidden', 'anditportfolio' )
				]
			]
		);

		$this->add_control(
			'show_comments',
			[
				'label' => esc_html__( 'Show Comments', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'true'  => esc_html__('Show', 'anditportfolio' ),
					'false' => esc_html__('Hidden', 'anditportfolio' )
				]
			]
		);

		$this->add_control(
			'show_category',
			[
				'label' => esc_html__( 'Show Category', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'true'  => esc_html__('Show', 'anditportfolio' ),
					'false' => esc_html__('Hidden', 'anditportfolio' )
				]
			]
		);

		$this->add_control(
			'show_author',
			[
				'label' => esc_html__( 'Show Author', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'true'  => esc_html__('Show', 'anditportfolio' ),
					'false' => esc_html__('Hidden', 'anditportfolio' )
				]
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label' => esc_html__( 'Show Excerpt', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'true'  => esc_html__('Show', 'anditportfolio' ),
					'false' => esc_html__('Hidden', 'anditportfolio' )
				]
			]
		);

		$this->add_control(
			'num_excerpt',
			[
				'label' => esc_html__( 'Number of characters of the Excerpt', 'anditportfolio' ),
				'type' => Controls_Manager::TEXT,
				'default' => '200',
				'condition'	=> [
					'show_excerpt'	=> 'true'
				]
			]
		);

		$this->add_control(
			'show_views',
			[
				'label' => esc_html__( 'Show Views', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'true',
				'options' => [
					'true'  => esc_html__('Show', 'anditportfolio' ),
					'false' => esc_html__('Hidden', 'anditportfolio' )
				]
			]
		);

		$this->add_control(
			'grid_masonry',
			[
				'label' => esc_html__( 'Grid/Masonry', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'anditwp_grid',
				'options' => [
					'anditwp_grid'  => esc_html__('Grid', 'anditportfolio' ),
					'anditwp_masonry' => esc_html__('Masonry', 'anditportfolio' )
				]
			]
		);

		$this->add_control(
			'filter',
			[
				'label' => esc_html__( 'Filter', 'anditportfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'off',
				'options' => [
					'on'  => esc_html__('Show', 'anditportfolio' ),
					'off' => esc_html__('Hidden', 'anditportfolio' )
				],
				'condition'	=> [
					'grid_masonry'	=> 'anditwp_grid'
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

		$this->add_control(
			'margin_right',
			[
				'label' => esc_html__( 'Margin right (px)', 'anditportfolio' ),
				'type' => Controls_Manager::TEXT,
				'default' => '10px',
				'condition'	=> [
					'custom_style'	=> 'on'
				]
			]
		);	

		$this->add_control(
			'margin_bottom',
			[
				'label' => esc_html__( 'Margin bottom (px)', 'anditportfolio' ),
				'type' => Controls_Manager::TEXT,
				'default' => '10px',
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
        $columns				= esc_html($settings['columns']);
        $show_date				= esc_html($settings['show_date']);
        $show_comments			= esc_html($settings['show_comments']);
        $show_category			= esc_html($settings['show_category']);
        $show_author			= esc_html($settings['show_author']);
        $show_excerpt			= esc_html($settings['show_excerpt']);
        $num_excerpt			= esc_html($settings['num_excerpt']);
        $show_views				= esc_html($settings['show_views']);
        $filter					= esc_html($settings['filter']);
        $grid_masonry			= esc_html($settings['grid_masonry']);
		
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
		$pagination				= 'no';
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
        $margin_right			= esc_html($settings['margin_right']);
        $margin_bottom			= esc_html($settings['margin_bottom']);
		
		// Animations
		$addon_animate			= esc_html($settings['addon_animate']);
		$effect					= esc_html($settings['effect']);
		$delay					= esc_html($settings['delay']);
			
		wp_enqueue_style( 'animations' );
		wp_enqueue_script( 'appear' );			
		wp_enqueue_script( 'animate' );
		wp_enqueue_style( 'elementor-icons' );
		wp_enqueue_style( 'font-awesome' );	
		wp_enqueue_script( 'anditportfoliogrid' );
		
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
				if($skin == 'portfoliostyle1') {$fonts = 'google_fonts'; $gfonts = 'Open Sans'; 	$title_fs = '20';
					$content_fs = '14';	$main_color = 'rgba(44,62,80,0.5)';$secondary_color = 'rgba(52,73,94,1)';
					$font_color = 'rgba(255,255,255,1)'; $a_color = 'rgba(255,255,255,1)';
					$over_color = 'rgba(0,0,0,1)';$margin_right = '10px'; $margin_bottom = '10px';	
				}
				if($skin == 'portfoliostyle2') {$fonts = 'google_fonts'; $gfonts = 'Open Sans'; 	$title_fs = '26';
					$content_fs = '16';	$main_color = 'rgba(0,0,0,0.8)';$secondary_color = 'rgba(0,0,0,0.3)';
					$font_color = 'rgba(255,255,255,1)'; $a_color = 'rgba(255,255,255,1)';
					$over_color = 'rgba(0,0,0,1)';$margin_right = '15px'; $margin_bottom = '15px';	
				}
				if($skin == 'portfoliostyle3') {$fonts = 'google_fonts'; $gfonts = 'Open Sans'; 	$title_fs = '18';
					$content_fs = '14';	$main_color = 'rgba(0,0,0,0.4)';$secondary_color = 'rgba(0,0,0,0.8)';
					$font_color = 'rgba(255,255,255,1)'; $a_color = 'rgba(255,255,255,1)';
					$over_color = 'rgba(0,0,0,1)';$margin_right = '25px'; $margin_bottom = '25px';	
				}
				if($skin == 'portfoliostyle4') {$fonts = 'google_fonts'; $gfonts = 'Open Sans'; 	$title_fs = '24';
					$content_fs = '14';	$main_color = 'rgba(255,255,255,1)';$secondary_color = 'rgba(0,0,0,0.5)';
					$font_color = 'rgba(78,78,78,1)'; $a_color = 'rgba(78,78,78,1)';
					$over_color = 'rgba(0,0,0,1)';$margin_right = '50px'; $margin_bottom = '50px';	
				}			
				if($skin == 'portfoliostyle5') {$fonts = 'google_fonts'; $gfonts = 'Open Sans'; 	$title_fs = '20';
					$content_fs = '15';	$main_color = 'rgba(192,57,43,1)';$secondary_color = 'rgba(231,76,60,1)';
					$font_color = 'rgba(255,255,255,1)'; $a_color = 'rgba(255,255,255,1)';
					$over_color = 'rgba(0,0,0,1)';$margin_right = '20px'; $margin_bottom = '20px';	
				}
				if($skin == 'portfoliostyle6') {$fonts = 'google_fonts'; $gfonts = 'Open Sans'; 	$title_fs = '22';
					$content_fs = '14';	$main_color = 'rgba(255,255,255,1)';$secondary_color = 'rgba(0,0,0,0.3)';
					$font_color = 'rgba(56,56,56,1)'; $a_color = 'rgba(56,56,56,1)';
					$over_color = 'rgba(138,138,138,1)';$margin_right = '10px'; $margin_bottom = '10px';	
				}	
				if($skin == 'portfoliostyle7') {$fonts = 'google_fonts'; $gfonts = 'Open Sans'; 	$title_fs = '22';
					$content_fs = '16';	$main_color = 'rgba(255,255,255,1)';$secondary_color = 'rgba(255,255,255,0.6)';
					$font_color = 'rgba(62,62,62,1)'; $a_color = 'rgba(217,32,32,1)';
					$over_color = 'rgba(62,62,62,1)';$margin_right = '25px'; $margin_bottom = '25px';	
				}									
			endif;
			echo andit_custom_style($instance,
											'andit-type-portfolio',
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

		echo '<div class="andit-general-container andit-filter-'.esc_html($filter).' andit-container-number-'.esc_html($instance).' andit-type-portfolio '.esc_html($skin).'">';

		/************** FILTER ***************/
		if($filter == 'on') {
			wp_enqueue_script( 'mixitup' );
			wp_enqueue_script( 'anditportfoliogrid' );
			echo andit_filter_item($skin,$instance,$source,$categories,'',$categories_post_type,$posts_type);
			echo '<div class="andit-clear"></div>';
		}
		
		echo '<div class="andit-container andit-type-portfolio grid-columns-'.esc_html($columns).' andit-grid andit-icon  andit-'.esc_html($instance).' '.esc_html($skin).' '.esc_html($grid_masonry).' '.andit_animate_class($addon_animate,$effect,$delay).'>';
		
		$numthumbs = 1;
		// Start Query Loop
		$loop = new \WP_Query($query);		

		
		if($loop) :
			while ( $loop->have_posts() ) : $loop->the_post();
		
				$id_post = get_the_id();
				$link = get_permalink(); 
				
		/************** FILTER ***************/
		if($filter == 'on') {
			echo andit_filter_item_figure($source,$categories,'',$categories_post_type,$posts_type);
		} else {
			echo '<figure class="andit-grid-item">';
		}
		/************** #FILTER ***************/
				
				if($skin == 'portfoliostyle1') {
					echo andit_get_thumb($grid_masonry);
					echo '<div class="andit-container-portfolio">
								<h1 class="andit-title">'.get_the_title().'</h1>
								<p class="andit-text">'.andit_get_blogs_excerpt($num_excerpt,'no','').'...<br></p>
								<p class="andit-info">'.andit_post_info($show_date,$show_comments,$show_author,$show_category,$show_views,$source,$posts_type,'F j, Y').'</p>							
								<a href="'.esc_url($link).'" class="andit-read-more">'.esc_html__('View more','anditportfolio').'</a>
							</div>';	
				}
			if($skin == 'portfoliostyle2') {
				echo andit_get_thumb($grid_masonry);
				echo '<div class="andit-container-portfolio">
								<h1 class="andit-title">'.get_the_title().'</h1>
								<p class="andit-info-date">'.andit_post_info($show_date,false,false,false,false,$show_views,$source,'F j, Y').'</p>															
								<p class="andit-text">'.andit_get_blogs_excerpt($num_excerpt,'no','').'<br></p>
								<p class="andit-info">'.andit_post_info(false,$show_comments,$show_author,$show_category,$show_views,$source,$posts_type,'F j, Y').'</p>							
								<a href="'.esc_url($link).'" class="andit-read-more">'.esc_html__('View more','anditportfolio').'</a>
							</div>';	
			}	
			if($skin == 'portfoliostyle3') {
				echo andit_get_thumb($grid_masonry);
				echo '<div class="andit-container-portfolio">
								<h1 class="andit-title">'.get_the_title().'</h1>								
								<p class="andit-info">'.andit_post_info($show_date,$show_comments,$show_author,$show_category,$show_views,$source,$posts_type,'F j, Y').'</p>
								<p class="andit-text">'.andit_get_blogs_excerpt($num_excerpt,'no','').'<br></p>
								<a href="'.esc_url($link).'" class="andit-read-more">'.esc_html__('View more','anditportfolio').'</a>
							</div>';	
			} 
			if($skin == 'portfoliostyle4') {
				echo '<div class="andit-image-container">';
				echo andit_get_thumb($grid_masonry);
				echo '<div class="andit-image-over">
								<a href="'.esc_url($link).'" class="icon-plus fa fa-plus"></a>
							</div></div>			
							<div class="andit-container-portfolio">
								<h1 class="andit-title">'.get_the_title().'</h1>
								<p class="andit-text">'.andit_get_blogs_excerpt($num_excerpt,'no','').'<br></p>								
								<p class="andit-info">'.andit_post_info($show_date,$show_comments,$show_author,$show_category,$show_views,$source,$posts_type,'F j, Y').'</p>								
							</div>';	
			} 
			if($skin == 'portfoliostyle5') {
				echo '<h1 class="andit-title">'.get_the_title().'</h1>';
				echo '<div class="andit-image-container">';				
				echo andit_get_thumb($grid_masonry);
				echo '<div class="andit-image-over">
								<a href="'.esc_url($link).'" class="icon-plus fa fa-plus"></a>
							</div></div>			
							<div class="andit-container-portfolio">
								<p class="andit-info">'.andit_post_info($show_date,$show_comments,$show_author,$show_category,$show_views,$source,$posts_type,'F j, Y').'</p>						
								<p class="andit-text">'.andit_get_blogs_excerpt($num_excerpt,'no','').'</p>								
							</div>';	
			} 
			if($skin == 'portfoliostyle6') {				
				echo '<div class="andit-image-container"><div class="andit-header-container">';
				echo '<span class="andit-info-date">'.andit_post_info($show_date,false,false,false,false,$source,$posts_type,'F j, Y').'</span>';				
				echo andit_get_thumb($grid_masonry);
				echo '<h1 class="andit-title">'.get_the_title().'</h1></div>';
				echo '<div class="andit-image-over"><a href="'.esc_url($link).'" class="icon-plus fa fa-plus"></a>
							</div></div>			
							<div class="andit-container-portfolio">
								<p class="andit-info">'.andit_post_info(false,$show_comments,$show_author,$show_category,$show_views,$source,$posts_type,'F j, Y').'</p>						
								<p class="andit-text">'.andit_get_blogs_excerpt($num_excerpt,'no','').'</p>
								<p class="andit-share">'.andit_share($skin).'</p>								
							</div>';	
			} 	
			if($skin == 'portfoliostyle7') {				
				echo '<div class="andit-image-container">
								<div class="andit-header-container">
								<p class="andit-share">'.andit_share($skin).'</p>';				
						echo andit_get_thumb($grid_masonry);
				echo '</div>';
				echo '<div class="andit-image-over">
							</div></div>			
							<div class="andit-container-portfolio">
								<h1 class="andit-title">'.get_the_title().'</h1>
								<p class="andit-info">'.andit_post_info(false,$show_comments,$show_author,$show_category,$show_views,$source,$posts_type,'F j, Y').'</p>						
								<p class="andit-text">'.andit_get_blogs_excerpt($num_excerpt,'no','').'</p>
								<p class="andit-info-date">'.andit_post_info($show_date,false,false,false,false,$show_views,$source,'F j, Y').'</p>				
								<a href="'.esc_url($link).'" class="andit-read-more">'.esc_html__('Read More >>','anditportfolio').'</a>								
							</div>';	
			} 			 				
				echo '</figure>'; // CLOSE FIGURE
		
				$numthumbs++;	
			endwhile;
		endif;	
		
		echo '</div><div class="clearfix"></div>';		
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
