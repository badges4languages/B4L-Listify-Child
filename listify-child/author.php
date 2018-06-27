<?php
/**
 * The template for displaying Author page.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Listify
 */

get_header(); 
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>
	
	<?php //If a user is logged in, we display his profile
	if( is_user_logged_in() ): ?>
		<div <?php echo apply_filters( 'listify_cover', 'page-cover' ); ?> >
			<div class="page-cover no-image">
			    <div class="page-title cover-wrapper">
			        <div id="profile-page" class="container">

			        	<?php 
			        	//Get the current user
			        	$current_user = wp_get_current_user();
			        	//Get user data
			        	$user_data = get_userdata( $current_user->ID );
			        	//Get the avatar's url of the user
			        	$urlImg = esc_url( get_avatar_url( $current_user->ID ) );
						?>

				        <!-- User info -->
				        <div class="author-name">
				            <h1>
				            	<!-- If exists, first and last name of the user -->
				                <?php 
				                if( !empty( $current_user->first_name ) && !empty( $current_user->last_name ) ){
				                	echo $current_user->first_name . ' ' . $current_user->last_name;
				                } 
				                //Else, display name
				                else{
				                	echo $current_user->display_name;
				                }?>
				                
				            </h1>
				        </div>

				        <!-- First section is about the general user info -->
				        <section>
				        	<!-- Display for tablets and large screens -->
				            <div class="user-info-admin flex-container profile-large-screen">
				                <div class="img-user flex-item">
				                	<!-- User's avatar (displayed with the url we get befor) -->
				                    <img class="circle-img" src="<?php echo $urlImg; ?>">
				                </div>
				                <!-- User information -->
				                <div class="username-user center-container flex-item">
				                    <div class="txt-info center-item">
				                        <ul>
				                            <li>
				                                <span class="ion-person"></span>
				                                <!-- The display name -->
				                                <?php echo $current_user->display_name; ?>
				                            </li>
				                            <li>
				                                <span class="ion-calendar"></span>
				                                <!-- Registration date -->
				                                <span> <?php _e( 'Member since','open-badges-framework' ); echo ' ' . date( "d M Y", strtotime( $current_user->user_registered ) ); ?></span>
				                            </li>
				                            <li>
				                                <span class="ion-email"></span>
				                                <!-- Email -->
				                                <?php echo $current_user->user_email; ?>
				                            </li>
				                            <li>
				                                <span class="ion-hammer"></span>
				                                <!-- Subscription type -->
				                                <?php
					                                //If Restrict Content Pro plugin is activated, we display the user subscription
				                                    if ( is_plugin_active( 'restrict-content-pro/restrict-content-pro.php' ) ){
				                                        echo rcp_get_subscription( get_queried_object_id() );
				                                    } 
				                                    //If not, we display the WP roles
				                                    else{
				                                        echo implode( ', ', $user_data->roles );
				                                    }
                                    			?>
				                            </li>
				                        </ul>
				                    </div>
				                </div>
				                <div class="username-user center-container flex-item">
				                    <div class="txt-info center-item">
				                        <ul>
				                            <li>
				                            	<!-- Year of birth -->
				                                <span class="ion-information"></span>
				                                <?php 
				                                    if( !empty( get_the_author_meta( 'year_of_birth' ) ) ){
				                                        echo 'Year of birth : ';
				                                        the_author_meta( 'year_of_birth' );
				                                    } else{
				                                        echo 'No year of birth';
				                                    }
				                                ?>
				                            </li>
				                            <li>
				                            	<!-- Country and city -->
				                                <span class="ion-flag"></span>
				                                <?php   
				                                    if( !empty( get_the_author_meta( 'country' ) ) && !empty( get_the_author_meta( 'city' ) ) ){
				                                        the_author_meta( 'country' );
				                                        echo ' - ';
														the_author_meta( 'city' );
				                                    } else if( !empty( get_the_author_meta( 'country' ) ) || !empty( get_the_author_meta( 'city' ) ) ) {
				                                        the_author_meta( 'country' );
														the_author_meta( 'city' );
				                                    } else{
				                                        echo 'No country and city';
				                                    }
				                                ?>
				                            </li>
				                            <li>
				                            	<!-- Mother tongue -->
				                                <span class="ion-chatboxes"></span>
				                                <?php 
				                                    if( !empty( get_the_author_meta( 'mother_tongue' ) ) ){
				                                        echo 'Mother tongue : ';
				                                        the_author_meta( 'mother_tongue' );
				                                    } else{
				                                        echo 'No mother tongue';
				                                    }
				                                ?>
				                            </li>
				                            <li>
				                            	<!-- Degrees -->
				                                <span class="ion-briefcase"></span>
				                                <?php 
				                                	//Primary degree
				                                    if( !empty( get_the_author_meta( 'primary_degree' ) ) ){
				                                        the_author_meta( 'primary_degree' );
				                                        //Secondary degree
					                                    if( !empty( get_the_author_meta( 'secondary_degree' ) ) ){
					                                        echo ' - ';
					                                        the_author_meta( 'secondary_degree' );
					                                    }
					                                    //Tertiary degree
					                                    if( !empty( get_the_author_meta( 'tertiary_degree' ) ) ){
					                                        echo ' - ';
					                                        the_author_meta( 'tertiary_degree' );
					                                    }
				                                    } else{
				                                        echo 'No degree';
				                                    }
				                                ?>
				                            </li>
				                        </ul>
				                    </div>
				                </div>
				            </div>

				            <!-- Display for phone screens -->
				            <div class="user-info-admin flex-container profile-little-screen">
				                <div class="username-user center-container flex-item">
				                    <div class="txt-info center-item">
				                        <ul>
				                            <li>
				                            	<!-- The display name -->
				                                <span class="ion-person"></span>
				                                <?php echo $current_user->display_name; ?>
				                            </li>
				                            <li>
				                            	<!-- Registration date -->
				                                <span class="ion-calendar"></span>
				                                <span> <?php _e( 'Member since','open-badges-framework' ); echo ' ' . date( "d M Y", strtotime( $current_user->user_registered ) ); ?></span>
				                            </li>
				                            <li>
				                            	<!-- Email -->
				                                <span class="ion-email"></span>
				                                <?php echo $current_user->user_email; ?>
				                            </li>
				                            <li>
				                            	<!-- Subscription type -->
				                                <span class="ion-hammer"></span>
				                                <?php
					                                //If Restrict Content Pro plugin is activated, we display the user subscription
				                                    if ( is_plugin_active( 'restrict-content-pro/restrict-content-pro.php' ) ){
				                                        echo rcp_get_subscription( get_queried_object_id() );
				                                    } 
				                                    //If not, we display the WP roles
				                                    else{
				                                        echo implode( ', ', $user_data->roles );
				                                    }
                                    			?>
				                            </li>
				                            <li>
				                            	<!-- Year of birth -->
				                                <span class="ion-information"></span>
				                                <?php 
				                                    if( !empty( get_the_author_meta( 'year_of_birth' ) ) ){
				                                        echo 'Year of birth : ';
				                                        the_author_meta( 'year_of_birth' );
				                                    } else{
				                                        echo 'No year of birth';
				                                    }
				                                ?>
				                            </li>
				                            <li>
				                            	<!-- Country and city -->
				                                <span class="ion-flag"></span>
				                                <?php   
				                                    if( !empty( get_the_author_meta( 'country' ) ) && !empty( get_the_author_meta( 'city' ) ) ){
				                                        the_author_meta( 'country' );
				                                        echo ' - ';
														the_author_meta( 'city' );
				                                    } else if( !empty( get_the_author_meta( 'country' ) ) || !empty( get_the_author_meta( 'city' ) ) ) {
				                                        the_author_meta( 'country' );
														the_author_meta( 'city' );
				                                    } else{
				                                        echo 'No country and city';
				                                    }
				                                ?>
				                            </li>
				                            <li>
				                            	<!-- Mother tongue -->
				                                <span class="ion-chatboxes"></span>
				                                <?php 
				                                    if( !empty( get_the_author_meta( 'mother_tongue' ) ) ){
				                                        echo 'Mother tongue : ';
				                                        the_author_meta( 'mother_tongue' );
				                                    } else{
				                                        echo 'No mother tongue';
				                                    }
				                                ?>
				                            </li>
				                            <li>
				                            	<!-- Degrees -->
				                                <span class="ion-briefcase"></span>
				                                <?php 
				                                	//Primary degree
				                                    if( !empty( get_the_author_meta( 'primary_degree' ) ) ){
				                                        the_author_meta( 'primary_degree' );
				                                        //Secondary degree
					                                    if( !empty( get_the_author_meta( 'secondary_degree' ) ) ){
					                                        echo ' - ';
					                                        the_author_meta( 'secondary_degree' );
					                                    }
					                                    //Tertiary degree
					                                    if( !empty( get_the_author_meta( 'tertiary_degree' ) ) ){
					                                        echo ' - ';
					                                        the_author_meta( 'tertiary_degree' );
					                                    }
				                                    } else{
				                                        echo 'No degree';
				                                    }
				                                ?>
				                            </li>
				                        </ul>
				                    </div>
				                </div>
				            </div>

				            <!-- User Social Links -->
				            <h2 class="social-links-title">Find me on :</h2>
				            <div class="user-info-admin flex-container">
				                <div class="username-user center-container flex-item" style="margin-left: 0px;">
				                    <div class="txt-info center-item" style="margin-left: 0px;">
				                        <ul>
				                            <li>
				                            	<!-- User Web Site -->
				                                <span><img src="<?php echo get_stylesheet_directory_uri() . '/images/Logos/_ionicons_svg_ios-globe.svg'?>" height="17px" width="17px"></span>
				                                <?php 
				                                if( !empty( $user_data->user_url ) ){
				                                    echo '<a href="<?php echo $user_data->user_url; ?>">Website</a>';
				                                } else{
				                                    echo 'No Website';
				                                }
				                                ?>
				                            </li>
				                            <li>
				                            	<!-- Facebook -->
				                                <span><img src="<?php echo get_stylesheet_directory_uri() . '/images/Logos/_ionicons_svg_logo-facebook.svg'?>" height="17px" width="17px"></span>
				                                <?php 
				                                if( !empty( get_the_author_meta( 'facebook' ) ) ){
				                                    echo '<a href="'. get_the_author_meta( 'facebook' ) .'">Facebook</a>';
				                                } else{
				                                    echo 'No Facebook';
				                                }
				                                ?>
				                            </li>
				                            <li>
				                            	<!-- Twitter -->
				                                <span><img src="<?php echo get_stylesheet_directory_uri() . '/images/Logos/_ionicons_svg_logo-twitter.svg'?>" height="17px" width="17px"></span>
				                                <?php 
				                                if( !empty( get_the_author_meta( 'twitter' ) ) ){
				                                    echo '<a href="'. get_the_author_meta( 'twitter' ) .'">Twitter</a>';
				                                } else{
				                                    echo 'No Twitter';
				                                }
				                                ?>
				                            </li>
				                            <li>
				                            	<!-- Google + -->
				                                <span><img src="<?php echo get_stylesheet_directory_uri() . '/images/Logos/_ionicons_svg_logo-googleplus.svg'?>" height="17px" width="17px"></span>
				                                <?php 
				                                if( !empty( get_the_author_meta( 'googleplus' ) ) ){
				                                    echo '<a href="'. get_the_author_meta( 'googleplus' ) .'">Google+</a>';
				                                } else{
				                                    echo 'No Google+';
				                                }
				                                ?>
				                            </li>
				                        </ul>
				                    </div>
				                </div>
				                <div class="username-user center-container flex-item" style="margin-left: 0px;">
				                    <div class="txt-info center-item" style="margin-left: 0px;">
				                        <ul>
				                            <li>
				                            	<!-- Pinterest -->
				                                <span><img src="<?php echo get_stylesheet_directory_uri() . '/images/Logos/_ionicons_svg_logo-pinterest.svg'?>" height="17px" width="17px"></span>
				                                <?php 
				                                if( !empty( get_the_author_meta( 'pinterest' ) ) ){
				                                    echo '<a href="'. get_the_author_meta( 'pinterest' ) .'">Pinterest</a>';
				                                } else{
				                                    echo 'No Pinterest';
				                                }
				                                ?>
				                            </li>
				                            <li>
				                            	<!-- LinkedIn -->
				                                <span><img src="<?php echo get_stylesheet_directory_uri() . '/images/Logos/_ionicons_svg_logo-linkedin.svg'?>" height="17px" width="17px"></span>
				                                <?php 
				                                if( !empty( get_the_author_meta( 'linkedin' ) ) ){
				                                    echo '<a href="'. get_the_author_meta( 'linkedin' ) .'">LinkedIn</a>';
				                                } else{
				                                    echo 'No LinkedIn';
				                                }
				                                ?>
				                            </li>
				                            <li>
				                            	<!-- GitHub -->
				                                <span><img src="<?php echo get_stylesheet_directory_uri() . '/images/Logos/_ionicons_svg_logo-github.svg'?>" height="17px" width="17px"></span>
				                                <?php 
				                                if( !empty( get_the_author_meta( 'github' ) ) ){
				                                    echo '<a href="'. get_the_author_meta( 'github' ) .'">GitHub</a>';
				                                } else{
				                                    echo 'No GitHub';
				                                }
				                                ?>
				                            </li>
				                            <li>
				                            	<!-- Instagram -->
				                                <span><img src="<?php echo get_stylesheet_directory_uri() . '/images/Logos/_ionicons_svg_logo-instagram.svg'?>" height="17px" width="17px"></span>
				                                <?php 
				                                if( !empty( get_the_author_meta( 'instagram' ) ) ){
				                                    echo '<a href="'. get_the_author_meta( 'instagram' ) .'">Instagram</a>';
				                                } else{
				                                    echo 'No Instagram';
				                                }
				                                ?>
				                            </li>
				                        </ul>
				                    </div>
				                </div>
				            </div>
				            <!-- Button linked to the 'Edit profile' page -->
				            <?php
				            	if( is_plugin_active( 'restrict-content-pro/restrict-content-pro.php' ) ){
				            ?>
	                            <div class="btn-update-container">
	                            	<?php if ( esc_url( get_permalink( $rcp_options['edit_profile'] ) ) ){ ?>
	                                	<a href="<?php echo esc_url(get_permalink($rcp_options['edit_profile'])); ?>" class="btn btn-secondary"><?php _e( 'Edit your profile','open-badges-framework' ); ?></a>
	                                <?php } ?>
	                            </div>
	                        <?php } ?>
				        </section>

				        <!-- Second section is about the badges earned by the user -->
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
				                        		$url = get_the_post_thumbnail_url( $dbBadge->idBadge, 'thumbnail' );
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
				                                    <span><?php echo get_the_title( $dbBadge->idBadge ); ?></span>
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

		<?php
		//Retrieve the information of the kind of subscription of the user (author).
		if ( is_plugin_active( 'restrict-content-pro/restrict-content-pro.php' ) && is_plugin_active( 'wp-job-manager/wp-job-manager.php' ) ){
			$subscription = rcp_get_subscription( get_queried_object_id() );

			if ($subscription == "Teacher") {
			    ?>
			    <!-- Display the classes of the user if he is a teacher -->
			    <div class="title-lst">
			        <div class="container">
			            <h2>Some infomation</h2>
			            <hr class="sep-testo-down">
			        </div>
			    </div>
			    <div class="container listings-user">
			        <div class="row">
			        	<!-- Remove comment to have links to get directly to the active/historic classes of the teacher. -->
			            <!-- <div class="col-3">
			                <div class="nav flex-column list-column nav-pills" id="v-pills-tab" role="tablist">
			                    <a class="nav-list active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-act-classes"
			                       role="tab" aria-controls="v-pills-act-classes" aria-expanded="true">
			                        Active classes
			                    </a>
			                    <a class="nav-list" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-hist-classes" role="tab"
			                       aria-controls="v-pills-act-classes" aria-expanded="true">
			                        Historic classes
			                    </a>
			                </div>
			            </div> -->
			            <div class="col-9">
			                <div class="tab-content" id="v-pills-tabContent">
			                    <div class="tab-pane fade show active" id="v-pills-act-classes" role="tabpanel"
			                         aria-labelledby="v-pills-home-tab">
			                        <?php

			                        $teacher_classes = get_posts( array(
								        'author'      => $current_user->ID,
								        'post_type'   => 'job_listing',
								        'numberposts' => -1
									) );

									if( !empty( $teacher_classes ) ) {
										$none = the_widget('Listify_Widget_Author_Listings',
				                            array(
				                                'title' => 'List of the active classes',
				                                'per_page' => 1000
				                            )
				                        );
									} else {
										echo "<p class=\"lead\">You don't have any class for now.</p>";
									}

			                        ?>
			                    </div>
			                    <div class="tab-pane fade" id="v-pills-hist-classes" role="tabpanel"
			                         aria-labelledby="v-pills-profile-tab">
			                        <div class="container">
			                            <h4 class="">Coming soon</h4>
			                            <p class="lead">This information will be available soon.</p>
			                        </div>
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div>
			    <?php
			}
		}
		?>


	<?php //If no user is logged in, we display the login form for him to connect.
	else: ?>
		<article id="post-177" class="post-177 page type-page status-publish hentry content-box content-box-wrapper">
			<div class="content-box-inner">
				<div class="entry-content">
					<h2 class="entry-title entry-title--in-cover">You are not logged in. Please log in to access your profile.</h2>
					<?php do_shortcode( '[login-form]' ); ?>
				</div>
			</div>
			</article>
	<?php endif; ?>

<?php get_footer(); ?>
