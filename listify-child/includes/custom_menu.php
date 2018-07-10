<?php

/* ////////////////////////
   /      Custom Menu     /
   //////////////////////// */

//Add the profile menu item if the user is logged in
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
        '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-87"><a href="'. get_permalink( get_page_by_path( 'author' ) ) . '/' . $user->user_login . '"><img id="menu-avatar" class="circle-img" src="' . $urlAvatar . '" height="40" width="40">' . $name . '</a>
          <ul class="sub-menu">
            <li class="ion-person menu-item menu-item-type-post_type menu-item-object-page"><a href="'. get_permalink( get_page_by_path( 'author' ) ) . '/' . $user->user_login . '">Profile</a></li>';

        if ( is_plugin_active('b4l-portfolio/b4l-portfolio.php') ){
            $items .= '<li class="ion-briefcase menu-item menu-item-type-post_type menu-item-object-page"><a href="'. get_permalink( get_page_by_path( 'passport' ) ) . '">Portfolios</a></li>';
        }

        if ( is_plugin_active('b4l-profiling-grid-for-teachers/b4l-profiling-grid-for-teachers.php') && in_array( 'teacher', (array) $user->roles ) ) {
            $items .=  '<li class="ion-briefcase menu-item menu-item-type-post_type menu-item-object-page"><a href="'. get_permalink( get_page_by_path( 'teacher_portfolio' ) ) . '">Profiling Grid</a></li>';
        }

        $items .=
        '<li class="ion-close-circled menu-item menu-item-type-post_type menu-item-object-page"><a href="' . get_permalink( get_page_by_path( 'sign-out' ) ) . '" class="popup-trigger-ajax">Sign out</a></li>
          </ul>
        </li>';
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'my_custom_menu_item');