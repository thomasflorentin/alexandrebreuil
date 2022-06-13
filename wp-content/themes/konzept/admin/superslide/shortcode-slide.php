<?php 
	function custom_slidessc($atts, $content = null){
		$class = shortcode_atts( array('text_color' => '#ffffff', 'image' => '', 'image_alt' => '', 'video_vimeo' => '', 'video_youtube' => '', 'video_mp4' => '', 'video_ogg' => '', 'video_webm' => '', 'video_poster' => '', 'slide_desc' => '', 'slide_horizontal' => '', 'slide_fitscreen' => '', 'slide_noresize' => '', 'custom' => '', 'css_class' => ''), $atts );
		
		if($class['css_class'] == ''){
			$class['css_class'] .= ' ' . get_option('flow_slide_class_default');
		}
		$class['css_class'] .= ' ' . get_option('flow_slide_class');

		/* Slide Description */
		if(($class['slide_desc'] != '') && ($class['slide_desc'] != '<h4></h4>')){ 
			$slide_desc = $class['slide_desc']; 
			//$slide_desc = "data-title=\"".$slide_desc."\"";
		}else{
			$slide_desc = false;
		}
		
		if($content && ($content != '') && ($content != '<h4></h4>')){ 
			$slide_desc = $content; 
			//$slide_desc = "data-title=\"".$slide_desc."\"";
		}else{
			$slide_desc = false;
		}
				
		
		if((isset($class['image_alt'])) && ($class['image_alt'] != '')){
			$image_alt = $class['image_alt'];
		}else{
			$image_alt = '';
		}
		
		/* Slide Text/Cursor Color */
		if($class['text_color'] == '#ffffff'){
			$text_color = 'text_white'; 
		}else{
			$text_color = 'text_black'; 
		}
		
		/* ------------------------------------*/
		/* -------->>> IMAGE SLIDE <<<---------*/
		/* ------------------------------------*/
		if((isset($class['image'])) && ($class['image'] != '')){
			$image = $class['image'];
			if($class['slide_horizontal'] == 'true'){ $horizontal = 'slide_horizontal '; }else{ $horizontal = ''; }
			if($class['slide_horizontal'] == 'true' || $class['slide_fitscreen'] == 'true'){ $slide_fitscreen = 'slide_fitscreen'; }else{ $slide_fitscreen = ''; }
			
			$the_slide = '<div class="project-slide project-slide-image ' . $class['css_class'] .'">';
				$the_slide .= '<img class="myimage" src="'.$image.'" alt="'.$image_alt.'" />';
				if($slide_desc){
					$the_slide .= '<span class="description">' . $slide_desc . '</span>';
				}
			$the_slide .= '</div>';
			
			return $the_slide;

		/* ------------------------------------*/
		/* ----->>> HTML5 VIDEO SLIDE <<<------*/
		/* ------------------------------------*/
		}elseif(($class['video_mp4'] != '' or $class['video_ogg'] != '' or $class['video_webm'] != '')){
			$video_mp4 = $class['video_mp4'];
			$video_ogg = $class['video_ogg'];
			$video_webm = $class['video_webm'];
			
			if($class['video_poster'] != ''){ 
				$video_poster = 'data-video-poster="'.$class['video_poster'].'"'; 
			}else{ 
				$video_poster = ''; 
			}
			
			$the_slide = '<div class="project-slide project-slide-video ' . $class['css_class'] .'">';
				$the_slide .= '<div class="video-wrapper" data-video-mp4="' . $video_mp4 . '" data-video-ogg="' . $video_ogg . '" data-video-webm="' . $video_webm . '" ' . $video_poster . '>';
					$the_slide .= '<div class="video-play"></div>';
					$the_slide .= '<div class="exit"></div>';
				$the_slide .= '</div>';
				if($slide_desc){
					$the_slide .= '<span class="description">' . $slide_desc . '</span>';
				}
			$the_slide .= '</div>';
			
			return $the_slide;
			
		/* ------------------------------------*/
		/* ------->>> YOUTUBE SLIDE <<<--------*/
		/* ------------------------------------*/
		}elseif($class['video_youtube'] != ''){
			$video_youtube = $class['video_youtube'];
			if($class['slide_noresize'] = 'true'){ $video_noresize = 'height="360" width="640"'; }else{ $video_noresize = 'height="100%" width="100%"'; }
			$strText = preg_replace( '/(https|http|ftp)+(s)?:(\/\/)((\w|\.)+)(\/)?(\S+)?/i', 'link', $video_youtube );
			if($strText == 'link'){ $array_link_explode = explode('v=', $video_youtube); $array_link_explode = explode('&', $array_link_explode[1]); $video_youtube =$array_link_explode[0]; }
			
			if($class['video_poster'] != ''){ 
				$video_poster = 'data-video-poster="'.$class['video_poster'].'"'; 
			}else{ 
				$video_poster = ''; 
			}
			
			$the_slide = '<div class="project-slide project-slide-youtube ' . $class['css_class'] .'">';
				$the_slide .= '<div class="video-wrapper" data-video="https://www.youtube.com/embed/' . $video_youtube . '?wmode=opaque&amp;vq=hd1080&amp;autoplay=1&amp;rel=0" ' . $video_poster . '>';
					$the_slide .= '<div class="video-play"></div>';
					$the_slide .= '<div class="exit"></div>';
				$the_slide .= '</div>';
				if($slide_desc){
					$the_slide .= '<span class="description">' . $slide_desc . '</span>';
				}
			$the_slide .= '</div>';
			
			return $the_slide;

		/* ------------------------------------*/
		/* -------->>> VIMEO SLIDE <<<---------*/
		/* ------------------------------------*/
		}elseif($class['video_vimeo'] != ''){
			$video_vimeo = $class['video_vimeo'];
			if($class['slide_noresize'] = 'true'){ $video_noresize = 'height="360" width="640"'; }else{ $video_noresize = 'height="100%" width="100%"'; }
			$strText = preg_replace( '/(https|http|ftp)+(s)?:(\/\/)((\w|\.)+)(\/)?(\S+)?/i', 'link', $video_vimeo );
			if($strText == 'link'){ $array_link_explode = explode('.com/', $video_vimeo); $video_vimeo = $array_link_explode[1]; }
			if($class['video_poster'] != ''){ 
				$video_poster = 'data-video-poster="'.$class['video_poster'].'"'; 
			}else{ 
				$video_poster = ''; 
			}
			
			$the_slide = '<div class="project-slide project-slide-vimeo ' . $class['css_class'] .'">';
				$the_slide .= '<div class="video-wrapper" data-video="https://player.vimeo.com/video/' . $video_vimeo . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff&amp;hd=1&amp;autoplay=1" ' . $video_poster . ' width="800" height="640" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen>';
					$the_slide .= '<div class="video-play"></div>';
					$the_slide .= '<div class="exit"></div>';
				$the_slide .= '</div>';
				if($slide_desc){
					$the_slide .= '<span class="description">' . $slide_desc . '</span>';
				}
			$the_slide .= '</div>';
			
			return $the_slide;

		/* -------------------------------------*/
		/* -------->>> CUSTOM SLIDE <<<---------*/
		/* -------------------------------------*/
		}elseif($class['custom'] != ''){
			return $class['custom'];
		}else{
			return false;
		}
	}
	add_shortcode("slide", "custom_slidessc");
?>