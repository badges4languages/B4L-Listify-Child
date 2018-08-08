<?php

/* //////////////
   /   Script   /
   ////////////// */

//Add my script file
function my_theme_scripts_function() {
	wp_enqueue_script( 'script', get_stylesheet_directory_uri() . '/js/script.js' );
	wp_enqueue_script( 'validation', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js' );

	//Allows to get the url of the ajax functions file in my JS file.
	$translation_array = array( 'ajaxFunctionURL' => get_stylesheet_directory_uri() . '/ajax' );
	wp_localize_script( 'script', 'ajax_function_path', $translation_array );
}
add_action('wp_enqueue_scripts','my_theme_scripts_function');