/**
 * Theme Customizer
 */


( function( api ) {

	// Extends our custom "hoot-premium" section.
	api.sectionConstructor['hoot-premium'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );


jQuery(document).ready(function($) {
	"use strict";


	/*** Hide and link module BG buttons ***/

	$('.frontpage_sections_modulebg .button').on('click',function(event){
		event.stopPropagation();
		var choice = $(this).closest('li.hybridextend-control-sortlistitem').data('choiceid');
		$('.hybridextend-control-id-frontpage_sectionbg_' + choice + ' .hybridextend-flypanel-button').trigger('click');
	});


	/*** Premium USe ***/

	var $premiumhead = $('#accordion-section-premium > h3', 'body:not(.hoot-bcomp)');
	if ( $premiumhead.length ) {
		$premiumhead.prepend('<i class="fa fa-star"></i> ');
		$premiumhead.on( 'click', function(){
			$('body').addClass('hoot-display-premiumuse');
		});
		//$('#sub-accordion-section-premium .customize-section-back, #accordion-section-premium .customize-section-back').on('click', function(){
		$('.customize-section-back').on('click', function(){
			$('body').removeClass('hoot-display-premiumuse');
		});
	}


});
