<?php
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
add_shortcode( 'gmap', 'konzept_shortcode_gmap' );

function konzept_shortcode_gmap_scripts() {
	wp_enqueue_script( 'jquery-gmap', get_template_directory_uri() . '/js/jquery.gmap.min.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'konzept-gmap-init', get_template_directory_uri() . '/js/gmap.js', array( 'jquery' ), false, true );
	wp_enqueue_style( 'konzept-gmap', get_template_directory_uri() . '/css/gmap.css' );
}
add_action( 'wp_enqueue_scripts', 'konzept_shortcode_gmap_scripts' );
