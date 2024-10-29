<?php
/** Get Animations **/
if(!function_exists('andit_animate_class')) {
	function andit_animate_class($addon_animate,$effect,$delay) {
		if($addon_animate == 'on') : 
			wp_enqueue_script( 'appear' );			
			wp_enqueue_script( 'animate' );		
			$animate_class = ' animate-in" data-anim-type="'.$effect.'" data-anim-delay="'.$delay.'"'; 
		else :
			$animate_class = '"';
		endif;		
		return $animate_class;
	}
}

/** Get Category **/
if(!function_exists('andit_get_category')) {
	function andit_get_category($source,$posts_type,$css_link,$limit = 1) {
		$separator = ' ';
		$output = '';	
		$count = 1;
		if($source=='wp_posts') {			
			$categories = get_the_category();
			if($categories){
				foreach($categories as $category) {
					$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s",'anditportfolio' ), $category->name ) ) . '" '.$css_link.'>'.esc_html($category->cat_name).'</a>'.esc_html($separator);
					if($count == $limit) { break; }
					$count++;
				}
			}
		} elseif($source=='post_type') {
			global $post;
			$taxonomy_names = get_object_taxonomies( $posts_type );
			$term_list = wp_get_post_terms($post->ID,$taxonomy_names);
			if($term_list){
				foreach ($term_list as $tax_term) {
					$output .= '<a href="' . esc_attr(get_term_link($tax_term, $posts_type)) . '" title="' . esc_attr( sprintf( __( "View all posts in %s",'anditportfolio' ), $tax_term->name ) ) . '" '.$css_link.'>' . esc_html($tax_term->name) .'</a>'.esc_html($separator);
				}
			}
		}
		$return = trim($output, $separator);
		return $return;
	}
}

/** Get Author **/
if(!function_exists('andit_get_author')) {
	function andit_get_author($css_link) {
		$return = '<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'" '.$css_link.'>'.get_the_author_meta( 'display_name' ).'</a>';
		return $return;
	}	
}

/** Get Comments **/
if(!function_exists('andit_get_num_comments')) {	
	function andit_get_num_comments($css_comment,$css_comment_link) {
			$num_comments = get_comments_number();

			if ( $num_comments == 0 ) {
					$comments = esc_html__('No Comments','anditportfolio');
					$return = $comments;
			} elseif ( $num_comments > 1 ) {
					$comments = $num_comments . esc_html__(' Comments','anditportfolio');
					$return = '<a href="' . get_comments_link() .'" '.$css_comment_link.'>'. esc_html($comments).'</a>';
			} else {
					$comments = esc_html__('1 Comment','anditportfolio');
					$return = '<a href="' . get_comments_link() .'" '.$css_comment_link.'>'. esc_html($comments) .'</a>';
			}
			return $return;
	}
}

if(!function_exists('andit_get_only_num_comments')) {
	function andit_get_only_num_comments($css_comment,$css_comment_link) {
			$num_comments = get_comments_number();

			if ( $num_comments == 0 ) {
					$return = '<span '.$css_comment.'>'.esc_html($num_comments).'</span>';
			} elseif ( $num_comments > 1 ) {
					$return = '<a href="' . get_comments_link() .'" '.$css_comment_link.'>'. esc_html($num_comments).'</a>';
			} else {
					$return = '<a href="' . get_comments_link() .'" '.$css_comment_link.'>'. esc_html($num_comments).'</a>';
			}
			return $return;
	}
}

/** Get Thumbnails **/
if(!function_exists('andit_get_thumb')) {
	function andit_get_thumb($thumbs_size = 'andit-normal') {
		global $post;
		$link = get_the_permalink();
		if(has_post_thumbnail()){ 
				$id_post = get_the_id();					
				$single_image = wp_get_attachment_image_src( get_post_thumbnail_id($id_post), $thumbs_size );	
				$return = '<a href="'.esc_url($link).'"><img class="andit-thumbs" src="'.$single_image[0].'" alt="'.get_the_title().'"></a>';
			} else {               
				$return = '';                 
		}
		return $return;
	}
}

function andit_get_thumbs_link() {
	global $post;
	if(has_post_thumbnail()){ 
			$id_post = get_the_id();					
			$single_image = wp_get_attachment_image_src( get_post_thumbnail_id($id_post), 'anditwp_zoom' );	 					 
		} else {               
             $single_image[0] = ANDIT_URL .'assets/img/no-img.png';                 
    }	
	$return = $single_image[0];
	return $return;
}


/** Get Blog Thumbnails **/
if(!function_exists('andit_get_blogs_thumb')) {
	function andit_get_blogs_thumb($columns,$post_id) {
		global $post; 		
		if($columns == '1') :
			$return = andit_get_thumb('andit-blog-large');
		elseif($columns == '2') :
			$return = andit_get_thumb('andit-blog-medium');
		else :
			$return = andit_get_thumb('andit-blog-small');
		endif;	
		return $return;
	}
}	


/** Get Blog Excerpt **/
if(!function_exists('andit_get_blogs_excerpt')) {
	function andit_get_blogs_excerpt($excerpt = 'default',$readmore = 'on',$css_link = '') {
		global $post;
		if($excerpt == 'default') : 
			$return = get_the_excerpt();
		else :
			$return = substr(get_the_excerpt(), 0, $excerpt);
			if($readmore == 'on') :
				$return .= '<a class="article-read-more" href="'. get_permalink($post->ID) . '" '.$css_link.'>'.esc_html__('Read More','anditportfolio').'</a>';
			else :
				$return .= '...';
			endif;
		endif;
		return $return;
	}
}

/** Get News Excerpt **/
if(!function_exists('andit_get_news_excerpt')) {
	function andit_get_news_excerpt($excerpt = 'default',$readmore = 'on',$css_link) {
		global $post;
		if($excerpt == 'default') : 
			$return = get_the_excerpt();
		else :
			$return = substr(get_the_excerpt(), 0, $excerpt);
			if($readmore == 'on') :
				$return .= '<a class="article-read-more" href="'. get_permalink($post->ID) . '" '.$css_link.'><i class="fa fa-angle-double-right"></i></a>';
			else :
				$return .= '...';
			endif;
		endif;
		return $return;
	}
}

/** Get News Excerpt **/
if(!function_exists('andit_get_news_v2_excerpt')) {
	function andit_get_news_v2_excerpt($excerpt = 'default',$readmore = 'on',$css_link) {
		global $post;
		if($excerpt == 'default') : 
			$return = get_the_excerpt();
		else :
			$return = substr(get_the_excerpt(), 0, $excerpt);
			if($readmore == 'on') :
				$return .= '<a class="article-read-more" href="'. get_permalink($post->ID) . '" '.$css_link.'>...</a>';
			else :
				$return .= '...';
			endif;
		endif;
		return $return;
	}
}

/** Check Post Format **/
if(!function_exists('andit_check_post_format')) {
	function andit_check_post_format() {
		global $post;
		$format = get_post_format_string( get_post_format() );
		if($format == 'Video') :
			$return = '<span class="andit-format-type fa fa-play-circle-o"></span>';
		elseif($format == 'Audio') :
			$return = '<span class="andit-format-type fa fa-headphones"></span>';
		else :
			$return = '';
		endif;
		return $return;
	}
}

