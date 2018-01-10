<?php
/**
 * The Header for our child theme.
 * Displays all of the <head> section and everything up till <div id="content">
 *
 *
 *
 * @package Listify Child Theme
 * @since 0.1
 * @version 0.1
 */

$current_user = wp_get_current_user();

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

	<?php wp_head(); ?>
    <script type="text/javascript">
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>"; //Important: It useful for the file code.js that do an Ajax call and need the path of that specific file
    </script>
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site">

	<header id="masthead" class="site-header<?php if ( is_front_page() ) :?> site-header--<?php echo get_theme_mod( 'home-header-style', 'default' ); ?><?php endif; ?>">
		<div class="primary-header">
			<div class="container">
				<div class="primary-header-inner">
					<div class="site-branding">
						<?php echo listify_partial_site_branding(); ?>
					</div>
                    <div class="primary nav-menu">
						<?php
						wp_nav_menu( array(
							'theme_location' => 'primary',
							'container_class' => 'nav-menu-container',
						) );

						?>

                    </div>

                    <?php // User menu access
                    if($current_user->user_login != ""){ ?>
                        <div class="user-menu">
                            <a href="<?php echo site_url() . "/author/" . $current_user->user_login; ?>">
			                    <?php echo get_avatar( $current_user->ID ); ?>
                                <span><?php echo $current_user->user_login; ?></span>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
				</div>

				<?php if ( get_theme_mod( 'nav-search', true ) ) : ?>
				<div id="search-header" class="search-overlay">
					<div class="container">
						<?php locate_template( array( 'searchform-header.php', 'searchform.php' ), true, false ); ?>
						<a href="#search-header" data-toggle="#search-header" class="ion-close search-overlay-toggle"></a>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</header><!-- #masthead -->

	<?php do_action( 'listify_content_before' ); ?>

	<div id="content" class="site-content">

