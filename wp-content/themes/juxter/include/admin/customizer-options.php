<?php
/**
 * Defines customizer options
 *
 * This file is loaded at 'after_setup_theme' hook with 10 priority.
 *
 * @package    Hoot
 * @subpackage Juxter
 */

/**
 * Build the Customizer options (panels, sections, settings)
 *
 * Always remember to mention specific priority for non-static options like:
 *     - options being added based on a condition (eg: if woocommerce is active)
 *     - options which may get removed (eg: logo_size, headings_fontface)
 *     - options which may get rearranged (eg: logo_background_type)
 *     This will allow other options inserted with priority to be inserted at
 *     their intended place.
 *
 * @since 1.0
 * @access public
 * @return array
 */
if ( !function_exists( 'hoot_theme_customizer_options' ) ) :
function hoot_theme_customizer_options() {

	// Stores all the settings to be added
	$settings = array();

	// Stores all the sections to be added
	$sections = array();

	// Stores all the panels to be added
	$panels = array();

	// Theme default colors and fonts
	extract( apply_filters( 'hoot_theme_options_defaults', array(
		'accent_color'         => '#000000',
		'accent_font'          => '#ffffff',
		'box_background'       => '#ffffff',
		'site_background'      => '#f7f7f7',
		'site_background_patt' => 'hybrid/extend/images/patterns/4.png',
	) ) );

	// Directory path for radioimage buttons
	$imagepath =  HYBRIDEXTEND_INCURI . 'admin/images/';

	// Logo Sizes (different range than standard typography range)
	$logosizes = array();
	$logosizerange = range( 14, 110 );
	foreach ( $logosizerange as $isr )
		$logosizes[ $isr . 'px' ] = $isr . 'px';
	$logosizes = apply_filters( 'hoot_theme_options_logosizes', $logosizes);

	// Logo Font Options for Lite version
	$logofont = apply_filters( 'hoot_theme_options_logofont', array(
					'heading' => __("Logo Font (set in 'Typography' section)", 'juxter'),
					'standard' => __('Standard Body Font', 'juxter'),
					) );

	/*** Add Options (Panels, Sections, Settings) ***/

	/** Section **/

	$section = 'links';

	$sections[ $section ] = array(
		'title'       => __( 'Demo / Support', 'juxter' ),
		'priority'    => '2',
	);

	$lcontent = '';
	$lcontent .= '<a class="hoot-cust-link" href="' .
				 'https://demo.wphoot.com/juxter/' .
				 '" target="_blank"><span class="hoot-cust-link-head">' .
				 '<i class="fa fa-eye"></i> ' .
				 __( "Demo", 'juxter') . 
				 '</span><span class="hoot-cust-link-desc">' .
				 __( "Demo the theme features and options with sample content.", 'juxter') .
				 '</span></a>';
	$lcontent .= '<a class="hoot-cust-link" href="' .
				 'https://wphoot.com/support/' .
				 '" target="_blank"><span class="hoot-cust-link-head">' .
				 '<i class="fa fa-support"></i> ' .
				 __( "Documentation / Support", 'juxter') . 
				 '</span><span class="hoot-cust-link-desc">' .
				 __( "Get theme related support for both free and premium users.", 'juxter') .
				 '</span></a>';
	$lcontent .= '<a class="hoot-cust-link" href="' .
				 'https://wordpress.org/support/view/theme-reviews/juxter#postform' .
				 '" target="_blank"><span class="hoot-cust-link-head">' .
				 '5 <i class="fa fa-star"></i> ' .
				 __( "Rate Us", 'juxter') . 
				 '</span><span class="hoot-cust-link-desc">' .
				 __( "If you are happy with the theme, give us a 5 star rating on wordpress.org", 'juxter') .
				 '</span></a>';

	$settings['linksection'] = array(
		// 'label'       => __( 'Premium Options', 'juxter' ),
		'section'     => $section,
		'type'        => 'content',
		'priority'    => '8', // Non static options must have a priority
		'content'     => $lcontent,
	);

	/** Section **/

	$section = 'title_tagline';

	$sections[ $section ] = array(
		'title'       => __( 'Setup &amp; Layout', 'juxter' ),
	);

	$settings['site_width'] = array(
		'label'       => __( 'Max. Site Width (pixels)', 'juxter' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'1260' => __('1260px (wide)', 'juxter'),
			'1080' => __('1080px (standard)', 'juxter'),
		),
		'default'     => '1260',
	);

	$settings['show_nav_menu_home'] = array(
		'label'       => __( 'Show Home Icon in Nav Menu', 'juxter' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'default'     => 1,
	);

	$settings['mobile_menu'] = array(
		'label'       => __( 'Mobile Menu', 'juxter' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'inline' => __('Inline - Menu Slide Downs to open', 'juxter'),
			'fixed'  => __('Fixed - Menu opens on the left', 'juxter'),
		),
		'default'     => 'fixed',
	);

	$settings['mobile_submenu_click'] = array(
		'label'       => __( "[Mobile Menu] Submenu opens on 'Click'", 'juxter' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'default'     => 1,
		'description' => __( "Uncheck this option to make all Submenus appear in 'Open' state. By default, submenus open on clicking (i.e. single tap on mobile).", 'juxter' ),
	);

	$settings['load_minified'] = array(
		'label'       => __( 'Load Minified Styles and Scripts (when available)', 'juxter' ),
		'sublabel'    => __( 'Checking this option reduces data size, hence increasing page load speed.', 'juxter' ),
		'section'     => $section,
		'type'        => 'checkbox',
		// 'default'     => 1,
	);

	$settings['sidebar_desc'] = array(
		'label'       => __( 'Multiple Sidebars', 'juxter' ),
		'section'     => $section,
		'type'        => 'content',
		'content'     => sprintf( __( 'This theme can display different sidebar content on different pages of your site with the %1sCustom Sidebars%2s plugin. Simply install and activate the plugin to use it with this theme. Or if you are using %3sJetpack%4s, you can use the %5s"Widget Visibility"%6s module.', 'juxter' ), '<a href="https://wordpress.org/plugins/custom-sidebars/screenshots/" target="_blank">', '</a>', '<a href="https://wordpress.org/plugins/jetpack/" target="_blank">', '</a>', '<a href="https://jetpack.com/support/widget-visibility/" target="_blank">', '</a>' ),
	);

	$settings['sidebar'] = array(
		'label'       => __( 'Sidebar Layout (Site-wide)', 'juxter' ),
		'section'     => $section,
		'type'        => 'radioimage',
		'choices'     => array(
			'wide-right'         => $imagepath . 'sidebar-wide-right.png',
			'narrow-right'       => $imagepath . 'sidebar-narrow-right.png',
			'wide-left'          => $imagepath . 'sidebar-wide-left.png',
			'narrow-left'        => $imagepath . 'sidebar-narrow-left.png',
			'narrow-left-right'  => $imagepath . 'sidebar-narrow-left-right.png',
			'narrow-left-left'   => $imagepath . 'sidebar-narrow-left-left.png',
			'narrow-right-right' => $imagepath . 'sidebar-narrow-right-right.png',
			'full-width'         => $imagepath . 'sidebar-full.png',
			'none'               => $imagepath . 'sidebar-none.png',
		),
		'default'     => 'wide-right',
		'description' => __("Set the default sidebar width and position for your site.", 'juxter'),
	);

	$settings['sidebar_pages'] = array(
		'label'       => __( 'Sidebar Layout (for Pages)', 'juxter' ),
		'section'     => $section,
		'type'        => 'radioimage',
		'choices'     => array(
			'wide-right'         => $imagepath . 'sidebar-wide-right.png',
			'narrow-right'       => $imagepath . 'sidebar-narrow-right.png',
			'wide-left'          => $imagepath . 'sidebar-wide-left.png',
			'narrow-left'        => $imagepath . 'sidebar-narrow-left.png',
			'narrow-left-right'  => $imagepath . 'sidebar-narrow-left-right.png',
			'narrow-left-left'   => $imagepath . 'sidebar-narrow-left-left.png',
			'narrow-right-right' => $imagepath . 'sidebar-narrow-right-right.png',
			'full-width'         => $imagepath . 'sidebar-full.png',
			'none'               => $imagepath . 'sidebar-none.png',
		),
		'default'     => 'wide-right',
	);

	$settings['sidebar_posts'] = array(
		'label'       => __( 'Sidebar Layout (for single Posts)', 'juxter' ),
		'section'     => $section,
		'type'        => 'radioimage',
		'choices'     => array(
			'wide-right'         => $imagepath . 'sidebar-wide-right.png',
			'narrow-right'       => $imagepath . 'sidebar-narrow-right.png',
			'wide-left'          => $imagepath . 'sidebar-wide-left.png',
			'narrow-left'        => $imagepath . 'sidebar-narrow-left.png',
			'narrow-left-right'  => $imagepath . 'sidebar-narrow-left-right.png',
			'narrow-left-left'   => $imagepath . 'sidebar-narrow-left-left.png',
			'narrow-right-right' => $imagepath . 'sidebar-narrow-right-right.png',
			'full-width'         => $imagepath . 'sidebar-full.png',
			'none'               => $imagepath . 'sidebar-none.png',
		),
		'default'     => 'wide-right',
	);

	/** Section **/

	$section = 'logo';

	$sections[ $section ] = array(
		'title'       => __( 'Logo', 'juxter' ),
	);

	$settings['logo_background_type'] = array(
		'label'       => __( 'Logo Background', 'juxter' ),
		'section'     => $section,
		'type'        => 'radio',
		'priority'    => '95', // Non static options must have a priority
		'choices'     => array(
			'transparent' => __('None', 'juxter'),
			'accent'      => __('Accent Color', 'juxter'),
		),
		'default'     => 'transparent',
	);

	$settings['logo'] = array(
		'label'       => __( 'Site Logo', 'juxter' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'text'        => __('Default Text (Site Title)', 'juxter'),
			'custom'      => __('Custom Text', 'juxter'),
			'image'       => __('Image Logo', 'juxter'),
			'mixed'       => __('Image &amp; Default Text (Site Title)', 'juxter'),
			'mixedcustom' => __('Image &amp; Custom Text', 'juxter'),
		),
		'default'     => 'text',
		'description' => sprintf( __('Use %sSite Title%s as default text logo', 'juxter'), '<a href="' . esc_url( admin_url('options-general.php') ) . '" target="_blank">', '</a>' ),
	);

	$settings['logo_size'] = array(
		'label'       => __( 'Logo Text Size', 'juxter' ),
		'section'     => $section,
		'type'        => 'select',
		'priority'    => '105', // Non static options must have a priority
		'choices'     => array(
			'tiny'   => __( 'Tiny', 'juxter'),
			'small'  => __( 'Small', 'juxter'),
			'medium' => __( 'Medium', 'juxter'),
			'large'  => __( 'Large', 'juxter'),
			'huge'   => __( 'Huge', 'juxter'),
		),
		'default'     => 'large',
		'active_callback' => 'hoot_callback_logo_size',
	);

	$settings['site_title_icon'] = array(
		'label'           => __( 'Site Title Icon (Optional)', 'juxter' ),
		'section'         => $section,
		'type'            => 'icon',
		// 'default'         => 'fa-anchor',
		'description'     => __( 'Leave empty to hide icon.', 'juxter' ),
		'active_callback' => 'hoot_callback_site_title_icon',
	);

	$settings['site_title_icon_size'] = array(
		'label'           => __( 'Site Title Icon Size', 'juxter' ),
		'section'         => $section,
		'type'            => 'select',
		'choices'         => $logosizes,
		'default'         => '50px',
		'active_callback' => 'hoot_callback_site_title_icon',
	);

	if ( ! function_exists( 'the_custom_logo' ) )
	$settings['logo_image'] = array(
		'label'           => __( 'Upload Logo', 'juxter' ),
		'section'         => $section,
		'type'            => 'image',
		'priority'        => '125', // Replaced by WP's custom_logo if available // Update in premium if needed
		'active_callback' => 'hoot_callback_logo_image',
	);

	$settings['logo_image_width'] = array(
		'label'           => __( 'Maximum Logo Width', 'juxter' ),
		'section'         => $section,
		'type'            => 'text',
		'priority'        => '126', // Keep it with image logo // Update in premium if needed
		'default'         => 200,
		'description'     => __( '(in pixels)<hr>The logo width may be automatically adjusted by the browser depending on title length and space available.', 'juxter' ),
		'input_attrs'     => array(
			'min'         => 0,
			'max'         => 3,
			'placeholder' => __( '(in pixels)', 'juxter' ),
		),
		'active_callback' => 'hoot_callback_logo_image_width',
	);

	$logo_custom_line_options = array(
		'text' => array(
			'label'       => __( 'Line Text', 'juxter' ),
			'type'        => 'text',
		),
		'size' => array(
			'label'       => __( 'Line Size', 'juxter' ),
			'type'        => 'select',
			'choices'     => $logosizes,
			'default'     => '24px',
		),
		'font' => array(
			'label'       => __( 'Line Font', 'juxter' ),
			'type'        => 'select',
			'choices'     => $logofont,
			'default'     => 'heading',
		),
	);

	$settings['logo_custom'] = array(
		'label'           => __( 'Custom Logo Text', 'juxter' ),
		'section'         => $section,
		'type'            => 'sortlist',
		'choices'         => array(
			'line1' => __('Line 1', 'juxter'),
			'line2' => __('Line 2', 'juxter'),
			'line3' => __('Line 3', 'juxter'),
			'line4' => __('Line 4', 'juxter'),
		),
		'options'         => array(
			'line1' => $logo_custom_line_options,
			'line2' => $logo_custom_line_options,
			'line3' => $logo_custom_line_options,
			'line4' => $logo_custom_line_options,
		),
		'attributes'      => array(
			'inactive' => array( 'line3', 'line4' ),
			'hideable' => true,
			'sortable' => false,
		),
		'active_callback' => 'hoot_callback_logo_custom',
	);

	$settings['show_tagline'] = array(
		'label'           => __( 'Show Tagline', 'juxter' ),
		'sublabel'        => __( 'Display site description as tagline below logo.', 'juxter' ),
		'section'         => $section,
		'type'            => 'checkbox',
		'default'         => 1,
		'active_callback' => 'hoot_callback_show_tagline',
	);

	/** Section **/

	$section = 'colors';

	// Redundant as 'colors' section is added by WP. But we still add it for brevity
	$sections[ $section ] = array(
		'title'       => __( 'Colors', 'juxter' ),
		'description' => __('Control various color options in the premium version for fonts, backgrounds, contrast, highlight, accent etc.', 'juxter'),
	);

	$settings['accent_color'] = array(
		'label'       => __( 'Accent Color', 'juxter' ),
		'section'     => $section,
		'type'        => 'color',
		'default'     => $accent_color,
	);

	$settings['accent_font'] = array(
		'label'       => __( 'Font Color on Accent Color', 'juxter' ),
		'section'     => $section,
		'type'        => 'color',
		'default'     => $accent_font,
	);

	if ( current_theme_supports( 'woocommerce' ) ) :
		$settings['woocommerce-colors-plugin'] = array(
			'label'       => __( 'Woocommerce Styling', 'juxter' ),
			'section'     => $section,
			'type'        => 'content',
			'priority'    => '165', // Non static options must have a priority
			'content'     => sprintf( __('Looks like you are using Woocommerce. Install %sthis plugin%s to change colors and styles for WooCommerce elements like buttons etc.', 'juxter'), '<a href="https://wordpress.org/plugins/woocommerce-colors/" target="_blank">', '</a>' ),
		);
	endif;

	/** Section **/

	$section = 'backgrounds';

	$sections[ $section ] = array(
		'title'       => __( 'Backgrounds', 'juxter' ),
		'description' => __('The premium version comes with background options for different sections of your site like header, menu dropdown, content area, logo background, footer etc.', 'juxter'),
	);

	$settings['background'] = array(
		'label'       => __( 'Site Background', 'juxter' ),
		'section'     => $section,
		'type'        => 'betterbackground',
		'default'     => array(
			'color'      => $site_background,
			'pattern'    => $site_background_patt,
		),
	);

	$settings['box_background_color'] = array(
		'label'       => __( 'Content Box Background', 'juxter' ),
		'section'     => $section,
		'type'        => 'color',
		'default'     => $box_background,
		// 'description' => __("This background is available only when <strong>Site Layout</strong> option is set to <strong>'Boxed'</strong> in the <strong>'Setup &amp; Layout'</strong> section.", 'juxter'),
		// 'active_callback' => 'hoot_callback_box_background_color',
	);

	/** Section **/

	$section = 'typography';

	$sections[ $section ] = array(
		'title'       => __( 'Typography', 'juxter' ),
		'description' => __('The premium version offers complete typography control (color, style, size) for various headings, header, menu, footer, widgets, content sections etc (over 600 Google Fonts to chose from)', 'juxter'),
	);

	$settings['logo_fontface'] = array(
		'label'       => __( 'Logo Font (Free Version)', 'juxter' ),
		'section'     => $section,
		'type'        => 'select',
		'priority'    => 285, // Non static options must have a priority
		'choices'     => array(
			'standard' => __( 'Standard Font (Droid Sans)', 'juxter'),
			'display'  => __( 'Display Font (Slabo)', 'juxter'),
		),
		'default'     => 'display',
	);

	/** Section **/

	$section = 'frontpage';

	$sections[ $section ] = array(
		'title'       => __( 'Frontpage - Modules', 'juxter' ),
	);

	$widget_area_options = array(
		'columns' => array(
			'label'   => __( 'Columns', 'juxter' ),
			'type'    => 'select',
			'choices' => array(
				'100'         => __('One Column [100]', 'juxter'),
				'50-50'       => __('Two Columns [50 50]', 'juxter'),
				'33-66'       => __('Two Columns [33 66]', 'juxter'),
				'66-33'       => __('Two Columns [66 33]', 'juxter'),
				'25-75'       => __('Two Columns [25 75]', 'juxter'),
				'75-25'       => __('Two Columns [75 25]', 'juxter'),
				'33-33-33'    => __('Three Columns [33 33 33]', 'juxter'),
				'25-25-50'    => __('Three Columns [25 25 50]', 'juxter'),
				'25-50-25'    => __('Three Columns [25 50 25]', 'juxter'),
				'50-25-25'    => __('Three Columns [50 25 25]', 'juxter'),
				'25-25-25-25' => __('Four Columns [25 25 25 25]', 'juxter'),
			),
		),
		'modulebg' => array(
			'label'       => '',
			'type'        => 'content',
			'content'     => '<div class="button">' . __( 'Module Background', 'juxter' ) . '</div>',
		),
	);

	$settings['frontpage_sections'] = array(
		'label'       => __( 'Frontpage Widget Areas', 'juxter' ),
		'sublabel'    => sprintf( __("<p></p><ul><li>Sort different sections of the Frontpage in the order you want them to appear.</li><li>You can add content to widget areas from the %1sWidgets Management screen%2s.</li><li>You can disable areas by clicking the 'eye' icon. (This will hide them on the Widgets screen as well)</li></ul>", 'juxter'), '<a href="' . esc_url( admin_url('widgets.php') ) . '" target="_blank">', '</a>' ),
		'section'     => $section,
		'type'        => 'sortlist',
		'choices'     => array(
			'slider_html' => __('HTML Slider', 'juxter'),
			'slider_img'  => __('Image Slider', 'juxter'),
			'area_a'      => __('Widget Area A', 'juxter'),
			'area_b'      => __('Widget Area B', 'juxter'),
			'area_c'      => __('Widget Area C', 'juxter'),
			'area_d'      => __('Widget Area D', 'juxter'),
			'area_e'      => __('Widget Area E', 'juxter'),
			'content'     => __('Frontpage Content', 'juxter'),
		),
		'default'     => array(
			// 'content' => array( 'sortitem_hide' => 1, ),
			'area_c'  => array( 'columns' => '33-33-33' ),
		),
		'options'     => array(
			'slider_html' => array(
				'modulebg' => array(
					'label'       => '',
					'type'        => 'content',
					'content'     => '<div class="button">' . __( 'Module Background', 'juxter' ) . '</div>',
				),
			),
			'slider_img'  => array(
				'modulebg' => array(
					'label'       => '',
					'type'        => 'content',
					'content'     => '<div class="button">' . __( 'Module Background', 'juxter' ) . '</div>',
				),
			),
			'area_a'      => $widget_area_options,
			'area_b'      => $widget_area_options,
			'area_c'      => $widget_area_options,
			'area_d'      => $widget_area_options,
			'area_e'      => $widget_area_options,
			'content'     => array(
							'title' => array(
								'label'       => __( 'Title (optional)', 'juxter' ),
								'type'        => 'text',
							),
							'modulebg' => array(
								'label'       => '',
								'type'        => 'content',
								'content'     => '<div class="button">' . __( 'Module Background', 'juxter' ) . '</div>',
							), ),
		),
		'attributes'  => array(
			'hideable'      => true,
			'sortable'      => true,
		),
		// 'description' => sprintf( __('You must first save the changes you make here and refresh this screen for widget areas to appear in the Widgets panel (in customizer). Once you save the settings, you can add content to these widget areas using the %sWidgets Management screen%s.', 'juxter'), '<a href="' . esc_url( admin_url('widgets.php') ) . '" target="_blank">', '</a>' ),
	);

	$settings['frontpage_content_desc'] = array(
		'label'       => __( "Frontpage Content", 'juxter' ),
		'section'     => $section,
		'type'        => 'content',
		'content'     => sprintf( __( "The 'Frontpage Content' module in above list will show<ul style='list-style:disc;margin:1em 0 0 2em;'><li>the <strong>'Blog'</strong> if you have <strong>Your Latest Posts</strong> selectd in %3sReading Settings%4s</li><li>the <strong>Page Content</strong> of the page set as Front page if you have <strong>A static page</strong> selected in %3sReading Settings%4s</li></ul>", 'juxter' ), '<a href="' . esc_url( admin_url('options-reading.php') ) . '" target="_blank">', '</a>', '<a href="' . esc_url( admin_url('options-reading.php') ) . '" target="_blank">', '</a>' ),
	);

	$settings["frontpage_sectionbg_slider_html"] =
	$settings["frontpage_sectionbg_slider_img"] = array(
		'label'       => '',
		'section'     => $section,
		'type'        => 'group',
		'button'      => __( 'Module Background', 'juxter' ),
		'options'     => array(
			'description' => array(
				'label'       => '',
				'type'        => 'content',
				'content'     => '<span class="hoot-module-bg-title">' . __('Slider Background', 'juxter') . '</span>',
			),
			'type' => array(
				'label'   => __( 'Background Type', 'juxter' ),
				'type'    => 'radio',
				'choices' => array(
					'none'        => __('None', 'juxter'),
					'highlight'   => __('Highlight Color', 'juxter'),
					'accent'      => __('Accent Color', 'juxter'),
				),
				'default' => 'none',
			),
		),
	);

	$frontpagemodule_bg = array(
		'area_a'      => __('Widget Area A', 'juxter'),
		'area_b'      => __('Widget Area B', 'juxter'),
		'area_c'      => __('Widget Area C', 'juxter'),
		'area_d'      => __('Widget Area D', 'juxter'),
		'area_e'      => __('Widget Area E', 'juxter'),
		'content'     => __('Frontpage Content', 'juxter'),
		);

	foreach ( $frontpagemodule_bg as $fpgmodid => $fpgmodname ) {

		$settings["frontpage_sectionbg_{$fpgmodid}"] = array(
			'label'       => '',
			'section'     => $section,
			'type'        => 'group',
			'button'      => __( 'Module Background', 'juxter' ),
			'options'     => array(
				'description' => array(
					'label'       => '',
					'type'        => 'content',
					'content'     => '<span class="hoot-module-bg-title">' . $fpgmodname . '</span>',
				),
				'type' => array(
					'label'   => __( 'Background Type', 'juxter' ),
					'type'    => 'radio',
					'choices' => array(
						'none'        => __('None', 'juxter'),
						'highlight'   => __('Highlight Color', 'juxter'),
						'image'       => __('Background Image', 'juxter'),
					),
					'default' => ( ( $fpgmodid == 'area_d' ) ? 'image' : ( ( $fpgmodid == 'area_b' ) ? 'highlight' : 'none' ) ),
				),
				'image' => array(
					'label'       => __( "Background Image (Select 'Image' above)", 'juxter' ),
					'type'        => 'image',
					'default' => ( ( $fpgmodid == 'area_d' ) ? HYBRID_PARENT_URI . 'images/modulebg.jpg' : '' ),
				),
				'parallax' => array(
					'label'   => __( 'Apply Parallax Effect to Background Image', 'juxter' ),
					'type'    => 'checkbox',
					'default' => ( ( $fpgmodid == 'area_d' ) ? 1 : 0 ),
				),
			),
		);

	} // end for

	/** Section **/

	$section = 'slider_html';

	$sections[ $section ] = array(
		'title'       => __( 'Frontpage - HTML Slider', 'juxter' ),
	);

	$settings['wt_html_slider_width'] = array(
		'label'       => __( 'Slider Width', 'juxter' ),
		'sublabel'    => __( "Note: This option is useful only if the <strong>Site Layout</strong> option is set to <strong>Stretched</strong> in 'Setup &amp; Layout' section.", 'juxter' ),
		'section'     => $section,
		'type'        => 'radioimage',
		'choices'     => array(
			'boxed'   => $imagepath . 'slider-width-boxed.png',
			'stretch' => $imagepath . 'slider-width-stretch.png',
		),
		'default'     => 'boxed',
	);

	$settings['wt_html_slider_min_height'] = array(
		'label'       => __( 'Minimum Slider Height (in pixels)', 'juxter' ),
		'section'     => $section,
		'type'        => 'text',
		'priority'    => 755, // Non static options must have a priority
		'default'     => 375,
		'description' => __('<strong>(in pixels)</strong><hr>Leave empty to let the slider height adjust automatically.', 'juxter'),
		'input_attrs' => array(
			'min' => 0,
			'max' => 3,
			'placeholder' => __( '(in pixels)', 'juxter' ),
		),
	);

	$settings['wt_html_slider'] = array(
		'label'       => __( 'Slides', 'juxter' ),
		'section'     => $section,
		'type'        => 'content',
		'priority'    => 755, // Non static options must have a priority
		'content'     => __( 'Premium version of this theme comes with capability to create <strong>Unlimited slides</strong>.', 'juxter' ),
	);

	for ( $slide = 1; $slide <= 4; $slide++ ) {

		$settings["wt_html_slide_{$slide}"] = array(
			'label'       => sprintf( __( 'Slide %s Content', 'juxter' ), $slide),
			'section'     => $section,
			'type'        => 'group',
			'priority'    => 755, // Non static options must have a priority
			'button'      => sprintf( __( 'Edit Slide %s', 'juxter' ), $slide),
			'options'     => array(
				'description' => array(
					'label'       => '',
					'type'        => 'content',
					'content'     => '<span class="hoot-module-bg-title">' . sprintf( __( 'Slide %s Content', 'juxter' ), $slide) . '</span>',
				),
				'image' => array(
					'label'       => __( 'Showcase Image (Right Column)', 'juxter' ),
					'type'        => 'content',
					'description' => __( "If the page below has a 'Featured Image', it will be used as the Showcase Image (image in right column)", 'juxter' ),
				),
				'content' => array(
					'label'       => __( 'Content (Left Column)', 'juxter' ),
					'type'        => 'select',
					'choices'     => array( __( 'Select Page', 'juxter' ) ) + HybridExtend_Options_Helper::pages(),
				),
				// 'image' => array(
				// 	'label'       => __( 'Featured Image (Right Column)', 'juxter' ),
				// 	'type'        => 'image',
				// 	'description' => __( 'Content below will be center aligned if no image is present.', 'juxter' ),
				// ),
				// 'content' => array(
				// 	'label'       => __( 'Content (Left Column)', 'juxter' ),
				// 	'type'        => 'textarea',
				// 	'default'     => '<h3>Lorem Ipsum Dolor</h3>' . "\n" . __('<p>This is a sample description text for the slide.</p>', 'juxter'),
				// 	'description' => __('You can use the <code>&lt;h3&gt;Lorem Ipsum Dolor&lt;/h3&gt;</code> tag to create styled heading.', 'juxter'),
				// ),
				// ),
				'content_bg' => array(
					'label'   => __( 'Content Styling', 'juxter' ),
					'type'    => 'select',
					'default' => 'dark-on-light',
					'choices' => array(
						'dark'          => __('Dark Font', 'juxter'),
						'light'         => __('Light Font', 'juxter'),
						'dark-on-light' => __('Dark Font / Light Background', 'juxter'),
						'light-on-dark' => __('Light Font / Dark Background', 'juxter'),
					),
				),
				'button' => array(
					'label'       => __( 'Button Text', 'juxter' ),
					'type'        => 'text',
				),
				'url' => array(
					'label'       => __( 'Button URL', 'juxter' ),
					'type'        => 'url',
					'description' => __( 'Leave empty if you do not want to show the button.', 'juxter' ),
					'input_attrs' => array(
						'placeholder' => 'http://',
					),
				),
			),
		);

		$settings["wt_html_slide_{$slide}-background"] = array(
			'label'       => sprintf( __( 'Slide %s Background', 'juxter' ), $slide),
			'section'     => $section,
			'type'        => 'betterbackground',
			'priority'    => 755, // Non static options must have a priority
			'default'     => array(
				'color'      => '#dddddd',
			),
			'options'     => array( 'color', 'image', 'pattern' ),
		);

	} // end for

	/** Section **/

	$section = 'slider_img';

	$sections[ $section ] = array(
		'title'       => __( 'Frontpage - Image Slider', 'juxter' ),
	);

	$settings['wt_img_slider_width'] = array(
		'label'       => __( 'Slider Width', 'juxter' ),
		'sublabel'    => __("Note: This option is useful only if the <strong>Site Layout</strong> option is set to <strong>Stretched</strong> in 'Setup &amp; Layout' section.", 'juxter'),
		'section'     => $section,
		'type'        => 'radioimage',
		'choices'     => array(
			'boxed'   => $imagepath . 'slider-width-boxed.png',
			'stretch' => $imagepath . 'slider-width-stretch.png',
		),
		'default'     => 'boxed',
	);

	$settings['wt_img_slider'] = array(
		'label'       => __( 'Slides', 'juxter' ),
		'section'     => $section,
		'type'        => 'content',
		'priority'    => 765, // Non static options must have a priority
		'content'     => __( 'Premium version of this theme comes with capability to create <strong>Unlimited slides</strong>.', 'juxter' ),
	);

	for ( $slide = 1; $slide <= 4; $slide++ ) { 

		$settings["wt_img_slide_{$slide}"] = array(
			'label'       => '',//sprintf( __( 'Slide %s Content', 'juxter' ), $slide),
			'section'     => $section,
			'type'        => 'group',
			'priority'    => 765, // Non static options must have a priority
			'button'      => sprintf( __( 'Edit Slide %s', 'juxter' ), $slide),
			'options'     => array(
				'description' => array(
					'label'       => '',
					'type'        => 'content',
					'content'     => '<span class="hoot-module-bg-title">' . sprintf( __( 'Slide %s Content', 'juxter' ), $slide) . '</span>' . __( '<em>To hide this slide, simply leave the Image empty.</em>', 'juxter' ),
				),
				'image' => array(
					'label'       => __( 'Slide Image', 'juxter' ),
					'type'        => 'image',
					'description' => __( 'The main showcase image.', 'juxter' ),
				),
				'caption' => array(
					'label'       => __( 'Slide Caption (optional)', 'juxter' ),
					'type'        => 'textarea',
					'default'     => '<h3>Lorem Ipsum Dolor</h3>' . "\n" . __('<p>This is a sample description text for the slide.</p>', 'juxter'),
					'description' => __('You can use the <code>&lt;h3&gt;Lorem Ipsum Dolor&lt;/h3&gt;</code> tag to create styled heading.', 'juxter'),
				),
				'caption_bg' => array(
					'label'   => __( 'Caption Styling', 'juxter' ),
					'type'    => 'select',
					'default' => 'dark-on-light',
					'choices' => array(
						'dark'          => __('Dark Font', 'juxter'),
						'light'         => __('Light Font', 'juxter'),
						'dark-on-light' => __('Dark Font / Light Background', 'juxter'),
						'light-on-dark' => __('Light Font / Dark Background', 'juxter'),
					),
				),
				'url' => array(
					'label'       => __( 'Slide Link', 'juxter' ),
					'type'        => 'url',
					'description' => __( 'Leave empty if you do not want to link the slide.', 'juxter' ),
					'input_attrs' => array(
						'placeholder' => 'http://',
					),
				),
				'button' => array(
					'label'       => __( 'Button Text (Optional)', 'juxter' ),
					'type'        => 'text',
					'description' => __( 'Leave empty if you do not want to show the button and instead link the slide image (if you have a url set in the above field)', 'juxter' ),
				),
			),
		);

	} // end for

	/** Section **/

	$section = 'archives';

	$sections[ $section ] = array(
		'title'       => __( 'Archives (Blog, Cats, Tags)', 'juxter' ),
	);

	$settings['archive_post_content'] = array(
		'label'       => __( 'Post Items Content', 'juxter' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'excerpt' => __('Post Excerpt', 'juxter'),
			'full-content' => __('Full Post Content', 'juxter'),
		),
		'default'     => 'excerpt',
		'description' => __( 'Content to display for each post in the list', 'juxter' ),
	);

	$settings['archive_post_meta'] = array(
		'label'       => __( 'Meta Information for Post List Items', 'juxter' ),
		'sublabel'    => __( 'Check which meta information to display for each post item in the archive list.', 'juxter' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'choices'     => array(
			'author'   => __('Author', 'juxter'),
			'date'     => __('Date', 'juxter'),
			'cats'     => __('Categories', 'juxter'),
			'tags'     => __('Tags', 'juxter'),
			'comments' => __('No. of comments', 'juxter')
		),
		'default'     => 'author, date, cats, comments',
	);

	$settings['excerpt_length'] = array(
		'label'       => __( 'Excerpt Length', 'juxter' ),
		'section'     => $section,
		'type'        => 'text',
		'description' => __( 'Number of words in excerpt. Default is 105. Leave empty if you dont want to change it.', 'juxter' ),
		'input_attrs' => array(
			'min' => 0,
			'max' => 3,
			'placeholder' => __( 'default: 105', 'juxter' ),
		),
	);

	$settings['read_more'] = array(
		'label'       => __( "'Read More' Text", 'juxter' ),
		'section'     => $section,
		'type'        => 'text',
		'description' => __( "Replace the default 'Read More' text. Leave empty if you dont want to change it.", 'juxter' ),
		'input_attrs' => array(
			'placeholder' => __( 'default: READ MORE &rarr;', 'juxter' ),
		),
	);

	/** Section **/

	$section = 'singular';

	$sections[ $section ] = array(
		'title'       => __( 'Single (Posts, Pages)', 'juxter' ),
	);

	$settings['page_header_full'] = array(
		'label'       => __( 'Stretch Page Header to Full Width', 'juxter' ),
		'sublabel'    => '<img src="' . $imagepath . 'page-header.png">',
		'section'     => $section,
		'type'        => 'checkbox',
		'choices'     => array(
			'default'    => __('Default (Archives, Blog, Woocommerce etc.)', 'juxter'),
			'posts'      => __('For All Posts', 'juxter'),
			'pages'      => __('For All Pages', 'juxter'),
			'no-sidebar' => __('Always override for full width pages (any page which has no sidebar)', 'juxter'),
		),
		'default'     => 'default, pages, no-sidebar',
		'description' => __('This is the Page Header area containing Page/Post Title and Meta details like author, categories etc.', 'juxter'),
	);

	$settings['post_featured_image'] = array(
		'label'       => __( 'Display Featured Image', 'juxter' ),
		'sublabel'    => __( 'Display featured image at the beginning of post/page content.', 'juxter' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'default'     => 1,
	);

	$settings['post_meta'] = array(
		'label'       => __( 'Meta Information on Posts', 'juxter' ),
		'sublabel'    => __( "Check which meta information to display on an individual 'Post' page", 'juxter' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'choices'     => array(
			'author'   => __('Author', 'juxter'),
			'date'     => __('Date', 'juxter'),
			'cats'     => __('Categories', 'juxter'),
			'tags'     => __('Tags', 'juxter'),
			'comments' => __('No. of comments', 'juxter')
		),
		'default'     => 'author, date, cats, tags, comments',
	);

	$settings['page_meta'] = array(
		'label'       => __( 'Meta Information on Page', 'juxter' ),
		'sublabel'    => __( "Check which meta information to display on an individual 'Page' page", 'juxter' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'choices'     => array(
			'author'   => __('Author', 'juxter'),
			'date'     => __('Date', 'juxter'),
			'comments' => __('No. of comments', 'juxter')
		),
		'default'     => 'author, date, comments',
	);

	$settings['post_meta_location'] = array(
		'label'       => __( 'Meta Information location', 'juxter' ),
		'section'     => $section,
		'type'        => 'radio',
		'choices'     => array(
			'top'    => __('Top (below title)', 'juxter'),
			'bottom' => __('Bottom (after content)', 'juxter'),
		),
		'default'     => 'top',
	);

	$settings['post_prev_next_links'] = array(
		'label'       => __( 'Previous/Next Posts', 'juxter' ),
		'sublabel'    => __( 'Display links to Prev/Next Post links at the end of post content.', 'juxter' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'default'     => 1,
	);

	$settings['contact-form'] = array(
		'label'       => __( 'Contact Form', 'juxter' ),
		'section'     => $section,
		'type'        => 'content',
		'content'     => sprintf( __('This theme comes bundled with CSS required to style %sContact-Form-7%s forms. Simply install and activate the plugin to add Contact Forms to your pages.', 'juxter'), '<a href="https://wordpress.org/plugins/contact-form-7/" target="_blank">', '</a>'), // @todo update link to docs
	);

	if ( current_theme_supports( 'woocommerce' ) ) :

		/** Section **/

		$section = 'woocommerce';

		$sections[ $section ] = array(
			'title'       => __( 'WooCommerce', 'juxter' ),
			'priority'    => '53', // Non static options must have a priority
		);

		$wooproducts = range( 0, 99 );
		for ( $wpr=0; $wpr < 4; $wpr++ )
			unset( $wooproducts[$wpr] );
		$settings['wooshop_products'] = array(
			'label'       => __( 'Total Products per page', 'juxter' ),
			'section'     => $section,
			'type'        => 'select',
			'priority'    => '875', // Non static options must have a priority
			'choices'     => $wooproducts,
			'default'     => '12',
			'description' => __( 'Total number of products to show on the Shop page', 'juxter' ),
		);

		$settings['wooshop_product_columns'] = array(
			'label'       => __( 'Product Columns', 'juxter' ),
			'section'     => $section,
			'type'        => 'select',
			'priority'    => '875', // Non static options must have a priority
			'choices'     => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
			),
			'default'     => '3',
			'description' => __( 'Number of products to show in 1 row on the Shop page', 'juxter' ),
		);

		$settings['sidebar_wooshop'] = array(
			'label'       => __( 'Sidebar Layout (Woocommerce Shop/Archives)', 'juxter' ),
			'section'     => $section,
			'type'        => 'radioimage',
			'priority'    => '875', // Non static options must have a priority
			'choices'     => array(
				'wide-right'         => $imagepath . 'sidebar-wide-right.png',
				'narrow-right'       => $imagepath . 'sidebar-narrow-right.png',
				'wide-left'          => $imagepath . 'sidebar-wide-left.png',
				'narrow-left'        => $imagepath . 'sidebar-narrow-left.png',
				'narrow-left-right'  => $imagepath . 'sidebar-narrow-left-right.png',
				'narrow-left-left'   => $imagepath . 'sidebar-narrow-left-left.png',
				'narrow-right-right' => $imagepath . 'sidebar-narrow-right-right.png',
				'full-width'         => $imagepath . 'sidebar-full.png',
				'none'               => $imagepath . 'sidebar-none.png',
			),
			'default'     => 'wide-right',
			'description' => __("Set the default sidebar width and position for WooCommerce Shop and Archives pages like product categories etc.", 'juxter'),
		);

		$settings['sidebar_wooproduct'] = array(
			'label'       => __( 'Sidebar Layout (Woocommerce Single Product Page)', 'juxter' ),
			'section'     => $section,
			'type'        => 'radioimage',
			'priority'    => '875', // Non static options must have a priority
			'choices'     => array(
				'wide-right'         => $imagepath . 'sidebar-wide-right.png',
				'narrow-right'       => $imagepath . 'sidebar-narrow-right.png',
				'wide-left'          => $imagepath . 'sidebar-wide-left.png',
				'narrow-left'        => $imagepath . 'sidebar-narrow-left.png',
				'narrow-left-right'  => $imagepath . 'sidebar-narrow-left-right.png',
				'narrow-left-left'   => $imagepath . 'sidebar-narrow-left-left.png',
				'narrow-right-right' => $imagepath . 'sidebar-narrow-right-right.png',
				'full-width'         => $imagepath . 'sidebar-full.png',
				'none'               => $imagepath . 'sidebar-none.png',
			),
			'default'     => 'wide-right',
			'description' => __("Set the default sidebar width and position for WooCommerce product page", 'juxter'),
		);

	endif;

	/** Section **/

	$section = 'footer';

	$sections[ $section ] = array(
		'title'       => __( 'Footer', 'juxter' ),
	);

	$settings['footer'] = array(
		'label'       => __( 'Footer Layout', 'juxter' ),
		'section'     => $section,
		'type'        => 'radioimage',
		'choices'     => array(
			'1-1' => $imagepath . '1-1.png',
			'2-1' => $imagepath . '2-1.png',
			'2-2' => $imagepath . '2-2.png',
			'2-3' => $imagepath . '2-3.png',
			'3-1' => $imagepath . '3-1.png',
			'3-2' => $imagepath . '3-2.png',
			'3-3' => $imagepath . '3-3.png',
			'3-4' => $imagepath . '3-4.png',
			'4-1' => $imagepath . '4-1.png',
		),
		'default'     => '3-1',
		'description' => sprintf( __('You must first save the changes you make here and refresh this screen for footer columns to appear in the Widgets panel (in customizer).<hr> Once you save the settings here, you can add content to footer columns using the %sWidgets Management screen%s.', 'juxter'), '<a href="' . esc_url( admin_url('widgets.php') ) . '" target="_blank">', '</a>' ),
	);

	$settings['site_info'] = array(
		'label'       => __( 'Site Info Text (footer)', 'juxter' ),
		'section'     => $section,
		'type'        => 'textarea',
		'default'     => __( '<!--default-->', 'juxter'),
		'description' => sprintf( __('Text shown in footer. Useful for showing copyright info etc.<hr>Use the <code>&lt;!--default--&gt;</code> tag to show the default Info Text.<hr>Use the <code>&lt;!--year--&gt;</code> tag to insert the current year.<hr>Always use %sHTML codes%s for symbols. For example, the HTML for &copy; is <code>&amp;copy;</code>', 'juxter'), '<a href="http://ascii.cl/htmlcodes.htm" target="_blank">', '</a>' ),
	);

	/** Premium Section **/

	$premium_features_file = HYBRIDEXTEND_INC . 'admin/premium.php';
	$hoot_customizer_load_premiumsection = apply_filters( 'hoot_customize_load_premiumsection', file_exists( $premium_features_file ) );
	if ( $hoot_customizer_load_premiumsection ) :

		$section = 'premium';

		$sections[ $section ] = array(
			'title'       => __( 'Premium Options', 'juxter' ),
			'priority'    => 41,
		);

		include( HYBRIDEXTEND_INC . 'admin/premium.php' );
		$pcontent = '';
		$plink = ( !empty( $hoot_cta_url ) ) ? $hoot_cta_url : '';
		$pdemo = ( !empty( $hoot_cta_demo_url ) ) ? $hoot_cta_demo_url : '';
		$hoot_intro = ( !empty( $hoot_intro ) && is_array( $hoot_intro ) ) ? $hoot_intro : array();
		$hoot_intro = wp_parse_args( $hoot_intro, array(
			'name' => __('Upgrade to Premium', 'juxter'),
			'desc' => '',
			) );

		if ( !empty( $hoot_options_premium ) && is_array( $hoot_options_premium ) ):
			$pcontent .= '<div id="hoot-psection" class="hoot-psection">';
				$pcontent .= '<h1 class="centered">' . $hoot_intro['name'] . '</h1>';
				$pcontent .= '<p class="hoot-upsell-intro centered">' . $hoot_intro['desc'] . '</p>';
				$pcontent .= '<p class="hoot-upsell-cta centered pcontent-actions pcontent-top">';
					if ( !empty( $plink ) ) $pcontent .= '<a class="button button-primary" href="' . esc_url( $plink ) . '" target="_blank"><i class="fa fa-star"></i> ' . __( 'Buy Now', 'juxter' ) . '</a>';
					if ( !empty( $pdemo ) ) $pcontent .= '<a class="button button-secondary" href="' . esc_url( $pdemo ) . '" target="_blank"><i class="fa fa-eye"></i> ' . __( 'Theme Demo', 'juxter' ) . '</a>';
				$pcontent .= '</p>';
				$pcontent .= '<div class="hoot-psection-content">';
					foreach ( $hoot_options_premium as $pofeature ) :
						$looparray = ( !empty( $pofeature['style'] ) && $pofeature['style'] == 'aside' ) ? $pofeature['blocks'] : array( $pofeature );
						foreach ( $looparray as $pfeature ) :
						$pcontent .= '<div class="section-premium premium-info">';
							if ( !empty( $pfeature['img'] ) )
								$pcontent .= '<div class="premium-info-img"><img src="' . esc_url( $pfeature['img'] ) . '" /></div>';
							$pcontent .= '<div class="premium-info-textblock">';
								if ( !empty( $pfeature['name'] ) )
									$pcontent .= '<div class="premium-info-heading"><h4 class="heading">' . $pfeature['name'] . '</h4></div>';
								if ( !empty( $pfeature['desc'] ) )
									$pcontent .= '<div class="premium-info-text">' . $pfeature['desc'] . '</div>';
								$pcontent .= '<div class="clear"></div>';
							$pcontent .= '</div>';
						$pcontent .= '</div>';
						endforeach;
					endforeach;
				$pcontent .= '</div>';
				$pcontent .= '<p class="hoot-upsell-cta centered pcontent-actions pcontent-bottom">';
					if ( !empty( $plink ) ) $pcontent .= '<a class="button button-primary" href="' . esc_url( $plink ) . '" target="_blank"><i class="fa fa-star"></i> ' . __( 'Buy Now', 'juxter' ) . '</a>';
					if ( !empty( $pdemo ) ) $pcontent .= '<a class="button button-secondary" href="' . esc_url( $pdemo ) . '" target="_blank"><i class="fa fa-eye"></i> ' . __( 'Theme Demo', 'juxter' ) . '</a>';
				$pcontent .= '</p>';
			$pcontent .= '</div>';
		endif;

		if ( !empty( $pcontent ) )
			$settings['premium-use'] = array(
				// 'label'       => __( 'Premium Options', 'juxter' ),
				'section'     => $section,
				'type'        => 'content',
				'priority'    => '505', // Non static options must have a priority
				'content'     => $pcontent,
			);

	endif;


	/*** Return Options Array ***/
	return apply_filters( 'hoot_theme_customizer_options', array(
		'settings' => $settings,
		'sections' => $sections,
		'panels'   => $panels,
	) );

}
endif;

/**
 * Add Options (settings, sections and panels) to HybridExtend_Customize class options object
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hoot_theme_add_customizer_options' ) ) :
function hoot_theme_add_customizer_options() {

	$hybridextend_customize = HybridExtend_Customize::get_instance();

	// Add Options
	$options = hoot_theme_customizer_options();
	$hybridextend_customize->add_options( array(
		'settings' => $options['settings'],
		'sections' => $options['sections'],
		'panels' => $options['panels'],
		) );

}
endif;
add_action( 'init', 'hoot_theme_add_customizer_options', 0 ); // cannot hook into 'after_setup_theme' as this hook is already being executed (this file is loaded at after_setup_theme @priority 10) (hooking into same hook from within while hook is being executed leads to undesirable effects as $GLOBALS[$wp_filter]['after_setup_theme'] has already been ksorted)
// Hence, we hook into 'init' @priority 0, so that settings array gets populated before 'widgets_init' action ( which itself is hooked to 'init' at priority 1 ) for creating widget areas ( settings array is needed for creating defaults when user value has not been stored )

/**
 * Enqueue custom scripts to customizer screen
 *
 * @since 1.0
 * @return void
 */
function hoot_theme_customizer_enqueue_scripts() {
	// Enqueue Styles
	wp_enqueue_style( 'hoot-theme-customize-styles', HYBRIDEXTEND_INCURI . 'admin/css/customize.css', array(),  HYBRIDEXTEND_VERSION );
	// Enqueue Scripts
	wp_enqueue_script( 'hoot-theme-customize-script', HYBRIDEXTEND_INCURI . 'admin/js/customize.js', array( 'jquery', 'wp-color-picker', 'customize-controls', 'hybridextend-customize-script' ), HYBRIDEXTEND_VERSION, true );
}
// Load scripts at priority 12 so that Hoot Customizer Interface (11) / Custom Controls (10) have loaded their scripts
add_action( 'customize_controls_enqueue_scripts', 'hoot_theme_customizer_enqueue_scripts', 12 );

/**
 * Modify default WordPress Settings Sections and Panels
 *
 * @since 1.0
 * @param object $wp_customize
 * @return void
 */
function hoot_customizer_modify_default_options( $wp_customize ) {

	if ( function_exists( 'the_custom_logo' ) ) {
		$wp_customize->get_control( 'custom_logo' )->section = 'logo';
		$wp_customize->get_control( 'custom_logo' )->priority = 125; // Replaces theme's logo_image // Update in premium if needed
		$wp_customize->get_control( 'custom_logo' )->width = 250;
		$wp_customize->get_control( 'custom_logo' )->height = 90;
		// $wp_customize->get_control( 'custom_logo' )->type = 'image'; // Stored value becomes url instead of image ID (fns like the_custom_logo() dont work)
		// Defaults: [type] => cropped_image, [width] => 150, [height] => 150, [flex_width] => 1, [flex_height] => 1, [button_labels] => array(...), [label] => Logo
		$wp_customize->get_control( 'custom_logo' )->active_callback = 'hoot_callback_logo_image';
	}

	if ( function_exists( 'get_site_icon_url' ) )
		$wp_customize->get_control( 'site_icon' )->priority = 10;

	$wp_customize->get_section( 'static_front_page' )->priority = 3;

	// $wp_customize->get_section( 'title_tagline' )->panel = 'general';
	// $wp_customize->get_section( 'title_tagline' )->priority = 1;
	// $wp_customize->get_section( 'colors' )->panel = 'styling';

	// global $wp_version;
	// if ( version_compare( $wp_version, '4.3', '>=' ) ) // 'Creating Default Object from Empty Value' error before 4.3 since 'nav_menus' panel did not exist ( we did have 'nav' section till 4.1.9 i.e. before 4.2 )
	// 	$wp_customize->get_panel( 'nav_menus' )->priority = 999;
	// This will set the priority, however will give a 'Creating Default Object from Empty Value' error first.
	// $wp_customize->get_panel( 'widgets' )->priority = 999;

}
add_action( 'customize_register', 'hoot_customizer_modify_default_options', 100 );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since 1.0
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function hoot_customizer_customize_register( $wp_customize ) {
	// $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'hoot_customizer_customize_register' );

/**
 * Callback Functions for customizer settings
 */

function hoot_callback_logo_size( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'text' || $selector == 'mixed' ) ? true : false;
}
function hoot_callback_site_title_icon( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'text' || $selector == 'custom' ) ? true : false;
}
function hoot_callback_logo_image( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'image' || $selector == 'mixed' || $selector == 'mixedcustom' ) ? true : false;
}
function hoot_callback_logo_image_width( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'mixed' || $selector == 'mixedcustom' ) ? true : false;
}
function hoot_callback_logo_custom( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'custom' || $selector == 'mixedcustom' ) ? true : false;
}
function hoot_callback_show_tagline( $control ) {
	$selector = $control->manager->get_setting('logo')->value();
	return ( $selector == 'text' || $selector == 'custom' || $selector == 'mixed' || $selector == 'mixedcustom' ) ? true : false;
}

// function hoot_callback_box_background_color( $control ) {
// 	$selector = $control->manager->get_setting('site_layout')->value();
// 	return ( $selector == 'boxed' ) ? true : false;
// }

/**
 * Helper function to return the theme mod value.
 * If no value has been saved, it returns $default provided by the theme.
 * If no $default provided, it checks the default value specified in the customizer settings..
 * 
 * @since 1.0
 * @access public
 * @param string $name
 * @param mixed $default
 * @return mixed
 */
function hoot_get_mod( $name, $default = NULL ) {

	if ( is_customize_preview() ) {

		// We cannot use "if ( !empty( $mod ) )" as this will become false for empty values, and hence fallback to default. isset() is not an option either as $mod is always set. Hence we calculate the default here, and supply it as second argument to get_theme_mod()
		$default = ( $default !== NULL ) ? $default : hybridextend_customize_get_default( $name );
		$mod = get_theme_mod( $name, $default );

		return apply_filters( 'hoot_get_mod_customize', $mod, $name, $default );

	} else {

		/*** Return value if set ***/

		// Cache
		static $mods = NULL;

		// Get the values from database
		if ( !$mods ) {
			$mods = get_theme_mods();
			$mods = apply_filters( 'hoot_get_mod', $mods );
		}

		if ( isset( $mods[$name] ) ) {
			// Filter applied as in get_theme_mod() core function
			$mods[$name] = apply_filters( "theme_mod_{$name}", $mods[$name] );
			// Add exceptions: If a value has been set but is empty, this gives the option to return default values in such cases. Simply return $override as (bool)true.
			$override = apply_filters( 'hoot_get_mod_override_empty_values', false, $name, $mods[$name] );
			if ( $override !== true )
				return apply_filters( 'hoot_sanitize_get_mod', $mods[$name], $name );
		}

		/*** Return default if provided ***/
		if ( $default !== NULL )
			return apply_filters( "theme_mod_{$name}", $default );

		/*** Return default theme option value specified in customizer settings ***/
		$default = hybridextend_customize_get_default( $name );
		if ( !empty( $default ) )
			return apply_filters( "theme_mod_{$name}", $default );

	}

	/*** We dont have anything! ***/
	return false;
}

/**
 * Sanitization function for return value of theme mod
 * jnes No chan-ni applied
 * 
 * @since 1.0
 * @access public
 * @param mixed $value
 * @param string $name
 * @return mixed
 */
function hoot_sanitize_get_mod( $value, $name ) {

	/** Get Setting array from the Customizer Class **/
	$hybridextend_customize = HybridExtend_Customize::get_instance();
	$settings = $hybridextend_customize->get_options('settings');

	if ( isset( $settings[ $name ] ) ) {

		/** Load Sanitization functions if not loaded already (for frontend) **/
		if ( !function_exists( 'hybridextend_sanitize_enum' ) )
			require_once( HYBRIDEXTEND_DIR . 'includes/sanitization.php' );

		/** Sanitize values **/
		if ( isset( $settings[ $name ]['type'] ) ) {
			switch ( $settings[ $name ]['type'] ) {

				// Text Field
				case 'text':
					$value = sanitize_text_field( $value ); // Alternately, can also use "hybridextend_customize_sanitize_text" to use wp_kses() instead
					break;

				// Textarea Field
				case 'textarea':
					$value = hybridextend_sanitize_textarea( $value );
					break;

				// Select, Radio, Image Radio
				case 'select':
				case 'radio':
				case 'radioimage':
					$value = hybridextend_sanitize_enum( $value, $settings[ $name ]['choices'] );
					break;

				// Image / Upload Field
				case 'image':
				case 'upload':
					$value = esc_url( $value );
					break;

				// URL Field
				case 'url':
					$value = esc_url( $value );
					break;

				// Range Field
				case 'range':
					$value = hybridextend_customize_sanitize_range( $value );
					break;

				// Dropdown Pages Field
				case 'dropdown-pages':
					$value = absint( $value );
					break;

				// Color Field
				case 'color':
					$value = sanitize_hex_color( $value );
					break;

				// Checkbox Field
				case 'checkbox':
					$value = hybridextend_sanitize_checkbox( $value );
					break;

				// MultiCheckbox Field
				case 'bettercheckbox':
					if ( !empty( $settings[ $name ]['choices'] ) && is_array( $settings[ $name ]['choices'] ) )
						$value = hybridextend_customize_sanitize_multicheckbox( $value, $name );
					else
						$value = hybridextend_sanitize_checkbox( $value );
					break;

				// Icon Field
				case 'icon':
					$value = hybridextend_sanitize_icon( $value, $name );
					break;

				// Sortlist Field
				case 'sortlist':
					$value = hybridextend_customize_sanitize_sortlist( $value, $name );
					break;

			} // endswitch
		} // endif

	} // endif

	return $value;
}