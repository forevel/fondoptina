<?php
/**
 * Content Posts Blocks Widget
 *
 * @package    Hoot
 * @subpackage Juxter
 */

/**
* Class Hoot_Content_Posts_Blocks_Widget
*/
class Hoot_Content_Posts_Blocks_Widget extends HybridExtend_WP_Widget {

	function __construct() {

		$settings['id'] = 'hoot-posts-blocks-widget';
		$settings['name'] = __( 'Hoot > Content Blocks (Posts)', 'juxter' );
		$settings['widget_options'] = array(
			'description'	=> __('Display Styled Content Blocks.', 'juxter'),
			// 'classname'		=> 'hoot-posts-blocks-widget', // CSS class applied to frontend widget container via 'before_widget' arg
		);
		$settings['control_options'] = array();
		$settings['form_options'] = array(
			//'name' => can be empty or false to hide the name
			array(
				'name'		=> __( "Title (optional)", 'juxter' ),
				'id'		=> 'title',
				'type'		=> 'text',
			),
			array(
				'name'		=> __( 'Blocks Style', 'juxter' ),
				'id'		=> 'style',
				'type'		=> 'images',
				'std'		=> 'style1',
				'options'	=> array(
					'style1'	=> HYBRIDEXTEND_INCURI . 'admin/images/content-block-style-1.png',
					'style2'	=> HYBRIDEXTEND_INCURI . 'admin/images/content-block-style-2.png',
					// 'style3'	=> HYBRIDEXTEND_INCURI . 'admin/images/content-block-style-3.png',
					'style4'	=> HYBRIDEXTEND_INCURI . 'admin/images/content-block-style-4.png',
				),
			),
			array(
				'name'		=> __( 'Category (Optional)', 'juxter' ),
				'desc'		=> __( 'Leave empty to display posts from all categories.', 'juxter' ),
				'id'		=> 'category',
				'type'		=> 'select',
				'options'	=> array( '0' => '' ) + HybridExtend_WP_Widget::get_tax_list('category') ,
			),
			array(
				'name'		=> __( 'No. Of Columns', 'juxter' ),
				'id'		=> 'columns',
				'type'		=> 'smallselect',
				'std'		=> '4',
				'options'	=> array(
					'1'	=> __( '1', 'juxter' ),
					'2'	=> __( '2', 'juxter' ),
					'3'	=> __( '3', 'juxter' ),
					'4'	=> __( '4', 'juxter' ),
					'5'	=> __( '5', 'juxter' ),
				),
			),
			array(
				'name'		=> __( 'Number of Posts to show', 'juxter' ),
				'desc'		=> __( 'Default: 4', 'juxter' ),
				'id'		=> 'count',
				'type'		=> 'text',
				'settings'	=> array( 'size' => 3, ),
				'sanitize'	=> 'absint',
			),
			array(
				'name'		=> __( 'Offset', 'juxter' ),
				'desc'		=> __( 'Number of posts to skip from the start. Leave empty to start from the latest post.', 'juxter' ),
				'id'		=> 'offset',
				'type'		=> 'text',
				'settings'	=> array( 'size' => 3, ),
				'sanitize'	=> 'absint',
			),
			array(
				'name'		=> __( 'Show Author', 'juxter' ),
				'id'		=> 'show_author',
				'type'		=> 'checkbox',
			),
			array(
				'name'		=> __( 'Show Post Date', 'juxter' ),
				'id'		=> 'show_date',
				'type'		=> 'checkbox',
			),
			array(
				'name'		=> __( 'Show number of comments', 'juxter' ),
				'id'		=> 'show_comments',
				'type'		=> 'checkbox',
			),
			array(
				'name'		=> __( 'Show categories', 'juxter' ),
				'id'		=> 'show_cats',
				'type'		=> 'checkbox',
			),
			array(
				'name'		=> __( 'Show tags', 'juxter' ),
				'id'		=> 'show_tags',
				'type'		=> 'checkbox',
			),
			array(
				'name'		=> __( 'Content', 'juxter' ),
				'id'		=> 'fullcontent',
				'type'		=> 'select',
				'std'		=> 'excerpt',
				'options'	=> array(
					'excerpt'	=> __( 'Display Excerpt', 'juxter' ),
					'content'	=> __( 'Display Full Content', 'juxter' ),
					'none'		=> __( 'None', 'juxter' ),
				),
			),
			array(
				'name'		=> __( 'Custom Excerpt Length', 'juxter' ),
				'desc'		=> __( 'Leave empty to use the automatically created excerpts.', 'juxter' ),
				'id'		=> 'excerptlength',
				'type'		=> 'text',
				'settings'	=> array( 'size' => 3, ),
				'sanitize'	=> 'absint',
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

		$settings = apply_filters( 'hoot_content_posts_blocks_widget_settings', $settings );

		parent::__construct( $settings['id'], $settings['name'], $settings['widget_options'], $settings['control_options'], $settings['form_options'] );

	}

	/**
	 * Echo the widget content
	 */
	function display_widget( $instance, $before_title = '', $title='', $after_title = '' ) {
		extract( $instance, EXTR_SKIP );
		include( hybridextend_locate_widget( 'content-posts-blocks' ) ); // Loads the widget/content-posts-blocks or template-parts/widget-content-posts-blocks.php template.
	}

}

/**
 * Register Widget
 */
function hoot_content_posts_blocks_widget_register(){
	register_widget('Hoot_Content_Posts_Blocks_Widget');
}
add_action('widgets_init', 'hoot_content_posts_blocks_widget_register');