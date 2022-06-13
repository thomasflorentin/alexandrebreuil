<?php
function flow_styling_admin_tabs( $current = 'general' ){ /* Define available tabs */
	//$tabs = array( 'general' => 'General', 'header' => 'Header', 'portfolio' => 'Portfolio' );
	//$tabs = array( 'general' => 'General', 'header' => 'Header' );
	$tabs = array( 'general' => 'General' );
	echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br></div>';
	echo '<h2 class="nav-tab-wrapper">';
	foreach( $tabs as $tab => $name ){
		$class = ( $tab == $current ) ? ' nav-tab-active' : '';
		echo "<a class='nav-tab$class' href='?page=sub-page41&tab=$tab'>$name</a>";
	}
	echo '</h2>';
}

$styling_options = array(
	'group-label-background-styles' => array(
		'group' => 'general',
		'options' => array(
			array(
				'title' => __('Global Background', 'konzept'),
				'type' => 'group-label'
			)
		)
	),
	'body' => array(
		'group' => 'general',
		'options' => array(
			array(
				'title' => __('Background Color', 'konzept'),
				'description' => '',
				'css_property' => 'background-color',
				'type' => 'colorpicker',
				'placeholder' => '#fff'
			),
			array(
				'title' => __('Background Image', 'konzept'),
				'description' => '',
				'css_property' => 'background-image',
				'type' => 'upload',
				'placeholder' => 'none'
			),
			array(
				'title' => __('Background Repeat', 'konzept'),
				'css_property' => 'background-repeat',
				'type' => 'select',
				'options' => array('repeat' => 'Repeat', 'repeat-x' => 'Repeat-x', 'repeat-y' => 'Repeat-y', 'no-repeat' => 'No-repeat')
			),
			array(
				'title' => __('Background Position (vertiacal)', 'konzept'),
				'css_property' => 'background-position-y',
				'type' => 'select',
				'options' => array('top' => 'Top', 'center' => 'Center', 'bottom' => 'Bottom')
			),
			array(
				'title' => __('Background Position (horizontal)', 'konzept'),
				'css_property' => 'background-position-x',
				'type' => 'select',
				'options' => array('left' => 'Left', 'center' => 'Center', 'right' => 'Right')
			),
			array(
				'title' => __('Background Attachment', 'konzept'),
				'css_property' => 'background-attachment',
				'type' => 'select',
				'options' => array('fixed' => 'Fixed', 'scroll' => 'Scroll')
			),
			array(
				'title' => __('Background Size', 'konzept'),
				'css_property' => 'background-size',
				'type' => 'input',
				//'options' => array('fixed' => 'Fixed', 'scroll' => 'Scroll')
			)
		)
	),
);

