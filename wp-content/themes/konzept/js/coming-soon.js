jQuery(document).ready(function(){
	jQuery('.dg-wrapper > *:not(.dg-block)').remove();
	var allImages = jQuery('.dg-container').find('.dg-block').length;
	var currentImage = 1;
	// if(allImages <= 2){
		// For 2 images we can't setup gallery
	// }else{
		function DGdisposeClasses(el){
			var center = jQuery('.dg-wrapper .dg-block:nth-child(' + el + ')');
			center.prevAll('.dg-block').addClass('dg-block dg-outleft dg-outleft-farther');
			center.nextAll('.dg-block').addClass('dg-block dg-outright dg-outright-farther');
			center.prev().removeClass().addClass('dg-block dg-left');
			center.next().removeClass().addClass('dg-block dg-right');
			center.prev().prev().removeClass().addClass('dg-block dg-outleft');
			center.next().next().removeClass().addClass('dg-block dg-outright');
			center.removeClass().addClass('dg-block dg-center');
		}
		function DGforward(){
			if((currentImage+1) <= allImages && (currentImage+1) >= 1){
				currentImage++;
				DGdisposeClasses(currentImage);
			}
		}
		function DGbackward(){
			if((currentImage-1) <= allImages && (currentImage-1) >= 1){
				currentImage--;
				DGdisposeClasses(currentImage);
			}
		}
		
		// Click
		jQuery('.dg-next').on('click', function(){
			DGforward();
		});
		jQuery('.dg-prev').on('click', function(){
			DGbackward();
		});
		
		// Mousewheel
		function DGMousewheel(){
			jQuery('.dg-container').off('mousewheel.dg');
			jQuery('.dg-container').on('mousewheel.dg', function(event, delta){
				var dir = delta > 0 ? DGbackward() : DGforward();
				event.preventDefault();
			});
		}
		DGMousewheel();
		
		// Keyboard
		function DGKeyboard(){
			jQuery(window).off('keydown.dg');
			jQuery(window).on('keydown.dg', function(e){
				if(e.keyCode == 37 || e.keyCode == 38){
					DGbackward();
				}else if(e.keyCode == 39 || e.keyCode == 40){
					DGforward();
				}
			});
		}
		DGKeyboard();
		
		jQuery(window).on('resize', function(){
			if(jQuery(window).width() < 850){
				jQuery('.dg-container').off('mousewheel.dg');
				jQuery(window).off('keydown.dg');
			}else{
				DGMousewheel();
				DGKeyboard();
			}
		});
	// }
});