/**
 * Contains functionality specific to this theme.
 * This is a set of functions that handle core theme parts.
 */

jQuery(document).ready(function(){

	/**
	 * Shows the content with nicer fade in animation if a browser supports it.
	 */
	jQuery('body').addClass('body-visible');
	 
	/**
	 * Adds has-submenu class to menu items that have submenus.
	 */
	jQuery('.nav-menu li').each(function(){
		if(jQuery(this).children('.sub-menu').length){ // children() gets direct children
			jQuery(this).addClass('has-submenu');
		}
	});
	
	/**
	 * Enable menu toggle for small screens.
	 */
	( function() {
		var nav = jQuery( '.site-navigation' ), button, menu;
		if ( ! nav )
			return;

		button = nav.find( '.menu-toggle' );
		if ( ! button )
			return;

		// Hide button if menu is missing or empty.
		menu = nav.find( '.nav-menu' );
		if ( ! menu || ! menu.children().length ) {
			button.hide();
			return;
		}

		jQuery( '.menu-toggle' ).on( 'click.konzept', function() {
			nav.toggleClass( 'toggled-on' );
		} );
	} )();
	
	/**
	 * Enable language toggle for small screens.
	 */
	( function() {
		jQuery( '.current_language' ).on( 'click.konzept', function() {
			jQuery( '#flags_language_selector' ).toggleClass( 'toggled-on' );
		} );
	} )();
	
	/**
	 * Add a body class when the mouse cursor is on the screen.
	 */
	( function() {
		jQuery( document ).on( 'mouseenter.konzept', function() {
			jQuery( 'body' ).addClass( 'cursor-in-viewport' );
		} );
		jQuery( document ).on( 'mouseleave.konzept', function() {
			jQuery( 'body' ).removeClass( 'cursor-in-viewport' );
		} );
	} )();
});

function headerPadding(){
	var wasCompact = false;
	if(jQuery('body').hasClass('header-compact')){
		jQuery('body').removeClass('header-compact');
		wasCompact = true;
	}
	var headerHeight = jQuery('#header').height();
	if(jQuery('body').hasClass('viewing-portfolio-grid')){
		var footerHeight = jQuery('#footer').height();
	}else{
		var footerHeight = jQuery('#footer').outerHeight(true);
	}
	if(wasCompact){
		jQuery('body').addClass('header-compact');
	}
	jQuery('body').css('padding-top', headerHeight);
	jQuery('body').css('padding-bottom', footerHeight);
	if(jQuery(window).width() <= 700){
		jQuery('body').css('padding-top', '');
		jQuery('body').css('padding-bottom', '');
	}
}
jQuery(window).load(function(){
	headerPadding();
	jQuery(window).resize(function(){
		headerPadding();
		compactHeader();
	});
});
jQuery(document).ready(function(){
	headerPadding();
	jQuery('.header-back-to-top').click(function() {
		jQuery('html, body').animate({ scrollTop: 0 }, 'slow');
		return false;
	});
});

function compactHeader(){
	if(jQuery('body').hasClass('disable-compact-header')){
		return;
	}
	if(jQuery('body').hasClass('blog') || jQuery('body').hasClass('page-template-index-php') || jQuery('body').hasClass('single') || jQuery('body').hasClass('search') || jQuery('body').hasClass('archive')){
		var headerTop = jQuery(window).scrollTop();
		if(headerTop > 200 && jQuery(window).width() > 720){
			jQuery('body').addClass('header-compact');
		}else{
			jQuery('body').removeClass('header-compact');
		}
	}
}
jQuery(document).ready(function(){
	jQuery(window).scroll(function(){
		compactHeader();
	});
});
jQuery(window).load(function(){
	if(!(jQuery('body').hasClass('viewing-portfolio-grid'))){
		var headerHeight = jQuery('.portfolio-container').height();
		jQuery('.portfolio-container').css({'margin-top' : ~headerHeight});
	}
});
jQuery(document).ready(function(){
	jQuery('.pf_nav li a').on('click', function(e){
		closePortfolioItem();
		e.preventDefault();
		jQuery('.pf_nav li a').removeClass('selected');
		jQuery(this).addClass('selected');
		var categorySelector = jQuery(this).attr('data-option-value');
		jQuery('.element').addClass('thumb-inactive');
		jQuery(categorySelector).removeClass('thumb-inactive');
		
		jQuery('body').addClass('viewing-portfolio-grid');
		jQuery('.portfolio-container').css({'margin-top' : ''});
		jQuery('.nav-menu').find('li').each(function(){
			jQuery(this).removeClass('current-menu-item').removeClass('current_page_item');
		});
		
		headerPadding();
		
		// Scroll to the first selected item
		var htmlMarginTop = parseInt( jQuery('html').css('margin-top'), 10 );
		var bodyPaddingTop = parseInt( jQuery('body').css('padding-top'), 10 );
		if(jQuery(window).width() >= 1024 && !jQuery('.tn-grid-container').hasClass('text-grid')){
			jQuery('html, body').animate({
				scrollTop: ((jQuery(categorySelector).eq(0).offset().top) - (htmlMarginTop + bodyPaddingTop))
			}, 500);
		}
	});
});

/**
 * Handles compact header search textarea.
 */
jQuery(document).ready(function(){
	jQuery('.compact-search').click(function(){
		jQuery('.header-search').css({ 'display' : 'block' });
		jQuery('.header-search .search-field').focus();
	});
	jQuery('.header-search').click(function(e){
		var target = e.target;

		while (target.nodeType != 1) target = target.parentNode;
		if(target.tagName != 'INPUT'){
			jQuery('.header-search').css({ 'display' : 'none' });
		}
	});
});