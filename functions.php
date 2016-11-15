<?php

// Nav walker for Bootstrap friendly navs.
require 'inc/walker.php';

// Optimising page size by remove code injected into the theme...

// Hide the admin bar.
show_admin_bar(false);

// Remove wp-embed.js
function my_deregister_scripts()
{
  wp_deregister_script('wp-embed');
}
add_action('wp_footer', 'my_deregister_scripts');

// Removing window._wpemojiSettings from header.
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Let WordPress manage the document title.
add_theme_support('title-tag');

// To keep images fluid, remove height and width HTML attributes from all
// <img> within post content.
add_filter('post_thumbnail_html', 'remove_width_attribute', 10);
add_filter('image_send_to_editor', 'remove_width_attribute', 10);

function remove_width_attribute($html)
{
    return preg_replace('/(width|height)="\d*"\s/', '', $html);
}

function init_scripts()
{
	$currentTheme = wp_get_theme();

	// Theme's main CSS file.
	wp_enqueue_style('main.css', get_stylesheet_directory_uri() . '/css/main.min.css', [], $currentTheme->get('Version'), 'screen');

	// HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
	wp_enqueue_script('html5shiv.js', 
						get_stylesheet_directory_uri() . '/js/html5shiv.min.js', 
						array('jquery'), 
						$currentTheme->get('Version'), 
						false);

	wp_enqueue_script('respond.js', 
						get_stylesheet_directory_uri() . '/js/respond-1.4.2/respond.min.js', 
						array('html5shiv.js'), 
						$currentTheme->get('Version'), 
						false);

	// Twitter Bootstrap JS
	wp_enqueue_script('bootstrap.js', 
						get_stylesheet_directory_uri() . '/js/bootstrap.min.js', 
						array('respond.js'), 
						$currentTheme->get('Version'), 
						false);
}
add_action('wp_enqueue_scripts', 'init_scripts');

/**
 * Add BS active class to active nav elements.
 *
 */
function theme_special_nav_class($classes, $item) 
{
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'theme_special_nav_class', 10, 2);

/**
 * Displays an optional post thumbnail.
 *
 */
if (!function_exists('theme_get_post_thumbnail')){
	function theme_get_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		$base = '';
		if (is_singular()){
			$base = '
				<div class="post-thumbnail">
					' . the_post_thumbnail() . '
				</div><!-- .post-thumbnail -->
			';
		}else{
			$base = '
				<a class="post-thumbnail" href="' . the_permalink() . '" aria-hidden="true">
					' . the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) ) . '
				</a><!-- .post-thumbnail -->
			';
		}

		return $base;
	}
}

/**
 * Displays HTML with meta information for the categories, tags.
 *
 */
if (!function_exists('theme_get_post_entry_meta')){
	function theme_get_post_entry_meta() {
		if ( 'post' === get_post_type() ) {
			$author_avatar_size = apply_filters( 'twentysixteen_author_avatar_size', 49 );
			printf( '<span class="byline"><span class="author vcard">%1$s<span class="screen-reader-text">%2$s </span> <a class="url fn n" href="%3$s">%4$s</a></span></span>',
				get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
				_x( 'Author', 'Used before post author name.'),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				get_the_author()
			);
		}

		if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
			theme_get_post_date();
		}

		$format = get_post_format();
		if ( current_theme_supports( 'post-formats', $format ) ) {
			printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
				sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.') ),
				esc_url( get_post_format_link( $format ) ),
				get_post_format_string( $format )
			);
		}

		if ( 'post' === get_post_type() ) {
			theme_get_taxonomies();
		}

		if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>'), get_the_title() ) );
			echo '</span>';
		}
	}
}

if (!function_exists('theme_get_post_date')){
	function theme_get_post_date() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			get_the_date(),
			esc_attr( get_the_modified_date( 'c' ) ),
			get_the_modified_date()
		);

		printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
			_x( 'Posted on', 'Used before publish date.'),
			esc_url( get_permalink() ),
			$time_string
		);
	}
}

/**
 * Prints HTML with category and tags for current post.
 *
 */
if (!function_exists('theme_get_taxonomies')){
	function theme_get_taxonomies() {
		$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'twentysixteen' ) );
		if ( $categories_list && theme_site_has_categories() ) {
			printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x( 'Categories', 'Used before category names.', 'twentysixteen' ),
				$categories_list
			);
		}

		$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'twentysixteen' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x( 'Tags', 'Used before tag names.', 'twentysixteen' ),
				$tags_list
			);
		}
	}
}

if (!function_exists('theme_site_has_categories')){
	function theme_site_has_categories() {
		
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so theme_site_has_categories should return true.
			return true;
		} else {
			// This blog has only 1 category so theme_site_has_categories should return false.
			return false;
		}
	}
}