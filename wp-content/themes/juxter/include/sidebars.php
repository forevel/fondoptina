<?php
/**
 * Register sidebar widget areas for the theme
 * This file is loaded via the 'after_setup_theme' hook at priority '10'
 *
 * @package    Hoot
 * @subpackage Juxter
 */

/* Register sidebars. */
add_action( 'widgets_init', 'hoot_base_register_sidebars', 5 );
add_action( 'widgets_init', 'hoot_frontpage_register_sidebars' );

/**
 * Registers sidebars.
 *
 * @since 1.0
 * @access public
 * @return void
 */
function hoot_base_register_sidebars() {

	// Primary Sidebar
	hybrid_register_sidebar(
		array(
			'id'          => 'hoot-primary-sidebar',
			'name'        => _x( 'Primary Sidebar', 'sidebar', 'juxter' ),
			'description' => __( 'The main sidebar used throughout the site.', 'juxter' )
		)
	);

	// Secondary Sidebar
	hybrid_register_sidebar(
		array(
			'id'          => 'hoot-secondary-sidebar',
			'name'        => _x( 'Secondary Sidebar', 'sidebar', 'juxter' ),
			'description' => __( 'The secondary sidebar used throughout the site (if you are using a 3 column layout with 2 sidebars).', 'juxter' )
		)
	);

	// Topbar Left Widget Area
	hybrid_register_sidebar(
		array(
			'id'          => 'hoot-topbar-left',
			'name'        => _x( 'Topbar Left', 'sidebar', 'juxter' ),
			'description' => __( 'Leave empty if you dont want to show topbar.', 'juxter' )
		)
	);

	// Topbar Right Widget Area
	hybrid_register_sidebar(
		array(
			'id'          => 'hoot-topbar-right',
			'name'        => _x( 'Topbar Right', 'sidebar', 'juxter' ),
			'description' => __( 'Leave empty if you dont want to show topbar.', 'juxter' )
		)
	);

	// Header Widget Area
	hybrid_register_sidebar(
		array(
			'id'          => 'hoot-header',
			'name'        => _x( 'Header Side', 'sidebar', 'juxter' ),
			'description' => __( 'Area on right of logo in the header', 'juxter' )
		)
	);

	// Subfooter Widget Area
	hybrid_register_sidebar(
		array(
			'id'          => 'hoot-sub-footer',
			'name'        => _x( 'Sub Footer', 'sidebar', 'juxter' ),
			'description' => __( 'Leave empty if you dont want to show subfooter.', 'juxter' )
		)
	);

	// Footer Columns
	$footercols = hoot_get_footer_columns();

	if( $footercols ) :
		$alphas = range('a', 'z');
		for ( $i=0; $i < $footercols; $i++ ) :
			if ( isset( $alphas[ $i ] ) ) :
				hybrid_register_sidebar(
					array(
						'id'          => 'hoot-footer-' . $alphas[ $i ],
						'name'        => sprintf( _x( 'Footer %s', 'sidebar', 'juxter' ), strtoupper( $alphas[ $i ] ) ),
						'description' => __( 'You can set footer columns in Theme Options page.', 'juxter' )
					)
				);
			endif;
		endfor;
	endif;

}

/**
 * Registers frontpage widget areas.
 *
 * @since 1.0
 * @access public
 * @return void
 */
function hoot_frontpage_register_sidebars() {

	$areas = array();

	/* Set up defaults */
	$defaults = apply_filters( 'hoot_frontpage_widget_areas', array( 'a', 'b', 'c', 'd', 'e' ) );
	$locations = apply_filters( 'hoot_frontpage_widget_area_names', array(
		__( 'Left', 'juxter' ),
		__( 'Center Left', 'juxter' ),
		__( 'Center', 'juxter' ),
		__( 'Center Right', 'juxter' ),
		__( 'Right', 'juxter' ),
	) );

	// Get user settings
	$sections = hybridextend_sortlist( hoot_get_mod( 'frontpage_sections' ) );

	foreach ( $defaults as $key ) {
		$id = "area_{$key}";
		if ( empty( $sections[$id]['sortitem_hide'] ) ) {

			$columns = ( isset( $sections[$id]['columns'] ) ) ? $sections[$id]['columns'] : '';
			$count = count( explode( '-', $columns ) ); // empty $columns still returns array of length 1
			$location = '';

			for ( $c = 1; $c <= $count ; $c++ ) {
				switch ( $count ) {
					case 2: $location = ($c == 1) ? $locations[0] : $locations[4];
							break;
					case 3: $location = ($c == 1) ? $locations[0] : (
								($c == 2) ? $locations[2] : $locations[4]
							);
							break;
					case 4: $location = ($c == 1) ? $locations[0] : (
								($c == 2) ? $locations[1] : (
									($c == 3) ? $locations[3] : $locations[4]
								)
							);
				}
				$areas[ $id . '_' . $c ] = sprintf( __('Frontpage - Widget Area %s %s', 'juxter'), strtoupper( $key ), $location );
			}

		}
	}

	foreach ( $areas as $key => $name ) {
		hybrid_register_sidebar(
			array(
				'id'          => 'hoot-frontpage-' . $key,
				'name'        => $name,
				'description' => __( "You can order Frontpage areas in Customizer > 'Content' panel > 'Frontpage - Modules' section.", 'juxter' )
			)
		);
	}

}