function flow_styling_generate_fields($styling_options, $this_group, $field_values){
	if(is_array($styling_options) && isset($this_group)){
		$i = 0;
		$all_fields = '';
		foreach($styling_options as $key_main => $value_main){
			if($value_main['group'] == $this_group){
				foreach($value_main['options'] as $key => $value){
					$description = '';
					if(isset($value['description'])){
						$description = '<p>'.$value['description'].'</p>';
					}
					if($value['type'] == 'colorpicker2'){
						$color = '';
						$this_value = '';
						if(isset($field_values[$key_main][$value['css_property']])){
							$color = 'style="background-color:'.$field_values[$key_main][$value['css_property']].';"';
							$this_value = $field_values[$key_main][$value['css_property']];
						}
						$field = '
							<tr>
								<th><span class="flow-styling-title">'.$value['title'].'</span><span class="flow-styling-subtitle">(<b>'.$value['css_property'].'</b> for: '.$key_main.')</span></th>
								<td>
									<input type="text" class="attcolorpicker flow_styling_input" name="flow_styling_'.$i.'" placeholder="'.$value['placeholder'].'" value="'.$this_value.'">
									<div class="colorSelector">
										<div '.$color.'></div>
									</div>
									'.$description.'
								</td>
							</tr>
						';
					}else if($value['type'] == 'colorpicker'){
						$color = '';
						$this_value = '';
						if(isset($field_values[$key_main][$value['css_property']])){
							$color = 'style="background-color:'.$field_values[$key_main][$value['css_property']].';"';
							$this_value = $field_values[$key_main][$value['css_property']];
						}
						$field = '
							<tr>
								<th><span class="flow-styling-title">'.$value['title'].'</span><span class="flow-styling-subtitle">(<b>'.$value['css_property'].'</b> for: '.$key_main.')</span></th>
								<td>
									<input class="flow_styling_input_color" type="text" name="flow_styling_'.$i.'" placeholder="'.$value['placeholder'].'" value="'.$this_value.'" />
									'.$description.'
								</td>
							</tr>
						';
					}else if($value['type'] == 'upload2'){
						$this_value = '';
						if(isset($field_values[$key_main][$value['css_property']])){
							$this_value = $field_values[$key_main][$value['css_property']];
						}
						$field = '
							<tr>
								<th><span class="flow-styling-title">'.$value['title'].'</span><span class="flow-styling-subtitle">(<b>'.$value['css_property'].'</b> for: '.$key_main.')</span></th>
								<td>
									<input class="flow_styling_input" name="flow_styling_'.$i.'" type="text" placeholder="'.$value['placeholder'].'" value="'.$this_value.'">
									<span href="#" title="" class="briskuploader button">'.__('Upload', 'konzept').'</span><br/><div class="briskuploader_preview"></div>
									'.$description.'
								</td>
							</tr>
						';
					}else if($value['type'] == 'upload'){
						$this_value = '';
						if(isset($field_values[$key_main][$value['css_property']])){
							$this_value = $field_values[$key_main][$value['css_property']];
						}
						$field = '
							<tr>
								<th><span class="flow-styling-title">'.$value['title'].'</span><span class="flow-styling-subtitle">(<b>'.$value['css_property'].'</b> for: '.$key_main.')</span></th>
								<td>
									<div class="flowuploader">
										<input class="flowuploader_media_url flow_styling_input" type="text" name="flow_styling_'.$i.'" type="text" placeholder="'.$value['placeholder'].'" value="'.$this_value.'" />
										<span class="flowuploader_upload_button button">' . __('Upload', 'konzept') . '</span>
										<div class="flowuploader_media_preview_image"></div>
									</div>
									'.$description.'
								</td>
							</tr>
						';
					}else if($value['type'] == 'select'){
						if(is_array($value['options'])){
							$this_value = '';
							if(isset($field_values[$key_main][$value['css_property']])){
								$this_value = $field_values[$key_main][$value['css_property']];
							}
							$field = '
								<tr>
									<th><span class="flow-styling-title">'.$value['title'].'</span><span class="flow-styling-subtitle">(<b>'.$value['css_property'].'</b> for: '.$key_main.')</span></th>
									<td>
										<select class="flow_styling_input" name="flow_styling_'.$i.'">';
											if(empty($this_value)){
												$field .= '<option value="disabled" selected="selected">(none)</option>';
											}else{
												$field .= '<option value="disabled">Disable</option>';
											}
											foreach($value['options'] as $key_inner => $value_inner){
												if($key_inner == $this_value){
													$field .= '<option value="'.$key_inner.'" selected="selected">'.$value_inner.'</option>';
												}else{
													$field .= '<option value="'.$key_inner.'">'.$value_inner.'</option>';
												}
											}
										$field .= '</select>
										'.$description.'
									</td>
								</tr>
							';
						}
					}else if($value['type'] == 'slider'){
						if(is_array($value['options'])){
							$this_value = '';
							if(isset($field_values[$key_main][$value['css_property']])){
								$this_value = $field_values[$key_main][$value['css_property']];
							}
							unset($number, $unit, $input_number, $input_unit, $min, $max);
							$number = $unit = $input_number = $input_unit = $min = $max = '';
							$max = $value['options']['max'] ? $value['options']['max'] : '100'; //superglobal
							$min = $value['options']['min'] ? $value['options']['min'] : '1'; //superglobal
							$unit = $value['options']['unit'] ? $value['options']['unit'] : 'px'; //superglobal
							if($this_value){
								$arr = preg_split('/(?<=[0-9])(?=[a-z%]+)/i', $field_values[$key_main][$value['css_property']]);
								$number = $arr[0];
								$unit = $arr[1];
							}
							if(!isset($unit) || empty($unit)){
								$unit = 'px'; //superglobal
							}
							$input_number = $number;
							$input_unit = $unit;
							if(!isset($number) || empty($number)){
								$number = $min-1; //superglobal
								$input_number = ''; //superglobal
								$input_unit = '';
							}
							if($number > $max){
								$max = $number;
							}
							if($number < ($min-1)){
								$min = $number;
							}
							$field = '
								<tr>
									<th><span class="flow-styling-title">'.$value['title'].'</span><span class="flow-styling-subtitle">(<b>'.$value['css_property'].'</b> for: '.$key_main.')</span></th>
									<td>
										<script>
											jQuery(document).ready(function() {
												var unit_'.$i.' = "'.$unit.'";
												jQuery( "#flow_styling_slider-range-min_'.$i.'" ).slider({
													range: "min",
													value: '.$number.',
													min: '.($min-1).',
													max: '.$max.',
													slide: function( event, ui ) {
														var min = jQuery(this).slider( "option", "min" );
														if(min == ui.value){
															jQuery( "#flow_styling_amount_'.$i.'" ).val("");
														}else{
															jQuery( "#flow_styling_amount_'.$i.'" ).val( ui.value + unit_'.$i.' );
														}
													}
												});
												//jQuery( "#flow_styling_amount_'.$i.'" ).val( jQuery( "#flow_styling_slider-range-min_'.$i.'" ).slider( "value" ) + unit_'.$i.' );
											});
										</script>
										<input type="text" id="flow_styling_amount_'.$i.'" class="flow_styling_input" name="flow_styling_'.$i.'" placeholder="'.$value['placeholder'].'" value="'.$input_number.$input_unit.'">
										<div id="flow_styling_slider-range-min_'.$i.'"></div>
										'.$description.'
									</td>
								</tr>
							';
						}
					}else if($value['type'] == 'group-label'){
						$field = '
							<tr>
								<th colspan="2" class="flow-styling-section-header"><h2>'.$value['title'].'</h2></th>
							</tr>
						';
					}else{
						$this_value = '';
						if(isset($field_values[$key_main][$value['css_property']])){
							$this_value = $field_values[$key_main][$value['css_property']];
						}
						if(!isset($value['placeholder'])){
							$value['placeholder'] = '';
						}
						$field = '
							<tr>
								<th><span class="flow-styling-title">'.$value['title'].'</span><span class="flow-styling-subtitle">(<b>'.$value['css_property'].'</b> for: '.$key_main.')</span></th>
								<td>
									<input class="flow_styling_input" name="flow_styling_'.$i.'" type="text" placeholder="'.$value['placeholder'].'" value="'.$this_value.'">
									'.$description.'
								</td>
							</tr>
						';
					}
					$all_fields .= $field;
					$i++;
				}
			}
		}
		return $all_fields;
	}
	return;
}
function flow_styling_field_names($styling_options, $this_group, $settings){
	if(is_array($styling_options) && isset($this_group) && is_array($settings)){
		$i = 0;
		foreach($styling_options as $key_main => $value_main){
			if(is_array($value_main) && ($value_main['group'] == $this_group && $value['options']['type'] != 'group-label')){
				foreach($value_main['options'] as $key => $value){
					if($_POST['flow_styling_'.$i] == '' || ($value['type'] == 'select' && $_POST['flow_styling_'.$i] == 'disabled')){
						unset($settings[$key_main][$value['css_property']]);
						if(empty($settings[$key_main])){
							unset($settings[$key_main]);
						}
					}else{
						if(!current_user_can('unfiltered_html')){
							$settings[$key_main][$value['css_property']] = stripslashes( esc_textarea( wp_filter_post_kses( $_POST['flow_styling_'.$i] ) ) );
						}else{
							$settings[$key_main][$value['css_property']] = $_POST['flow_styling_'.$i];
						}
					}
					$i++;
				}
			}
		}
		return $settings;
	}
	return;
}
function flow_save_styling_settings(){
	global $pagenow;
	global $styling_options;
	$settings = get_option("flow_styling");
	if(!is_array($settings)){ $settings = array(); }
	
	if($pagenow == 'admin.php' && $_GET['page'] == 'sub-page41'){
		if(isset($_GET['tab'])){
			$tab = $_GET['tab'];
		}else{
			$tab = 'general';
		}

		switch($tab){
			case 'header':
				$settings = flow_styling_field_names($styling_options, $tab, $settings);
			break;
			case 'portfolio':
				$settings = flow_styling_field_names($styling_options, $tab, $settings);
			break;
			case 'footer':
			
			break;
			case 'general':
				$settings = flow_styling_field_names($styling_options, $tab, $settings);
			break;
			case 'skins':
				
			break;
			case 'info':
				
			break;
		}
	}

	$updated = update_option( "flow_styling", $settings );
	return $updated;
	//return $settings;
}
function flow_styling_menu(){
    if(!current_user_can('manage_options')){
		wp_die(__('You do not have sufficient permissions to access this page.', 'konzept'));
    }
	
	// variables for the field and option names 
	$hidden_field_name = 'mt_submit_hidden';
	
	$opt_name = 'custom_css_style';
    $data_field_name = 'custom_css_style';
	
    // Read in existing option value from database
    $opt_val = get_option( $opt_name );
	
	if(isset($_POST['flow_styling_nonce_security']) && $_POST['flow_styling_nonce_security'] == "Y"){
		check_admin_referer("flow_styling_nonce_security");
		// Read their posted value
		$opt_val = $_POST[ $data_field_name ];
		
		 // Save the posted value in the database
        update_option( $opt_name, $opt_val );
		
		// Save other styling options
		$settings = flow_save_styling_settings();
		?>
		<div class="updated"><p><strong><?php _e('Settings saved.', 'konzept' ); ?></strong></p></div>
		<?php 
	}
		
	global $pagenow;

	if(isset($_GET['tab'])){
		flow_styling_admin_tabs($_GET['tab']);
	}else{
		flow_styling_admin_tabs('general');
	}
		
	?>
	<form method="post" action="<?php admin_url('admin.php?page=sub-page41'); ?>">
		<?php
		if($pagenow == 'admin.php' && $_GET['page'] == 'sub-page41'){
			if(isset($_GET['tab'])){
				$tab = $_GET['tab'];
			}else{
				$tab = 'general';
			}
			
			$show_update_button = true;
			
			global $styling_options;
			$saved_options = get_option("flow_styling");
			if(!is_array($saved_options)){ $saved_options = array(); }

			echo '<table class="form-table flow-styling-table flow-admin-table">';
			switch($tab){
				case 'header':
					echo flow_styling_generate_fields($styling_options, $tab, $saved_options);
				break;
				case 'portfolio':
					echo flow_styling_generate_fields($styling_options, $tab, $saved_options);
				break;
				case 'footer':
				
				break;
				case 'info': ?>
					<div class="flow-styling-info">
						<p style="font-size: 15px; line-height: 150%;">This is <b>Styling Tool</b>. It will generate simple <abbr title="Cascading Style Sheets">CSS</abbr> styling rules and put them into the <code>&lt;head&gt;</code> section of your website into <code>wp_head();</code>.</p>
						<ul class="flow-styling-info-list">
							<li>It is obviously recommended and more efficient to use "Custom CSS Code" under [Daisho > General] to add custom CSS code...</li>
							<li>... or to put custom CSS directly in style.css and other style files...</li>
							<li>... or even better - use <a href="http://codex.wordpress.org/Child_Themes" target="_blank">Child Themes</a> to do any modifications...</li>
							<li>... but this tool is convenience utility that lists the most common and basic options that you may want to change. It generates only 1 database request, so it's fast and well optimized.</li>
							<li>If something is not on the list then it is probably not a general setting. You should rather consider <a href="http://support.forcg.com/bb-templates/kakumei-flow/help/daisho/index.html#customModifications" target="_blank">Custom Modifications guide</a> for more extensive changes.</li>
						</ul>
						<?php 
							$show_update_button = false;
							if(is_array($saved_options) && !empty($saved_options)){
								echo 'Styling Tool generated the following code based on your settings and will put that into the <code>&lt;head&gt;</code> section of your website:';
								echo '<pre><code>&lt;style type="text/css"&gt;';
								foreach($saved_options as $key => $value){
									$style_output .= "\n";
									$style_output .= $key . ' { ';
									if(array_key_exists('background-position-x', $value) || array_key_exists('background-position-y', $value)){
										$repeat_x = $value['background-position-x'];
										$repeat_y = $value['background-position-y'];
										if($repeat_x == ''){
											$repeat_x = '0';
										}
										if($repeat_y == ''){
											$repeat_y = '0';
										}
										$style_output .= "\n&#09;";
										$style_output .= 'background-position: ' . $repeat_x .' '. $repeat_y . '; ';
									}
									foreach($value as $key_1 => $value_1){
										if($key_1 == 'background-image'){
											$value_1 = 'url("'.$value_1.'")';
										}
										if($key_1 == 'background-position-x' || $key_1 == 'background-position-y'){
											
										}else{
											$style_output .= "\n&#09;";
											$style_output .= $key_1 . ': ' . $value_1 . '; ';
										}
									}
									$style_output .= "\n";
									$style_output .= '}';
									$style_output .= "\n";
								}
								echo $style_output;
								echo '&lt;/style&gt;</code></pre>';
							}
						?>
					</div>
				<?php break;
				case 'general':
					echo flow_styling_generate_fields($styling_options, $tab, $saved_options);
				break;
			}
			echo '</table>';
		}
		?>
		<?php if($show_update_button){ ?>
			<p class="submit" style="clear: both;">
				<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Update Settings'); ?>" />
				<input type="hidden" name="flow_styling_nonce_security" value="Y" />
				<?php wp_nonce_field("flow_styling_nonce_security"); ?>
			</p>
		<?php } ?>
	</form>
</div> <!-- /.wrap -->
<?php
}

	function add_bg_changerstyle(){
		$saved_options = get_option("flow_styling");
		if(is_array($saved_options) && !empty($saved_options)){
			echo '<style type="text/css">';
			foreach($saved_options as $key => $value){
				$style_output .= ' ' . $key . ' { ';
				if(array_key_exists('background-position-x', $value) || array_key_exists('background-position-y', $value)){
					$repeat_x = $value['background-position-x'];
					$repeat_y = $value['background-position-y'];
					if($repeat_x == ''){
						$repeat_x = '0';
					}
					if($repeat_y == ''){
						$repeat_y = '0';
					}
					$style_output .= 'background-position: ' . $repeat_x .' '. $repeat_y . '; ';
				}
				foreach($value as $key_1 => $value_1){
					if($key_1 == 'background-image'){
						$value_1 = 'url("'.$value_1.'")';
					}
					if($key_1 == 'background-position-x' || $key_1 == 'background-position-y'){
						
					}else{
						$style_output .= $key_1 . ': ' . $value_1 . '; ';
					}
				}
				$style_output .= '}';
			}
			echo $style_output;
			echo '</style>';
		}
	}
	add_action( 'wp_head', 'add_bg_changerstyle' );
	
	/*
	 * 1. Prints background CSS for pages.
	 * 2. Prints "Custom CSS Code".
	 */
	function flow_add_custom_css(){
		global $wp_query;
		
		$style_output = $page_image = $page_color = $page_repeat = $page_position = $page_attachment = $page_size = '';
		
		$portfolio_page = get_option('flow_portfolio_page');
		if ( $portfolio_page ) {
			$page_image = get_post_meta($portfolio_page, 'bg_image', true);
			$page_color = get_post_meta($portfolio_page, 'bg_color', true);
			$page_repeat = get_post_meta($portfolio_page, 'bg_repeat', true);
			$page_position = get_post_meta($portfolio_page, 'bg_position', true);
			$page_attachment = get_post_meta($portfolio_page, 'bg_attachment', true);
			$page_size = get_post_meta($portfolio_page, 'bg_size', true);
			if($page_image){ $style_output .= 'background-image: url(\''.$page_image.'\'); '; }
			if($page_color){ $style_output .= 'background-color: '.$page_color.'; '; }
			if($page_repeat){ $style_output .= 'background-repeat: '.$page_repeat.'; '; }
			if($page_position){ $style_output .= 'background-position: '.$page_position.'; '; }
			if($page_attachment){ $style_output .= 'background-attachment: '.$page_attachment.'; '; }
			if($page_size){ $style_output .= 'background-size: '.$page_size.'; '; }
			if(!empty($style_output)){
				print("<style id=\"main-portfolio-css\" type=\"text/css\" data-style=\"body{ ".$style_output." }\"></style>");
			}
			$script = '
			<script>
			jQuery(document).ready(function(){
				jQuery(".pf_nav li a").on("click", function(){
					jQuery("#custom-background-css").text("");
					if(jQuery("#main-portfolio-css").text() == ""){
						jQuery("#main-portfolio-css").text(jQuery("#main-portfolio-css").attr("data-style"));
					}
				});
			});
			</script>
			';
			echo $script;
		}
		
		if ( is_singular() || is_home() ) {
			$id = $wp_query->queried_object_id;
			$page_image = get_post_meta($id, 'bg_image', true);
			$page_color = get_post_meta($id, 'bg_color', true);
			$page_repeat = get_post_meta($id, 'bg_repeat', true);
			$page_position = get_post_meta($id, 'bg_position', true);
			$page_attachment = get_post_meta($id, 'bg_attachment', true);
			$page_size = get_post_meta($id, 'bg_size', true);
			$style_output = '';
			if($page_image){ $style_output .= 'background-image: url("'.$page_image.'"); '; }
			if($page_color){ $style_output .= 'background-color: '.$page_color.'; '; }
			if($page_repeat){ $style_output .= 'background-repeat: '.$page_repeat.'; '; }
			if($page_position){ $style_output .= 'background-position: '.$page_position.'; '; }
			if($page_attachment){ $style_output .= 'background-attachment: '.$page_attachment.'; '; }
			if($page_size){ $style_output .= 'background-size: '.$page_size.'; '; }
			if(!empty($style_output)){ print("<style id=\"custom-background-css\" type=\"text/css\">body{ ".$style_output." }</style>"); }
		}
		
		$custom_css_style = get_option( 'custom_css_style' );
		if($custom_css_style){
			print("<style type=\"text/css\" id=\"custom-css\">".stripslashes($custom_css_style)."</style>");
		}
	}
	add_action( 'wp_head', 'flow_add_custom_css', 11 );
?>