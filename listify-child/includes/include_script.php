<?php

/* //////////////
   /   Script   /
   ////////////// */

//Add my script file
function my_theme_scripts_function() {
  wp_enqueue_script( 'script', get_stylesheet_directory_uri() . '/js/script.js');
}
add_action('wp_enqueue_scripts','my_theme_scripts_function');