/** Post Social Share **/
if(!function_exists('andit_post_social_share')) {
	function andit_post_social_share($css_link) {
		
		$return = '<div class="container-social">
			<a target="_blank" href="http://www.facebook.com/sharer.php?u='.get_the_permalink().'&amp;t='.get_the_title().'" title="'.esc_html__('Click to share on Facebook','anditportfolio').'" '.$css_link.'><i class="fa fa-facebook"></i></a>
			<a target="_blank" href="http://twitter.com/home?status='.get_the_permalink().'" title="'.esc_html__('Click to share on Twitter','anditportfolio').'"><i class="fa fa-twitter" '.$css_link.'></i></a>
			<a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url='.get_the_permalink().'" title="'.esc_html__('Click to share on Linkedin','anditportfolio').'"><i class="fa fa-linkedin" '.$css_link.'></i></a></div>';
		
		return $return;
	}
}
/** Get Numeric Pagination **/
if(!function_exists('andit_posts_numeric_pagination')) {
	function andit_posts_numeric_pagination($pages = '', $range = 2,$loop,$paged,$css_current_pag_num,$css_link) {  
		 $showitems = ($range * 2)+1;  

		 if(empty($paged)) $paged = 1;

		 if($pages == '')
		 {
			 $pages = $loop->max_num_pages;
			 if(!$pages)
			 {
				 $pages = 1;
			 }
		 }   
		
		 $return = '';
		
		 if(1 != $pages) {		 	
			 $return .= "<div class='andittheme-numeric-pagination'>";
			 if($paged > 2 && $paged > $range+1 && $showitems < $pages) $return .=  "<a href='".get_pagenum_link(1)."' class=\"andittheme-pagination-numeric-arrow\" ".$css_link."><i class=\"fa fa-angle-double-left andittheme-icon-double-left\"></i></a>";
			 if($paged > 1 && $showitems < $pages) $return .=  "<a href='".get_pagenum_link($paged - 1)."' class=\"andittheme-pagination-numeric-arrow\" ".$css_link."><i class=\"fa fa-angle-left andittheme-icon-left\"></i></a>";

			 for ($i=1; $i <= $pages; $i++)
			 {
				 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
				 {
					 $return .=  ($paged == $i)? "<span class='current' ".$css_current_pag_num.">".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' ".$css_link.">".$i."</a>";
				 }
			 }

			 if ($paged < $pages && $showitems < $pages) $return .= "<a href='".get_pagenum_link($paged + 1)."' class=\"andittheme-pagination-numeric-arrow\" ".$css_link."><i class=\"fa fa-angle-right andittheme-icon-right\"></i></a>";
			 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) $return .=  "<a href='".get_pagenum_link($pages)."' class=\"andittheme-pagination-numeric-arrow\" ".$css_link."><i class=\"fa fa-angle-double-right andittheme-icon-double-right\"></i></a>";
			 $return .=  "</div>\n";
		 }
		 
		 return $return;
	}
}

/* Gallery Pagination */
function andit_get_gallery_pagination($num_page_for_pagination,$pagination) {
	$output = '<ul class="andit_gallery_pagination">';
	for($i=1; $i <= $num_page_for_pagination; $i++) {
		
		if($i == $pagination) {
			$output .= '<li class="mg_current">'.esc_html($i).'</li>'; // CURRENT PAGE
		} else {
			$output .= '<li><a href="'.get_post_permalink().'&mg_page='.$i.'">'.esc_html($i).'</a></li>'; // OTHER PAGE
		}
	}
	$output .= '</ul>';
	return $output;
}

/* Var Gallery Pagination */
function andit_add_query_vars_andit_gallery_pagination( $vars ){
  $vars[] = "mg_page";
  return $vars;
}
add_filter( 'query_vars', 'andit_add_query_vars_andit_gallery_pagination' );

/* Gallery Share Button */
function andit_share_button($id,$image_lightbox,$text_caption) {
	$return = '';
	$return .= '<a href="" class="fa fa-share-alt"></a>';
	$return .= '<div class="andit-gallery-social-share-container">';
		$return .= '<div class="andit-gallery-social-share-container-content">';
			$return .= '<a target="_blank" href="http://www.facebook.com/sharer.php?caption='.$text_caption.'&description='.$text_caption.'&u='.$image_lightbox.'&picture='.$image_lightbox.'"><i class="fa fa-facebook"></i></a>';
		$return .= '</div>';
	$return .= '</div>';
	return $return;
	
}

function andit_share($skin) {
	global $post;
	$pinterestimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
	
		
	$return = '<div class="andit-share-container">
        <div class="andit-share-item"><a target="_blank" class="icon-facebook fa fa-facebook" href="http://www.facebook.com/sharer.php?u='.get_the_permalink().'&amp;t='.get_the_title().'" title="'.esc_html__('Click to share on Facebook','anditportfolio').'"></a></div>
		<div class="andit-share-item"><a target="_blank" class="icon-twitter fa fa-twitter" href="http://twitter.com/home?status='.get_the_permalink().'" title="'.esc_html__('Click to share on Twitter','anditportfolio').'"></a></div>';
       
	$return .= '<div class="andit-share-item"><a target="_blank" class="icon-linkedin fa fa-linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url='.get_the_permalink().'" title="'.esc_html__('Click to share on Linkedin','anditportfolio').'"></a></div>';
	
	$return .= '<div class="andit-share-item"><a target="_blank" class="icon-pinterest fa fa-pinterest" href="http://pinterest.com/pin/create/button/?url='.urlencode(get_permalink($post->ID)).'&media='.esc_url($pinterestimage[0]).'&description='.get_the_title().'" title="'.esc_html__('Click to share on Pinterest','anditportfolio').'"></a></div>
    </div>';
	
    return $return;
    
}

function andit_post_info(
						$show_date,
						$show_comments,
						$show_author,
						$show_category,
						$show_views,
						$source,
						$posts_type,
						$date_format) {	   
		   global $post;
		   $return = '';
		   if($show_date == 'true') {
		   
		   		$return .= '<span class="andimpex-date"><i class="fa fa-calendar"></i>' . get_the_date($date_format) . '</span>'; 
			
		   }
		    
		   if($show_author == 'true') {	   
		   		$return .= '<span class="andimpex-author"><i class="fa fa-user"></i><a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'">'.get_the_author_meta( 'display_name' ).'</a></span>'; 
		   } 	
		   	   
		   if($show_comments == 'true') {
           	   
           		$return .= '<span class="andimpex-comments"><i class="fa fa-comments"></i><a href="'.get_comments_link().'">'.get_comments_number().'</a></span>';
		   
		   }
		    		    
		   if($show_category == 'true' && $source == 'wp_posts') {
		   		$return .= '<span class="andimpex-category"><i class="fa fa-tag"></i>'.andit_get_category($source,$posts_type,'',1).'</span>'; 
		   }
			
		   if($show_views == 'true') {        
		   $return .= '<span class="andimpex-views"><i class="fa fa-eye"></i>'.andit_get_post_views(get_the_ID()).'</span>';
		   }
		   
		   return $return; 		   
}

