<?php
 
/**
 * Template Name: Tekserve FAQ OS - Single
 * Description: Used as a page template showing the contents of a single operating-system and its related questions sorted by issue.  Genesis only for now...
 */
 
// wp_enqueue_script( 'underscore' );


add_action( 'wp_loaded', 'who_am_i' );

function who_am_i() {
	global $wp_query;
	$thePostID = $wp_query->post->ID;
	return $thePostID;
}

$osImage = '<span class="tekserve-faq-os-image">'; 
if( has_post_thumbnail() ) {
	$osImage .= get_the_post_thumbnail();
	
}
else {
	$osImage .= '<img src="' . plugins_url( '/images/defaultos.svg', __FILE__ ) . '" />';
}
$osImage .= '</span>';
 
//* Customize the post info function to display custom fields */

//add text to the title
// add_action('genesis_entry_header', 'tekserve_faq_os_title');
// add_action('genesis_before_post_content', 'tekserve_faq_os_title');
function tekserve_faq_os_title() {
	global $osImage;
	$faq_os_custom_title = 'Answers to your ' . get_the_title() . ' questions';
	echo '<div class="wpb_row section"><div class="tekserve-faq-os-image-container">' . $osImage . '</div><h1 class="entry-title">'.$faq_os_custom_title.'</h1></div>';
}


//Content
add_action( 'genesis_post_content', 'tekserve_faq_os_content' );

function tekserve_faq_os_content() {
	$these_issues = wp_get_post_terms( who_am_i(), 'tekserve_faq_issue' );
	$issue_list = '<div class="vc_span5 wpb_column column_container tekserve-faq-col-left">
		<div class="wpb_wrapper">';
	$issue_list .= '<ul class="tekserve-faq-issue-list">';
	foreach( $these_issues as $issue ) {
		$issue_list .= '<li>';
		$issue_list .= '<a class="tekserve-faq-os-issue" id="' . $issue->slug . '" href="javascript:;" title="' . $issue->name . '">' . $issue->name . '</a>';
		$issue_list .= '</li>';
	}
	$issue_list .= '</ul></div>
	</div>';
	$page_content = '<div id="tekserve_faq_os_content" class="wpb_row section flatTop">';
	$page_content .= $issue_list;
	$page_content .= '<div class="vc_span7 wpb_column column_container tekserve-faq-col-right">
		<div class="wpb_wrapper">
			<div class="tekserve-faq-slide-link" style="display: none;"><span class="tekserve-faq-slide-back">Back</span><span class="tekserve-faq-slide-title"></span></div>
			<div id="tekserve-faq-questions"></div>
		</div> 
	</div>';
	$page_content .= '</div>';
	tekserve_faq_os_title();
	echo $page_content;	
}

//Footer
add_action( 'genesis_after_content_sidebar_wrap', 'add_footer_folk' );

function add_footer_folk() {
	if( function_exists('footer_folk') ) {
		$footerfolk = "<div class='tekserve-faq-edition-folk'>".footer_folk( array( 'rotate' => 'yes' ) )."</div>";
		echo '<div style="clear:both;"></div>';
		echo $footerfolk;
	}
	
}

/** Remove Post Info */
remove_action( 'genesis_after_post_title', 'genesis_post_meta' );
remove_action( 'genesis_post_title', 'genesis_do_post_title' );
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action( 'genesis_post_content', 'genesis_do_post_content' );

//Add class
add_filter( 'body_class', 'tekserve_faq_os_body_class' );
function tekserve_faq_os_body_class( $classes ) {
     $classes[] = 'page-template-static_content-php';
     return $classes;
}

genesis();