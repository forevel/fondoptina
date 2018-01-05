<?php
/**
 * Add custom css to frontend.
 *
 * @package    Hoot
 * @subpackage Juxter
 */

// Add action at 5 for adding css rules (premium hooks in at 6-9).
// Child themes can hook in at priority 10.
add_action( 'hybridextend_dynamic_cssrules', 'hoot_dynamic_cssrules', 5 );

/**
 * Custom CSS built from user theme options
 * For proper sanitization, always use functions from hoot/includes/sanitization.php
 * and hoot/customizer/sanitization.php
 *
 * @since 1.0
 * @access public
 */
function hoot_dynamic_cssrules() {

	/*** Settings Values ***/

	/* Lite Settings */

	$settings = array();
	$settings['grid_width']           = intval( hoot_get_mod( 'site_width' ) ) . 'px';
	$settings['accent_color']         = hoot_get_mod( 'accent_color' );
	$settings['accent_color_dark']    = hybridext_color_increase( $settings['accent_color'], 20, 20 );
	$settings['accent_font']          = hoot_get_mod( 'accent_font' );
	$settings['logo_fontface']        = hoot_get_mod( 'logo_fontface' );
	$settings['site_layout']          = hoot_get_mod( 'site_layout', 'boxed' );
	$settings['box_background_color'] = hoot_get_mod( 'box_background_color' );
	$settings['content_bg_color']     = ( $settings['site_layout'] == 'boxed' ) ?
	                                        $settings['box_background_color'] :
	                                        hoot_get_mod( 'background-color' );
	$settings['site_title_icon_size'] = hoot_get_mod( 'site_title_icon_size' );
	$settings['site_title_icon']      = hoot_get_mod( 'site_title_icon' );
	$settings['logo_image_width']     = hoot_get_mod( 'logo_image_width' );
	$settings['logo_image_width']     = ( intval( $settings['logo_image_width'] ) ) ?
	                                        intval( $settings['logo_image_width'] ) . 'px' :
	                                        '150px';
	$settings['logo']                 = hoot_get_mod( 'logo' );
	$settings['logo_custom']          = apply_filters( 'hoot_logo_custom_text', hybridextend_sortlist( hoot_get_mod( 'logo_custom' ) ) );

	// Troubleshooting
	// echo '<!-- '; print_r($settings); echo ' -->';

	extract( apply_filters( 'hoot_custom_css_settings', $settings, 'lite' ) );

	/*** Add Dynamic CSS ***/

	/* Hoot Grid */

	hybridextend_add_css_rule( array(
						'selector'  => '.hgrid',
						'property'  => 'max-width',
						'value'     => $grid_width,
						'idtag'     => 'grid_width',
					) );

	/* Base Typography and HTML */

	hybridextend_add_css_rule( array(
						'selector'  => 'a',
						'property'  => 'color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) ); // Overridden in premium

	hybridextend_add_css_rule( array(
						'selector'  => '.accent-typo',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background' => array( $accent_color, 'accent_color' ),
							'color'      => array( $accent_font, 'accent_font' ),
							),
					) );

	hybridextend_add_css_rule( array(
						'selector'  => '.invert-typo',
						'property'  => 'color',
						'value'     => $content_bg_color,
					) );

	hybridextend_add_css_rule( array(
						'selector'  => '.enforce-typo',
						'property'  => 'background',
						'value'     => $content_bg_color,
					) );

	hybridextend_add_css_rule( array(
						'selector'  => 'input[type="submit"], #submit, .button',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background' => array( $accent_color, 'accent_color' ),
							'color'      => array( $accent_font, 'accent_font' ),
							),
					) );

	hybridextend_add_css_rule( array(
						'selector'  => 'input[type="submit"]:hover, #submit:hover, .button:hover',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background' => array( $accent_color_dark ),
							'color'      => array( $accent_font, 'accent_font' ),
							),
					) );

	hybridextend_add_css_rule( array(
						'selector'  => 'input[type="submit"]:before, #submit:before, .button:before',
						'property'  => 'border-color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );

	/* Layout */

	hybridextend_add_css_rule( array(
						'selector'  => 'body',
						'property'  => 'background',
						'idtag'     => 'background',
					) );

	if ( $site_layout == 'boxed' ) {
		hybridextend_add_css_rule( array(
						'selector'  => '#main',
						'property'  => 'background',
						'value'     => $box_background_color,
						'idtag'     => 'box_background_color',
					) );
	}

	/* Header (Topbar, Header, Main Nav Menu) */
	// Topbar

	hybridextend_add_css_rule( array(
						'selector'  => '.topbar-wrap',
						'property'  => 'border-color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );

	hybridextend_add_css_rule( array(
						'selector'  => '#topbar .social-icons-icon',
						'property'  => 'color',
						'value'     => $accent_font,
						'idtag'     => 'accent_font',
					) );

	/* Header (Topbar, Header, Main Nav Menu) */
	// Text Logo

	if ( 'display' != $logo_fontface ) { // Override @logoFontFamily if selected in options
		hybridextend_add_css_rule( array(
						'selector'  => '#site-title',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'font-family' => array( '"Droid Sans", sans-serif' ),
							),
					) ); // Removed in premium
	}

	/* Header (Topbar, Header, Main Nav Menu) */
	// Logo (with icon)

	if ( intval( $site_title_icon_size ) ) {
		hybridextend_add_css_rule( array(
						'selector'  => '.site-logo-with-icon #site-title i',
						'property'  => 'font-size',
						'value'     => $site_title_icon_size,
						'idtag'     => 'site_title_icon_size',
					) );
	}

	if ( $site_title_icon && intval( $site_title_icon_size ) ) {
		hybridextend_add_css_rule( array(
						'selector'  => '.site-logo-with-icon #site-title',
						'property'  => 'margin-left',
						'value'     => $site_title_icon_size,
						'idtag'     => 'site_title_icon_size',
					) );
	}

	/* Header (Topbar, Header, Main Nav Menu) */
	// Mixed/Mixedcustom Logo (with image)

	if ( !empty( $logo_image_width ) ) :
	hybridextend_add_css_rule( array(
						'selector'  => '.site-logo-mixed-image img',
						'property'  => 'max-width',
						'value'     => $logo_image_width,
						'idtag'     => 'logo_image_width',
					) );
	endif;

	/* Header (Topbar, Header, Main Nav Menu) */
	// Custom Logo

	if ( 'custom' == $logo || 'mixedcustom' == $logo ) {
		if ( is_array( $logo_custom ) && !empty( $logo_custom ) ) {
			$lcount = 1;
			foreach ( $logo_custom as $logo_custom_line ) {
				if ( !$logo_custom_line['sortitem_hide'] && !empty( $logo_custom_line['size'] ) ) {
					hybridextend_add_css_rule( array(
						'selector'  => '#site-logo-custom .site-title-line' . $lcount . ',#site-logo-mixedcustom .site-title-line' . $lcount,
						'property'  => 'font-size',
						'value'     => $logo_custom_line['size'],
					) );
				}
				if ( $lcount == 1 ) {
					hybridextend_add_css_rule( array(
						'selector'  => '.site-logo-custom .site-title i',
						'property'  => 'line-height',
						'value'     => $logo_custom_line['size'],
					) );
				}
				$lcount++;
			}
		}
	}

	/* Header (Topbar, Header, Main Nav Menu) */
	// Nav Menu

	hybridextend_add_css_rule( array(
						'selector'  => '.header-static-home',
						'property'  => 'border-color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );

	/* Header (Topbar, Header, Main Nav Menu) */
	// Aside Header

	hybridextend_add_css_rule( array(
						'selector'  => '#sidebar-header-sidebar',
						'property'  => 'color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );

	/* Main #Content */

	hybridextend_add_css_rule( array(
						'selector'  => '#loop-meta.pageheader-bg-incontent:after, #loop-meta.pageheader-bg-none:after',
						'property'  => 'border-color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );

	hybridextend_add_css_rule( array(
						'selector'  => '.content .entry-byline:after',
						'property'  => 'border-color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );

	hybridextend_add_css_rule( array(
						'selector'  => '.entry-footer .entry-byline',
						'property'  => 'color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) ); // Overridden in premium

	/* Main #Content for Index (Archive / Blog List) */

	hybridextend_add_css_rule( array(
						'selector'  => '.archive-big .more-link, .archive-medium .more-link, .archive-small .more-link',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background' => array( $accent_color, 'accent_color' ),
							'color'      => array( $accent_font, 'accent_font' ),
							),
					) );

	hybridextend_add_css_rule( array(
						'selector'  => '.entry .more-link:before', // Replaces: '.archive-big .more-link:before, .archive-medium .more-link:before, .archive-small .more-link:before',
						'property'  => 'border-color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );

	hybridextend_add_css_rule( array(
						'selector'  => '.archive-big .more-link:hover, .archive-medium .more-link:hover, .archive-small .more-link:hover',
						'property'  => 'background',
						'value'     => $accent_color_dark,
					) );

	/* Light Slider */

	hybridextend_add_css_rule( array(
						'selector'  => '#page-wrapper .lSSlideOuter .lSPager.lSpg > li a',
						'property'  => 'border-color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );

	/* Frontpage */

	hybridextend_add_css_rule( array(
						'selector'  => '.frontpage-area.module-bg-accent',
						'property'  => 'background-color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );

	// Set as inline CSS
	// foreach ( $wtmodule_bg as $wtmname ) {
	// 	if ( $wtm_sectionbg[ $wtmname . '_type'] == 'image' && !empty( $wtm_sectionbg[ $wtmname . '_image'] ) && empty( $wtm_sectionbg[ $wtmname . '_parallax'] ) ) {
	// 		hybridextend_add_css_rule( array(
	// 					'selector'  => "#frontpage-{$wtmname}",
	// 					'property'  => 'background-image',
	// 					'value'     => $wtm_sectionbg[ $wtmname . '_image'],
	// 					'idtag'     => "frontpage_sectionbg_{$wtmname}-image",
	// 				) );
	// 	}
	// }

	/* Sidebars and Widgets */

	hybridextend_add_css_rule( array(
						'selector' => '.topborder-shadow:before, .bottomborder-shadow:after',
						'property' => 'border-color',
						'value'    => $accent_color,
						'idtag'    => 'accent_color',
					) );

	hybridextend_add_css_rule( array(
						'selector' => '.content-block-style4 .content-block-icon:before' . ',' . '.social-icons-widget' . ',' . '.content-flush .more-link:before',
						'property'  => 'border-color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );

	hybridextend_add_css_rule( array(
						'selector'  => '.social-icons-widget .social-icons-icon',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background'   => array( $accent_color, 'accent_color' ),
							'color'        => array( $accent_font, 'accent_font' ),
							// 'border-color' => array( $accent_color, 'accent_color' ), // for skype block
							),
					) );

	/* Plugins */

	hybridextend_add_css_rule( array(
						'selector'  => '#infinite-handle span',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background' => array( $accent_color, 'accent_color' ),
							'color'      => array( $accent_font, 'accent_font' ),
							),
					) );

}