<?php
/**
 * Functions for sending list of fonts available.
 *
 * @package    Hoot
 * @subpackage Juxter
 */

/**
 * Build URL for loading Google Fonts
 * @credit http://themeshaper.com/2014/08/13/how-to-add-google-fonts-to-wordpress-themes/
 *
 * @since 1.0
 * @access public
 * @return void
 */
function hoot_google_fonts_enqueue_url() {
	$fonts_url = '';
	$query_args = apply_filters( 'hoot_google_fonts_enqueue_url_args', array() );

	/** If no google font loaded, load the default ones **/
	if ( !is_array( $query_args ) || empty( $query_args ) ):
 
		/* Translators: If there are characters in your language that are not
		* supported by this font, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$slabo = ( 'display' == hoot_get_mod( 'logo_fontface' ) ) ? _x( 'on', 'Slabo 27px font: on or off', 'juxter' ) : 'off';

		/* Translators: If there are characters in your language that are not
		* supported by this font, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$droid_sans = _x( 'on', 'Droid Sans font: on or off', 'juxter' );

		if ( 'off' !== $slabo || 'off' !== $droid_sans ) {
			$font_families = array();

			if ( 'off' !== $slabo ) {
				$font_families[] = 'Slabo 27px:400';
			}

			if ( 'off' !== $droid_sans ) {
				$font_families[] = 'Droid Sans:300,400,400italic,700,700italic,800';
			}

			if ( !empty( $font_families ) )
				$query_args = array(
					'family' => urlencode( implode( '|', $font_families ) ),
					//'subset' => urlencode( 'latin,latin-ext' ),
					'subset' => urlencode( 'latin' ),
				);

		}

	endif;

	if ( !empty( $query_args ) && !empty( $query_args['family'] ) )
		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

	return $fonts_url;
}

/**
 * Modify the font (websafe) list
 * Font list should always have the form:
 * {css style} => {font name}
 *
 * @since 1.0
 * @access public
 * @return array
 */
function hoot_theme_fonts_list( $fonts ) {
	// Add droid sans (google font) to the available font list
	// Even though the list isn't currently used in customizer options,
	// this is still needed so that sanitization functions recognize the font.
	$fonts['"Droid Sans", sans-serif'] = 'Droid Sans';
	$fonts['"Slabo 27px", serif'] = 'Slabo 27px';
	return $fonts;
}
add_filter( 'hybridextend_fonts_list', 'hoot_theme_fonts_list' );