<?php 
/**
 * Template name: One project page
 */ 
// Loads the header.php template.
require_once('inc/config.php');
get_header();
?>

<?php
// Dispay Loop Meta at top
hoot_display_loop_title_content( 'pre', 'pageprojects.php' );
if ( hoot_page_header_attop() ) {
	get_template_part( 'template-parts/loop-meta' ); // Loads the template-parts/loop-meta.php template to display Title Area with Meta Info (of the loop)
	hoot_display_loop_title_content( 'post', 'pageprojects.php' );
}

// Template modification Hook
do_action( 'hoot_template_before_content_grid', 'pageprojects.php' );
?>

<div class="hgrid main-content-grid">

	<?php
	// Template modification Hook
	do_action( 'hoot_template_before_main', 'pageprojects.php' );
	?>

    <main <?php hybridextend_attr( 'content' ); ?>>

		<?php
		// Template modification Hook
		do_action( 'hoot_template_main_start', 'pageprojects.php' ); ?>

        <div id='project-picture-frame'>
            <img src="/wp-content/uploads/2018/01/shkola_pokrovsk_1-300x225.png" />
        </div>
        
        <div id="project-works-frame">
            123
            <div id="pgb"></div>
        </div>
    
        <div><p>История Покровской школы начинается с 1898 года, когда в селе Покровск Костешовской волости Козельского уезда при церкви была открыта церковно-приходская школа. Помещалась она в собственном доме священника. С 1916 года в Покровской церковно-приходской школе начал учительствовать Беляев Иван Петрович. В 30-е годы Беляев И.П., желая сохранить Покровскую церковь от разрушения, добился создания в ней 7-летней школы. В 1960 году школа стала 8-летней.</p>
        <p>В 1979 году в д. Покровск построили новую двухэтажную школу по типовому проекту. Строительство здания новой 8-летней школы шло, когда директором школы был Чеглаков Александр Егорович. К 1990 году назрела необходимость в полном среднем общем образовании, и по просьбе родителей, школа была преобразована в среднюю общеобразовательную школу. С 1 сентября 2008 года, в связи с комплексной прогроаммой модернизации образования, школа вновь стала основной общеобразовательной школой. Открыта группа предшкольной подготовки детей с 5,5 лет.</p>
        <p>С июля 2011 года название школы изменилось на Муниципальное бюджетное общеобразовательное учреждение, а с января 2012 года название школы стало Муниципальное казённое общеобразовательное учреждение.</p>
        <p>В настоящее время в школе реализуются основная общебразовательная программа начального общего образования, основная общеобразовательная программа основного общего образования, дополнительные программы следующих направленностей: художественно-эстетической; физкультурно-спортивной; социально-педагогической; военно-патриотической; научно-технической; подготовка детей к школе.</p>  
        </div>
		<?php // Template modification Hook
		do_action( 'hoot_template_main_end', 'pageprojects.php' );
		?>

	</main><!-- #content -->

	<?php
	// Template modification Hook
	do_action( 'hoot_template_after_main', 'pageprojects.php' );
	?>

	<?php hybridextend_get_sidebar( 'primary' ); // Loads the template-parts/sidebar-primary.php template. ?>

</div><!-- .hgrid -->

    <script>
        $(document).ready(function() {
            'use strict';
            var pgb = $('#pgb');
            pgb.ariaProgressbar({
//                progressClass: 'progress progress_streamtext',
                maxVal: 100
            });

            pgb.ariaProgressbar('update', 37);
        });
    </script> 

<?php get_footer(); // Loads the footer.php template. ?>