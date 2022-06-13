<?php 
/**
Made with the help of a tutorial at WPShout.com => http://wpshout.com.

Courtesy of the konzept theme - themekonzept.com

 * Adds the konzept Settings meta box on the Write Post/Page screeens
 *
 * @package konzept
 * @subpackage Admin
 */

/**
 * Function for adding meta boxes to the admin.
 * Separate the post and page meta boxes.
 *
 * @since 0.3
 */
function konzept_create_meta_box() {
	global $theme_name;

	add_meta_box( 'post-meta-boxes', __('Post Options', 'konzept'), 'post_meta_boxes', 'post', 'normal', 'high' );
	add_meta_box( 'page-meta-boxes', __('Page Options', 'konzept'), 'page_meta_boxes', 'page', 'normal', 'high' );
	add_meta_box( 'portfolio-meta-boxes', __('Project Settings', 'konzept'), 'portfolio_meta_boxes', 'portfolio', 'normal', 'high' );
	add_meta_box( 'slideshow-meta-boxes', __('Slide Options', 'konzept'), 'slideshow_meta_boxes', 'slideshow', 'normal', 'high' );
}

/**
 * Array of variables for post meta boxes.  Make the 
 * function filterable to add options through child themes.
 *
 * @since 0.3
 * @return array $meta_boxes
 */
