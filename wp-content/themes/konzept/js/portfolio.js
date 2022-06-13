// The variable prevents initial onpopstate on Chrome and Safari. As soon as onpopstate happens or as soon as any pushState happens it is permanently set to 'false'.
var	initialURL = location.href;

var myScroll = {};
var current_slide = 0; // Initial slide is always 0
var number_of_slides; // each slide has id="slide_0", id="slide_1" etc.
/* var autoplayTime = <?php echo json_encode(get_option('flow_slideshow_autoplay')); ?>; // False, (empty string) or Integer (or anything that user put here)
var mouseWheel = <?php echo json_encode(get_option('flow_slideshow_mousewheel')); ?>; // False, (empty string) or Integer (0 = enabled, 1 = disabled) */
var slideshowWidth = jQuery(window).width();
var newVals = [];
var windowHeight;
var windowWidth;
var totalWidth;
var moved;
var projectIsLoading;
var _flowScrolling = false;

function bringPortfolio(current_id){

	global_current_id = current_id;
	
	// If project with such ID does not exist, load project 0 or do nothing
	if(projectsArray[current_id] === undefined){ 
		if(projectsArray.length != 0){
			// If user wants to open projects with page refresh, do this
			if(jQuery('body').hasClass('page-refresh')){
				location.href = projectsArray[0][7];
				return;
			}
			bringPortfolio(0); 
		} 
		return;
	}
	
	// Assign projects array to variables
	var title = projectsArray[current_id][0];
	var desc = projectsArray[current_id][1];
	var date = projectsArray[current_id][2];
	var client = projectsArray[current_id][3];
	var agency = projectsArray[current_id][4];
	var ourrole = projectsArray[current_id][5];
	var slides = projectsArray[current_id][6];
	var permalink = projectsArray[current_id][7];
	var external_link = projectsArray[current_id][8]; // It never exists at this moment but it's reserved space for it
	var categories_array = projectsArray[current_id][9];
	var project_id = projectsArray[current_id][10];
	
	// Count number of projects
	var number_of_ids = projectsArray.length;

	// Fade out current project data
	jQuery('.portfolio_box').removeClass('portfolio_box-visible');

	jQuery('body').addClass('daisho-portfolio-viewing-project');

	setTimeout(function(){
		jQuery('.project-slides').html(slides);
		
		if(date == ''){ jQuery('.project-date').hide(); }else{ jQuery('.project-date').show(); }
		if(client == ''){ jQuery('.project-client').hide(); }else{ jQuery('.project-client').show(); }
		if(agency == ''){ jQuery('.project-agency').hide(); }else{ jQuery('.project-agency').show(); }
		if(ourrole == ''){ jQuery('.project-ourrole').hide(); }else{ jQuery('.project-ourrole').show(); }
		
		// Show menu, navigation, containers etc.
		jQuery('.portfolio_box').addClass('portfolio_box-visible');
		jQuery('.project-coverslide').addClass('project-coverslide-visible');
		
		// Add current project data
		jQuery('.project-title').html(title);
		jQuery('.project-description').html(desc);
		jQuery('.project-exdate').html(date);
		jQuery('.project-exclient').html(client);
		jQuery('.project-exagency').html(agency);
		jQuery('.project-exourrole').html(ourrole);
		
		setupProject();

		// Update document title, URL and brwosing history using HTML5 History API
		if(!window.history.state || (window.history.state.projid != current_id)){
			window.history.pushState({'cancelback': true, 'projid': current_id}, title, permalink);
			initialURL = false;
		}
		jQuery('title').html(title);
		
		// Setup sharing icons (desktop mode)
		if(jQuery(".sharing-icons").length){
			jQuery(".sharing-icons-twitter").attr("href", "https://twitter.com/share?url=" + encodeURIComponent(window.location.href) + "&amp;text=" + encodeURIComponent(title));
			jQuery(".sharing-icons-facebook").attr("href", "http://www.facebook.com/sharer.php?u=" + encodeURIComponent(window.location.href) + "&amp;t=" + encodeURIComponent(title));
			jQuery(".sharing-icons-googleplus").attr("href", "https://plus.google.com/share?url=" + encodeURIComponent(window.location.href));
		}

		recreateControls();
	}, 200); // We wait for CSS3 fade out animation to opacity=0 of .portfolio_box (inner container of portfolio) to complete
}

/**
 * Recreates project controls based on currently viewed project and other settings
 */
function recreateControls(){
	// Unbind and show current controls
	jQuery('.portfolio-arrowright').unbind('click.nextproject');
	jQuery('.portfolio-arrowleft').unbind('click.prevproject');
	jQuery('.portfolio-arrowleft').addClass('portfolio-arrowleft-visible');
	jQuery('.portfolio-arrowright').addClass('portfolio-arrowright-visible');

	// Currently selected category ID (alternatively "all" or undefined)
	var selected_category_id = jQuery('.pf_nav').find('li a.selected').attr('data-project-category-id');
	
	// Count number of projects
	var project_ids = projectsArray.length;
	
	// Stop if there's only one project available
	if(project_ids < 2){
		jQuery('.portfolio-arrowleft').removeClass('portfolio-arrowleft-visible');
		jQuery('.portfolio-arrowright').removeClass('portfolio-arrowright-visible');
		return;
	}
	
	// Current project, next and previous IDs
	var project_id_current = global_current_id;
	var project_id_previous = ((project_id_current - 1) < 0) ? (project_ids - 1) : (project_id_current - 1);
	var project_id_next = ((project_id_current + 1) >= project_ids) ? 0 : (project_id_current + 1);

	// Disable boundary arrows mode
	// @uses boundary_arrows (bool) global variable
	if(boundary_arrows){
		if((project_id_current - 1) < 0){
			jQuery('.portfolio-arrowleft').removeClass('portfolio-arrowleft-visible');
		}
		if((project_id_current + 1) >= project_ids){
			jQuery('.portfolio-arrowright').removeClass('portfolio-arrowright-visible');
		}
	}

	// Browse in selected category mode
	// @uses loop_through (bool) global variable
	if(loop_through){
		var prevProjects = []; // Previous projects from selected category
		var nextProjects = []; // Next projects from selected category
		var prev_project_arrow = []; // (int|array) - ID of the previous arrow, empty array otherwise
		var next_project_arrow = []; // (int|array) - ID of the next arrow, empty array otherwise
		
		if(selected_category_id == 'all' || selected_category_id === undefined){
			prev_project_arrow[0] = project_id_previous;
			next_project_arrow[0] = project_id_next;
		}else{
			for(var i = 0; i < (projectsArray.length - (projectsArray.length - project_id_current)); i++){
				if(projectsArray[i][9].indexOf(selected_category_id) != -1){
					prevProjects[prevProjects.length] = i; // All previous projects from selected category
				}
			}
			for(var i = (project_id_current + 1); i < projectsArray.length; i++){
				if(projectsArray[i][9].indexOf(selected_category_id) != -1){
					nextProjects[nextProjects.length] = i; // All next projects from selected category
				}
			}
			
			var prev_project_arrow = prevProjects.slice(-1); // One previous project from selected category
			var next_project_arrow = nextProjects.slice(0, 1); // One next project from selected category

			if(prevProjects.length != 0){
				jQuery('.portfolio-arrowleft').attr('href', projectsArray[prev_project_arrow[0]][7]);
			}else{
				jQuery('.portfolio-arrowleft').removeClass('portfolio-arrowleft-visible');
			}
			if(nextProjects.length != 0){
				jQuery('.portfolio-arrowright').attr('href', projectsArray[next_project_arrow[0]][7]);
			}else{
				jQuery('.portfolio-arrowright').removeClass('portfolio-arrowright-visible');
			}
		}
		
		var project_id_previous = prev_project_arrow[0];
		var project_id_next = next_project_arrow[0];
	}
	
	if(projectsArray[project_id_previous] !== undefined){
		jQuery('.portfolio-arrowleft').attr('href', projectsArray[project_id_previous][7]);
	}
	if(projectsArray[project_id_next] !== undefined){
		jQuery('.portfolio-arrowright').attr('href', projectsArray[project_id_next][7]);
	}
	
	// Left Arrow
	jQuery('.portfolio-arrowleft').on('click.prevproject', function(e){
		if(!jQuery('body').hasClass('page-refresh')){
			e.preventDefault();
			bringPortfolio( project_id_previous );
		}
		return;
	});
	
	// Right Arrow
	jQuery('.portfolio-arrowright').on('click.nextproject', function(e){
		if(!jQuery('body').hasClass('page-refresh')){
			e.preventDefault();
			bringPortfolio( project_id_next );
		}
		return;
	});
}