/**************************************************************************/
/************************** FUNCTION VIEW *********************************/
/**************************************************************************/

function andit_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
		$view = esc_html__('Views','anditportfolio');
        return "0";
    }
	$count_final = $count;
    return $count_final;
}

function andit_set_post_views() {
	if ( is_single() ) {
	global $post;
	$postID = $post->ID;	
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
	}
}
add_filter( 'wp_footer', 'andit_set_post_views', 200000 );


if(!function_exists('andit_query')) {
	function andit_query( $source,
						$posts_source, 
						$posts_type, 
						$categories,
						$categories_post_type,
						$order, 
						$orderby, 
						$pagination, 
						$pagination_type,
						$num_posts, 
						$num_posts_page) {
								  
						if($orderby == 'views') { 
								$orderby = 'meta_value_num'; 
								$view_order = 'views';
						} else { $view_order = ''; }	
										
						if($source == 'post_type') {
							$posts_source = 'all_posts';
						}
						
						if($posts_source == 'all_posts') {
						
							$query = 'post_type=Post&post_status=publish&ignore_sticky_posts=1&orderby='.$orderby.'&order='.$order.'';						
							
							// CUSTOM POST TYPE
							if($source == 'post_type') {
								$query .= '&post_type='.$posts_type.'';
							}

							if($view_order == 'views') { 
								$query .= '&meta_key=wpb_post_views_count';
							}
							
							// CATEGORIES POST TYPE
							if($categories_post_type != '' && !empty($categories_post_type) && $source == 'post_type') {
								$taxonomy_names = get_object_taxonomies( $posts_type );
								$query .= '&'.$taxonomy_names[0].'='.$categories_post_type.'';	
							}

							// CATEGORIES POSTS
							if($categories != '' && $categories != 'all' && !empty($categories) && $source == 'wp_posts') {
								$query .= '&category_name='.$categories.'';	
							}
								
							if($pagination == 'yes' || $pagination == 'load-more') {
								$query .= '&posts_per_page='.$num_posts_page.'';	
							} else {
								if($num_posts == '') { $num_posts = '-1'; }
								$query .= '&posts_per_page='.$num_posts.'';
							}
						
							// PAGINATION		
							if($pagination == 'yes' || $pagination == 'load-more') {
								if ( get_query_var('paged') ) {
									$paged = get_query_var('paged');
								
								} elseif ( get_query_var('page') ) {			
									$paged = get_query_var('page');			
								} else {			
									$paged = 1;			
								}			
								$query .= '&paged='.$paged.'';
							}
							// #PAGINATION	
						
						} else { // IF STICKY
							

							if($pagination == 'yes' || $pagination == 'load-more') {
								$num_posts = $num_posts_page;	
							} else {
								if($num_posts == '') { $num_posts = '-1'; }
								$num_posts = $num_posts;
							}

							// PAGINATION		
							
							if ( get_query_var('paged') ) {
								$paged = get_query_var('paged');							
							} elseif ( get_query_var('page') ) {			
								$paged = get_query_var('page');			
							} else {			
								$paged = 1;			
							}			
							
							// #PAGINATION	
												
							/* STICKY POST DA FARE ARRAY PER SCRITTURA IN ARRAY */
						
							$sticky = get_option( 'sticky_posts' );
							$sticky = array_slice( $sticky, 0, 5 );
							if($view_order == 'views') { 
								$query = array(
									'post_type' => 'post',
									'post_status' => 'publish',
									'orderby' 	=> $orderby,
									'order' => $order,
									'category_name' => $categories,
									'posts_per_page' => $num_posts,
									'meta_key' => 'wpb_post_views_count',
									'paged' => $paged, 
									'post__in'  => $sticky,
									'ignore_sticky_posts' => 1
								);
							} else {
								$query = array(
									'post_type' => 'post',
									'post_status' => 'publish',
									'orderby' 	=> $orderby,
									'order' => $order,
									'category_name' => $categories,
									'posts_per_page' => $num_posts,
									'paged' => $paged, 
									'post__in'  => $sticky,
									'ignore_sticky_posts' => 1
								);
							}						
							
						} // #all_posts
						
						return $query;	
	}
}

/************************************************************/
/*********************** CUSTOM STYLE ***********************/
/************************************************************/

