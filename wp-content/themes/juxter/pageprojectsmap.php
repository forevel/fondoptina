<?php 
/**
 * Template name: Projects Page
 */ 
// Loads the header.php template.
require_once('inc/config.php');
get_header();
?>

<?php
// Dispay Loop Meta at top
hoot_display_loop_title_content( 'pre', 'page.php' );
if ( hoot_page_header_attop() ) {
	get_template_part( 'template-parts/loop-meta' ); // Loads the template-parts/loop-meta.php template to display Title Area with Meta Info (of the loop)
	hoot_display_loop_title_content( 'post', 'page.php' );
}

// Template modification Hook
do_action( 'hoot_template_before_content_grid', 'page.php' );
?>

<div class="hgrid main-content-grid">

	<?php
	// Template modification Hook
	do_action( 'hoot_template_before_main', 'page.php' );
	?>

	<main <?php hybridextend_attr( 'content' ); ?>>

		<?php
		// Template modification Hook
		do_action( 'hoot_template_main_start', 'page.php' );

		// Checks if any posts were found.
		if ( have_posts() ) :

			// Dispay Loop Meta in content wrap
			if ( ! hoot_page_header_attop() ) {
				hoot_display_loop_title_content( 'post', 'page.php' );
				get_template_part( 'template-parts/loop-meta' ); // Loads the template-parts/loop-meta.php template to display Title Area with Meta Info (of the loop)
			}
			?>

			<div id="content-wrap">

				<?php
				// Template modification Hook
				do_action( 'hoot_loop_start', 'page.php' );

				// Display Featured Image if present
				if ( hoot_get_mod( 'post_featured_image' ) && !hybridextend_is_404() ) {
					$img_size = apply_filters( 'hoot_post_image_page', '' );
					hoot_post_thumbnail( 'entry-content-featured-img', $img_size, true );
				}

				// Begins the loop through found posts, and load the post data.
				while ( have_posts() ) : the_post();

					// Loads the template-parts/content-{$post_type}.php template.
					hybridextend_get_content_template();

				// End found posts loop.
				endwhile;

				// Template modification Hook
				do_action( 'hoot_loop_end', 'page.php' );
				?>

			</div><!-- #content-wrap -->

			<?php
			// Template modification Hook
			do_action( 'hoot_template_after_content_wrap', 'page.php' );

			// Loads the comments.php template if this page is not being displayed as frontpage or a custom 404 page or if this is attachment page of media attached (uploaded) to a page.
			if ( !is_front_page() && !hybridextend_is_404() && !is_attachment() ) :

				// Loads the comments.php template
				comments_template( '', true );

			endif;

		// If no posts were found.
		else :

			// Loads the template-parts/error.php template.
			get_template_part( 'template-parts/error' );

		// End check for posts.
		endif;

		// Template modification Hook
		do_action( 'hoot_template_main_end', 'page.php' );
		?>
        
        <script type="text/javascript">
            jQuery(document).ready(function()
                                  {
            ymaps.ready(init);
            var myMap, myPlacemark;

            function init()
            { 
                myMap = new ymaps.Map("yamap", {
                center: [54.03482, 35.78226],
                zoom: 13
            }); 

            var MyBalloonContentLayoutClass = ymaps.templateLayoutFactory.createClass(
    '<h3>{{ properties.name }}</h3>' +
    '<p>Описание: {{ properties.description }}</p>' +
    '<p><a href= {{ properties.url|default:"#" }} >Продолжение</a></p>'
            );
            <?php
            $template_url = get_template_directory_uri();
            $projects = get_table_from_db("projects");
            foreach($projects as $p)
            {
                $symbols = array(
                    "heartg.png",
                    "heartp.png",
                    "christ.png",
                    "building.png",
                )
            ?>
            myPlacemark = new ymaps.Placemark([<?php echo $p['lat']; ?>,
                                               <?php echo $p['log']; ?>],
                                              {
                hintContent: '<?php echo $p['name']; ?>',
                name: '<?php echo $p["name"]; ?>',
                description: '<?php echo $p["descr"]; ?>',
                url: '<?php echo $p["url"]; ?>'},{
                iconLayout: 'default#image',
                iconImageHref: '<?php echo $template_url ?>/pic/<?php echo $symbols[$p['cat']]; ?>',
                iconImageSize: [30, 40],
                iconImageOffset: [-20, -40],
                balloonContentLayout: MyBalloonContentLayoutClass
            });
            myMap.geoObjects.add(myPlacemark); 
            <?php
            }
            ?>

                                  }
        });
        </script>
            
        <div id="yamap" style="height: 600px; width: 100%;"></div>

	</main><!-- #content -->

	<?php
	// Template modification Hook
	do_action( 'hoot_template_after_main', 'page.php' );
	?>

	<?php hybridextend_get_sidebar( 'primary' ); // Loads the template-parts/sidebar-primary.php template. ?>

</div><!-- .hgrid -->

<?php get_footer(); // Loads the footer.php template. ?>