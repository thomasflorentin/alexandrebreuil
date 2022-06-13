<?php
/**
 * Adds WPML language switcher. You can hide it with CSS or in a
 * Child Theme in header.php by removing call to this function.
 *
 * @return void|string Returns language switcher if WPML is installed.
 */
function flow_language_selector_flags(){
	if(!function_exists('icl_get_languages')){
		return;
	}

	$languages = icl_get_languages('skip_missing=0&orderby=desc');

	if(!empty($languages)){
		$out = '<div class="conatainer_language_selector"><div id="flags_language_selector">';
		$out .= '<div class="current_language">' . ICL_LANGUAGE_NAME . '</div>';
		$out .= '<ul id="lang_ul">';
		foreach($languages as $l){
			$this_active = '';
			if($l['active']){
				$this_active = 'active_lng';
			}

			$out .= '<li class="language-li ' . $this_active . '">';
			if(!$l['active']){
				$out .= '<a href="' . $l['url'] . '">';
			}
			$out .= '<span class="language-name">' . $l['native_name'] . '</span>';
			if(!$l['active']){
				$out .= '</a>';
			}
			$out .= '</li>';
		}
		$out .= '</ul>';
		$out .= '</div></div>';
	}
	return $out;
}

function flow_wpml_language_switcher_scripts() {
	wp_enqueue_style( 'flow-wpml-language-switcher-script', get_template_directory_uri() . '/css/wpml-language-switcher.css' );
}
add_action( 'wp_enqueue_scripts', 'flow_wpml_language_switcher_scripts' );
