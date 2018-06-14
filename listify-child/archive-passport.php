<?php
/**
 * The template for displaying Passport Archive page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listify
 */

global $style;

$blog_style = get_theme_mod( 'content-blog-style', 'default' );
$style      = 'grid-standard' == $blog_style ? 'standard' : 'cover';
$sidebar    = 'none' != esc_attr( listify_theme_mod( 'content-sidebar-position', 'right' ) ) && is_active_sidebar( 'widget-area-sidebar-1' );

get_header(); ?>

	<div <?php echo apply_filters( 'listify_cover', 'page-cover' ); ?>>
		<h1 class="page-title cover-wrapper">Portfolios</h1>
	</div>

	<div id="primary" class="container">
		<div class="row content-area">

			<?php if ( 'left' == esc_attr( listify_theme_mod( 'content-sidebar-position', 'right' ) ) ) : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>

			<main id="main" class="site-main col-xs-12 <?php if ( $sidebar ) : ?> col-sm-7 col-md-8<?php endif; ?>" role="main">

				<?php if ( 'default' != $blog_style ) : ?>
				<div class="blog-archive blog-archive--grid <?php if ( $sidebar ) : ?> blog-archive--has-sidebar<?php endif; ?>" data-columns>
					<?php add_filter( 'excerpt_length', 'listify_short_excerpt_length' ); ?>
				<?php endif; ?>

				<?php
				while ( have_posts() ) :
					the_post();

					//Display only the passports of the current user connected (give access to only his portfolios)
					if( get_the_author_meta('ID') == get_current_user_id() ){
						get_template_part( 'content' );
					}
				endwhile;
				?>

				<?php if ( 'default' != $blog_style ) : ?>
					<?php remove_filter( 'excerpt_length', 'listify_short_excerpt_length' ); ?>
					</div>
				<?php endif; ?>

				<?php
					// Display the pagination template
					get_template_part( 'content', 'pagination' );
				?>

			</main>

		</div>
	</div>

<?php get_footer(); ?>
