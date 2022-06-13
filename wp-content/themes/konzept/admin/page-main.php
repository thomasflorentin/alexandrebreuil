<?php 
function konzept_theme_options_render_page() {

    //must check that the user has the required capability 
    if( ! current_user_can('manage_options') ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.', 'konzept' ) );
    }

    // variables for the field and option names 
	$hidden_field_name = 'mt_submit_hidden';
	
    $opt_name = 'flow_logo';
    $data_field_name = 'flow_logo';
	$opt_name3 = 'footer_col_countcustom';
    $data_field_name3 = 'footer_col_countcustom';
	$opt_name13 = 'flow_portfolio_page';
    $data_field_name13 = 'flow_portfolio_page';
	
	$opt_name21 = 'flow_featured_slideshow';
    $data_field_name21 = 'flow_featured_slideshow';
	$opt_name23 = 'flow_slide_class';
    $data_field_name23 = 'flow_slide_class';
	$opt_name24 = 'flow_slide_class_default';
    $data_field_name24 = 'flow_slide_class_default';
	
    // Read in existing option value from database
    $opt_val = get_option( $opt_name );
	$opt_val3 = get_option( $opt_name3 );
	$opt_val13 = get_option( $opt_name13 );
	
	$opt_val21 = get_option( $opt_name21 );
	$opt_val23 = get_option( $opt_name23 );
	$opt_val24 = get_option( $opt_name24 );
	
    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset( $_POST[ $hidden_field_name ] ) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
		$opt_val = $_POST[ $data_field_name ];
        $opt_val3 = $_POST[ $data_field_name3 ];
        $opt_val13 = $_POST[ $data_field_name13 ];
		
        $opt_val21 = $_POST[ $data_field_name21 ];
        $opt_val23 = $_POST[ $data_field_name23 ];
        $opt_val24 = $_POST[ $data_field_name24 ];

        // Save the posted value in the database
        update_option( $opt_name, $opt_val );
        update_option( $opt_name3, $opt_val3 );
        update_option( $opt_name13, $opt_val13 );
		
        update_option( $opt_name21, $opt_val21 );
        update_option( $opt_name23, $opt_val23 );
        update_option( $opt_name24, $opt_val24 );
		?>
		<div class="updated"><p><strong><?php _e( 'Settings Saved', 'konzept' ); ?></strong></p></div>
	<?php } ?>

	<div class="wrap">
		<h2><?php _e('General Settings', 'konzept'); ?></h2>
		<form name="form-main-page" method="post" action="">
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
		
		<table class="form-table flow-admin-table">
			<tr valign="top">
				<th scope="row"><?php _e('Logo', 'konzept'); ?></th>
				<td>
					<div class="flowuploader">
						<input class="flowuploader_media_url" type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" />
						<span class="flowuploader_upload_button button"><?php _e('Upload', 'konzept'); ?></span>
						<div class="flowuploader_media_preview_image"></div>
					</div>
					<p><?php _e('WordPress will display text logo and tagline unless you put a link to image logo here. Allowed formats: PNG, JPG, GIF, ICO, SVG. Recommended size (demo size): around 150x40px. Text logo and tagline can be modified under <b>Settings &rarr; General</b>.', 'konzept'); ?></p>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><?php _e('Featured Slideshow', 'konzept'); ?></th>
				<td>
					<?php 
					$first21 = '';
					$zero21 = '';
					if($opt_val21 == "1"){
						$first21 = 'selected="selected"';
					}else{
						$zero21 = 'selected="selected"';
					}
					?>
					<select name="<?php echo $data_field_name21; ?>">
						<option value="0" <?php echo $zero21; ?>><?php _e('Enable', 'konzept'); ?></option>
						<option value="1" <?php echo $first21; ?>><?php _e('Disable', 'konzept'); ?></option>
					</select>
					<p><?php _e('You can add slides in <b>Slideshow &rarr; Add New</b>. This slideshow support images and HTML5 videos and can be displayed before user sees a homepage. At least two slides are required for it to show up.', 'konzept'); ?></p>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><?php _e('Main Portfolio Page', 'konzept'); ?></th>
				<td><select name="<?php echo $data_field_name13; ?>"><option value=""><?php _e('None', 'konzept'); ?></option><?php 
					$pages = get_pages();
					foreach ($pages as $pagg) {
						print("<option value=\"".$pagg->ID."\"".(($opt_val13==$pagg->ID)?" selected=\"selected\"":"").">".$pagg->post_title."</option>");
					}
				  ?></select><br/>
				<p><?php _e('Your main portfolio page.<br>1. "Back" button of each project will link to this portfolio page if nothing else is specified under <b>Portfolio &rarr; (a project) &rarr; Back Button</b>.<br>2. "View Portfolio" button in "Classic Homepage" will link to this page.<br>3. This must be a page with "Portfolio Template" selected.', 'konzept'); ?></p>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><?php _e('Footer Layout', 'konzept'); ?></th>
				<td>
					<div class="footer-new-row">
						<select>
							<option value="grid_12 last">1 Column (100)</option>
							<option value="grid_6, grid_6 last">2 Columns (50|50)</option>
							<option value="grid_4, grid_8 last">2 Columns (33|66)</option>
							<option value="grid_8, grid_4 last">2 Columns (66|33)</option>
							<option value="grid_4, grid_4, grid_4 last">3 Columns (33|33|33)</option>
							<option value="grid_3, grid_3, grid_6 last">3 Columns (25|25|50)</option>
							<option value="grid_3, grid_6, grid_3 last">3 Columns (25|50|25)</option>
							<option value="grid_6, grid_3, grid_3 last">3 Columns (50|25|25)</option>
							<option value="grid_3, grid_3, grid_3, grid_3 last">4 Columns (25|25|25|25)</option>
						</select>
						<button type="button" class="footer-add-new-row">Add New Row</button>
						<button type="button" class="footer-clear-rows">Clear Rows</button>
					</div>
					<div class="clearfix">
						<textarea class="footer-creator-textarea" rows="6" cols="70" name="<?php echo $data_field_name3; ?>"><?php echo $opt_val3; ?></textarea>
						<div class="footer-creator clearfix">
							<div class="footer-columns clearfix"></div>
						</div>
					</div>
					<p><?php printf(__('A comma-separated list of grid system CSS classes.<br><b>Example:</b> 4 equal columns - <code>grid_3, grid_3, grid_3, grid_3 last</code>.<br><b>Default:</b> <code>grid_12 last grid_responsive_only, grid_6 widget_no_margin, grid_6 widget_no_margin last</code><br>When you create a column, new widget area is created in <b>Appearance &rarr; Widgets</b>. Once you\'re done please <a href="%s" target="_blank">add widgets</a> to footer columns.', 'konzept'), admin_url( 'widgets.php' )); ?></p>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><?php _e('Slide Classes (default)', 'konzept'); ?></th>
				<td>
					<input type="text" name="<?php echo $data_field_name24; ?>" value="<?php echo $opt_val24; ?>" />
					<p><?php _e('Space separated list of default image slide classes. These will be used if a slide does not have any CSS classes specified. If it has any CSS classes specified, these will be ignored altogether.', 'konzept'); ?></p>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row"><?php _e('Slide Classes', 'konzept'); ?></th>
				<td>
					<input type="text" name="<?php echo $data_field_name23; ?>" value="<?php echo $opt_val23; ?>" />
					<p><?php _e('Space separated list of additional image slide classes. They will be added for each image slide and they can not be overwritten.', 'konzept'); ?></p>
					<p>
						<b>Default</b> - your images will be centered and will fit screen.<br>
						<b>fullscreen</b> - slide is 100x100% and image inside takes full space and may be cropped from sides or top and bottom if image ratio and screen ratios don't match.<br>
						<b>fullscreen + fit</b> - slide is 100x100% but the image inside will not be cropped and will not be scaled up so it may leave blank space at the top and bottom or on sides if ratios don't match.<br>
						<b>fullscreen + fit + scale-up-allowed</b> - slide is 100x100% but the image inside will not be cropped and will scale up to fit the most space it possibly can without cropping any part of the image.<br>
						<b>fit</b> - slides adapt to the current image width. Images inside will not be cropped and will not be scaled up.<br>
						<b>fit + scale-up-allowed</b> - slides adapt to the current image width. Images inside will not be cropped and will be scaled up if necessary.<br>
						<b>fit-align-left</b> - fit screen slides can align to the left instead of being centered.<br>
						<b>fit-align-right</b> - works for the last slide only. If you're using "fit" then the last slide will be centered and may leave a bit of blank space to the right. This makes it stick to the right.<br>
						<b>raw</b> - prevent centering, fullscreen and fit screen.<br>
						<b>cursor-white</b> - sets white cursor for this slide. Default is black.<br>
					</p>
				</td>
			</tr>
		</table>
		<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes', 'konzept') ?>" /></p>
	</form>
<?php }