function konzept_post_meta_boxes() {

	/* Array of the meta box options. */
	$meta_boxes = array(
		'flow_post_description' => array( 'name' => 'flow_post_description', 'title' => __('Description', 'konzept'), 'desc' => __('You can add description to your post using this custom field. It will be displayed below the title. It\'s optional.', 'konzept'), 'type' => 'textarea' ),
		'flow_post_layout' => array( 'name' => 'flow_post_layout', 'title' => __( 'Layout:', 'konzept' ), 'options' => array( 'no-sidebar' => __('No Sidebar', 'konzept'), 'sidebar-left' => __('Left Sidebar', 'konzept'), 'sidebar-right' => __('Right Sidebar', 'konzept') ), 'desc' => __( 'Pick post layout here.', 'konzept' ), 'type' => 'select' )
	);

	return apply_filters( 'konzept_post_meta_boxes', $meta_boxes );
}
function konzept_slideshow_meta_boxes() {

	/* Array of the meta box options. */
	$meta_boxes = array(
	
		/* General */
		'flow_post_title' => array( 'name' => 'flow_post_title', 'title' => __('Title', 'konzept'), 'desc' => 'Slide title (specify if needs to be different than in admin panel).', 'type' => 'text' ),
		'flow_post_description' => array( 'name' => 'flow_post_description', 'title' => __('Description', 'konzept'), 'desc' => __('Slide description.', 'konzept'), 'type' => 'textarea' ),
		
		/* Videos */
		'slide-image' => array( 'name' => 'slide-image', 'title' => __('Image (JPG/PNG):', 'konzept'), 'desc' => __('(Required) Recommended size is HD (like 1920 x 1080 pixels) and no more than 100-200 kB. If you specify video links below, this image will act as video poster.', 'konzept'), 'type' => 'upload' ),
		//'slide-video' => array( 'name' => 'slide-video', 'title' => __('Slide video:', 'konzept'), 'desc' => 'Put <strong>a link or video ID</strong> to YouTube or Vimeo video here.', 'type' => 'text' ),
		'slide-video-mp4' => array( 'name' => 'slide-video-mp4', 'title' => __('Video (MP4):', 'konzept'), 'desc' => '(Optional) Put a link to MP4 format of your video.', 'type' => 'upload' ),
		'slide-video-ogg' => array( 'name' => 'slide-video-ogg', 'title' => __('Video (OGG):', 'konzept'), 'desc' => '(Optional) Put a link to OGG format of your video.', 'type' => 'upload' ),
		'slide-video-webm' => array( 'name' => 'slide-video-webm', 'title' => __('Video (WEBM):', 'konzept'), 'desc' => '(Optional) Put a link to WEBM format of your video.', 'type' => 'upload' ),
		//'slide-video-poster' => array( 'name' => 'slide-video-poster', 'title' => __('Video Poster (JPG/PNG):', 'konzept'), 'desc' => 'Put <strong>a link</strong> to image poster of your video.', 'type' => 'upload' ),
		
		'slide-link-name' => array( 'name' => 'slide-link-name', 'title' => __('Link Name', 'konzept'), 'desc' => 'Each slide can have a link button. Put here a button name if you need it. Suggested default: "+ View Item". Leave blank to disable button on this slide.', 'type' => 'text' ),
		'slide-link' => array( 'name' => 'slide-link', 'title' => __('Link', 'konzept'), 'desc' => 'Your slide button can link to post, page, portfolio project or external location. Put here a link. Example: http://example.com/', 'type' => 'text' ),
		
		/* Button */
		//'slide-button-x-offset' => array( 'name' => 'slide-button-x-offset', 'title' => __('Buttons X axis offset', 'konzept'), 'desc' => 'Specify X offset of your button (starting from the right). Examples: <strong>10px</strong> will move it 10px to the left.', 'type' => 'text' ),		
		//'slide-button-y-offset' => array( 'name' => 'slide-button-y-offset', 'title' => __('Buttons Y axis offset', 'konzept'), 'desc' => __('Specify Y offset of your button (starting from the top). Examples: <strong>10px</strong> will move it 10px to the bottom.', 'konzept'), 'type' => 'text' ),
		//'slide-button-icon' => array( 'name' => 'slide-button-icon', 'title' => __('Buttons icon (optional)', 'konzept'), 'desc' => __('Button icon. You can put here UTF-8 icons - search engines will give you lists and codes of available icons.', 'konzept'), 'type' => 'text' ),
		
		/* Colors */
		//'slide-color' => array( 'name' => 'slide-color', 'title' => __('Slide color', 'konzept'), 'desc' => 'Since button is transparent with white glow it will also affect button\'s color.', 'type' => 'colorpicker' ),
		'slide-title-text-color' => array( 'name' => 'slide-title-text-color', 'title' => __('Title Text Color', 'konzept'), 'desc' => '', 'type' => 'colorpicker' ),
		'slide-description-text-color' => array( 'name' => 'slide-description-text-color', 'title' => __('Description Text Color', 'konzept'), 'desc' => '', 'type' => 'colorpicker' ),
		'slide-button-text-color' => array( 'name' => 'slide-button-text-color', 'title' => __('Link Text Color', 'konzept'), 'desc' => __('Default is #3B95B1.', 'konzept'), 'type' => 'colorpicker' ),
		
		'slide-cursor-color' => array( 'name' => 'slide-cursor-color', 'title' => __('Cursor color', 'konzept'), 'options' => array('white' => __('White', 'konzept'), 'black' => __('Black', 'konzept')), 'desc' => '', 'type' => 'select' ),
		
		/* Image Offset */
		//'slide-image-x-offset' => array( 'name' => 'slide-image-x-offset', 'title' => __('Image\'s X axis offset', 'konzept'), 'desc' => __('Specify left X offset of your slide image (starting from the middle of slide). Examples: <strong>10px</strong> will move it 10px to the right. <strong>-10px</strong> will move it 10px to the left. Technical limitation for this is ((1120px-(width_of_your_image))/2) so like 200-300px.', 'konzept'), 'type' => 'text' ),		
		//'slide-image-y-offset' => array( 'name' => 'slide-image-y-offset', 'title' => __('Image\'s Y axis offset', 'konzept'), 'desc' => __('Specify top Y offset of your slide image. Examples: <strong>10px</strong> will move it 10px downwards. <strong>-10px</strong> will move it 10px to the top.', 'konzept'), 'type' => 'text' ),
		
		/* Custom Code */
		//'slide-custom-code' => array( 'name' => 'slide-custom-code', 'title' => __('Custom Code', 'konzept'), 'desc' => __('Any custom HTML.', 'konzept'), 'type' => 'textarea' ),
	);

	return apply_filters( 'konzept_slideshow_meta_boxes', $meta_boxes );
}
function konzept_portfolio_meta_boxes() {

	$list_of_pages_raw = get_pages();
	$list_of_pages['none'] = __('(main portfolio page)', 'konzept');
	foreach($list_of_pages_raw as $single_page){
		$list_of_pages[$single_page->ID] = $single_page->post_title; /* Must be [ID] => [display name] */
	}
	/* Array of the meta box options. */
	$meta_boxes = array(
		'slides' => array( 'name' => 'slides', 'title' => __('Thumbnail image:', 'konzept'), 'desc' => __('Manage your slides here.', 'konzept'), 'type' => 'slidemanager' ),
		'300-160-image' => array( 'name' => '300-160-image', 'title' => __('Thumbnail image', 'konzept'), 'desc' => __('Recommended thumbnail size: 400x300px.', 'konzept'), 'type' => 'imagesmapler' ),
		'thumbnail_hover_color' => array( 'name' => 'thumbnail_hover_color', 'title' => __('Thumbnail mouse over color:', 'konzept'), 'desc' => __('Pick some color that will be used as mouse over color for this project\'s thumbnail on front page.', 'konzept'), 'type' => 'imagesamplerhidden' ),
		'display_cover_slide' => array( 'name' => 'display_cover_slide', 'title' => __('Display Cover Slide', 'konzept'), 'options' => array('yes' => __('Display', 'konzept'), 'no' => __('Don\'t display', 'konzept')), 'desc' => __('Cover slide shows project information while other slides are loading.', 'konzept'), 'type' => 'select' ),
		'flow_post_description' => array( 'name' => 'flow_post_description', 'title' => __('Description', 'konzept'), 'desc' => __('Project description. Displayed on the cover slide.', 'konzept'), 'type' => 'textarea' ),
		'portfolio_date' => array( 'name' => 'portfolio_date', 'title' => __('Project date', 'konzept'), 'desc' => __('Displayed on the cover slide. Suggested date format: dd.mm.yyyy (like 20.07.2011).', 'konzept'), 'type' => 'text' ),
		'portfolio_client' => array( 'name' => 'portfolio_client', 'title' => __('Project client', 'konzept'), 'desc' => __('Displayed on the cover slide.', 'konzept'), 'type' => 'text' ),
		'portfolio_agency' => array( 'name' => 'portfolio_agency', 'title' => __('Project agency', 'konzept'), 'desc' => __('Displayed on the cover slide.', 'konzept'), 'type' => 'text' ),
		'portfolio_ourrole' => array( 'name' => 'portfolio_ourrole', 'title' => __('Project role', 'konzept'), 'desc' => __('Displayed on the cover slide. Please use &lt;br&gt; HTML tag to add multi-line roles (&lt;br&gt; starts a new line).', 'konzept'), 'type' => 'text' ),
		'thumbnail_link' => array( 'name' => 'thumbnail_link', 'title' => __('Thumbnail External Link (optional)', 'konzept'), 'desc' => __('You can make the thumbnail link somewhere (like a blog post or external website).', 'konzept'), 'type' => 'text' ),
		'thumbnail_link_newwindow' => array( 'name' => 'thumbnail_link_newwindow', 'title' => __('Open link in a new window?', 'konzept'), 'desc' => __('This option works only if you have specified external link for this thumbnail.', 'konzept'), 'options' => array('0' => __('Same window', 'konzept'), '1' => __('New window', 'konzept')), 'type' => 'select' ),
		'portfolio_back_button' => array( 'name' => 'portfolio_back_button', 'title' => __('Parent portfolio page', 'konzept'), 'desc' => __('When this project is entered directly, which portfolio page is its parent?', 'konzept'), 'type' => 'select', 'options' => $list_of_pages )
	);

	return apply_filters( 'konzept_portfolio_meta_boxes', $meta_boxes );
}