function closePortfolioItem(){
	global_current_id = false;
	jQuery('body').removeClass('portfolio-is-loading');
	jQuery('.portfolio-loadingbar').removeClass('portfolio-loadingbar-visible');
	jQuery('.portfolio_box').removeClass('portfolio_box-visible');
	jQuery('body').removeClass('daisho-portfolio-viewing-project');
	jQuery('.project-coverslide').removeClass('project-coverslide-visible');
	
	jQuery('.portfolio-arrowright').removeClass('portfolio-arrowright-visible');
	jQuery('.portfolio-arrowleft').removeClass('portfolio-arrowleft-visible');
	
	jQuery('.project-slides').empty();
	jQuery('title').html(portfolio_page_title);

	if(location.href != portfolio_page_url){
		window.history.pushState({}, portfolio_page_title, portfolio_page_url);
		initialURL = false;
	}
}

jQuery(document).ready(function(){

	// close bringPortfolio()
	jQuery('.portfolio-cancelclose').on('click', function(e){

		if(jQuery(this).hasClass('back-link-external') || jQuery('body').hasClass('single-portfolio')){
			return;
		}

		e.preventDefault();
		
		jQuery('.portfolio_box').removeClass('portfolio_box-visible');
		jQuery('body').removeClass('konzept-portfolio-viewing-project');
		jQuery('.project-coverslide').removeClass('project-coverslide-visible');
		
		myScroll.destroy();
		closePortfolioItem();
	});
});

window.onpopstate = function(ev){
	var evstate = (ev.state) ? ev.state : {};

	// Ignore initial onpopstate on Chrome and Safari
	if(location.href == initialURL){
		popped = true;
		initialURL = false;
		return;
	}
	initialURL = false;

	if(!evstate.cancelback){
		if(jQuery('body').hasClass('single-portfolio')){
			location.href = jQuery('.back').attr('href');
		}else{
			closePortfolioItem();
		}
	}else{
		if(ev.state.projid || ev.state.projid == 0){
			bringPortfolio(ev.state.projid);
		}
	}
}

jQuery(document).ready(function(){
    
    var $container = jQuery('#container');
	
	if(jQuery('body').hasClass('single-portfolio')){
		recreateControls();
	}

	// change size of clicked element
	$container.on('click', '.element', function(){
		
		// Exclude external link thumbnails
		if(jQuery(this).find('.thumbnail-link').length != 0){
			return;
		}
		
		// Don't run JavaScript if user wants to open projects with page refresh
		if(jQuery('body').hasClass('page-refresh')){
			return;
		}
		
		var current_id = parseInt( jQuery(this).attr('data-id'), 10 );
		bringPortfolio(current_id);
	});
	
	// Prevent thumbnail links from working unless they are external links.
	$container.on('click', '.thumbnail-project-link', function(e){
		// Don't run JavaScript if user wants to open projects with page refresh
		if(jQuery('body').hasClass('page-refresh')){
			return;
		}
		e.preventDefault();
	});

	// toggle variable sizes of all elements
	jQuery('#toggle-sizes').find('a').click(function(){
		if(jQuery(this).hasClass('toggle-selected')){
			return false;
		}
		jQuery('#toggle-sizes').find('a').removeClass('toggle-selected');
		jQuery(this).addClass('toggle-selected');
		$container.toggleClass('variable-sizes').isotope('reLayout');
		centerIsotopeImages();
		return false;
	});
	
	// Shuffle button
	jQuery('#shuffle a').click(function(){
		$container.isotope('shuffle');
		return false;
	});
});

/**
 * Centers images inside Isotope's thumbnails.
 */
function centerIsotopeImages(){
	jQuery('.project-img').addClass('project-img-visible');
	return;
}
jQuery(window).load(function(){
	centerIsotopeImages();
});

jQuery(document).ready(function(){
	jQuery(".project-img").one("load",function(){
		jQuery(this).addClass('project-img-visible');
	});
});

function destroyProject(){
	// Destroy if exists
	if(typeof myScroll.destroy === 'function'){
		myScroll.destroy();
	}
}
jQuery(document).ready(function(){
	if(jQuery('body').hasClass('single-portfolio')){
		setupProject();
	}
});

