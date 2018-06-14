<?php

/* //////////////////////
   /     Shortcodes    /
   ///////////////////// */

//Create a login form shortcode that redirect to the homepage
function login_form_redirect_shortcode(){
  return do_shortcode('[login_form redirect="'. home_url() . '"]');
}

//Create the logout link shortcode
function logout_link_shortcode() {
	return wp_logout_url( home_url() );
}

//Create the profile name shortcode
function profile_name_shortcode(){
    $user=wp_get_current_user();
    $name=$user->user_firstname; 
    return $name;
}

//Add the shortcodes
function my_add_shortcodes() {
	add_shortcode( 'logout-link', 'logout_link_shortcode' );
	add_shortcode('profile-name', 'profile_name_shortcode');
  add_shortcode( 'login-form-redirect', 'login_form_redirect_shortcode' );
}
add_action( 'init', 'my_add_shortcodes' );