/**
 * Array of variables for page meta boxes.  Make the 
 * function filterable to add options through child themes.
 *
 * @since 0.3
 * @return array $meta_boxes
 */
function konzept_page_meta_boxes() {

	/* Array of the meta box options. */
	$meta_boxes = array(

	);
	
	$page_portfolio_orderby = array('date' => 'date', 'none' => 'none', 'ID' => 'ID', 'author' => 'author', 'title' => 'title', 'modified' => 'modified', 'parent' => 'parent', 'rand' => 'rand', 'comment_count' => 'comment_count', 'menu_order' => 'menu_order');
	$page_portfolio_order = array('DESC' => 'DESC', 'ASC' => 'ASC');
	
	$page_portfolio_post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
	if($page_portfolio_post_id){
		$page_portfolio_templatefile = get_post_meta($page_portfolio_post_id, '_wp_page_template', true);
		if($page_portfolio_templatefile){
			if(in_array(strtolower($page_portfolio_templatefile), array('template-portfolio.php')) || $page_portfolio_post_id == get_option('page_on_front')){
				$page_portfolio_options = array();
				$page_portfolio_categories = get_terms("portfolio_category", "hide_empty=0");
				for($h=0;$h<count($page_portfolio_categories);$h++){
					$page_portfolio_options[$page_portfolio_categories[$h]->slug] = $page_portfolio_categories[$h]->name;
				}
				$meta_boxes = array_merge($meta_boxes, array(
					'page_portfolio_mode' => array( 'name' => 'page_portfolio_mode', 'title' => __('Portfolio Type', 'konzept'), 'desc' => __('Text and thumbnail portfolio pages are supported.', 'konzept'), 'options' => array('thumbnails' => __('Thumbnails', 'konzept'), 'text' => __('Text', 'konzept')), 'type' => 'select'),
					'page_portfolio_tax_query_operator' => array( 'name' => 'page_portfolio_tax_query_operator', 'title' => __('Operator for categories box', 'konzept'), 'desc' => __('You can make below box INCLUDE only selected categories or EXCLUDE selected categories. When you\'re using INCLUDE you must select at least two categories. If you will not select any categories it\'s going to display everything.', 'konzept'), 'options' => array(false => __('Exclude', 'konzept'), true => __('Include', 'konzept')), 'type' => 'select'),
					'page_portfolio_exclude' => array( 'name' => 'page_portfolio_exclude', 'title' => __('Exclude portfolio categories', 'konzept'), 'desc' => __('Select categories that should be excluded from this portfolio page. You can select multiple categories if you hold Ctrl / CMD and click on them.', 'konzept'), 'type' => 'select', 'is_multiple' => true, 'options' => $page_portfolio_options),
					'page_portfolio_orderby' => array( 'name' => 'page_portfolio_orderby', 'title' => __('Thumbnails order by', 'konzept'), 'desc' => __('Default: date.', 'konzept'), 'type' => 'select', 'is_multiple' => false, 'options' => $page_portfolio_orderby),
					'page_portfolio_order' => array( 'name' => 'page_portfolio_order', 'title' => __('Thumbnails order', 'konzept'), 'desc' => __('Default: DESC.', 'konzept'), 'type' => 'select', 'is_multiple' => false, 'options' => $page_portfolio_order),
					//'page_portfolio_shuffle' => array( 'name' => 'page_portfolio_shuffle', 'title' => __('Shuffle button', 'konzept'), 'options' => array(false => __('Disable', 'konzept'), true => __('Enable', 'konzept')), 'desc' => __('Enable or disable the shuffle button on this page.', 'konzept'), 'type' => 'select'),
					//'page_portfolio_welcome_text' => array( 'name' => 'page_portfolio_welcome_text', 'title' => __('Welcome text', 'konzept'), 'desc' => __('Set welcome text for this portfolio page.', 'konzept'), 'type' => 'textarea'),
					'page_portfolio_loop_through' => array( 'name' => 'page_portfolio_loop_through', 'title' => __('Browse projects from selected category', 'konzept'), 'options' => array(false => __('No', 'konzept'), true => __('Yes', 'konzept')), 'desc' => __('By default entering project will make left/right arrows go to the next project regardless of what category is it in. Select this to "yes" if you would users to browser projects from currently selected category only.', 'konzept'), 'type' => 'select'),
					'page_portfolio_boundary_arrows' => array( 'name' => 'page_portfolio_boundary_arrows', 'title' => __('Projects loop', 'konzept'), 'options' => array(false => __('Loop', 'konzept'), true => __('Do not loop', 'konzept')), 'desc' => __('When user sees the first/last project in current projects set should the first/last arrow disappear or should it be looped?', 'konzept'), 'type' => 'select')
				));
			}else{
				$meta_boxes = array_merge($meta_boxes, array(
					'flow_post_description' => array( 'name' => 'flow_post_description', 'title' => __('Description', 'konzept'), 'desc' => __('You can add description to your page using this custom field. It will be displayed above page. It\'s optional.', 'konzept'), 'type' => 'textarea' ),
					'flow_post_layout' => array( 'name' => 'flow_post_layout', 'title' => __( 'Layout:', 'konzept' ), 'options' => array( 'no-sidebar' => __('No Sidebar', 'konzept'), 'sidebar-left' => __('Left Sidebar', 'konzept'), 'sidebar-right' => __('Right Sidebar', 'konzept'), 'no-boundaries' => __('No boundaries', 'konzept') ), 'desc' => __( 'Pick page layout here.', 'konzept' ), 'type' => 'select' )
				));
			}
		}
	}
	
	$meta_boxes = array_merge($meta_boxes, array(
		'bg_image' => array( 'name' => 'bg_image', 'title' => __('Background image:', 'konzept'), 'desc' => 'Put link to your large background image here. The bigger the better (recommended ratio would be like 4:3 or 16:9 and dimensions like 1920x1080px).', 'type' => 'upload' ),
		'bg_color' => array( 'name' => 'bg_color', 'title' => __('Background color:', 'konzept'), 'desc' => __('Pick background color here. If you\'re not planning to use background image you should set some color instead. It should be in this format: <strong>#ffffff</strong> (for white background).', 'konzept'), 'type' => 'colorpicker' ),
		'bg_attachment' => array( 'name' => 'bg_attachment', 'title' => __('Background Attachment', 'konzept'), 'options' => array(false => __('Disable', 'konzept'), 'scroll' => __('Scroll (Default)', 'konzept'), 'fixed' => __('Fixed', 'konzept')), 'desc' => __('Scroll - the background image scrolls with the rest of the page. Fixed - the background image is fixed.', 'konzept'), 'type' => 'select' ),
		'bg_repeat' => array( 'name' => 'bg_repeat', 'title' => __('Background Repeat', 'konzept'), 'options' => array(false => __('Disable', 'konzept'), 'repeat' => __('Repeat', 'konzept'), 'no-repeat' => __('No-repeat', 'konzept'), 'repeat-x' => __('Repeat X', 'konzept'), 'repeat-y' => __('Repeat Y', 'konzept')), 'desc' => '', 'type' => 'select' ),
		'bg_position' => array( 'name' => 'bg_position', 'title' => __('Background Position', 'konzept'), 'desc' => __('Use like: left top OR center center OR 20% 20% OR center etc. Default: left top.', 'konzept'), 'type' => 'text' ),
		'bg_size' => array( 'name' => 'bg_size', 'title' => __('Background Size', 'konzept'), 'desc' => __('Use like: 100px 100px OR 10px 150px OR 200px OR 50% OR 100% 100% OR cover OR contain etc. Default: auto.', 'konzept'), 'type' => 'text' ),
	));

	return apply_filters( 'konzept_page_meta_boxes', $meta_boxes );
}

