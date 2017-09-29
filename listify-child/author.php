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



$sidebar_args = array(
	'before_widget' => '<aside class="widget widget--author widget--author-sidebar">',
	'after_widget'  => '</aside>',
	'before_title'  => '<h3 class="widget-title widget-title--author widget--author-sidebar %s">',
	'after_title'   => '</h3>',
);

$user_info = get_userdata(get_queried_object_id());

get_header(); ?>

	<div <?php echo apply_filters( 'listify_cover', 'page-cover' ); ?>>
		<div class="author-title page-title cover-wrapper">
			<div id="profile-page" class="container">
				<div class="user-info">
					<div class="author-name">
                        <h1 class="">
	                        <?php echo $user_info->first_name; ?>&nbsp;<?php echo $user_info->last_name; ?>
                        </h1>
					</div>
					<div class="img-info">
						<?php echo get_avatar( get_queried_object_id(), 200 ); ?>
					</div>
					<div class="txt-info">
						<ul>
                            <li>
                                <span class="dashicons dashicons-admin-users"></span>
                                <?php echo $user_info->nickname; ?>
                            </li>
                            <li >
                            <span class="dashicons dashicons-calendar"></span>
                                <?php echo 'Member since <strong>'.date('F jS, Y', strtotime($user_info->user_registered)).'</strong>';?></br>
                            </li>
                            <li>
                                <span class="dashicons dashicons-email-alt"></span>
								<?php echo $user_info->user_email; ?>
                            </li>
                            <li>
                                <span class="dashicons dashicons-admin-tools"></span>
								<?php echo get_usermeta(get_queried_object_id(), 'rcp_profession'); ?>
                            </li>
							</ul>
						</div>
				</div>




				<!-- ********************
				        BADGES
				     ******************** -->

                <div class="user-badges">
                    <div class="badge-title">
                        <h3>Badges</h3>
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">

                    <?php  //function current_user_badges( $user ) {
                        $allbadges = get_all_badges();
                        $currentbadges = get_the_author_meta( 'user_badges', get_queried_object_id() );

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
                                             <div class="badges_profil col-2 " >
                                                 <img src="<?php echo get_the_post_thumbnail_url($badge->ID, 'thumbnail'); ?>">
                                             </div>
                                             <?php
                                          endif;
                                     endforeach;
                                     $badge_counter++;
                             endforeach;
                        }
                    ?>
                        </div>
                    </div>
			    </div>
            </div>
        </div>
    </div>

    <!--
    **************************************
        CLASSES
	**************************************
	-->

    <?php
        $permission = 0;
        foreach ($user_info->roles as $role){
	        if($role == 'teacher'){
		        $permission = 1;

            }
        }
        if($permission){
	?>
        <div class="container listings-user" >
            <div class="row">
                <div class="col-3">
                    <div class="nav flex-column list-column nav-pills" id="v-pills-tab" role="tablist">
                        <a class="nav-list active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-act-classes" role="tab" aria-controls="v-pills-act-classes" aria-expanded="true">
                            Active classes <!--<span style="float: right;" class="badge badge-dark">5</span>-->
                        </a>
                        <a class="nav-list" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-hist-classes" role="tab" aria-controls="v-pills-act-classes" aria-expanded="true">
                            Historic classes <!--<span style="float: right;" class="badge badge-dark">1</span>-->
                        </a>
                    </div>
                </div>
                <div class="col-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-act-classes" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <?php

                                $none = the_widget('Listify_Widget_Author_Listings',
                                    array(
                                            'title' => 'List of the active classes',
                                        'per_page' => 1000
                                    )
                                );

                            ?>
                        </div>
                        <div class="tab-pane fade" id="v-pills-hist-classes" role="tabpanel" aria-labelledby="v-pills-profile-tab">
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
    ?>

<?php get_footer(); ?>