function setupProject(){
	/* ----------------------------------------------------------- */
	/* ------------------ START KONZEPT SCRIPTS ------------------ */
	/* ----------------------------------------------------------- */
	var loadingindicatorval = false;
	var loadingindicatorstart = 0;
	function setloadingindicatorstart(){
		loadingindicatorstart = (new Date()).getTime();
		jQuery(".project-arrow-right, .project-arrow-left").addClass('project-arrow-loading');
		jQuery('body').addClass('portfolio-is-loading');
	}
	function updateLoadingIndicator(){
		var timedel = (((new Date()).getTime())-loadingindicatorstart)/1000;
		if(timedel > 20){
			timedel = 20;
		}else if(timedel < 0){
			timedel = 0;
		}
		var loadproc = (timedel/24)*100;
		jQuery(".portfolio-indicator").text((Math.round(loadproc*10)/10)+"%");
		lockControls();
	}

	jQuery(".portfolio-loadingbar").stop(true).addClass('portfolio-loadingbar-visible').css({'left': jQuery(window).width()});
	jQuery(".portfolio-loadingbar").animate({'left': 0.8*jQuery(window).width()}, 400, function(){
		jQuery(".portfolio-loadingbar").animate({'left': 200}, 25000);
	});

	setloadingindicatorstart();
	loadingindicatorval = setInterval(function(){
		updateLoadingIndicator();
	}, 100);
	
	function removeLoadingIndicator(){
		if(loadingindicatorval){
			clearInterval(loadingindicatorval);
		}
		jQuery('.portfolio-loadingbar').stop().animate({ 'left': -200 }, 400, function(){
			jQuery('.portfolio-loadingbar').removeClass('portfolio-loadingbar-visible');
		});
		jQuery('.project-slide-cover-empty').remove();
		unlockControls();
		setTimeout(function(){
			jQuery('.project-slide').removeClass('project-slide-invisible');
		}, 250);
		jQuery(".project-arrow-right, .project-arrow-left").removeClass('project-arrow-loading');
		jQuery('body').removeClass('portfolio-is-loading');
	}
	
	function lockControls(){
		if(typeof myScroll.disable === 'function'){
			myScroll.disable();
		}
		projectIsLoading = true;
		if(jQuery('.project-slide-cover').hasClass('project-slide-cover-empty')){
			jQuery('.project-slide').addClass('project-slide-invisible');
		}
	}
	function unlockControls(){
		if(typeof myScroll.enable === 'function'){
			myScroll.enable();
			myScroll.refresh();
			jQuery(window).trigger('resize');
		}
		projectIsLoading = false;
	}
	
	// Imitate project loaded
	var allImages = jQuery(".project-slide-image .myimage").length;
	if(allImages == 0){
		removeLoadingIndicator();
	}else{
		var counter = 0;
		jQuery(".project-slide-image").each(function(){
			var slide = jQuery(this);
			var image = jQuery(this).find('.myimage');
			var image_dom = jQuery(this).find('.myimage').get(0);
			jQuery('<img />').attr('src', image.attr('src')).load(function(){
				counter++;
				if(counter >= allImages){
					setTimeout(function(){
						removeLoadingIndicator();
					}, 500);
				}
			});
		});
		setTimeout(function(){
			removeLoadingIndicator();
		}, 20000);
	}
	
	// Destroy if exists
	if(typeof myScroll.destroy === 'function'){
		myScroll.destroy();
	}
	
	// Set dimensions
	var windowHeight = jQuery(window).height();
	var windowWidth = jQuery(window).width();
	var windowHeight = jQuery('.flow_slideshow_box').height();
	var windowWidth = jQuery('.flow_slideshow_box').width();
	jQuery(".project-slide").css({ 'width' : windowWidth });
	jQuery('#project-slides').css({ 'width' : (jQuery('.project-slide').length * windowWidth) });
	var totalWidth = jQuery('.project-slide').length * windowWidth;
	jQuery('#thelist').css({ 'width' : 2*totalWidth, 'height' : windowHeight });

	/**
	 * Handles resizing and centering of images in various modes.
	 * Supports: center (default), fullscreen, fit screen and a few others.
	 */
	function positionImages(){
		jQuery(".project-slide-image").each(function(){
			var slide = jQuery(this);
			var image = jQuery(this).find('.myimage');
			var image_dom = jQuery(this).find('.myimage').get(0);
			jQuery('<img />').attr('src', image.attr('src')).load(function(){
				image.attr('data-real-width', jQuery(this).get(0).width);
				image.attr('data-real-height', jQuery(this).get(0).height);
				var realWidth = image.attr('data-real-width');
				var realHeight = image.attr('data-real-height');
				var currentWidth = image.width();
				var currentHeight = image.height();
				var windowWidth = jQuery(window).width();
				var windowWidth = jQuery('.flow_slideshow_box').width();
				var windowHeight = jQuery(window).height();
				var windowHeight = jQuery('.flow_slideshow_box').height();
				var screen_ratio = windowWidth / windowHeight;
				var image_ratio = realWidth / realHeight;
				
				// If .raw class is present, don't do anything else
				if(slide.hasClass('raw')){
					return;
				}
				
				// Only center if no classes are used
				slide.css({ 'height' : windowHeight });
				slide.css({ 'width' : windowWidth });
				image.css({'width' : 'auto', 'max-width' : '100%', 'height' : 'auto', 'max-height' : '100%', 'top' : 0, 'left' : 0});
				if(currentHeight < windowHeight){
					var top = ((windowHeight-currentHeight)/2);
					image.css({'top' : top, 'left' : 0});
				}
				
				// Fullscreen
				if(slide.hasClass('fullscreen')){
					if(image_ratio < screen_ratio){ // vertical like 1:3 < 4:3
						image.css({'width' : '100%', 'max-width' : 'none', 'height' : 'auto', 'max-height' : 'none'});
						var currentHeight = image.height();
						if(currentHeight > windowHeight){
							var top = -((currentHeight - windowHeight)/2);
							image.css({'top' : top, 'left' : 0});
						}
					}else{ // horizontal
						image.css({'width' : 'auto', 'max-width' : 'none', 'height' : '100%', 'max-height' : 'none'});
						var currentWidth = image.width();
						if(currentWidth > windowWidth){
							var left = -((currentWidth - windowWidth)/2);
							image.css({'top' : 0, 'left' : left});
						}
					}
				}
				
				// Fit
				if(slide.hasClass('fit')){
					// Calculate slide width (image width vs window width - whatever is smaller)
					slide.css({ 'width' : realWidth });
					if(realWidth > windowWidth){
						slide.css({ 'width' : windowWidth });
					}
					
					// Image 100% wide or 100% tall?
					slide.css({ 'height' : windowHeight });
					if(image_ratio < screen_ratio){ // vertical like 1:3 < 4:3
						image.css({'width' : 'auto', 'max-width' : 'none', 'height' : 'auto', 'max-height' : '100%'});
						var currentHeight = image.height();
						var top = ((windowHeight - currentHeight)/2);
						image.css({'top' : top, 'left' : 0});
					}else{ // horizontal
						image.css({'width' : 'auto', 'max-width' : '100%', 'height' : 'auto', 'max-height' : 'none'});
						var currentHeight = image.height();
						var top = ((windowHeight-currentHeight)/2);
						image.css({'top' : top, 'left' : 0});
						if(currentHeight > windowHeight){
							image.css({'width' : 'auto', 'max-width' : '100%', 'height' : 'auto', 'max-height' : '100%', 'top' : 0, 'left' : 0});
						}	
					}
					var currentWidth = image.width();
					slide.css({ 'width' : currentWidth });
				}
				
				// Fullscreen + fit
				if(slide.hasClass('fit') && slide.hasClass('fullscreen')){
					slide.css({ 'width' : windowWidth });
				}
				
				// Fit + scale up allowed
				if(slide.hasClass('fit-scale-up-allowed')){
					if(image_ratio < screen_ratio){ // vertical like 1:3 < 4:3
						image.css({'width' : 'auto', 'max-width' : 'none', 'height' : '100%', 'max-height' : 'none', 'top' : 0, 'left' : 0});
					}else{ // horizontal
						image.css({'width' : '100%', 'max-width' : 'none', 'height' : 'auto', 'max-height' : 'none', 'top' : 0, 'left' : 0});
						var currentHeight = image.height();
						var top = ((windowHeight-currentHeight)/2);
						image.css({'top' : top});
					}
					var currentWidth = image.width();
					slide.css({ 'width' : currentWidth });
				}
				
				// Fullscreen + fit + scale up allowed
				if(slide.hasClass('fullscreen') && slide.hasClass('fit-scale-up-allowed')){
					slide.css({ 'width' : windowWidth });
					if(image_ratio < screen_ratio){ // vertical like 1:3 < 4:3
						image.css({'width' : 'auto', 'max-width' : 'none', 'height' : '100%', 'max-height' : 'none', 'top' : 0, 'left' : 0});
					}else{ // horizontal
						image.css({'width' : '100%', 'max-width' : 'none', 'height' : 'auto', 'max-height' : 'none', 'top' : 0, 'left' : 0});
						var currentHeight = image.height();
						var top = ((windowHeight-currentHeight)/2);
						image.css({'top' : top});
					}
				}
				
				if(typeof myScroll.refresh === 'function'){
					myScroll.refresh();
				}
			});
			//}).trigger('load');
		});
	}
	positionImages();
	
	/**
	 * Setups YouTube and Vimeo videos.
	 * This function prevents slideshow from working temporarily and enables "watching video" mode.
	 */
	/* function setupVideos(){
		jQuery('.project-slide-youtube, .project-slide-vimeo').each(function(){
			var slide = jQuery(this);
			var playButton = slide.find('.video-play');
			var videoContainer = slide.find('.video-wrapper');
			var videoCode = videoContainer.attr('data-video');
			var videoCodePoster = videoContainer.attr('data-video-poster');
			var video = jQuery('<iframe type="text/html" frameborder="0" allowFullScreen></iframe>').attr('src', videoCode);
			var description = slide.find('.description');
			var exit = videoContainer.find('.exit');
			var mainExit = slide.closest('.flow_slideshow_box').find('.portfolio-cancelclose');
			
			// Fullscreen Poster Image before video
			if(videoCodePoster){
				var poster = jQuery('<img class="" />').attr('src', videoCodePoster).load(function(){
					var poster_img = this;
					centerVideoPoster(poster_img);
					jQuery(window).resize(function(){
						centerVideoPoster(poster_img);
					});
				});
				videoContainer.append(poster);
			}
			
			playButton.on('click', function(){
				if(moved){
					return;
				}
				// Project arrows
				if(jQuery('.project-arrow-left').hasClass('project-arrow-left-visible')){
					var projectLeftHadClass = true;
					jQuery('.project-arrow-left').removeClass('project-arrow-left-visible');
				}else{
					var projectLeftHadClass = false;
				}
				if(jQuery('.project-arrow-right').hasClass('project-arrow-right-visible')){
					var projectRightHadClass = true;
					jQuery('.project-arrow-right').removeClass('project-arrow-right-visible');
				}else{
					var projectRightHadClass = false;
				}
				
				// Portfolio arrows
				if(jQuery('.portfolio-arrowleft').hasClass('hide-arrow')){
					var portfolioLeftHadClass = true;
				}else{
					var portfolioLeftHadClass = false;
					jQuery('.portfolio-arrowleft').addClass('hide-arrow');
				}
				if(jQuery('.portfolio-arrowright').hasClass('hide-arrow')){
					var portfolioRightHadClass = true;
				}else{
					var portfolioRightHadClass = false;
					jQuery('.portfolio-arrowright').addClass('hide-arrow');
				}
				myScroll.disable();
				videoContainer.append(video);
				playButton.hide();
				description.hide();
				slide.addClass('watching-video');
				mainExit.hide();
				if(videoCodePoster){
					poster.hide();
				}
				
				// Disable Mousewheel
				jQuery('.flow_slideshow_init').off('mousewheel.dg');
				
				// Disable Keyboard
				jQuery(window).off('keydown.dg');
				
				exit.addClass('exit-visible');
				
				exit.on('click', function(){
					// Project arrows
					if(projectLeftHadClass){
						jQuery('.project-arrow-left').addClass('project-arrow-left-visible');
					}
					if(projectRightHadClass){
						jQuery('.project-arrow-right').addClass('project-arrow-right-visible');
					}
					
					// Portfolio arrows
					if(!portfolioLeftHadClass){
						jQuery('.portfolio-arrowleft').removeClass('hide-arrow');
					}
					if(!portfolioRightHadClass){
						jQuery('.portfolio-arrowright').removeClass('hide-arrow');
					}
					
					// Enable Mousewheel
					jQuery('.flow_slideshow_init').on('mousewheel.dg', function(event, delta){
						var dir = delta > 0 ? FSPrevSlide() : FSNextSlide();
						event.preventDefault();
					});
					
					// Enable Keyboard
					jQuery(window).on('keydown.dg', function(e){
						if(e.keyCode == 37 || e.keyCode == 38){
							FSPrevSlide();
						}else if(e.keyCode == 39 || e.keyCode == 40){
							FSNextSlide();
						}
					});
					
					playButton.show();
					video.remove();
					description.show();
					slide.removeClass('watching-video');
					mainExit.show();
					if(videoCodePoster){
						poster.show();
					}
					exit.removeClass('exit-visible');
					exit.unbind('click');
					myScroll.enable();
				});
			});
		});
	} */
	function setupVideos(){
		jQuery('.project-slide-youtube, .project-slide-vimeo').each(function(){
			var slide = jQuery(this);
			var playButton = slide.find('.video-play');
			var videoContainer = slide.find('.video-wrapper');
			var videoCode = videoContainer.attr('data-video');
			var videoCodePoster = videoContainer.attr('data-video-poster');
			var video = jQuery('<iframe type="text/html" frameborder="0" allowFullScreen></iframe>').attr('src', videoCode);
			var exit = jQuery('<div class="exit"></div>');
			
			// Fullscreen Poster Image before video
			if(videoCodePoster){
				var poster = jQuery('<img class="" />').attr('src', videoCodePoster).load(function(){
					var poster_img = this;
					centerVideoPoster(poster_img);
					jQuery(window).resize(function(){
						centerVideoPoster(poster_img);
					});
				});
				videoContainer.append(poster);
			}
			
			playButton.on('click', function(){
				if(moved){
					return;
				}
				// Project arrows
				if(jQuery('.project-arrow-left').hasClass('project-arrow-left-visible')){
					var projectLeftHadClass = true;
					jQuery('.project-arrow-left').removeClass('project-arrow-left-visible');
				}else{
					var projectLeftHadClass = false;
				}
				if(jQuery('.project-arrow-right').hasClass('project-arrow-right-visible')){
					var projectRightHadClass = true;
					jQuery('.project-arrow-right').removeClass('project-arrow-right-visible');
				}else{
					var projectRightHadClass = false;
				}
				
				// Portfolio arrows
				if(jQuery('.portfolio-arrowleft').hasClass('hide-arrow')){
					var portfolioLeftHadClass = true;
				}else{
					var portfolioLeftHadClass = false;
					jQuery('.portfolio-arrowleft').addClass('hide-arrow');
				}
				if(jQuery('.portfolio-arrowright').hasClass('hide-arrow')){
					var portfolioRightHadClass = true;
				}else{
					var portfolioRightHadClass = false;
					jQuery('.portfolio-arrowright').addClass('hide-arrow');
				}
				myScroll.disable();
				var videoContainerOutside = jQuery('<div class="portfolio-video-container"></div>').append(video).append(exit);
				jQuery('body').append(videoContainerOutside);
				
				// Disable Mousewheel
				jQuery('.flow_slideshow_init').off('mousewheel.dg');
				
				// Disable Keyboard
				jQuery(window).off('keydown.dg');
				
				exit.on('click', function(){
					// Project arrows
					if(projectLeftHadClass){
						jQuery('.project-arrow-left').addClass('project-arrow-left-visible');
					}
					if(projectRightHadClass){
						jQuery('.project-arrow-right').addClass('project-arrow-right-visible');
					}
					
					// Portfolio arrows
					if(!portfolioLeftHadClass){
						jQuery('.portfolio-arrowleft').removeClass('hide-arrow');
					}
					if(!portfolioRightHadClass){
						jQuery('.portfolio-arrowright').removeClass('hide-arrow');
					}
					
					// Enable Mousewheel
					jQuery('.flow_slideshow_init').on('mousewheel.dg', function(event, delta){
						if(_flowScrolling){
							return;
						}
						var dir = delta > 0 ? FSPrevSlide() : FSNextSlide();
						event.preventDefault();
					});
					
					// Enable Keyboard
					jQuery(window).on('keydown.dg', function(e){
						if(e.keyCode == 37 || e.keyCode == 38){
							FSPrevSlide();
						}else if(e.keyCode == 39 || e.keyCode == 40){
							FSNextSlide();
						}
					});
					
					video.remove();
					exit.removeClass('exit-visible');
					exit.unbind('click');
					myScroll.enable();
					videoContainerOutside.remove();
				});
			});
		});
	}
	setupVideos();
	
	/**
	 * Centers an image.
	 */
	function centerVideoPoster(img){
		var image = jQuery(img);
		jQuery('<img />').attr('src', image.attr('src')).load(function(){
			image.attr('data-real-width', jQuery(this).get(0).width);
			image.attr('data-real-height', jQuery(this).get(0).height);
			var realWidth = image.attr('data-real-width');
			var realHeight = image.attr('data-real-height');
			var currentWidth = image.width();
			var currentHeight = image.height();
			var screen_ratio = windowWidth / windowHeight;
			var image_ratio = realWidth / realHeight;
			
			if(image_ratio < screen_ratio){ // vertical like 1:3 < 4:3
				image.css({'width' : '100%', 'max-width' : 'none', 'height' : 'auto', 'max-height' : 'none'});
				var currentHeight = image.height();
				if(currentHeight > windowHeight){
					var top = -((currentHeight - windowHeight)/2);
					image.css({'top' : top, 'left' : 0});
				}
			}else{ // horizontal
				image.css({'width' : 'auto', 'max-width' : 'none', 'height' : '100%', 'max-height' : 'none'});
				var currentWidth = image.width();
				if(currentWidth > windowWidth){
					var left = -((currentWidth - windowWidth)/2);
					image.css({'top' : 0, 'left' : left});
				}
			}
		});
	}
	
	/**
	 * Setups <video> tag for slides.
	 * This function prevents slideshow from working temporarily and enables "watching video" mode.
	 */
	function setupHTMLVideos(){
		jQuery('.project-slide-video').each(function(){
			var slide = jQuery(this);
			var playButton = slide.find('.video-play');
			var videoContainer = slide.find('.video-wrapper');
			var description = slide.find('.description');
			var exit = videoContainer.find('.exit');
			var mainExit = slide.closest('.flow_slideshow_box').find('.portfolio-cancelclose');
			
			var videoCodeMp4 = videoContainer.attr('data-video-mp4');
			var videoCodeOgg = videoContainer.attr('data-video-ogg');
			var videoCodeWebm = videoContainer.attr('data-video-webm');
			var videoCodePoster = videoContainer.attr('data-video-poster');
			var videoMp4 = jQuery('<source type="video/mp4"></source>').attr('src', videoCodeMp4);
			var videoOgg = jQuery('<source type="video/ogg; codecs=&quot;theora, vorbis&quot;"></source>').attr('src', videoCodeOgg);
			var videoWebm = jQuery('<source type="video/webm; codecs=&quot;vp8, vorbis&quot;"></source>').attr('src', videoCodeWebm);
			var video = jQuery('<video type="text/html" controls="" preload="auto">').attr('poster', videoCodePoster).append(videoMp4).append(videoOgg).append(videoWebm);
				
			// Fullscreen Poster Image before video
			if(videoCodePoster){
				var poster = jQuery('<img class="" />').attr('src', videoCodePoster).load(function(){
					var poster_img = this;
					centerVideoPoster(poster_img);
					jQuery(window).resize(function(){
						centerVideoPoster(poster_img);
					});
				});
				videoContainer.append(poster);
			}
			
			playButton.on('click', function(){
			
				if(moved){
					return;
				}
				
				// Project arrows
				if(jQuery('.project-arrow-left').hasClass('project-arrow-left-visible')){
					var projectLeftHadClass = true;
					jQuery('.project-arrow-left').removeClass('project-arrow-left-visible');
				}else{
					var projectLeftHadClass = false;
				}
				if(jQuery('.project-arrow-right').hasClass('project-arrow-right-visible')){
					var projectRightHadClass = true;
					jQuery('.project-arrow-right').removeClass('project-arrow-right-visible');
				}else{
					var projectRightHadClass = false;
				}
				
				// Portfolio arrows
				if(jQuery('.portfolio-arrowleft').hasClass('hide-arrow')){
					var portfolioLeftHadClass = true;
				}else{
					var portfolioLeftHadClass = false;
					jQuery('.portfolio-arrowleft').addClass('hide-arrow');
				}
				if(jQuery('.portfolio-arrowright').hasClass('hide-arrow')){
					var portfolioRightHadClass = true;
				}else{
					var portfolioRightHadClass = false;
					jQuery('.portfolio-arrowright').addClass('hide-arrow');
				}
				
				myScroll.disable();
				videoContainer.append(video);
				video.get(0).play();
				slide.addClass('watching-video');
				playButton.hide();
				description.hide();
				if(videoCodePoster){
					poster.hide();
				}
				mainExit.hide();
				exit.addClass('exit-visible');
				
				// Disable Mousewheel
				jQuery('.flow_slideshow_init').off('mousewheel.dg');
				
				// Disable Keyboard
				jQuery(window).off('keydown.dg');
				
				exit.on('click', closeVideoOnEnd);
				video.on('ended', closeVideoOnEnd);
				
				function closeVideoOnEnd(){
					// Project arrows
					if(projectLeftHadClass){
						jQuery('.project-arrow-left').addClass('project-arrow-left-visible');
					}
					if(projectRightHadClass){
						jQuery('.project-arrow-right').addClass('project-arrow-right-visible');
					}
					
					// Portfolio arrows
					if(!portfolioLeftHadClass){
						jQuery('.portfolio-arrowleft').removeClass('hide-arrow');
					}
					if(!portfolioRightHadClass){
						jQuery('.portfolio-arrowright').removeClass('hide-arrow');
					}
					
					// Enable Mousewheel
					jQuery('.flow_slideshow_init').on('mousewheel.dg', function(event, delta){
						if(_flowScrolling){
							return;
						}
						var dir = delta > 0 ? FSPrevSlide() : FSNextSlide();
						event.preventDefault();
					});
					
					// Enable Keyboard
					jQuery(window).on('keydown.dg', function(e){
						if(e.keyCode == 37 || e.keyCode == 38){
							FSPrevSlide();
						}else if(e.keyCode == 39 || e.keyCode == 40){
							FSNextSlide();
						}
					});
					
					slide.removeClass('watching-video');
					myScroll.enable();
					playButton.show();
					video.remove();
					video = jQuery('<video type="text/html" controls="" preload="auto">').attr('poster', videoCodePoster).append(videoMp4).append(videoOgg).append(videoWebm);
					description.show();
					if(videoCodePoster){
						poster.show();
					}
					mainExit.show();
					exit.removeClass('exit-visible');
					exit.unbind('click');
				}
			});
		});
	}
	setupHTMLVideos();
	
	/**
	 * Makes the content of custom slide centered.
	 * It is suitable only when video doesn't have controls and has to look nice rather than be very functional.
	 */
	function setupCustomSlides(){
		jQuery('.project-slide-custom').each(function(){
			var slide = jQuery(this);
			var content = slide.children('.custom-wrapper');
			var contentHeight = slide.children('.custom-wrapper').height();

			// If .raw class is present, don't do anything
			if(slide.hasClass('raw')){
				return;
			}
			
			if(contentHeight < windowHeight){
				content.css('margin-top', ((windowHeight - contentHeight)/2));
			}
		});
	}
	setupCustomSlides();
	
	/**
	 * Setup iScroll 4
	 * @return {void} Updates myScroll variable 
	 */
	jQuery(jQuery('.project-slide')[0]).addClass('project-slide-current');
	var slideshowDOMElement = jQuery('.flow_slideshow_init').get(0);
	myScroll = new iScroll(slideshowDOMElement, {
		snap: 'div.project-slide',
		bounce: false,
		bounceLock: false,
		momentum: false,
		hScrollbar: false,
		vScrollbar: false,
		hScroll: true,
		vScroll: false,
		wheelAction: 'none',
		//wheelAction: 'scroll',
		onBeforeScrollStart: function (e) {
			e.preventDefault();
			if(e.target.nodeName == 'INPUT'){
				e.target.focus();
			}
			// TODO: Refresh myScroll.pagesX before scrolling happens to consider .fit slides.
			//console.log(myScroll.pagesX);
			//postSetup();
		},
		onTouchEnd: function(){
			jQuery('.project-slide').removeClass('project-slide-current');
			var scroller = this.scroller;
			var snap = this.options.snap;
			jQuery(scroller).children(snap + ':eq(' + this.currPageX + ')').addClass('project-slide-current');
		},
		onBeforeScrollEnd: function(){
			
		},
		onScrollStart: function(){
		},
		onScrollMove: function(){
			moved = true;
		},
		onScrollEnd: function(){
			_flowScrolling = false;
			if(!jQuery('.project-slide-current').hasClass('watching-video')){
				hideArrows();
			}
			moved = false;
			if(jQuery('.project-slide-cover-empty').length || !(jQuery('.project-slide-cover').length)){
				if(jQuery('.project-slide-current').hasClass('cursor-white')){
					jQuery('.portfolio-arrowleft').addClass('portfolio-arrowleft-white');
				}else{
					jQuery('.portfolio-arrowleft').removeClass('portfolio-arrowleft-white');
				}
			}
			
			jQuery('.project-slide').removeClass('project-slide-current');
			var scroller = this.scroller;
			var snap = this.options.snap;
			jQuery(scroller).children(snap + ':eq(' + this.currPageX + ')').addClass('project-slide-current');
			
			jQuery('.flow_slideshow_box').removeClass('white black');
			jQuery('.portfolio-arrowright').removeClass('portfolio-arrowright-white');
			if(jQuery('.project-slide-current').hasClass('cursor-white')){
				jQuery('.flow_slideshow_box').addClass('white');
				jQuery('.portfolio-arrowright').addClass('portfolio-arrowright-white');
			}else if(jQuery('.project-slide:last-child').hasClass('project-slide-current') && jQuery('.project-slide:last-child').hasClass('cursor-white')){
				jQuery('.portfolio-arrowright').addClass('portfolio-arrowright-white');
			}else{
				jQuery('.flow_slideshow_box').addClass('black');
			}
		},
		onRefresh: function(){
			if(jQuery('.project-slide-cover-empty').length || !(jQuery('.project-slide-cover').length)){
				if(jQuery('.project-slide-current').hasClass('cursor-white')){
					jQuery('.portfolio-arrowleft').addClass('portfolio-arrowleft-white');
				}else{
					jQuery('.portfolio-arrowleft').removeClass('portfolio-arrowleft-white');
				}
			}
			jQuery('.flow_slideshow_box').removeClass('white black');
			jQuery('.portfolio-arrowright').removeClass('portfolio-arrowright-white');
			if(jQuery('.project-slide-current').hasClass('cursor-white')){
				jQuery('.flow_slideshow_box').addClass('white');
				jQuery('.portfolio-arrowright').addClass('portfolio-arrowright-white');
			}else if(jQuery('.project-slide:last-child').hasClass('project-slide-current') && jQuery('.project-slide:last-child').hasClass('cursor-white')){
				jQuery('.portfolio-arrowright').addClass('portfolio-arrowright-white');
			}else{
				jQuery('.flow_slideshow_box').addClass('black');
			}
		},
		onDestroy: function(){ },
	});
	number_of_slides = myScroll.pagesX.length;
	
	function postSetup(){
		// Set new max scroll X offset
		myScroll.maxScrollX = myScroll.pagesX[myScroll.pagesX.length-1];
		
		// Post-refresh fixes to consider "fit screen" mode etc.
		jQuery('.project-slide-image.fit, .project-slide-image.fit-scale-up-allowed').each(function(index, element){
			var slide = jQuery(this);
			var slidesLength = myScroll.pagesX.length;
			var liPosition = jQuery(".project-slide").index(slide); // 0-based
			var nextSlide = liPosition + 1;
			
			if(slide.hasClass('fit-align-left') || slide.hasClass('fullscreen')){ // do not center fit screen slides
			
			}else if(nextSlide >= slidesLength){ // last slide has .fit
				var dlugosc_slajda = jQuery(".project-slide:last-child").width();
				var offset = myScroll.pagesX[slidesLength-1] + ((windowWidth - dlugosc_slajda)/2); // center last .fit slide
				if(slide.hasClass('fit-align-right')){ // or last .fit slide has .fit-align-right
					var offset = -(totalWidth - dlugosc_slajda - (windowWidth - dlugosc_slajda));
					myScroll.maxScrollX = offset; // stop entire slideshow to be scrollable further than that
				}
				myScroll.pagesX[slidesLength-1] = offset;
			}else if(liPosition == 0){ // first slide has .fit
				
			}else{
				var dlugosc_slajda = Math.abs(myScroll.pagesX[nextSlide]) - Math.abs(myScroll.pagesX[liPosition]);
				var offset = Math.floor(Math.abs(myScroll.pagesX[liPosition]) - ((windowWidth - dlugosc_slajda)/2)); // scroll to the next and subtract half of remaining space (windowW-slideW) to make it centered
				//console.log('Math.floor(Math.abs(myScroll.pagesX[liPosition])', Math.floor(Math.abs(myScroll.pagesX[liPosition])));
				//console.log('((windowWidth - dlugosc_slajda)/2))', ((windowWidth - dlugosc_slajda)/2));
				if(nextSlide >= slidesLength){ // last slide has .fit
				}else{
					//console.log('offset', offset);
					myScroll.pagesX[liPosition] = -offset;
				}
			}
		});
	}
	
	setTimeout(function(){
		//postSetup();
		jQuery(window).trigger('resize');
	}, 1000);
	
	// Window resizing adjustments
	function resizeSlideshow(){
		//var windowWidth = jQuery(window).width();
		//var windowHeight = jQuery(window).height();
		windowWidth = jQuery('.flow_slideshow_box').width();
		windowHeight = jQuery('.flow_slideshow_box').height();
		var projectSlide = jQuery(".project-slide");
		
		projectSlide.css({ 'width' : windowWidth });
		
		positionImages();
		setupCustomSlides();
		
		// This setTimeout is present only because iScroll 4 added setTimeout for its refresh() method and this adjustment is supposed to run after refresh().
		setTimeout(function(){
			// This is used in myScroll.maxScrollX
			totalWidth = 0;
			jQuery('.project-slide').each(function(){
				totalWidth += jQuery(this).width();
			});
			jQuery('#thelist').css({ 'width' : 2*totalWidth, height: windowHeight });
			jQuery('#project-slides').css({ 'width' : totalWidth, height: windowHeight });

			// Refresh!
			myScroll.refresh();

			postSetup();

			// Make sure to center the slideshow in the correct place after resize
			myScroll.scrollTo(myScroll.pagesX[myScroll.currPageX], 0, 0);
		}, 10);
	}
	jQuery(window).bind("resize.resizeSlideshow", function(){
		resizeSlideshow();
	});
	
	// Restore standard arrows if hidden
	jQuery('.project-arrow-left').removeClass('hide-arrow');
	jQuery('.project-arrow-right').removeClass('hide-arrow');
				
	// Controls
	function hideArrows(){
		if(myScroll.currPageX == 0){
			// Arrows between projects
			jQuery('.portfolio-arrowleft').addClass('portfolio-arrowleft-cover');
			jQuery('.portfolio-arrowright').addClass('portfolio-arrowright-cover');
			
			// Arrows between slides
			jQuery('.project-arrow-left').addClass('project-arrow-left-cover');
			jQuery('.project-arrow-right').addClass('project-arrow-right-cover');
			
			jQuery('.sharing-icons').addClass('sharing-icons-cover');
			jQuery('.portfolio-cancelclose').addClass('portfolio-cancelclose-cover');
		}else{
			// Arrows between projects
			jQuery('.portfolio-arrowleft').removeClass('portfolio-arrowleft-cover');
			jQuery('.portfolio-arrowright').removeClass('portfolio-arrowright-cover');
			
			// Arrows between slides
			jQuery('.project-arrow-left').removeClass('project-arrow-left-cover');
			jQuery('.project-arrow-right').removeClass('project-arrow-right-cover');
			
			jQuery('.sharing-icons').removeClass('sharing-icons-cover');
			jQuery('.portfolio-cancelclose').removeClass('portfolio-cancelclose-cover');
		}
		if(myScroll.currPageX == (myScroll.pagesX.length - 1)){
			jQuery('.project-arrow-right').addClass('project-arrow-right-last');
		}else{
			jQuery('.project-arrow-right').removeClass('project-arrow-right-last');
		}
		
		if(myScroll.currPageX == (myScroll.pagesX.length - 1)){
			jQuery('.project-arrow-right').removeClass('project-arrow-right-visible');
			jQuery('.portfolio-arrowright').removeClass('hide-arrow');
		}else{
			jQuery('.project-arrow-right').addClass('project-arrow-right-visible');
			jQuery('.portfolio-arrowright').addClass('hide-arrow');
		}
		if(myScroll.currPageX == 0){
			jQuery('.project-arrow-left').removeClass('project-arrow-left-visible');
			jQuery('.portfolio-arrowleft').removeClass('hide-arrow');
		}else{
			jQuery('.project-arrow-left').addClass('project-arrow-left-visible');
			jQuery('.portfolio-arrowleft').addClass('hide-arrow');
		}
	}
	hideArrows();
	function FSNextSlide(){
		_flowScrolling = true;
		if(projectIsLoading){
			return;
		}
		if(myScroll.currPageX == (myScroll.pagesX.length - 1)){
			jQuery('.portfolio-arrowright').trigger('click');
			return;
		}
		myScroll.scrollToPage(myScroll.currPageX + 1, 0, 250);
		hideArrows();
	}
	function FSPrevSlide(){
		_flowScrolling = true;
		if(projectIsLoading){
			return;
		}
		if(myScroll.currPageX == 0){
			jQuery('.portfolio-arrowleft').trigger('click');
			return;
		}
		myScroll.scrollToPage(myScroll.currPageX - 1, 0, 250);
		hideArrows();
	}
	jQuery('.project-arrow-right').off('click.nextpage');
	jQuery('.project-arrow-right').on('click.nextpage', function(){
		FSNextSlide();
	});
	jQuery('.project-arrow-left').off('click.prevpage');
	jQuery('.project-arrow-left').on('click.prevpage', function(){
		FSPrevSlide();
	});
	
	// Mousewheel
	jQuery('.flow_slideshow_init').off('mousewheel.dg');
	jQuery('.flow_slideshow_init').on('mousewheel.dg', function(event, delta){
		if(_flowScrolling){
			return;
		}
		var dir = delta > 0 ? FSPrevSlide() : FSNextSlide();
		event.preventDefault();
	});
	
	// Keyboard
	jQuery(window).off('keydown.dg');
	jQuery(window).on('keydown.dg', function(e){
		if(e.keyCode == 37 || e.keyCode == 38){
			FSPrevSlide();
		}else if(e.keyCode == 39 || e.keyCode == 40){
			FSNextSlide();
		}
	});
	
	/* --------------------------------------------------------- */
	/* ------------------ END KONZEPT SCRIPTS ------------------ */
	/* --------------------------------------------------------- */
}

