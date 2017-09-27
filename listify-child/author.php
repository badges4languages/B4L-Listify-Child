<?php
/**
 * The template for displaying Author pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listify child
 */

// Only use this template if we have custom data to load.
if ( ! listify_has_integration( 'wp-job-manager' ) ) {
	return locate_template( array( 'archive.php' ), true );
}


echo '<link href="/css/style.css" rel="stylesheet">';

$sidebar_args = array(
	'before_widget' => '<aside class="widget widget--author widget--author-sidebar">',
	'after_widget'  => '</aside>',
	'before_title'  => '<h3 class="widget-title widget-title--author widget--author-sidebar %s">',
	'after_title'   => '</h3>',
);


get_header(); ?>

	<div <?php echo apply_filters( 'listify_cover', 'page-cover' ); ?>>
		<div class="author-title page-title cover-wrapper">
			<div id="profile-page" class="container">
				<div class="author-name">
					<?php //echo get_avatar( get_queried_object_id(), 150 ); ?>
					<h1><?php echo $current_user->user_firstname; ?>&nbsp;<?php echo $current_user->user_lastname; ?></h1>
				</div>
				<div class="user-info">
					<?php echo get_avatar( get_queried_object_id(), 150 ); ?>
					<ul  style="list-style: none;">
							<li style="float:left; font-size:50%">
								<span class="dashicons dashicons-admin-users"></span>
								<?php echo $current_user->user_login; ?></br>
							</li>
							<li style="clear:left; float:left; font-size:50%">
								<span class="dashicons dashicons-admin-users"></span>
								<?php echo $current_user->user_firstname; ?></br>
							</li>
							<li style="clear:left; float:left; font-size:50%">
								<span class="dashicons dashicons-admin-users"></span>
								<?php echo $current_user->user_lastname; ?></br>
							</li>
						</ul>
				</div>

				<!-- <div class="author-body" style="clear:left; float:left; margin-right:20%; min-height: 60%;">
						</br>
						<?php
							global $current_user;
	      			get_currentuserinfo();
							?>
						<ul  style="list-style: none;">
								<li style="float:left; font-size:50%">
	                <span class="dashicons dashicons-admin-users"></span>
	                <?php echo $current_user->user_login; ?></br>
	              </li>
								<li style="clear:left; float:left; font-size:50%">
	                <span class="dashicons dashicons-admin-users"></span>
	                <?php echo $current_user->user_firstname; ?></br>
	              </li>
								<li style="clear:left; float:left; font-size:50%">
	                <span class="dashicons dashicons-admin-users"></span>
	                <?php echo $current_user->user_lastname; ?></br>
	              </li>
								<li style="clear:left; float:left; font-size:50%">
	                <span class="dashicons dashicons-calendar"></span>
									<?php echo 'Member since <strong>'.date('F jS, Y', strtotime($current_user->user_registered)).'</strong>';?></br>
								</li>
								<?php if($current_user->user_email){ ?>
								<li style="clear:left; float:left; font-size:50%">
									<span class="dashicons dashicons-format-chat"></span>
									<?php echo $current_user->user_email; ?></br>
								</li>
								<?php } ?>
								<?php if(the_author_meta( 'rcp_mother_tongue')){ ?>
								<li style="clear:left; float:left; font-size:50%">
									<span class="dashicons dashicons-format-chat"></span>
									<?php the_author_meta( 'rcp_mother_tongue' ); ?></br>
								</li>
								<?php } ?>
								<?php if(the_author_meta( 'rcp_university')){ ?>
								<li style="clear:left; float:left; font-size:50%">
									<span class="dashicons dashicons-format-chat"></span>
									<?php the_author_meta( 'rcp_university'); ?></br>
								</li>
								<?php } ?>
								<?php if(the_author_meta( 'rcp_other_education')){ ?>
								<li style="clear:left; float:left; font-size:50%">
									<span class="dashicons dashicons-format-chat"></span>
									<?php the_author_meta('rcp_other_education'); ?></br>
								</li>
								<?php } ?>
								<?php if(the_author_meta( 'rcp_profession')){ ?>
								<li style="clear:left; float:left; font-size:50%">
									<span class="dashicons dashicons-format-chat"></span>
									<?php the_author_meta( 'rcp_profession'); ?></br>
								</li>
								<?php } ?>
								<?php if(the_author_meta( 'rcp_location')){ ?>
								<li style="clear:left; float:left; font-size:50%">
									<span class="dashicons dashicons-format-chat"></span>
									<?php the_author_meta( 'rcp_location'); ?></br>
								</li>
								<?php } ?>
								<?php if(the_author_meta( 'user_url')){ ?>
								<li style="clear:left; float:left; font-size:50%">
									<span class="dashicons dashicons-admin-links"></span>
									<a href="<?php the_author_meta( 'user_url' ); ?>">My personnal website</a></br>
								</li>
								<?php } ?>
						</br>
						</ul>
					 <p style="clear:left; float:left; margin-left:20px; font-size:60%">Find me on : &nbsp;</p>

							<a style="float:left;"href="https://twitter.com/share?url=https://simplesharebuttons.com&amp;text=Simple%20Share%20Buttons&amp;hashtags=simplesharebuttons" target="_blank">
									<span class="dashicons dashicons-twitter"></span>
								</a>

							<a style="float:left;"href="http://www.facebook.com/sharer.php?u=https://simplesharebuttons.com" target="_blank">
									<span class="dashicons dashicons-facebook"></span>
							</a>
				</div>
				</br> -->

				<!-- **********BADGES******************BADGES************BADGES*****************BADGES
				<?php  //function current_user_badges( $user ) {
					$allbadges = get_all_badges();
				  $currentbadges = get_the_author_meta( 'user_badges', $current_user->ID );

					if(empty($currentbadges)) {
					?>
						<div class="badges_profil">
								<img src="  <?php echo get_template_directory_uri();?>/images/default-badge-thumbnail.png">
						</div>
					<?php
					$badge_counter = 0;
					}
					else {
						foreach ($currentbadges as $currentbadge):
							foreach ($allbadges as $badge):
									 if ($currentbadge['name']==$badge->post_title):
										 ?>
				              <div class="badges_profil" style="float:left;padding:10px;">
													<img src="<?php echo get_the_post_thumbnail_url($badge->ID, 'thumbnail'); ?>" width="150px" height="150px">
											</div>
											<?php
										if($badge_counter%6 == 0):
											echo '</br>';
											endif;
									  endif;
								 endforeach;
								 $badge_counter++;
						 endforeach;
					}
				?>

				<p class="author-meta" style="clear:both">
					</br></br></br>
					<?php do_action( 'listify_author_meta' ); ?>
				</p>
			-->
	 </div>
 </div>
 </div>

	<div id="primary" class="container">
		<div class="row content-area">

			<main id="main" class="site-main col-md-8 col-sm-7 col-xs-12" role="main">

				<?php if ( ! dynamic_sidebar( 'widget-area-author-main' ) ) : ?>

					<?php
						the_widget(
							'Listify_Widget_Author_Biography',
							array(
								'title' => 'Biography',
								'icon' => 'ion-person',
							),
							$sidebar_args
						);

						the_widget(
							'Listify_Widget_Author_Listings',
							array(),
							wp_parse_args(
								array(
									'before_widget' => '<aside class="widget widget--author widget--author-main listify_widget_author_listings">',
								),
								$sidebar_args
							)
						);

					if ( listify_has_integration( 'astoundify-favorites' ) ) {
						the_widget(
							'Listify_Widget_Author_Favorites',
							array(),
							wp_parse_args(
								array(
								'before_widget' => '<aside class="widget widget--author widget--author-main listify_widget_author_favorites">',
								),
								$sidebar_args
							)
						);
					}
					?>

				<?php endif; ?>

			</main>

			<div id="secondary" class="widget-area col-md-4 col-sm-5 col-xs-12" role="complementary">

				<?php if ( ! dynamic_sidebar( 'widget-area-author-sidebar' ) ) : ?>

					<?php
						the_widget(
							'WP_Widget_Recent_Posts',
							array(
								'title' => 'Recent Posts',
							),
							$sidebar_args
						);

					if ( listify_has_integration( 'woocommerce' ) ) {
						the_widget(
							'Listify_Widget_Listing_Social_Profiles',
							array(
							'title' => 'Social Profiles',
							),
							$sidebar_args
						);
					}
					?>

				<?php endif; ?>

			</div><!-- #secondary -->

		</div>
	</div>

<?php get_footer(); ?>
