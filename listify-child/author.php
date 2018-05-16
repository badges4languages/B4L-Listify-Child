<?php
/**
 * The template for displaying Author pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listify
 */

// Only use this template if we have custom data to load.
if ( ! listify_has_integration( 'wp-job-manager' ) ) {
	return locate_template( array( 'archive.php' ), true );
}

get_header(); ?>
	
	<?php //If a user is logged in, we display his profile
	if( is_user_logged_in() ): ?>
		<div <?php echo apply_filters( 'listify_cover', 'page-cover' ); ?> >
			<div class="page-cover no-image">
			    <div class="page-title cover-wrapper">
			        <div id="profile-page" class="container">

			        	<?php 
			        	//Get the current user
			        	$current_user = wp_get_current_user();
			        	//Get the avatar's url of the user
			        	$urlImg = esc_url( get_avatar_url( $current_user->ID ) );
						?>

				        <!-- User info -->
				        <div class="author-name">
				            <h1>
				            	<!-- First and last name of the user -->
				                <?php the_author_meta( 'first_name' ); ?>&nbsp;<?php the_author_meta( 'last_name' ); ?>
				            </h1>
				        </div>

				        <!-- First section is about the general user info -->
				        <section>
				            <div class="user-info-admin flex-container">
				                <div class="img-user flex-item">
				                	<!-- User's avatar (displayed with the url we get befor) -->
				                    <img class="circle-img" src="<?php echo $urlImg; ?>">
				                </div>
				                <!-- User information -->
				                <div class="username-user center-container flex-item">
				                    <div class="txt-info center-item">
				                        <ul>
				                            <li>
				                                <span class="dashicons dashicons-admin-users"></span>
				                                <!-- The display name (chosen by the user) -->
				                                <?php the_author_meta( 'display_name' ); ?>
				                            </li>
				                            <li>
				                                <span class="dashicons dashicons-calendar"></span>
				                                <!-- Registration date -->
				                                <span> <?php _e( 'Member since','open-badges-framework' ); echo ' ' . date( "d M Y", strtotime( $current_user->user_registered ) ); ?></span>
				                            </li>
				                            <li>
				                                <span class="dashicons dashicons-email-alt"></span>
				                                <!-- Email -->
				                                <?php the_author_meta( 'user_email' ); ?>
				                            </li>
				                            <li>
				                                <span class="dashicons dashicons-admin-tools"></span>
				                                <!-- Profession -->
				                                <?php the_author_meta( 'rcp_profession' ); ?>
				                            </li>
				                            <li>
				                            	<!-- Button linked to the 'Edit profile' page -->
		                                        <div class="btn-update-container">
		                                            <a href="<?php echo get_page_link( 420 ); ?>"
		                                               class="btn btn-secondary"><?php _e( 'Edit your profile','open-badges-framework' ); ?></a>
		                                        </div>
				                            </li>
				                        </ul>
				                    </div>
				                </div>
				            </div>
				        </section>

				        <!-- The second section is about the badges earned by the user -->
				        <?php 
				        // Get the data base info about the user.
				        $userDb = apply_filters('theme_DbUser_get_single', ["idWP" => $current_user->ID] );

				        // If no user match with the current user ID in the data base (security control)
				        if( !$userDb ):
				        	$dbBadges = null;
				        // IF a user match, we get the data base info about the badges he earned
				        else:
				        	$dbBadges = apply_filters('theme_DbBadge_get', ["idUser" => $userDb->id] );
				        endif;

				        ?>
				        <!-- User badges ( earned ones ) -->
				        <section class="user-badges-cont">
				            <div class="user-badges flex-container">
				                <div class="title-badges-cont">
				                    <h3><?php _e('Badges earned','open-badges-framework'); ?> &nbsp;<span class="dashicons dashicons-yes"></span></h3>
				                </div>
				                <?php
				                // If he has at least one badge
				                if ( $dbBadges ) {
				                	// For each badge he earned
				                	foreach ($dbBadges as $dbBadge) {
				                		// If the badge got a date (means that he has been accepted by the user)
				                        if ( $dbBadge->gotDate ) {
				                        	// Check if the badge has a featured image, if not we get the default badge's url
				                        	if( !has_post_thumbnail( $dbBadge->idBadge ) ){
				                        		$url = get_stylesheet_directory_uri() . '/images/default-badge.png';
				                        	// If it has one, we get the thmbnail's url
				                        	} else {
				                        		$url = get_the_post_thumbnail_url( $dbBadge->idBadge );
				                        	}
				                        	?>
				                        	<div class="badge flex-item">
				                        		<!-- Each badge is linked to its single page to get more info about it -->
				                                <a class="wrap-link" href="<?php echo get_post_permalink( $dbBadge->idBadge ); ?>">
				                                <!-- Image of the badge (default or not) -->
				                                <div class="cont-img-badge">
				                                    <img class="circle-img"
				                                         src="<?php echo $url; ?>">
				                                </div>
				                                <!-- Name of the badge -->
				                                <div>
				                                    <span><?php echo get_the_title($dbBadge->idBadge); ?></span>
				                                </div>
				                                </a>
				                            </div>
				                        <?php
				                       	}
				                    }
				                // If the user has no badge we display 'No badges earned'.
				                } else { ?>
				                    <p class='lead'><br/>&nbsp;&nbsp;&nbsp;&nbsp; <?php _e('No badges earned','open-badges-framework');?></p>
									<?php
				                }
				                ?>
				            </div>
				        </section>
			        
			        </div>
			    </div>
			</div>
		</div>
	<?php //If no user is logged in, we display the login form for him to connect.
	else: ?>
		<article id="post-177" class="post-177 page type-page status-publish hentry content-box content-box-wrapper">
			<div class="content-box-inner">
				<div class="entry-content">
					<h2 class="entry-title entry-title--in-cover">You are not logged in. Please log in to access your profile.</h2>
					<?php do_shortcode('[login-form]'); ?>
				</div>
			</div>
			</article>
	<?php endif; ?>

<?php get_footer(); ?>