/**
 * Displays meta boxes on the Write Post panel.  Loops 
 * through each meta box in the $meta_boxes variable.
 * Gets array from konzept_post_meta_boxes().
 *
 * @since 0.3
 */
function post_meta_boxes() {
	global $post;
	$meta_boxes = konzept_post_meta_boxes(); ?>

	<table class="form-table meta-boxes-table">
	<?php foreach ( $meta_boxes as $meta ) :
	
		// $value = get_post_meta( $post->ID, $meta['name'], true ); // original - no stripslashes()
		$value = get_post_meta( $post->ID, $meta['name'], true );
		if(is_array($value)){
			//foreach($value as $k => $v){
				//$value[$k] = stripslashes( $v );
			//}
		}else{
			$value = stripslashes( $value );
		}

		if ( $meta['type'] == 'text' )
			get_meta_text_input( $meta, $value );
		elseif ( $meta['type'] == 'upload' )
			get_meta_text_upload( $meta, $value );
		elseif ( $meta['type'] == 'textarea' )
			get_meta_textarea( $meta, $value );
		elseif ( $meta['type'] == 'select' )
			get_meta_select( $meta, $value );
		elseif ( $meta['type'] == 'imagesampler' )
			get_meta_imagesampler( $meta, $value );
		elseif ( $meta['type'] == 'imagesamplerhidden' )
			get_meta_imagesamplerhidden( $meta, $value );
		elseif ( $meta['type'] == 'slidemanager' )
			get_meta_slidemanager( $meta, $value );

	endforeach; ?>
	</table>
<?php 
}

