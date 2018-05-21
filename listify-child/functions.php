<?php
/**
 * Listify child theme.
 */
function listify_child_styles() {
    wp_enqueue_style( 'listify-child', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'listify_child_styles', 999 );

/* //////////////
   /   Script   /
   ////////////// */

//Add my script file
function my_theme_scripts_function() {
  wp_enqueue_script( 'script', get_stylesheet_directory_uri() . '/js/script.js');
}
add_action('wp_enqueue_scripts','my_theme_scripts_function');

/* ///////////////////
   /    Taxonomies   /
   /////////////////// */

//Return the list of the term names of a taxonomy
function get_CPT_terms($postID, $term){
	$terms_list = wp_get_post_terms($postID, $term);
	if( empty( $terms_list ) ) :
		return 'Not Specified';
	else :
		$output = '';
		$i = 0;
		foreach ($terms_list as $t) {
			$i++;
			if($i > 1){ $output .= ', '; }
			$output .= $t->name.' ';
		}
		return $output;
	endif;
}

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

/* ////////////////////////
   /      Custom Menu     /
   //////////////////////// */

//Add the profile menu item
function my_custom_menu_item($items)
{
    if( is_user_logged_in() ) {
        $user=wp_get_current_user();
        $urlAvatar=esc_url( get_avatar_url( $user->ID ) );
        if( ! empty( $user->user_firstname ) ) :
        	$name=$user->user_firstname; // or user_login , user_firstname, user_lastname
        else :
        	$name=$user->user_login;
        endif;
        
        //Avatar and user name item and submenu item
        $items .= 
        '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-87"><a href="'. get_page_link( 187 ) . '/' . $user->user_login . '"><img id="menu-avatar" class="circle-img" src="' . $urlAvatar . '" height="40" width="40">' . $name . '</a>
          <ul class="sub-menu">
            <li class="ion-person menu-item menu-item-type-post_type menu-item-object-page"><a href="'. get_page_link( 187 ) . '/' . $user->user_login . '">Profile</a></li>
            <li class="ion-close-circled menu-item menu-item-type-post_type menu-item-object-page"><a href="' . get_page_link( 179 ) . '" class="popup-trigger-ajax">Sign out</a></li>
          </ul>
        </li>';
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'my_custom_menu_item');

/* /////////////////////////
   /   Limit Upload Size   /
   ///////////////////////// */

// Limit the upload size limit to 1MB for any users who are not an administrator.
function limit_upload_size_limit_for_non_admin( $limit ) {
  if ( ! current_user_can( 'manage_options' ) ) {
    $limit = '1000000'; // 1mb in bytes
  }
  return $limit;
}
add_filter( 'upload_size_limit', 'limit_upload_size_limit_for_non_admin' );

/* ////////////////////////////////
   /   Custom Registration Form   /
   //////////////////////////////// */

// Adds the custom fields to the registration form and profile editor.
function pw_rcp_add_user_fields() {

  $profession       = get_user_meta( get_current_user_id(), 'rcp_profession', true );
  $location         = get_user_meta( get_current_user_id(), 'rcp_location', true );
  $university       = get_user_meta( get_current_user_id(), 'rcp_university', true );
  $mother_tongue    = get_user_meta( get_current_user_id(), 'rcp_mother_tongue', true );
  $other_education  = get_user_meta( get_current_user_id(), 'rcp_other_education', true );

  ?>
    <label for="rcp_mother_tongue"><?php _e( 'Mother Tongue', 'rcp' ); ?></label>
    <input name="rcp_mother_tongue" id="rcp_mother_tongue" type="text" value="<?php echo esc_attr( $mother_tongue ); ?>"/>
  </p>
  <p>
    <label for="rcp_university"><?php _e( 'University Degree', 'rcp' ); ?></label>
    <input name="rcp_university" id="rcp_university" type="text" value="<?php echo esc_attr( $university ); ?>"/>
  </p>
  <p>
  <p>
    <label for="rcp_other_education"><?php _e( 'Other Education', 'rcp' ); ?></label>
    <input name="rcp_other_education" id="rcp_other_education" type="text" value="<?php echo esc_attr( $other_education ); ?>"/>
  </p>
  <p>
    <label for="rcp_profession"><?php _e( 'Profession', 'rcp' ); ?></label>
    <input name="rcp_profession" id="rcp_profession" type="text" value="<?php echo esc_attr( $profession ); ?>"/>
  </p>
  <p>
    <label for="rcp_location"><?php _e( 'Location', 'rcp' ); ?></label>
    <input name="rcp_location" id="rcp_location" type="text" value="<?php echo esc_attr( $location ); ?>"/>
  </p>

  <?php
}
add_action( 'rcp_before_subscription_form_fields', 'pw_rcp_add_user_fields' );
add_action( 'rcp_profile_editor_after', 'pw_rcp_add_user_fields' );

// Adds the custom fields to the member edit screen
function pw_rcp_add_member_edit_fields( $user_id = 0 ) {

  $profession       = get_user_meta( $user_id, 'rcp_profession', true );
  $location         = get_user_meta( $user_id, 'rcp_location', true );
  $university       = get_user_meta( $user_id, 'rcp_university', true );
  $mother_tongue    = get_user_meta( $user_id, 'rcp_mother_tongue', true );
  $other_education  = get_user_meta( $user_id, 'rcp_other_education', true );
  ?>

  <tr valign="top">
    <th scope="row" valign="top">
      <label for="rcp_mother_tongue"><?php _e( 'Mother Tongue', 'rcp' ); ?></label>
    </th>
    <td>
      <input name="rcp_mother_tongue" id="rcp_mother_tongue" type="text" value="<?php echo esc_attr( $mother_tongue ); ?>"/>
      <p class="description"><?php _e( 'The member\'s mother tongue', 'rcp' ); ?></p>
    </td>
  </tr>
  <tr valign="top">
    <th scope="row" valign="top">
      <label for="rcp_university"><?php _e( 'University', 'rcp' ); ?></label>
    </th>
    <td>
      <input name="rcp_university" id="rcp_university" type="text" value="<?php echo esc_attr( $university ); ?>"/>
      <p class="description"><?php _e( 'The member\'s University', 'rcp' ); ?></p>
    </td>
  </tr>
  <tr valign="top">
    <th scope="row" valign="top">
      <label for="rcp_other_education"><?php _e( 'Other Education', 'rcp' ); ?></label>
    </th>
    <td>
      <input name="rcp_other_education" id="rcp_other_education" type="text" value="<?php echo esc_attr( $other_education ); ?>"/>
      <p class="description"><?php _e( 'The member\'s other qualification', 'rcp' ); ?></p>
    </td>
  </tr>
  <tr valign="top">
    <th scope="row" valign="top">
      <label for="rcp_profession"><?php _e( 'Profession', 'rcp' ); ?></label>
    </th>
    <td>
      <input name="rcp_profession" id="rcp_profession" type="text" value="<?php echo esc_attr( $profession ); ?>"/>
      <p class="description"><?php _e( 'The member\'s profession', 'rcp' ); ?></p>
    </td>
  </tr>
  <tr valign="top">
    <th scope="row" valign="top">
      <label for="rcp_location"><?php _e( 'Location', 'rcp' ); ?></label>
    </th>
    <td>
      <input name="rcp_location" id="rcp_location" type="text" value="<?php echo esc_attr( $location ); ?>"/>
      <p class="description"><?php _e( 'The member\'s location', 'rcp' ); ?></p>
    </td>
  </tr>

  <?php
}
add_action( 'rcp_edit_member_after', 'pw_rcp_add_member_edit_fields' );

// Stores the information submitted during registration
function pw_rcp_save_user_fields_on_register( $posted, $user_id ) {

  if( ! empty( $posted['rcp_profession'] ) ) {
    update_user_meta( $user_id, 'rcp_profession', sanitize_text_field( $posted['rcp_profession'] ) );
  }
  if( ! empty( $posted['rcp_location'] ) ) {
    update_user_meta( $user_id, 'rcp_location', sanitize_text_field( $posted['rcp_location'] ) );
  }
  if( ! empty( $posted['rcp_university'] ) ) {
    update_user_meta( $user_id, 'rcp_university', sanitize_text_field( $posted['rcp_university'] ) );
  }
  if( ! empty( $posted['rcp_mother_tongue'] ) ) {
    update_user_meta( $user_id, 'rcp_mother_tongue', sanitize_text_field( $posted['rcp_mother_tongue'] ) );
  }
  if( ! empty( $posted['rcp_other_education'] ) ) {
    update_user_meta( $user_id, 'rcp_other_education', sanitize_text_field( $posted['rcp_other_education'] ) );
  }
}
add_action( 'rcp_form_processing', 'pw_rcp_save_user_fields_on_register', 10, 2 );

// Stores the information submitted profile update
function pw_rcp_save_user_fields_on_profile_save( $user_id ) {

  if( ! empty( $_POST['rcp_profession'] ) ) {
    update_user_meta( $user_id, 'rcp_profession', sanitize_text_field( $_POST['rcp_profession'] ) );
  }

  if( ! empty( $_POST['rcp_location'] ) ) {
    update_user_meta( $user_id, 'rcp_location', sanitize_text_field( $_POST['rcp_location'] ) );
  }
  if( ! empty( $_POST['rcp_university'] ) ) {
    update_user_meta( $user_id, 'rcp_university', sanitize_text_field( $_POST['rcp_university'] ) );
  }
  if( ! empty( $_POST['rcp_mother_tongue'] ) ) {
    update_user_meta( $user_id, 'rcp_mother_tongue', sanitize_text_field( $_POST['rcp_mother_tongue'] ) );
  }
  if( ! empty( $_POST['rcp_other_education'] ) ) {
    update_user_meta( $user_id, 'rcp_other_education', sanitize_text_field( $_POST['rcp_other_education'] ) );
  }
}

add_action( 'rcp_user_profile_updated', 'pw_rcp_save_user_fields_on_profile_save', 10 );
add_action( 'rcp_edit_member', 'pw_rcp_save_user_fields_on_profile_save', 10 );

/* ////////////////////////////////
   /     Plugin Update Checker    /
   //////////////////////////////// */

/*
* Auto update from github
*
* @since 1.0.0
*/
require 'vendor/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
   'https://github.com/my-language-skills/open-badges-framework-listify-child/',
   __FILE__,
   'open-badges-framework-listify-child'
);

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