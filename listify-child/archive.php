<?php
/**
 * The template for displaying a list of badges.
 *
 *
 *
 * @package Listify Child Theme
 * @since 0.1
 * @version 0.1
 */


$post_type = get_post_type();
$obj = get_post_type_object( $post_type );

$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

// This is a query that permit to retrieve all badges.
$wp_query = new WP_Query(array(
	'post_type'=>'badge',
	'posts_per_page' => 16,
	'paged' => $paged
));

get_header(); ?>

<div class="container container-title">
    <h1><?php echo $obj->labels->singular_name . 's'; ?></h1>
    <hr class="sep-title">
</div>

	<div id="primary" class="container">

        <?php
        if ( $wp_query->have_posts() ) : ?>
            <div class="row">
                <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

	                <?php get_template_part( 'content', 'badge-preview' ); ?>

                <?php endwhile; ?>
            </div>

            <?php wp_reset_postdata(); ?>
            <div class="content-pagination">
	            <?php get_template_part( 'content', 'pagination' ); ?>
            </div>

        <?php else : ?>
            <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
        <?php endif; ?>

	</div>

<?php get_footer(); ?>