/**
 * Displays meta boxes on the Write Page panel.  Loops 
 * through each meta box in the $meta_boxes variable.
 * Gets array from konzept_page_meta_boxes()
 *
 * @since 0.3
 */
function page_meta_boxes() {
	global $post;
	$meta_boxes = konzept_page_meta_boxes(); ?>

	<table class="form-table meta-boxes-table">
	<?php foreach ( $meta_boxes as $meta ) :
	
		// $value = stripslashes( get_post_meta( $post->ID, $meta['name'], true ) ); // original
		$value = get_post_meta( $post->ID, $meta['name'], true );
		if(is_array($value)){
			//foreach($value as $k => $v){
				//$value[$k] = stripslashes( $v );
			//}
		}else{
			$value = stripslashes( $value );
		}

		if ( $meta['type'] == 'text' )
			get_meta_text_input( $meta, $value );
		elseif ( $meta['type'] == 'upload' )
			get_meta_text_upload( $meta, $value );
		elseif ( $meta['type'] == 'textarea' )
			get_meta_textarea( $meta, $value );
		elseif ( $meta['type'] == 'select' )
			get_meta_select( $meta, $value );
		elseif ( $meta['type'] == 'colorpicker' )
			get_meta_colorpicker( $meta, $value );
		elseif ( $meta['type'] == 'imagesampler' )
			get_meta_imagesampler( $meta, $value );
		elseif ( $meta['type'] == 'imagesamplerhidden' )
			get_meta_imagesamplerhidden( $meta, $value );
		elseif ( $meta['type'] == 'slidemanager' )
			get_meta_slidemanager( $meta, $value );

	endforeach; ?>
	</table>
<?php 
}

