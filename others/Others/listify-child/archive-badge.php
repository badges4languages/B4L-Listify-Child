<?php
/**
 * The template for displaying Badges Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listify
 */

get_header();

$post_type = get_post_type();
$obj = get_post_type_object( $post_type );

?>

	<div <?php echo apply_filters( 'listify_cover', 'page-cover' ); ?>>
		<h1 class="page-title cover-wrapper"><?php echo $obj->labels->singular_name . 's';  ?></h1>
	</div>

	<div id="primary" class="container">
		<div class="row content-area">

			<?php if ( 'left' == esc_attr( listify_theme_mod( 'content-sidebar-position', 'right' ) ) ) : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>

			<main id="main" class="site-main col-md-8 col-sm-7 col-xs-12" role="main">

				<?php if ( have_posts() ) : ?>

					<!-- Checking if there is any post and showing if there is any -->
					<?php while ( have_posts() ) : the_post(); ?>

						<!-- The place holder to show the post in archive page -->
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
							<?php if ( ! is_singular( 'page' ) ) : ?>

							<!-- applying the styles from the listify theme for the backgroud picture -->
							<header class="head" <?php echo apply_filters( 'listify_cover', 'entry-header entry-cover' ); ?>>
								<?php
								// Checing if the post has an image uploaded for the post
								 	if ( ! wp_get_attachment_image_src(get_post_thumbnail_id($post->ID))) : ?>
									<!-- getting the template url for the default image -->
										<style>
											.head {
													background-image: url('<?=get_template_directory_uri()?>/images/default-badge.png')
												}
										</style>
										?>
								<?php endif; ?>

							</header><!-- .entry-header -->
							<?php endif; ?>

							<!-- showing the badge title under the picture -->

							<h1 style="margin-top:-3px" >Badge: <a href="<?php the_permalink(); ?>" rel="bookmark"><?php  the_title(); ?></a></h1>

							<!-- showing the badge post tags -->
							<b><p style="margin-top:-15px">Tags:
							<?php

								// Getting all the tags for the current post
								$tags = get_the_terms( get_the_ID(), 'level' );
								if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {
										foreach ($tags as $tag) {
											?>
											<?php echo $tag->name; ?>
										<?php
										}
								}

							?>
							</p></b>

								<!-- Showing the summary and description for the post -->
								<?php if ( is_singular() ) : ?>
									<div class="entry-content">
										<?php the_content(); ?>
									</div>
								<?php else : ?>

									<div class="entry-summary">
										<?php the_excerpt(); ?>
									</div><!-- .entry-summary -->
								<?php endif; ?>

								<?php wp_link_pages(); ?>



						</article><!-- #post-## --> </br></br>
					<?php endwhile; ?>

					<!-- enabling the pagination for the archive page -->
					<?php get_template_part( 'archivebadge', 'pagination' ); ?>

				<?php else : ?>

					<?php get_template_part( 'archivebadge', 'none' ); ?>

				<?php endif; ?>

			</main>

			<?php if ( 'right' == esc_attr( get_theme_mod( 'content-sidebar-position', 'right' ) ) ) : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>

		</div>
	</div>

<?php get_footer(); ?>