jQuery(document).ready(function(){
	thumbnail_mouse_over();
	
	//thumbnail_mouse_over_mobile();
	jQuery(window).on('resize', function(){
		//thumbnail_mouse_over_mobile();
	});
});
function thumbnail_mouse_over_mobile(){
	if(!jQuery('.max-width-test').length){
		var maxWidthTest = jQuery('<div class="max-width-test"></div>');
		jQuery('body').append(maxWidthTest);
	}
	if(parseInt(jQuery('.max-width-test').css('max-width'), 10) <= 720){
		var thumbnail = jQuery('.element');
		thumbnail.off('mouseenter.konzept');
		thumbnail.off('mouseleave.konzept');
		thumbnail.find('.thumbnail-meta-data-wrapper').stop().css({ 'left' : '', 'top' : '' });
		thumbnail.find('.thumbnail-plus').stop().css({ 'left' : '', 'bottom' : '' });
	}else{
		thumbnail_mouse_over();
	}
}
function thumbnail_mouse_over(){
	var thumbnail = jQuery('.element');
	//thumbnail.off('mouseenter.konzept');
	//thumbnail.off('mouseleave.konzept');
	thumbnail.on('mouseenter.konzept', function(e){
		// Mouse enter
		var offset = jQuery(this).offset();
		var mindeltaside = 4;
		var mindeltacth = Math.abs(e.pageX - offset.left);
		if(Math.abs(offset.left+jQuery(this).width() - e.pageX) < mindeltacth){
			mindeltaside = 2;
			mindeltacth = Math.abs(offset.left+jQuery(this).width() - e.pageX);
		}
		if(Math.abs(e.pageY - offset.top) < mindeltacth){
			mindeltaside = 1;
			mindeltacth = Math.abs(e.pageY - offset.top);
		}
		if(Math.abs(offset.top+jQuery(this).height() - e.pageY) < mindeltacth){
			mindeltaside = 3;
		}
		
		if(mindeltaside == 1){ // from top
			jQuery(this).find('.thumbnail-meta-data-wrapper').stop().css({"left" : 0, "top": ~jQuery(this).height() }).animate({"top" : 0 }, 350);
			jQuery(this).find('.thumbnail-plus').stop().css({ 'left' : 0, "bottom": jQuery(this).height() }).animate({"bottom" : 0 }, 350);
		}else if(mindeltaside == 2){ // from right
			jQuery(this).find('.thumbnail-meta-data-wrapper').stop().css({ 'left' : jQuery(this).width(), 'top' : 0 }).animate({ 'left' : 0 }, 350);
			jQuery(this).find('.thumbnail-plus').stop().css({ 'left' : jQuery(this).width(), 'bottom' : 0 }).animate({ 'left' : 0 }, 350);
		}else if(mindeltaside == 3){ // from bottom
			jQuery(this).find('.thumbnail-meta-data-wrapper').stop().css({"left" : 0, "top": jQuery(this).height() }).animate({"top" : 0 }, 350);
			jQuery(this).find('.thumbnail-plus').stop().css({ 'left' : 0,  "bottom": ~jQuery(this).height() }).animate({"bottom" : 0 }, 350);
		}else if(mindeltaside == 4){ // from left
			jQuery(this).find('.thumbnail-meta-data-wrapper').stop().css({ 'left' : ~jQuery(this).width(), 'top' : 0 }).animate({ 'left' : 0 }, 350);
			jQuery(this).find('.thumbnail-plus').stop().css({ 'left' : ~jQuery(this).width(), 'bottom' : 0 }).animate({ 'left' : 0 }, 350);
		}
	});
	thumbnail.on('mouseleave.konzept', function(e){
		// Mouse leave
		var offset = jQuery(this).offset();
		var mindeltaside = 4;
		var mindeltacth = Math.abs(e.pageX - offset.left);
		if(Math.abs(offset.left+jQuery(this).width() - e.pageX) < mindeltacth){
			mindeltaside = 2;
			mindeltacth = Math.abs(offset.left+jQuery(this).width() - e.pageX);
		}
		if(Math.abs(e.pageY - offset.top) < mindeltacth){
			mindeltaside = 1;
			mindeltacth = Math.abs(e.pageY - offset.top);
		}
		if(Math.abs(offset.top+jQuery(this).height() - e.pageY) < mindeltacth){
			mindeltaside = 3;
		}
		if(mindeltaside == 1){
			jQuery(this).find('.thumbnail-meta-data-wrapper').stop().animate({"top" : jQuery(this).height() }, { queue: false, duration: 250 });
			jQuery(this).find('.thumbnail-plus').stop().animate({ 'bottom' : ~jQuery(this).height() }, { queue: false, duration: 250 });
		}else if(mindeltaside == 2){
			jQuery(this).find('.thumbnail-meta-data-wrapper').stop().animate({ 'left' : ~jQuery(this).width() }, { queue: false, duration: 250 });
			jQuery(this).find('.thumbnail-plus').stop().animate({ 'left' : ~jQuery(this).width() }, { queue: false, duration: 250 });
		}else if(mindeltaside == 3){
			jQuery(this).find('.thumbnail-meta-data-wrapper').stop().animate({"top" : ~jQuery(this).height() }, 250);
			jQuery(this).find('.thumbnail-plus').stop().animate({ 'bottom' : jQuery(this).height() }, 250);
		}else if(mindeltaside == 4){
			jQuery(this).find('.thumbnail-meta-data-wrapper').stop().animate({ 'left' : jQuery(this).width() }, { queue: false, duration: 250 });
			jQuery(this).find('.thumbnail-plus').stop().animate({ 'left' : jQuery(this).width() }, { queue: false, duration: 250 });
		}
	});
}
