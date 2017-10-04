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

	<?php wp_head(); ?>
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

		<!--<nav id="site-navigation" class="main-navigation<?php if ( is_front_page() ) : ?> main-navigation--<?php echo get_theme_mod( 'home-header-style', 'default' ); ?><?php endif; ?>">
			<div class="container">
				<a href="#" class="navigation-bar-toggle">
					<i class="ion-navicon-round"></i>
					<span class="mobile-nav-menu-label"><?php echo listify_get_theme_menu_name( 'primary' ); ?></span>
				</a>

				<div class="navigation-bar-wrapper">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'primary',
							'container_class' => 'primary nav-menu',
							'menu_class' => 'primary nav-menu',
						) );

						if ( listify_theme_mod( 'nav-secondary', true ) ) {
							wp_nav_menu( array(
								'theme_location' => 'secondary',
								'container_class' => 'secondary nav-menu',
								'menu_class' => 'secondary nav-menu',
							) );
						}
					?>
				</div>

				<?php if ( 'none' !== get_theme_mod( 'nav-search', 'left' ) ) : ?>
					<a href="#search-navigation" data-toggle="#search-navigation" class="ion-search search-overlay-toggle"></a>

					<div id="search-navigation" class="search-overlay">
						<?php locate_template( array( 'searchform-header.php', 'searchform.php' ), true, false ); ?>

						<a href="#search-navigation" data-toggle="#search-navigation" class="ion-close search-overlay-toggle"></a>
					</div>
				<?php endif; ?>
			</div>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<?php do_action( 'listify_content_before' ); ?>

	<div id="content" class="site-content">
