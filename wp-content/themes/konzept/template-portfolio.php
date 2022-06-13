<?php
/* Template Name: Portfolio Thumbnail Grid */ 

get_header();

// Data of this page
$id = $wp_query->queried_object->ID;
$main_portfolio_page = get_option('flow_portfolio_page');

// Welcome Text
if(is_singular('portfolio') && ($parent_page = get_post_meta($id, 'portfolio_back_button', true)) && !empty($parent_page) && ($parent_page != 'none')){
	$id_to_use = $parent_page;
}else if(is_singular('portfolio') && $main_portfolio_page != ''){
	$id_to_use = $main_portfolio_page;
}else if(is_page_template('template-portfolio.php')){
	$id_to_use = $id;
}else{
	$id_to_use = false;
}

//get_template_part( 'project', 'container' );
//get_template_part( 'project', 'loop' );

get_footer();
