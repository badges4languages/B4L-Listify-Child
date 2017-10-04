<?php
/**
 * The template for displaying pagination for any query, the pagination is a list of numbers that represent the number
 * of pages and all the numbers are link to each page.
 *
 *
 *
 * @package Listify Child Theme
 * @since 0.1
 * @version 0.1
 */


global $wp_query;

if ( $wp_query->max_num_pages == 1 ) {
	return;
}

$big = 999999999;
?>

<div class="content-pagination">
	<?php
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var( 'paged' ) ),
			'total' => $wp_query->max_num_pages,
		) );
	?>
</div>
