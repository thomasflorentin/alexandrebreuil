<?php
/**
 * SuperSlide [slide] shortcode.
 * 
 * It is deprecated since Daisho 1.9.5, WordPress 3.6 and August 2013.
 * It is left here to maintain backwards compatibility. It should be removed
 * sometime in 2014 or 2015.
 *
 * @param array Shortcode attributes.
 * @param string Inner content of the shortcode.
 * @return string Slide output.
 *
 * @todo Remove this shortcode because it's not used.
 */
function flow_superslide_slide_shortcodex($atts, $content = null){
	$class = shortcode_atts( array('text_color' => '#ffffff', 'image' => '', 'image_alt' => '', 'video_vimeo' => '', 'video_youtube' => '', 'video_mp4' => '', 'video_ogg' => '', 'video_webm' => '', 'video_poster' => '', 'slide_desc' => '', 'slide_horizontal' => '', 'slide_fitscreen' => '', 'slide_noresize' => '', 'custom' => ''), $atts );

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
		
		$the_slide = '<div class="project-slide project-slide-image wp-caption">';
			$the_slide .= '<img class="myimage" src="' . $image . '" alt="' . $image_alt . '" />';
			if($slide_desc){
				$the_slide .= '<div class="wp-caption-text superslide-caption-text">' . $slide_desc . '</div>';
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
			$video_poster = 'poster="'.$class['video_poster'].'"'; 
		}else{ 
			$video_poster = ""; 
		}
		
		$the_slide = '<div class="project-slide project-slide-video">';
			$the_slide .= do_shortcode('[video mp4="'.$video_mp4.'" ogg="'.$video_ogg.'" webm="'.$video_webm.'" '.$video_poster.' preload="true"]');
			if($slide_desc){
				$the_slide .= '<div class="wp-caption-text superslide-caption-text">' . $slide_desc . '</div>';
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
		$video_poster = $class['video_poster'];
		
		$the_slide = '<div class="project-slide project-slide-youtube">';
			$the_slide .= '<div class="youtube_container">';
				$the_slide .= '<iframe class="youtube-player" type="text/html" width="1120" height="660" src="https://www.youtube.com/embed/'.$video_youtube.'?wmode=opaque&amp;hd=1&amp;rel=0" frameborder="0"></iframe>';
			$the_slide .= '</div>';
			if($slide_desc){
				$the_slide .= '<div class="wp-caption-text superslide-caption-text">' . $slide_desc . '</div>';
			}
		$the_slide .= '</div>';
		
		return $the_slide;

	/* ------------------------------------*/
	/* -------->>> VIMEO SLIDE <<<---------*/
	/* ------------------------------------*/
	}elseif($class['video_vimeo'] != ''){
		$video_vimeo = $class['video_vimeo'];
		if($class['slide_noresize'] = 'true'){ $video_noresize = 'height="360" width="640"'; }else{ $video_noresize = 'height="100%" width="100%"'; }
		$strText = preg_replace( '/(http|ftp)+(s)?:(\/\/)((\w|\.)+)(\/)?(\S+)?/i', 'link', $video_vimeo );
		if($strText == 'link'){ $array_link_explode = explode('.com/', $video_vimeo); $video_vimeo = $array_link_explode[1]; }
		$video_poster = $class['video_poster'];
		
		$the_slide = '<div class="project-slide project-slide-vimeo">';
			$the_slide .= '<div class="youtube_container">';
				$the_slide .= '<iframe src="https://player.vimeo.com/video/'.$video_vimeo.'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff&amp;hd=1" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
			$the_slide .= '</div>';
			if($slide_desc){
				$the_slide .= '<div class="wp-caption-text superslide-caption-text">' . $slide_desc . '</div>';
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
//add_shortcode( 'slide', 'flow_superslide_slide_shortcode' );

/**
 * Vimeo video.
 * 
 * @param array Shortcode attributes.
 * @param string Inner content of the shortcode.
 * @return string Iframe with a video.
 *
 */
function iframe_vimeo_video_shortcode($atts, $content = null){
	$atts = shortcode_atts( array( 'link' => '' ), $atts);

	$video_vimeo = $atts['link'];
	$strText = preg_replace( '/(http|ftp)+(s)?:(\/\/)((\w|\.)+)(\/)?(\S+)?/i', 'link', $video_vimeo );
	if($strText == 'link'){ $array_link_explode = explode('.com/', $video_vimeo); $video_vimeo = $array_link_explode[1]; }

	return '<div class="youtube_container"><iframe src="https://player.vimeo.com/video/'.$video_vimeo.'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></div>';
}
add_shortcode('vimeo', 'iframe_vimeo_video_shortcode');

/**
 * YouTube video.
 * 
 * @param array Shortcode attributes.
 * @param string Inner content of the shortcode.
 * @return string Iframe with a video.
 *
 */
function iframe_youtube_video_shortcode($atts, $content = null){
	$atts = shortcode_atts( array( 'link' => '' ), $atts);

	$video_youtube = $atts['link'];
	$strText = preg_replace( '/(http|ftp)+(s)?:(\/\/)((\w|\.)+)(\/)?(\S+)?/i', 'link', $video_youtube );
	if($strText == 'link'){ $array_link_explode = explode('v=', $video_youtube); $array_link_explode = explode('&', $array_link_explode[1]); $video_youtube = $array_link_explode[0]; }

	return '<div class="youtube_container"><iframe class="youtube-player" type="text/html" src="https://www.youtube.com/embed/'.$video_youtube.'?wmode=opaque" frameborder="0"></iframe></div>';
}
add_shortcode('youtube', 'iframe_youtube_video_shortcode');

/**
 * The "Coming soon" page shortcode.
 */
function konzept_dribbble_carousel($atts, $content = null) {
	$class = shortcode_atts( array('player' => '', 'title_link' => '', 'access_token' => ''), $atts );

	// Connect to Dribbble and download latest posts
	$player = $class['player'];
	$access_token = $class['access_token'];

	$list = array('popular', 'debuts', 'everyone');

	$data = '';
	if ($player) {
		$data = wp_remote_get("https://api.dribbble.com/v1/users/$player/shots?access_token=$access_token", array('sslverify' => false,));
	}	

	$dribble_shots = '';
	if(is_array($data)){
		$data = json_decode($data['body']);
		foreach($data as $id => $properties){
			if($id == 0){
				$css = 'dg-center';
			}else if($id == 1){
				$css = 'dg-right';
			}else if($id == 2){
				$css = 'dg-outright';
			}else{
				$css = 'dg-outright dg-outright-farther';
			}
			$dribble_shots .= '<div class="dg-block ' . $css . '"><img src="' . $properties->images->normal . '" alt="' . $properties->title . '"><span class="dg-label"><a href="' . $properties->html_url . '" target="_blank">' . $properties->title . '</a></span></div>';
		}
	}

	// Produce output
	$output = '<section class="dg-container">';
		$output .= '<div class="dg-wrapper">';
			$output .= do_shortcode($content);
			$output .= $dribble_shots;
		$output .= '</div>';
		$output .= '<nav>';
			$output .= '<span class="dg-prev"></span>';
			$output .= '<span class="dg-next"></span>';
		$output .= '</nav>';
	$output .= '</section>';

	return $output;
}
add_shortcode( 'dribbble_carousel', 'konzept_dribbble_carousel' );

function konzept_dribbble_carousel_scripts() {
	wp_enqueue_script( 'jquery-mousewheel', get_template_directory_uri() . '/js/jquery.mousewheel.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'flow-coming-soon-script', get_template_directory_uri() . '/js/coming-soon.js', array( 'jquery' ), false, true );
	wp_enqueue_style( 'flow-coming-soon-style', get_template_directory_uri() . '/css/coming-soon.css' );
}
add_action( 'wp_enqueue_scripts', 'konzept_dribbble_carousel_scripts' );

/**
 * Styled Google Maps shortcode. Requires Google Maps API v3.
 *
 * @param array Shortcode attributes.
 * @param string Inner content of the shortcode.
 * @return string Iframe with a video.
 */
function konzept_shortcode_gmap($atts, $content = null) {
	$class = shortcode_atts( array('latitude' => '0', 'longitude' => '0', 'zoom' => '12', 'height' => '365px', 'width' => '100%'), $atts );
	$uniqid = uniqid();
	
	wp_enqueue_script('google-maps', 'http://maps.googleapis.com/maps/api/js?sensor=false', array(), false, true);
	
	return "<script type=\"text/javascript\">
			  jQuery(document).ready(function(){
				gmap_initialize(".$class['latitude'].", ".$class['longitude'].", '".$uniqid."', ".$class['zoom'].");
			  });
			</script>
			<div id=\"map_canvas_".$uniqid."\" class=\"map_canvas\" style=\"height:".$class['height'].";width:".$class['width'].";float:left;\"></div>";
}
add_shortcode('gmap', 'konzept_shortcode_gmap');

function konzept_shortcode_gmap_scripts() {
	wp_enqueue_script( 'flow-gmap-script', get_template_directory_uri() . '/js/jquery.gmap.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'flow-gmap-script-init', get_template_directory_uri() . '/js/gmap.js', array( 'jquery' ), false, true );
	wp_enqueue_style( 'flow-gmap-style', get_template_directory_uri() . '/css/gmap.css' );
}
add_action( 'wp_enqueue_scripts', 'konzept_shortcode_gmap_scripts' );