/**
 * Displays meta boxes on the Write Page panel.  Loops 
 * through each meta box in the $meta_boxes variable.
 * Gets array from konzept_page_meta_boxes()
 *
 * @since 0.3
 */
function portfolio_meta_boxes() {
	global $post;
	$meta_boxes = konzept_portfolio_meta_boxes(); ?>

	<table class="form-table meta-boxes-table">
	<?php foreach ( $meta_boxes as $meta ) :

		// $value = stripslashes( get_post_meta( $post->ID, $meta['name'], true ) ); // original
		$value = get_post_meta( $post->ID, $meta['name'], true );
		if(is_array($value)){
			//foreach($value as $k => $v){
				//$value[$k] = stripslashes( $v );
			//}
		}else{
			$value = stripslashes( $value );
		}

		if ( $meta['type'] == 'text' )
			get_meta_text_input( $meta, $value );
		elseif ( $meta['type'] == 'upload' )
			get_meta_text_upload( $meta, $value );
		elseif ( $meta['type'] == 'textarea' )
			get_meta_textarea( $meta, $value );
		elseif ( $meta['type'] == 'select' )
			get_meta_select( $meta, $value );
		elseif ( $meta['type'] == 'colorpicker' )
			get_meta_colorpicker( $meta, $value );
		elseif ( $meta['type'] == 'imagesmapler' )
			get_meta_imagesampler( $meta, $value );
		elseif ( $meta['type'] == 'imagesamplerhidden' )
			get_meta_imagesamplerhidden( $meta, $value );
		elseif ( $meta['type'] == 'slidemanager' )
			get_meta_slidemanager( $meta, $value );

	endforeach; ?>
	</table>
<?php 
}

function slideshow_meta_boxes() {
	global $post;
	$meta_boxes = konzept_slideshow_meta_boxes(); ?>

	<table class="form-table meta-boxes-table">
	<?php foreach ( $meta_boxes as $meta ) :

		// $value = stripslashes( get_post_meta( $post->ID, $meta['name'], true ) ); // original
		$value = get_post_meta( $post->ID, $meta['name'], true );
		if(is_array($value)){
			//foreach($value as $k => $v){
				//$value[$k] = stripslashes( $v );
			//}
		}else{
			$value = stripslashes( $value );
		}

		if ( $meta['type'] == 'text' )
			get_meta_text_input( $meta, $value );
		elseif ( $meta['type'] == 'upload' )
			get_meta_text_upload( $meta, $value );
		elseif ( $meta['type'] == 'textarea' )
			get_meta_textarea( $meta, $value );
		elseif ( $meta['type'] == 'select' )
			get_meta_select( $meta, $value );
		elseif ( $meta['type'] == 'colorpicker' )
			get_meta_colorpicker( $meta, $value );
		elseif ( $meta['type'] == 'imagesmapler' )
			get_meta_imagesampler( $meta, $value );
		elseif ( $meta['type'] == 'imagesamplerhidden' )
			get_meta_imagesamplerhidden( $meta, $value );
		elseif ( $meta['type'] == 'slidemanager' )
			get_meta_slidemanager( $meta, $value );

	endforeach; ?>
	</table>
<?php 
}

