<?php
/**
 * Listify child theme.
 */
function listify_child_styles() {
    wp_enqueue_style( 'listify-child', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'listify_child_styles', 999 );


//Include all the files for shortcodes, menus, admin panel, taxonomies and files size option
require_once( "includes/include_script.php" );
require_once( "includes/shortcodes.php" );
require_once( "includes/custom_menu.php" );
require_once( "includes/admin.php" );
require_once( "includes/get_taxonomy_terms.php" );
require_once( "includes/limit_upload_size.php" );


/**
* Function for adding a new RCP Template (mails).
*
* SINCE v0.1
*/

function ag_rcp_email_templates( $templates ) {
    $templates['badges4languages'] = __( 'Badges4Languages Template' );

    return $templates;
}

add_filter( 'rcp_email_templates', 'ag_rcp_email_templates' );
