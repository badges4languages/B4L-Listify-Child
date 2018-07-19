<?php
/**
 * The template for displaying Open Badge Archive page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listify
 */

get_header(); ?>
	
	<!-- For tablets and smartphones, the search form is hidden. A toggle button display the search form. -->
	<div id="primary" class="container little-screen">
		<!-- Toggle button -->
		<button onclick="toggle_filter_form()" class="button button-small" id="filter-button">Search Filter</button>

		<!-- Search form -->
		<div id="filter-form">
			<h1>Badges</h1>
		    <p>Here you can find all the badge that we have available.</p>

		    <?php // Search form created with the Search and filter pluggin.
		    echo do_shortcode('[searchandfilter slug="search-badges"]'); ?>
		</div>
	</div>

	<!-- For laptops and large screens, the search form is always displayed. -->
    <div id="primary" class="container normal-screen">
    	<div class="row content-area">
	        <h1 id="filter-form-title">Badges</h1>
			<p>Here you can find all the badge that we have available.</p>
		    <?php // Search form created with the Search and filter pluggin.
		    echo do_shortcode('[searchandfilter slug="search-badges"]'); ?>
		</div>
    </div>


	<h1 class="page-title cover-wrapper">Badges</h1>

	<div id="primary" class="container badge-archive">
		<div class="row content-area">

			<?php if ( 'left' == esc_attr( listify_theme_mod( 'content-sidebar-position', 'right' ) ) ) : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>

			<main id="main" class="site-main col-xs-12 <?php if ( $sidebar ) : ?> col-sm-7 col-md-8<?php endif; ?>" role="main">

				<?php
				// Checking if there is at least one badge
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						// Display the custom template archive-badge-content.php
						get_template_part( 'templates/archives/archive-badge-content' );
					endwhile;
				// If not, display the custom template archive-badge-none.php
				else :
					get_template_part( 'templates/archives/archive-badge-none' );
				endif;

				// Display the pagination template (if there are more than 5 results)
				get_template_part( 'content', 'pagination' ); ?>

			</main>

		</div>
	</div>

<?php get_footer(); ?>
