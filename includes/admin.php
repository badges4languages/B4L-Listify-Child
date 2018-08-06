<?php

/* ////////////////////////////////
   /           Admin              /
   //////////////////////////////// */

//Disable Admin Bar for All Users Except for Administrators
if ( !current_user_can( 'administrator' ) ) {
  add_filter( 'show_admin_bar', '__return_false' );
}

// Remove links to the Admin Tool-Bar
add_action( 'admin_bar_menu', 'remove_links_toolbar', 999 );
function remove_links_toolbar($wp_admin_bar)
{
 global $wp_admin_bar;
 //$wp_admin_bar->remove_menu('comments');
 //$wp_admin_bar->remove_menu('updates');

 $wp_admin_bar->remove_menu('wp-logo');
}

// Disable default dashboard widgets for All Users Except for Administrators
function disable_default_dashboard_widgets() {

  //remove_meta_box('dashboard_right_now', 'dashboard', 'core');
  remove_meta_box('dashboard_activity', 'dashboard', 'core');
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
  remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
  remove_meta_box('dashboard_plugins', 'dashboard', 'core');

  remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
  remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
  remove_meta_box('dashboard_primary', 'dashboard', 'core');
  remove_meta_box('dashboard_secondary', 'dashboard', 'core');
}

if (!current_user_can('manage_options')) {
        add_action('wp_dashboard_setup', 'disable_default_dashboard_widgets');
}