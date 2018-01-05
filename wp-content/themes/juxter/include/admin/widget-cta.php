<?php
/**
 * Call To Action Widget
 *
 * @package    Hoot
 * @subpackage Juxter
 */

/**
* Class Hoot_CTA_Widget
*/
class Hoot_CTA_Widget extends HybridExtend_WP_Widget {

	function __construct() {

		$settings['id'] = 'hoot-cta-widget';
		$settings['name'] = __( 'Hoot > Call To Action', 'juxter' );
		$settings['widget_options'] = array(
			'description'	=> __('Display Call To Action block.', 'juxter'),
			// 'classname'		=> 'hoot-cta-widget', // CSS class applied to frontend widget container via 'before_widget' arg
		);
		$settings['control_options'] = array();
		$settings['form_options'] = array(
			//'name' => can be empty or false to hide the name
			array(
				'name'		=> __( 'Headline', 'juxter' ),
				'id'		=> 'headline',
				'type'		=> 'text',
			),
			array(
				'name'		=> __( 'Description', 'juxter' ),
				'id'		=> 'description',
				'type'		=> 'textarea',
			),
			array(
				'name'		=> __( 'Button Text', 'juxter' ),
				'desc'		=> __( 'Leave empty if you dont want to show button', 'juxter' ),
				'id'		=> 'button_text',
				'type'		=> 'text',
				'std'		=> __( 'KNOW MORE', 'juxter' ),
			),
			array(
				'name'		=> __( 'URL', 'juxter' ),
				'desc'		=> __( 'Leave empty if you dont want to show button', 'juxter' ),
				'id'		=> 'url',
				'type'		=> 'text',
				'sanitize'	=> 'url',
			),
			array(
				'name'		=> __( 'Border', 'juxter' ),
				'desc'		=> __( 'Top and bottom borders.', 'juxter' ),
				'id'		=> 'border',
				'type'		=> 'select',
				'std'		=> 'none none',
				'options'	=> array(
					'line line'		=> __( 'Top - Line || Bottom - Line', 'juxter' ),
					'line shadow'	=> __( 'Top - Line || Bottom - StrongLine', 'juxter' ),
					'line none'		=> __( 'Top - Line || Bottom - None', 'juxter' ),
					'shadow line'	=> __( 'Top - StrongLine || Bottom - Line', 'juxter' ),
					'shadow shadow'	=> __( 'Top - StrongLine || Bottom - StrongLine', 'juxter' ),
					'shadow none'	=> __( 'Top - StrongLine || Bottom - None', 'juxter' ),
					'none line'		=> __( 'Top - None || Bottom - Line', 'juxter' ),
					'none shadow'	=> __( 'Top - None || Bottom - StrongLine', 'juxter' ),
					'none none'		=> __( 'Top - None || Bottom - None', 'juxter' ),
				),
			),
			array(
				'name'		=> __( 'Widget CSS', 'juxter' ),
				'id'		=> 'customcss',
				'type'		=> 'collapse',
				'fields'	=> array(
					array(
						'name'		=> __( 'Custom CSS Class', 'juxter' ),
						'desc'		=> __( 'Give this widget a custom css classname', 'juxter' ),
						'id'		=> 'class',
						'type'		=> 'text',
					),
					array(
						'name'		=> __( 'Margin Top', 'juxter' ),
						'desc'		=> __( '(in pixels) Leave empty to load default margins', 'juxter' ),
						'id'		=> 'mt',
						'type'		=> 'text',
						'settings'	=> array( 'size' => 3 ),
						'sanitize'	=> 'integer',
					),
					array(
						'name'		=> __( 'Margin Bottom', 'juxter' ),
						'desc'		=> __( '(in pixels) Leave empty to load default margins', 'juxter' ),
						'id'		=> 'mb',
						'type'		=> 'text',
						'settings'	=> array( 'size' => 3 ),
						'sanitize'	=> 'integer',
					),
					array(
						'name'		=> __( 'Widget ID', 'juxter' ),
						'id'		=> 'widgetid',
						'type'		=> '<span class="widgetid" data-baseid="' . $settings['id'] . '">' . __( 'Save this widget to view its ID', 'juxter' ) . '</span>',
					),
				),
			),
		);

		$settings = apply_filters( 'hoot_cta_widget_settings', $settings );

		parent::__construct( $settings['id'], $settings['name'], $settings['widget_options'], $settings['control_options'], $settings['form_options'] );

	}

	/**
	 * Echo the widget content
	 */
	function display_widget( $instance, $before_title = '', $title='', $after_title = '' ) {
		extract( $instance, EXTR_SKIP );
		include( hybridextend_locate_widget( 'cta' ) ); // Loads the widget/cta or template-parts/widget-cta.php template.
	}

}

/**
 * Register Widget
 */
function hoot_cta_widget_register(){
	register_widget('Hoot_CTA_Widget');
}
add_action('widgets_init', 'hoot_cta_widget_register');