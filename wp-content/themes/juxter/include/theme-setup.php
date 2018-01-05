<?php
/**
 * Theme Setup
 * This file is loaded using 'after_setup_theme' hook at priority 10
 *
 * @package    Hoot
 * @subpackage Juxter
 */

/** Misc **/

// Enable Font Icons
// Disable this (remove this line) if the theme doesnt use font icons,
// or if the font-awesome library is being enqueued by some other plugin using
// a handle other than 'font-awesome' or 'fontawesome' (to avoid loading the
// library twice)
if ( apply_filters( 'hoot_load_font_awesome', true ) )
	add_theme_support( 'font-awesome' );

// Enable google fonts (fixed fonts, or entire library)
add_theme_support( 'hoot-google-fonts' );


/** WordPress **/

// Add theme support for WordPress Custom Logo
add_theme_support( 'custom-logo' );

// Adds theme support for WordPress 'featured images'.
add_theme_support( 'post-thumbnails' );

// Automatically add feed links to <head>.
add_theme_support( 'automatic-feed-links' );

// Reintroduce emoji support (removed by hybrid framework)
if ( function_exists( 'print_emoji_styles' ) ) {
	add_action('wp_head', 'print_emoji_detection_script', 7);
	add_action('wp_print_styles', 'print_emoji_styles');
}

/** WordPress Jetpack **/
add_theme_support( 'infinite-scroll', array(
	'type' => apply_filters( 'hoot_theme_jetpack_infinitescroll_type', 'click' ), // scroll or click
	'container' => 'content',
	'footer' => false,
	'wrapper' => true,
	'render' => 'hoot_jetpack_infinitescroll_render',
) );


/** Extensions **/

// Enable custom widgets
add_theme_support( 'hybridextend-widgets' );

// Nicer [gallery] shortcode implementation when Jetpack tiled-gallery is not active
if ( !class_exists( 'Jetpack' ) || !Jetpack::is_module_active( 'tiled-gallery' ) ) 
	add_theme_support( 'cleaner-gallery' );


/** WooCommerce **/

// Woocommerce support and init load theme woo functions
if ( class_exists( 'WooCommerce' ) ) {
	add_theme_support( 'woocommerce' );
	include_once( HYBRID_PARENT . 'woocommerce/functions.php' );
}


/** Conditional Theme Setup */

/* Theme setup on the 'wp' hook. Only used for special scenarios (like enqueueing scripts/styles) based on conditional tags. */
add_action( 'wp', 'hoot_load_wt_lightslider', 10 );

/**
 * Load lightslider (scripts/styles) on frontpage
 *
 * @since 1.0
 * @access public
 * @return void
 */
function hoot_load_wt_lightslider() {
	if ( is_front_page() ) {
		add_theme_support( 'hoot-light-slider' );
	}
}


/** Theme Setup Hooks */

/* Handle content width for embeds and images. Hooked into 'init' so that we can pull custom content width from theme options */
add_action( 'init', 'hoot_set_content_width', 10 );

/**
 * Handle content width for embeds and images.
 *
 * @since 1.0
 * @access public
 * @return void
 */
function hoot_set_content_width() {
	$width = intval( hoot_get_mod( 'site_width' ) );
	$width = !empty( $width ) ? $width : 1260;
	hybrid_set_content_width( $width );
}

/* Modify the '[...]' Read More Text */
add_filter( 'the_content_more_link', 'hoot_modify_read_more_link' );
if ( apply_filters( 'hoot_force_excerpt_readmore', true ) ) {
	add_filter( 'excerpt_more', 'hoot_insert_excerpt_readmore_quicktag', 11 );
	add_filter( 'wp_trim_excerpt', 'hoot_replace_excerpt_readmore_quicktag', 11, 2 );
} else {
	add_filter( 'excerpt_more', 'hoot_modify_read_more_link' );
}

/**
 * Modify the '[...]' Read More Text
 *
 * @since 1.0
 * @access public
 * @return string
 */
function hoot_modify_read_more_link( $more = '[&hellip;]' ) {
	if ( is_admin() )
		return $more;

	$read_more = esc_html( hoot_get_mod('read_more') );
	$read_more = ( empty( $read_more ) ) ? sprintf( __( 'Read More %s', 'juxter' ), '&rarr;' ) : $read_more;
	global $post;
	$read_more = '<span class="more-link-wrap"><a class="more-link" href="' . esc_url( get_permalink( $post->ID ) ) . '">' . $read_more . '</a></span>';
	return apply_filters( 'hoot_readmore', $read_more ) ;
}

/**
 * Always display the 'Read More' link in Excerpts.
 * Insert quicktag to be replaced later in 'wp_trim_excerpt()'
 *
 * @since 1.0
 * @access public
 * @return string
 */
function hoot_insert_excerpt_readmore_quicktag( $more = '' ) {
	if ( is_admin() )
		return $more;
	return '<!--hoot-read-more-quicktag-->';
}

/**
 * Always display the 'Read More' link in Excerpts.
 * Replace quicktag with read more link
 *
 * @since 1.0
 * @access public
 * @return string
 */
function hoot_replace_excerpt_readmore_quicktag( $text, $raw_excerpt ) {
	if ( is_admin() )
		return $text;
	$read_more = hoot_modify_read_more_link();
	$text = str_replace( '<!--hoot-read-more-quicktag-->', '', $text );
	return $text . $read_more;
}

/* Modify the exceprt length. Make sure to set the priority correctly such as 999, else the default WordPress filter on this function will run last and override settng here.  */
add_filter( 'excerpt_length', 'hoot_custom_excerpt_length', 999 );

/**
 * Modify the exceprt length.
 *
 * @since 1.0
 * @access public
 * @return void
 */
function hoot_custom_excerpt_length( $length ) {
	if ( is_admin() )
		return $length;

	$excerpt_length = intval( hoot_get_mod('excerpt_length') );
	if ( !empty( $excerpt_length ) )
		return $excerpt_length;
	return 105;
}