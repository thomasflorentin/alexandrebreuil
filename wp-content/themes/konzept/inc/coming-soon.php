<?php 
function flow_dribbble_carousel($atts, $content = null) {
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
add_shortcode( 'dribbble_carousel', 'flow_dribbble_carousel' );

function flow_coming_soon_scripts() {
	wp_enqueue_script( 'jquery-mousewheel', get_template_directory_uri() . '/js/jquery.mousewheel.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'flow-coming-soon-script', get_template_directory_uri() . '/js/coming-soon.js', array( 'jquery' ), false, true );
	wp_enqueue_style( 'flow-coming-soon-style', get_template_directory_uri() . '/css/coming-soon.css' );
}
add_action( 'wp_enqueue_scripts', 'flow_coming_soon_scripts' );