function get_meta_text_input( $args = array(), $value = false ) {
	extract( $args ); ?>

	<tr>
		<th style="width:20%;">
			<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
		</th>
		<td>
			<input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_html( $value ); ?>" size="30" tabindex="30" style="width: 97%;" />
			<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
			<p><?php echo $desc; ?></p>
		</td>
	</tr>
	<?php 
}

function get_meta_text_upload( $args = array(), $value = false ) {
	extract( $args ); ?>
	<tr>
		<th style="width:20%;">
			<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
		</th>
		<td>
			<div class="flowuploader">
				<input class="flowuploader_media_url" type="text" name="<?php echo $name; ?>" value="<?php echo esc_html( $value ); ?>" />
				<span class="flowuploader_upload_button button">Upload</span>
				<div class="flowuploader_media_preview_image"></div>
			</div>
			<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
			<p><?php echo $desc; ?></p>
		</td>
	</tr>
	<?php 
}

function get_meta_colorpicker( $args = array(), $value = false ){
	extract( $args ); ?>
	<tr>
		<th style="width:20%;">
			<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
		</th>
		<td>						
			<input id="<?php echo $name; ?>" type="text" class="" name="<?php echo $name; ?>" value="<?php echo esc_html( $value ); ?>">
			<script type="text/javascript">
				jQuery(document).ready(function(){
					if(typeof jQuery.wp === "object" && typeof jQuery.wp.wpColorPicker === "function"){
						var options = {
							palettes: false
						};
						jQuery('#<?php echo $name; ?>').wpColorPicker(options);
					}
				});
			</script>
			<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
			<p>
				<?php echo $desc; ?>
			</p>
		</td>
	</tr>
	<?php 
}
function get_meta_imagesamplerhidden( $args = array(), $value = false ){ extract( $args ); ?>
	<tr style="display:none;">
		<th></th>
		<td>
			<input id="<?php echo $name; ?>" type="text" name="<?php echo $name; ?>" value="<?php echo esc_html( $value ); ?>">
			<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
		</td>
	</tr>
	<?php 
}

$nonce_name = plugin_basename( __FILE__ );
include( dirname( __FILE__ ) . '/superslide/superslide.php' );
include( dirname( __FILE__ ) . '/superslide/imagesampler.php' );
include( dirname( __FILE__ ) . '/superslide/shortcode-slide.php' );

function get_meta_select( $args = array(), $value = false ) {
	extract( $args );
		if(isset($is_multiple) && $is_multiple){
			$page_portfolio_post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
			if($page_portfolio_post_id){
				$value = get_post_meta($page_portfolio_post_id, $name, true);
			}
		}else{
			$is_multiple = false;
		}
	?>
	<tr>
		<th style="width:20%;">
			<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
		</th>
		<td>
			<select <?php if($is_multiple){ echo ' multiple="multiple"'; } ?> name="<?php echo $name; if($is_multiple){ echo '[]'; } ?>" id="<?php echo $name; ?>">
				<?php foreach( $options as $optionkey => $optionval ){ ?>
					<option value="<?php echo $optionkey; ?>" <?php if((is_array($value) && in_array($optionkey, $value)) || (is_string($value) && $optionkey == $value)){ echo ' selected="selected"'; } ?>><?php echo $optionval; ?></option>
				<?php } ?>
			</select>
			<p>
				<?php echo $desc; ?>
			</p>
			<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
		</td>
	</tr>
	<?php 
}

