<?php

/* ///////////////////
   /    Taxonomies   /
   /////////////////// */

//Return the list of the term names of a taxonomy
function get_CPT_terms($postID, $term){
	$terms_list = wp_get_post_terms($postID, $term);
	if( empty( $terms_list ) ) :
		return 'All of them';
	else :
		$output = '';
		$i = 0;
		foreach ($terms_list as $t) {
			$i++;
			if($i > 1){ $output .= ', '; }
			$output .= '<a href="' . get_home_url() . '/' . $term . '/' . $t->name . '">'. $t->name . ' ' . '</a>';
		}
		return $output;
	endif;
}