<?php
/**
 * Listify child theme.
 */

function listify_child_styles() {
    wp_enqueue_style( 'listify-child', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'listify_child_styles', 999 );

/** Place any new code below this line */





/** Redirect user after login/registration globally 
 *
 * https://codex.wordpress.org/Plugin_API/Filter_Reference/login_redirect
 *
 */

/* This code adapted from: Registration Redirect */

add_filter( 'registration_redirect', 'ckc_registration_redirect' );
function ckc_registration_redirect() {
    // Change this to the url to your custom page. return home_url( ‘/example’ )
    return home_url('/what-is-badges4languages/');
}

/* This code adapted from: Login Redirect */

add_filter( 'login_redirect', 'ckc_login_redirect' );
function ckc_login_redirect() {
    // Change this to the url to your custom page. return home_url( ‘/example’ )
    return 'https://badges4languages.wordpress.com/';
}