function get_meta_textarea( $args = array(), $value = false ) {

	extract( $args ); ?>

	<tr>
		<th style="width:20%;">
			<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
		</th>
		<td>
			<textarea name="<?php echo $name; ?>" id="<?php echo $name; ?>" cols="60" rows="4" tabindex="30" style="width: 97%;"><?php echo esc_html( $value ); ?></textarea>
			<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
			<p>
				<?php echo $desc; ?>
			</p>
		</td>
	</tr>
	<?php 
}

/* Add a new meta box to the admin menu. */
add_action( 'admin_menu', 'konzept_create_meta_box' );

/* Saves the meta box data. */
add_action( 'save_post', 'konzept_save_meta_data' );

/**
 * Loops through each meta box's set of variables.
 * Saves them to the database as custom fields.
 *
 * @since 0.3
 * @param int $post_id
 */
function konzept_save_meta_data( $post_id ) {
	global $post;
	$i = 0;

	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] )
		$meta_boxes = array_merge( konzept_page_meta_boxes() );
	elseif ( isset( $_POST['post_type'] ) && 'portfolio' == $_POST['post_type'] )
		$meta_boxes = array_merge( konzept_portfolio_meta_boxes() );
	elseif ( isset( $_POST['post_type'] ) && 'slideshow' == $_POST['post_type'] )
		$meta_boxes = array_merge( konzept_slideshow_meta_boxes() );
	else
		$meta_boxes = array_merge( konzept_post_meta_boxes() );
		
	foreach ( $meta_boxes as $meta_box ) :
		
		if ( isset( $_POST[$meta_box['name'] . '_noncename'] ) && !wp_verify_nonce( $_POST[$meta_box['name'] . '_noncename'], plugin_basename( __FILE__ ) ) )
			return $post_id;

		if ( ! isset( $_POST['post_type'] ) || ( 'page' == $_POST['post_type'] && !current_user_can( 'edit_page', $post_id ) ) ) {
			return $post_id;
		} else if ( ! isset( $_POST['post_type'] ) || ( 'post' == $_POST['post_type'] && !current_user_can( 'edit_post', $post_id ) ) ) {
			return $post_id;
		}

		$data = isset( $_POST[$meta_box['name']] ) ? $_POST[$meta_box['name']] : '';
		if(!is_array($data)){
			$data = stripslashes($data);
		}

		// Update post
		if($meta_box['name'] == "slides"){
			$this_id = get_the_ID();
			$my_post = array();
			$my_post['ID'] = $this_id;
			
			$post_content = json_decode($data);
			$shortcode_output = '';
			foreach((array)$post_content as $key => $value){
				$value = (array) $value;
				if(isset($value['type']) && ($value['type'] == 'custom')){
					$CSSClass = '';
					if(array_key_exists('css_class', $value)){
						$CSSClass = $value['css_class'];
					}
					$shortcode = '<div class="project-slide project-slide-image ' . $CSSClass . '">';
						$shortcode .= $value['custom'];
					$shortcode .= '</div>';
					$shortcode .= "\n\n";
				}else{
					$shortcode = '[slide';
					$has_desc = false;
					foreach($value as $field_name => $field_value){
						if($field_name == 'slide_desc'){
							$has_desc = true;
						}else{
							$shortcode .= ' ' . $field_name . '="' . $field_value . '"';
						}
						
					}
					$shortcode .= ']';
					if($has_desc){
						$shortcode .= $value['slide_desc'];
					}
					$shortcode .= '[/slide]';
					$shortcode .= "\n\n";
				}
				$shortcode_output .= $shortcode;
			}
			$my_post['post_content'] = $shortcode_output;
			
			//remove_action('save_post', 'konzept_save_meta_data');
			//wp_update_post( $my_post );
			//add_action('save_post', 'konzept_save_meta_data');
			
			$data = $_POST[$meta_box['name']];
		}
		 
		if ( get_post_meta( $post_id, $meta_box['name'] ) == '' )
			add_post_meta( $post_id, $meta_box['name'], $data, true );

		elseif ( $data != get_post_meta( $post_id, $meta_box['name'], true ) )
			update_post_meta( $post_id, $meta_box['name'], $data );

		elseif ( $data == '' )
			delete_post_meta( $post_id, $meta_box['name'], get_post_meta( $post_id, $meta_box['name'], true ) );

	endforeach;
} ?>