function andit_custom_style(	$istance,
									$type,
									$masonrygrid,
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
									$margin_bottom
									) {
	
	// FONTS
	if($fonts != 'default') {
		if($fonts != 'google_fonts') {
			
			$return = '.andit-general-container.andit-container-number-'.$istance.' {
				font-family:'.$fonts.';
			}';
		} else {
			$return = '@import url(\'http://fonts.googleapis.com/css?family='.$gfonts.'\');';
			$return .= '.andit-general-container.andit-container-number-'.$istance.' {
				font-family:'.$gfonts.';
			}';
		}	
	}
		
	// COLUMNS FOR GRID
	

	
	if($masonrygrid == 'anditwp_grid') {
			if($margin_right != '0' || !empty($margin_right)) {
				$return .= '.andit-grid.andit-'.$istance.' {
					padding-left:'.($margin_right/2).'px;
				}';
			}		
			if($columns == '2') {		
				$return .= '
					.andit-grid.grid-columns-2.andit-'.$istance.'.anditwp_grid .andit-grid-item {
						margin-right:'.$margin_right.';
						margin-bottom:'.$margin_bottom.';
						max-width: -webkit-calc(50% - '.$margin_right.');
						max-width:         calc(50% - '.$margin_right.');
					}';
			}
			if($columns == '3') {		
				$return .= '
					.andit-grid.grid-columns-3.andit-'.$istance.'.anditwp_grid .andit-grid-item {
						margin-right:'.$margin_right.';
						margin-bottom:'.$margin_bottom.';
						max-width: -webkit-calc(33.333333% - '.$margin_right.');
						max-width:         calc(33.333333% - '.$margin_right.');
					}';
			}
			if($columns == '4') {		
				$return .= '
					.andit-grid.grid-columns-4.andit-'.$istance.'.anditwp_grid .andit-grid-item {
						margin-right:'.$margin_right.';
						margin-bottom:'.$margin_bottom.';
						max-width: -webkit-calc(25% - '.$margin_right.');
						max-width:         calc(25% - '.$margin_right.');
					}';
			}			
			if($columns == '5') {		
				$return .= '
					.andit-grid.grid-columns-5.andit-'.$istance.'.anditwp_grid .andit-grid-item {
						margin-right:'.$margin_right.';
						margin-bottom:'.$margin_bottom.';
						max-width: -webkit-calc(20% - '.$margin_right.');
						max-width:         calc(20% - '.$margin_right.');
					}';
			}
	} else {
			if($columns == '2') {		
				$return .= '
					.andit-grid.grid-columns-2.andit-'.$istance.'.anditwp_masonry .andit-grid-item {
						margin-right:'.$margin_right.';
						margin-bottom:'.$margin_bottom.';
						max-width: -webkit-calc(50% - '.$margin_right.');
						max-width:         calc(50% - '.$margin_right.');
						width:50%;
					}';
			}
			if($columns == '3') {		
				$return .= '
					.andit-grid.grid-columns-3.andit-'.$istance.'.anditwp_masonry .andit-grid-item {
						margin-right:'.$margin_right.';
						margin-bottom:'.$margin_bottom.';
						max-width: -webkit-calc(33.333333% - '.$margin_right.');
						max-width:         calc(33.333333% - '.$margin_right.');
					}';
			}
			if($columns == '4') {		
				$return .= '
					.andit-grid.grid-columns-4.andit-'.$istance.'.anditwp_masonry .andit-grid-item {
						margin-right:'.$margin_right.';
						margin-bottom:'.$margin_bottom.';
						max-width: -webkit-calc(25% - '.$margin_right.');
						max-width:         calc(25% - '.$margin_right.');
					}';
			}			
			if($columns == '5') {		
				$return .= '
					.andit-grid.grid-columns-5.andit-'.$istance.'.anditwp_masonry .andit-grid-item {
						margin-right:'.$margin_right.';
						margin-bottom:'.$margin_bottom.';
						max-width: -webkit-calc(20% - '.$margin_right.');
						max-width:         calc(20% - '.$margin_right.');
					}';
			}			
	}
	// FONT SIZE
	
	$return .= '
			.andit-grid.andit-'.$istance.' h1 {
				font-size:'.$title_fs.'px;
			}
			.andit-grid.andit-'.$istance.' p, .andit-grid.andit-'.$istance.' .andit-read-more,
			.andit-container-portfolio,
			.andit-header-container
			 {
				font-size:'.$content_fs.'px;
			}';
	/*
	$return .= '
	.andit-grid.anditwp_masonry {
		-webkit-column-gap:'.$margin_right.';
		-moz-column-gap:'.$margin_right.';
		column-gap:'.$margin_right.';
	}
	.andit-grid.anditwp_masonry .andit-grid-item {
		margin-bottom:'.$margin_bottom.';
	}
	';*/
		if($type == 'andit-type-grid') {
			$return .= '
			.andit-grid.andit-'.$istance.' .andit-grid-item:hover .andit-container-grid, 
			.andit-controls ul li,
			.andit-container-grid .andit-title { 
				color:'.$font_color.';
			}
			.andit-grid.andit-'.$istance.' .andit-grid-item:hover .andit-container-grid a {
				color:'.$a_color.';
				background:'.$secondary_color.';
			}
			.andit-grid.andit-'.$istance.' .andit-grid-item:hover .andit-container-grid a:hover,
			.andit-controls .active, .andit-controls .filter:hover {
				color:'.$over_color.';
			} 	
			.andit-grid.andit-'.$istance.' .andit-grid-item:hover .andit-container-grid {
				background:'.$main_color.';
			}';
		}
		if($type == 'andit-type-portfolio') {
			if($skin == 'portfoliostyle5') {
					$return .= '.andit-'.$istance.' .andit-title { 
									color:'.$font_color.';
							}';
			}
			$return .= '.andit-'.$istance.' .andit-container-portfolio,
			.andit-'.$istance.' .andit-container-portfolio .andit-title { 
				color:'.$font_color.';
			}
			.andit-grid.andit-'.$istance.' .andit-grid-item .andit-container-portfolio a {
				color:'.$a_color.';
			}	
			.andit-controls .active, .andit-controls .filter:hover,
			.andit-grid.andit-'.$istance.' .andit-grid-item .andit-container-portfolio a:hover {
				color:'.$over_color.';
			}';			
		}
			
			
			
			
			
			$return .= '.andit-container-number-'.$istance.' .andit-pagination span {
				color:'.$over_color.';
			}
			.andit-container-number-'.$istance.' .andit-pagination a {
				color:'.$font_color.';	
			}
			.andit-container-number-'.$istance.' .andit-pagination a:hover {
				color:'.$over_color.';	
			}';		
		
		
		
		
		if($skin == 'gridstyle3') {
			$return .= '.andit-container-number-'.$istance.' .gridstyle3 .andit-container-grid .andit-title {
				border-color:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.' .gridstyle3 .andit-container-grid .andit-title {
				font-size:'.$title_fs.'px;
				line-height:'.$title_fs.'px;
			}
			';
		}
		if($skin == 'gridstyle4') {
			$return .= '.andit-container-number-'.$istance.' .andit-controls.filter-gridstyle4 ul li, 
			.andit-container-number-'.$istance.'  .andit-pagination.gridstyle4 a, 
			.andit-container-number-'.$istance.'  .andit-pagination.gridstyle4 .current
			 {
				background:'.$secondary_color.';
			}';
			if($margin_right == '0px' || empty($margin_right)) {
				$return .= '.andit-container-number-'.$istance.' .andit-controls.filter-gridstyle4 ul li {
					border-right:1px solid '.$font_color.';
					margin-right:0px;
				}
				.andit-container-number-'.$istance.' .andit-controls.filter-gridstyle4 ul li:last-child {
					border-right:0px;
				}							
				';
			} else {
				$return .= '.andit-container-number-'.$istance.' .andit-controls.filter-gridstyle4 ul li {
					border-right:0px;
					margin-right:10px;
				}';				
			}
			$return .= '.andit-container-number-'.$istance.' .gridstyle4 .andit-container-grid .andit-title {
					font-size:'.$title_fs.'px;
					line-height:'.($title_fs+8).'px;
			}';
		}
		if($skin == 'gridstyle5') {
			$return .= '.andit-container-number-'.$istance.' .gridstyle5 .andit-grid-item:hover .andit-title {
					margin-top:-'.($title_fs/2+10).'px;
			}
			.andit-container-number-'.$istance.' .gridstyle5 .andit-container-grid .andit-title {
				border-color:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.' .gridstyle5 .andit-container-grid .andit-title {
				font-size:'.$title_fs.'px;
				line-height:'.$title_fs.'px;
			}
			.andit-container-number-'.$istance.' .andit-controls.filter-gridstyle5 ul li {
				border:1px solid '.$secondary_color.';
				margin-right:10px;
				padding:10px 20px;
				border-radius:5px;
			}
			.andit-container-number-'.$istance.' .andit-pagination.gridstyle5 .pagination a,
			.andit-container-number-'.$istance.' .andit-pagination.gridstyle5 .pagination .current {
				border:1px solid '.$secondary_color.';
			}
			.andit-container-number-'.$istance.' .andit-pagination.gridstyle5 a {
				border:1px solid '.$secondary_color.';
			}									
			.andit-container-number-'.$istance.' .andit-controls.filter-gridstyle5 ul li:hover, 
			.andit-container-number-'.$istance.' .andit-controls.filter-gridstyle5 ul li.active,
			.andit-container-number-'.$istance.' .andit-pagination.gridstyle5 .current,
			.andit-container-number-'.$istance.' .andit-pagination.gridstyle5 a:hover {
				background:'.$secondary_color.';
			}';
		}
		if($skin == 'gridstyle6') {
			$return .= '.andit-container-number-'.$istance.' .gridstyle6 .andit-container-grid .andit-title {
				background:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.' .andit-controls.filter-gridstyle6 ul li {
				background:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.' .andit-pagination.gridstyle6 span, 
			.andit-container-number-'.$istance.' .andit-pagination.gridstyle6 a {
				background:'.$secondary_color.';	
			}
			.andit-container-number-'.$istance.' .andit-pagination.gridstyle6 span {
				color:'.$over_color.';
			}
			.andit-container-number-'.$istance.' .andit-pagination.gridstyle6 a {
				color:'.$a_color.';	
			}
			.andit-container-number-'.$istance.' .andit-pagination.gridstyle6 a:hover {
				color:'.$over_color.';	
			}';
		}
		if($skin == 'gridstyle8') {
			$return .= '.andit-container-number-'.$istance.' .gridstyle8 .andit-grid-item:hover .andit-container-grid a {
						color:'.$a_color.';
						background:none!important;
						border:1px solid '.$secondary_color.';
			}';
		}
		if($skin == 'portfoliostyle1') {
			$return .= 	'.portfoliostyle1 .andit-grid.andit-'.$istance.' .andit-grid-item .andit-container-portfolio a.andit-read-more:hover {
				border-color:'.$over_color.';
			}
			.andit-grid.andit-'.$istance.'.portfoliostyle1 .andit-grid-item .andit-container-portfolio a.andit-read-more {
				border-color:'.$a_color.';
			}
			.andit-grid.andit-'.$istance.'.portfoliostyle1 .andit-grid-item:hover .andit-container-portfolio {
				background:'.$main_color.';
			}
			.andit-container-number-'.$istance.'.portfoliostyle1  .andit-controls.filter-portfoliostyle1  ul li, 
			.andit-container-number-'.$istance.'.portfoliostyle1  .andit-pagination.portfoliostyle1 a {
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.'.portfoliostyle1  .andit-controls.filter-portfoliostyle1  ul li:hover,
			.andit-container-number-'.$istance.'.portfoliostyle1  .andit-controls.filter-portfoliostyle1  ul li.active, 
			.andit-container-number-'.$istance.'.portfoliostyle1  .andit-pagination.portfoliostyle1 a:hover {
				color:'.$over_color.';
			}			
			';			
		}		
		if($skin == 'portfoliostyle2') {
			$return .= 	'.andit-grid.andit-'.$istance.' .andit-grid-item .andit-container-portfolio a.andit-read-more	{
				background:'.$secondary_color.';
			}
			.andit-grid.andit-'.$istance.' .andit-grid-item .andit-container-portfolio a.andit-read-more {
				border-color:'.$a_color.';
			}			
			.andit-grid.andit-'.$istance.' .andit-grid-item .andit-container-portfolio {
				background:'.$secondary_color.';
			}
			.andit-grid.andit-'.$istance.' .andit-grid-item .andit-container-portfolio a.andit-read-more:hover {
				color:'.$over_color.';
			}
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle2 ul li, 
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle2 a {
				background:'.$font_color.';
				color:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle2 .pagination .current {
				background:'.$font_color.';
			}
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle2 ul li.active, 
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle2 ul li.filter:hover,
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle2 a:hover {
				color:'.$over_color.';	
			}
			.andit-grid.andit-'.$istance.' .andit-grid-item:hover .andit-container-portfolio {
				background:'.$main_color.';
			}';						
		}
		if($skin == 'portfoliostyle3') {
			$return .= 	'.andit-grid.andit-'.$istance.' .andit-grid-item .andit-container-portfolio a.andit-read-more:hover {
				background:'.$secondary_color.';
				border-color:'.$secondary_color.';
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle3 ul li,
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle3 ul li, 
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle3 a,
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle3 .pagination .current
			 {
				border:1px solid '.$secondary_color.';
				margin-right:10px;
				padding:10px 20px;
				border-radius:12px;
			}
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle3 .pagination a {
				color:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle3 .pagination .current,
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle3 a:hover {
				background:'.$secondary_color.';
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.' .portfoliostyle3 .andit-container-portfolio .andit-read-more {
				border:1px solid '.$secondary_color.';
			}
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle3 ul li:hover, 
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle3 ul li.active,
			.andit-'.$istance.' .andit-container-portfolio .andit-title {
				background:'.$secondary_color.';
				color:'.$font_color.';
			}
			.andit-grid.andit-'.$istance.' .andit-grid-item:hover .andit-container-portfolio {
				background:'.$main_color.';
			}';			
		}	
		if($skin == 'portfoliostyle4') {
			$return .= '
			 .andit-container-number-'.$istance.' .portfoliostyle4 .andit-grid-item,
			 .andit-container-number-'.$istance.' .portfoliostyle4 .andit-image-over .icon-plus,
			 .andit-controls.filter-portfoliostyle4 ul li {
				background:'.$main_color.';
			}
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle4 ul li:hover, 
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle4 ul li.active {
				background:'.$secondary_color.';
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle4 ul li {
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.' .portfoliostyle4 .andit-container-portfolio .andit-text {
				border-color:'.$font_color.';
			}
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle4 .pagination .current,
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle4 a:hover {
				background:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle4 a {
				background:'.$main_color.';
			}
			.andit-container-number-'.$istance.' .portfoliostyle4 .andit-image-over .icon-plus {
				color:'.$a_color.';
			}
			.andit-container-number-'.$istance.' .portfoliostyle4 .andit-image-over .icon-plus:hover {
				color:'.$over_color.';
			}
			';
		}
		if($skin == 'portfoliostyle5') {
			$return .= '
			 .andit-container-number-'.$istance.' .portfoliostyle5 .andit-grid-item,
			 .andit-container-number-'.$istance.' .portfoliostyle5 .andit-image-over .icon-plus,
			 .andit-controls.filter-portfoliostyle4 ul li {
				background:'.$main_color.';
			}
			 .andit-container-number-'.$istance.' .portfoliostyle5 .andit-image-over .icon-plus {
			 	color:'.$a_color.';
			}
			 .andit-container-number-'.$istance.' .portfoliostyle5 .andit-image-over .icon-plus:hover {
			 	color:'.$over_color.';
			}
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle5 ul li {
				background:'.$main_color.';
				color:'.$font_color.';	
			}
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle5 ul li:hover, 
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle5 ul li.active {
				color:'.$over_color.';
			}
			.andit-container-number-'.$istance.' .portfoliostyle5 .andit-image-over .icon-plus {
				border-color:'.$font_color.';
			}
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle5 .pagination .current,
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle5 .pagination a {
				background:'.$main_color.';
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle5 a:hover,
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle5 .pagination .current {	
				color:'.$over_color.';
			}
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle5 a {
				background:'.$main_color.';
			}
			.andit-container-number-'.$istance.' .portfoliostyle5 .andit-grid-item:hover .andit-image-over {
				background:'.$secondary_color.';
			}
			';			
		}		
		if($skin == 'portfoliostyle6') {
			$return .= '
			 .andit-container-number-'.$istance.' .portfoliostyle6 .andit-grid-item,
			 .andit-container-number-'.$istance.' .portfoliostyle6 .andit-image-over .icon-plus,
			 .andit-controls.filter-portfoliostyle6 ul li {
				background:'.$main_color.';
			}
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle5 ul li {
				background:'.$main_color.';
				color:'.$font_color.';	
			}
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle5 ul li:hover, 
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle5 ul li.active {
				color:'.$over_color.';
			}
			.andit-container-number-'.$istance.' .portfoliostyle6 .andit-image-over .icon-plus {
				border-color:'.$font_color.';
			}
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle6 .pagination .current,
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle6 .pagination a {
				background:'.$main_color.';
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle6 a:hover,
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle6 .pagination .current {	
				color:'.$over_color.';
			}
			.andit-container-number-'.$istance.' .portfoliostyle6 .andit-grid-item:hover .andit-image-over {
				background:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.' .portfoliostyle6 .andit-grid-item .andit-title {
				background:'.$secondary_color.';
				color:'.$main_color.';
			}
			.andit-container-number-'.$istance.' .portfoliostyle6 .andit-image-container .andit-info-date{
				background:'.$secondary_color.';
				color:'.$main_color.';
				font-size:'.$content_fs.';
			}
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle6 a {
				background:'.$main_color.';
			}
			.andit-container-number-'.$istance.' .portfoliostyle6 .andit-grid-item:hover .andit-image-over {
				background:'.$secondary_color.';
			}
			 .andit-container-number-'.$istance.' .portfoliostyle6 .andit-image-over .icon-plus {
			 	color:'.$a_color.';
			}
			 .andit-container-number-'.$istance.' .portfoliostyle6 .andit-image-over .icon-plus:hover {
			 	color:'.$over_color.';
			}						
			';
		}
		if($skin == 'portfoliostyle7') {
			$return .= '
			 .andit-container-number-'.$istance.' .portfoliostyle7 .andit-grid-item,
			 .andit-container-number-'.$istance.' .portfoliostyle7 .andit-image-over .icon-plus,
			 .andit-controls.filter-portfoliostyle7 ul li {
				background:'.$main_color.';
			}
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle7 ul li:hover, 
			.andit-container-number-'.$istance.' .andit-controls.filter-portfoliostyle7 ul li.active {
				background:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.' .portfoliostyle7 .andit-image-over .icon-plus {
				border-color:'.$font_color.';
			}
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle7 .pagination .current,
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle7 a:hover {
				background:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.' .andit-pagination.portfoliostyle7 a {
				background:'.$main_color.';
			}
			.andit-container-number-'.$istance.' .portfoliostyle7 .andit-share-container {
				background:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.' .portfoliostyle7 .andit-share-container a {
				color:'.$a_color.';
			}
			.andit-container-number-'.$istance.' .portfoliostyle7 .andit-share-container a:hover {
				color:'.$over_color.';
			}						
			';
		}	
		if($skin == 'trastevere') {
			$return .= '.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview figure a.andit-thumbnail h4 {
				color:'.$font_color.';
				background:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview figure.content {
				background:'.$main_color.';
			}
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview .post-content {
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview.trastevere .social-container .icon-menu2, 
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview.trastevere .social-container .icon-close,
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview figure .fcp-read-more,
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview .social-container .andit-share-container .andit-share-item {
				background:'.$font_color.';
				color:'.$main_color.';
			}
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview.trastevere .social-container .icon-menu2:hover, 
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview.trastevere .social-container .icon-close:hover,
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview .social-container .andit-share-container .andit-share-item:hover {
				color:'.$over_color.';
			}			
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview figure.content .close {
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview figure a.andit-thumbnail .active-arrow {
				border-bottom-color:'.$main_color.';
			}
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview figure.content {
				border-right-color:'.$main_color.';
				border-left-color:'.$main_color.';
				border-bottom-color:'.$main_color.';
			}
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview figure a.andit-thumbnail h4 {
				border-right-color:'.$font_color.';
				border-left-color:'.$font_color.';
				border-bottom-color:'.$font_color.';
			}
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview .social-container .andit-share-container .andit-share-item a {
				color:'.$main_color.';
			}
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview .social-container .andit-share-container .andit-share-item a:hover {
				color:'.$over_color.';
			}			
			.andit-container-number-'.$istance.'.trastevere .andit-pagination a,
			.andit-container-number-'.$istance.'.trastevere a {
				color:'.$a_color.';
			}
			.andit-container-number-'.$istance.'.trastevere .andit-pagination a:hover,
			.andit-container-number-'.$istance.'.trastevere a:hover,
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview figure .fcp-read-more:hover {
				color:'.$over_color.';
			}			
			.andit-container-number-'.$istance.'.trastevere .andit-pagination .current {
				color:'.$over_color.';
			}
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview .post-content h1{
				font-size:'.$title_fs.'px;
			}
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview .post-content {
				font-size:'.$content_fs.'px;
			}
			.andit-container-number-'.$istance.'.trastevere figure.content {
				margin-bottom:'.$margin_bottom.';
				margin-top:-'.$margin_bottom.';	
			}	
			.andit-container-number-'.$istance.'.trastevere .andit-type-portfolio-preview figure.content {
				max-width: -webkit-calc(100% - '.$margin_right.');
				max-width:         calc(100% - '.$margin_right.');
			}
			';
		}
		if($skin == 'mausoleodiaugusto') {
			$return .= '.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview figure a.andit-thumbnail h4 {
				color:'.$font_color.';
				background:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview figure.content {
				background:'.$main_color.';
			}
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview .post-content {
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview.mausoleodiaugusto .social-container .icon-menu2, 
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview.mausoleodiaugusto .social-container .icon-close,
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview figure .fcp-read-more,
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview .social-container .andit-share-container .andit-share-item {
				background:'.$font_color.';
				color:'.$main_color.';
			}
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview.mausoleodiaugusto .social-container .icon-menu2:hover, 
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview.mausoleodiaugusto .social-container .icon-close:hover,
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview .social-container .andit-share-container .andit-share-item:hover {
				color:'.$over_color.';
			}			
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview figure.content .close {
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview figure a.andit-thumbnail .active-arrow {
				border-bottom-color:'.$main_color.';
			}
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview figure.content {
				border-right-color:'.$main_color.';
				border-left-color:'.$main_color.';
				border-bottom-color:'.$main_color.';
			}
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview figure a.andit-thumbnail h4 {
				border-right-color:'.$font_color.';
				border-left-color:'.$font_color.';
				border-bottom-color:'.$font_color.';
			}
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview .social-container .andit-share-container .andit-share-item a {
				color:'.$main_color.';
			}
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview .social-container .andit-share-container .andit-share-item a:hover {
				color:'.$over_color.';
			}			
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-pagination a,
			.andit-container-number-'.$istance.'.mausoleodiaugusto a {
				color:'.$a_color.';
			}
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-pagination a:hover,
			.andit-container-number-'.$istance.'.mausoleodiaugusto a:hover,
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview figure .fcp-read-more:hover {
				color:'.$over_color.';
			}			
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-pagination .current {
				color:'.$over_color.';
			}
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview .post-content h1{
				font-size:'.$title_fs.'px;
			}
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview .post-content {
				font-size:'.$content_fs.'px;
			}
			.andit-container-number-'.$istance.'.mausoleodiaugusto figure.content {
				margin-bottom:'.$margin_bottom.';
				margin-top:-'.$margin_bottom.';	
			}	
			.andit-container-number-'.$istance.'.mausoleodiaugusto .andit-type-portfolio-preview figure.content {
				max-width: -webkit-calc(100% - '.$margin_right.');
				max-width:         calc(100% - '.$margin_right.');
			}
			';
		}
		if($skin == 'carouselstyle1') {
			$return .= '.andit-container-number-'.$istance.'.carouselstyle1 .andit-grid-item .ac-container {
				background:'.$main_color.';	
			}
			.andit-container-number-'.$istance.'.carouselstyle1 .andit-grid-item .title {
				color:'.$font_color.';
			}			
			.andit-container-number-'.$istance.'.carouselstyle1 .andit-grid-item .ac-icon a,
			.andit-container-number-'.$istance.'.carouselstyle1 .owl-theme .owl-controls .owl-dots  span {
				border-color:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle1 .andit-grid-item .ac-icon a {
				color:'.$a_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle1 .andit-grid-item .ac-icon a:hover {
				color:'.$over_color.';
				border-color:'.$over_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle1 .owl-next,
			.andit-container-number-'.$istance.'.carouselstyle1 .owl-prev {
				color:'.$font_color.'!important;
			}
			.andit-container-number-'.$istance.'.carouselstyle1 .owl-next:hover,
			.andit-container-number-'.$istance.'.carouselstyle1 .owl-prev:hover {
				color:'.$over_color.';
			}			
			';				
		}
		if($skin == 'carouselstyle2') {
			$return .= '.andit-container-number-'.$istance.'.carouselstyle2 .andit-grid-item .ac-container {
				background:'.$main_color.';	
			}
			.andit-container-number-'.$istance.'.carouselstyle2 .andit-grid-item .title {
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle2 .andit-grid-item .ac-icon a,
			.andit-container-number-'.$istance.'.carouselstyle2 .owl-theme .owl-controls .owl-dots  span {
				border-color:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle2 .andit-grid-item .ac-icon a {
				color:'.$a_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle2 .andit-grid-item .ac-icon a:hover {
				color:'.$over_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle2 .owl-next,
			.andit-container-number-'.$istance.'.carouselstyle2 .owl-prev {
				color:'.$font_color.'!important;
			}
			.andit-container-number-'.$istance.'.carouselstyle2 .owl-next:hover,
			.andit-container-number-'.$istance.'.carouselstyle2 .owl-prev:hover {
				color:'.$over_color.';
			}			
			';				
		}
		if($skin == 'carouselstyle3') {
			$return .= '.andit-container-number-'.$istance.'.carouselstyle3 .andit-grid-item .ac-container {
				background:'.$main_color.';	
			}
			.andit-container-number-'.$istance.'.carouselstyle3 .andit-grid-item .title {
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle3 .andit-grid-item .ac-icon a,
			.andit-container-number-'.$istance.'.carouselstyle3 .owl-theme .owl-controls .owl-dots  span {
				border-color:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle3 .andit-grid-item .ac-icon a {
				color:'.$a_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle3 .andit-grid-item .ac-icon a:hover {
				color:'.$over_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle3 .owl-next,
			.andit-container-number-'.$istance.'.carouselstyle3 .owl-prev {
				color:'.$font_color.'!important;
			}
			.andit-container-number-'.$istance.'.carouselstyle3 .owl-next:hover,
			.andit-container-number-'.$istance.'.carouselstyle3 .owl-prev:hover {
				color:'.$over_color.';
			}			
			';				
		}
		if($skin == 'carouselstyle4') {
			$return .= '.andit-container-number-'.$istance.'.carouselstyle4 .andit-grid-item .ac-container {
				background:'.$main_color.';	
			}
			.andit-container-number-'.$istance.'.carouselstyle4 .andit-grid-item .title {
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle4 .andit-grid-item .ac-icon a,
			.andit-container-number-'.$istance.'.carouselstyle4 .owl-theme .owl-controls .owl-dots  span {
				border-color:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle4 .andit-grid-item .ac-icon a {
				color:'.$a_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle4 .andit-grid-item .ac-icon a:hover {
				color:'.$over_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle4 .owl-next,
			.andit-container-number-'.$istance.'.carouselstyle4 .owl-prev {
				color:'.$font_color.'!important;
			}
			.andit-container-number-'.$istance.'.carouselstyle4 .owl-next:hover,
			.andit-container-number-'.$istance.'.carouselstyle4 .owl-prev:hover {
				color:'.$over_color.';
			}			
			';				
		}
		if($skin == 'carouselstyle5') {
			$return .= '.andit-container-number-'.$istance.'.carouselstyle5 .andit-grid-item .ac-container {
				background:'.$main_color.';	
			}
			.andit-container-number-'.$istance.'.carouselstyle5 .andit-grid-item .title {
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle5 .andit-grid-item .ac-icon a,
			.andit-container-number-'.$istance.'.carouselstyle5 .owl-theme .owl-controls .owl-dots  span {
				border-color:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle5 .andit-grid-item .ac-icon a {
				color:'.$a_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle5 .andit-grid-item .ac-icon a:hover {
				color:'.$over_color.';
				border-color:'.$over_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle5 .owl-next,
			.andit-container-number-'.$istance.'.carouselstyle5 .owl-prev {
				color:'.$font_color.'!important;
			}
			.andit-container-number-'.$istance.'.carouselstyle5 .owl-next:hover,
			.andit-container-number-'.$istance.'.carouselstyle5 .owl-prev:hover {
				color:'.$over_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle5 .andit-grid-item .text {
				font-size:'.$content_fs.'px;
			}
			';				
		}
		if($skin == 'carouselstyle6') {
			$return .= '.andit-container-number-'.$istance.'.carouselstyle6 .andit-grid-item .ac-container {
				background:'.$main_color.';	
			}
			.andit-container-number-'.$istance.'.carouselstyle6 .andit-grid-item .title {
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle6 .andit-grid-item .ac-icon a,
			.andit-container-number-'.$istance.'.carouselstyle6 .owl-theme .owl-controls .owl-dots  span {
				border-color:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle6 .andit-grid-item .ac-icon a {
				color:'.$a_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle6 .andit-grid-item .ac-icon a:hover {
				background:'.$over_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle6 .owl-next,
			.andit-container-number-'.$istance.'.carouselstyle6 .owl-prev {
				color:'.$font_color.'!important;
			}
			.andit-container-number-'.$istance.'.carouselstyle6 .owl-next:hover,
			.andit-container-number-'.$istance.'.carouselstyle6 .owl-prev:hover {
				color:'.$over_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle6 .andit-grid-item .text {
				font-size:'.$content_fs.'px;
			}
			.andit-container-number-'.$istance.'.carouselstyle6 .andit-grid-item .container-top .hover-img .icon-plus {
				border-color:'.$main_color.';
				background:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle6 .andit-grid-item .container-top .hover-img {
				background:'.$secondary_color.';
			}
			';				
		}
		if($skin == 'carouselstyle7') {
			$return .= '.andit-container-number-'.$istance.'.carouselstyle7 .andit-grid-item .title {
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle7 .andit-grid-item .ac-icon a,
			.andit-container-number-'.$istance.'.carouselstyle7 .owl-theme .owl-controls .owl-dots  span {
				border-color:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle7 .andit-grid-item .ac-icon a {
				color:'.$a_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle7 .andit-grid-item .ac-icon a:hover,
			.andit-container-number-'.$istance.'.carouselstyle7 .andit-grid-item .ac-icon a {
				background:'.$over_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle7 .owl-next,
			.andit-container-number-'.$istance.'.carouselstyle7 .owl-prev {
				color:'.$font_color.'!important;
			}
			.andit-container-number-'.$istance.'.carouselstyle7 .owl-next:hover,
			.andit-container-number-'.$istance.'.carouselstyle7 .owl-prev:hover {
				color:'.$over_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle7 .andit-grid-item .text {
				font-size:'.$content_fs.'px;
			}
			.andit-container-number-'.$istance.'.carouselstyle7 .andit-grid-item .container-top .hover-img .icon-plus {
				border-color:'.$main_color.';
				background:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle7 .andit-grid-item .container-top .hover-img {
				background:'.$secondary_color.';
			}
			';				
		}	
		if($skin == 'carouselstyle8') {
			$return .= '.andit-container-number-'.$istance.'.carouselstyle8 .andit-grid-item .title,
			.andit-container-number-'.$istance.'.carouselstyle8 .andit-grid-item .text 
			 {
				color:'.$font_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle8 .andit-grid-item .ac-icon a,
			.andit-container-number-'.$istance.'.carouselstyle8 .owl-theme .owl-controls .owl-dots  span {
				border-color:'.$secondary_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle8 .andit-grid-item .ac-icon a {
				border-color:'.$a_color.';
				color:'.$a_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle8 .andit-grid-item .ac-icon a:hover {
				border-color:'.$over_color.';
				color:'.$over_color.';				
			}
			.andit-container-number-'.$istance.'.carouselstyle8 .owl-next,
			.andit-container-number-'.$istance.'.carouselstyle8 .owl-prev {
				color:'.$font_color.'!important;
			}
			.andit-container-number-'.$istance.'.carouselstyle8 .owl-next:hover,
			.andit-container-number-'.$istance.'.carouselstyle8 .owl-prev:hover {
				color:'.$over_color.';
			}
			.andit-container-number-'.$istance.'.carouselstyle8 .andit-grid-item .text {
				font-size:'.$content_fs.'px;
			}
			.andit-container-number-'.$istance.'.carouselstyle8 .andit-grid-item .title {
				font-size:'.$title_fs.'px;
			}
			';				
		}															
	return $return;
}

function andit_filter_item($skin,$istance,$source,$wp_cat,$wp_fc_cat,$wp_custom_taxonomy_cat,$custom_type) {


		$return = '<div class="andit-controls filter-'.$skin.'">
					<ul>
						<li data-filter="all" class="filter active">'.esc_html__('All','anditportfolio').'</li>';
		//echo '------'.$wp_cat;
			
		/* WP POST */
		if($source == 'wp_posts') {
			// ALL CATEGORY
			if(empty($wp_cat)) {
						$categories = get_categories();
						foreach ( $categories as $category ) {
								$return .= '<li data-filter="' . $category->slug . '" class="filter">' . $category->name . '</li>';
						}
			} else { 
						$wp_cat = explode(",", $wp_cat);
						//print_r($wp_cat);
						foreach ( $wp_cat as $category ) {
								$category_name = get_category_by_slug($category);
								$return .= '<li data-filter="' . $category . '" class="filter">' . $category_name->name . '</li>';
						}
			}
		}
		/* #WP POST */	

		/* WP CUSTOM POST */
		if($source == 'post_type') {
			// ALL CATEGORY
			$taxonomy_names = get_object_taxonomies( $custom_type );
			
			// CHECK WOOCOMMERCE
			if($custom_type == 'product' && class_exists('Woocommerce')) {
					$taxonomy_names[0]= 'product_cat';
			}
			// #CHECK WOOCOMMERCE
			 
			if(!empty($taxonomy_names)) {
				if(empty($wp_custom_taxonomy_cat)) {
							$categories = get_categories('taxonomy='.$taxonomy_names[0].'');
	
							foreach ( $categories as $category ) {
									$return .= '<li data-filter="' . $category->slug . '" class="filter">' . $category->name . '</li>';
							}
				} else {
						$wp_custom_taxonomy_cat_split = explode(",", $wp_custom_taxonomy_cat);
							foreach ( $wp_custom_taxonomy_cat_split as $category ) {
									$category_single = get_term_by('name',$category,$taxonomy_names[0]);								
									$return .= '<li data-filter="' . $category_single->slug . '" class="filter">' . $category . '</li>';
							}
				}
			}
		}
		/* #WP CUSTOM POST */		
		
		
		
		
		
		$return .= '</ul></div>';
		
		
	return $return;
}

function andit_filter_item_figure($source,$wp_cat,$wp_fc_cat,$wp_custom_taxonomy_cat,$custom_type) {

	/* WP POST */
	if($source == 'wp_posts') {
		if(empty($wp_cat)) {
			$category = get_the_category();
			$return = '<figure data-cat="'.$category[0]->slug.'" class="andit-grid-item '.$category[0]->slug.'" style=" display: inline-block; opacity: 1;">';
		} else {
			$cat_array = get_the_category();
			$cat_list = '';
			$cat_list2 = array();
				foreach ( $cat_array as $category ) {
						$cat_list .= $category->slug.' ';
						$cat_list2[] = $category->name;
				}
			$return = '<figure data-cat="'.$cat_list.'" class="andit-grid-item '.$cat_list.'" style=" display: inline-block; opacity: 1;">';				
		}
	}
	/* #WP POST */

	/* WP CUSTOM POST */
	if($source == 'post_type') {
					$taxonomy_names = get_object_taxonomies( $custom_type );
					
					// CHECK WOOCOMMERCE
					if($custom_type == 'product' && class_exists('Woocommerce')) {
						$taxonomy_names[0]= 'product_cat';
					}
					// #CHECK WOOCOMMERCE 
						
					if(!empty($taxonomy_names)) {					
						$cat_array = wp_get_post_terms( get_the_ID(), $taxonomy_names[0]);
						$cat_list = '';
						$cat_list2 = array();
						foreach ( $cat_array as $category ) {
							$cat_list .= $category->slug.' ';
							$cat_list2[] = $category->name;
						}
						$return = '<figure data-cat="'.$cat_list.'" class="andit-grid-item '.$cat_list.'" style=" display: inline-block; opacity: 1;">';								
					} else {
						$return = '<figure class="andit-grid-item" style=" display: inline-block; opacity: 1;">';
					}
	}	
	/* #WP CUSTOM POST */

	
	return $return;	
}