<?php
/*
 * Template Name: List Badges
 */

/**
 * The template for displaying a list of badges.
 *
 *
 *
 * @package Listify Child Theme
 * @since   0.1
 * @version 0.1
 */


$post_type = get_post_type();
$obj = get_post_type_object($post_type);

get_header(); ?>

<div class="">
    <div class="jumbotron jumbotron-fluid search-badges-container">
        <div class="container">
            <h1 class="display-3">Badges</h1>
            <p class="lead">Here you can find all the badge that we have available.</p>
            <hr class="sep-testo-down">

            <div class="form-row">
                <!-- #### Keep out the comment to add the Certification filter and modify the ajax call in the file /js/code.js -->
                <!--<div class="col-auto">
                    <label class="mr-sm-2" for="inlineFormCustomSelect">Certification</label>
                    <select class="custom-select mb-2 mr-sm-2 mb-sm-0 form-control-fix" id="inlineFormCustomSelect">
                        <option value="0">Select</option>
                        <option value="1">Certified</option>
                        <option value="2">Not Certified</option>
                    </select>
                </div>-->
                <div class="col-auto">
                    <label class="mr-sm-2" for="inlineFormCustomSelect">Target</label>
                    <select class="custom-select mb-2 mr-sm-2 mb-sm-0 form-control-fix" id="target-selection">
                        <option value="1">Student</option>
                        <option value="2">Teacher</option>
                    </select>
                </div>
                <div class="col-auto">
                    <label class="mr-sm-2" for="inlineFormCustomSelect">Level</label>
                    <select class="custom-select mb-2 mr-sm-2 mb-sm-0 form-control-fix" id="target-level">
                        <?php
                        $values = get_terms('level');
                        $count = 0;
                        echo "<option value='$count'>Select</option>";
                        foreach ($values as $value) {
                            $count++;
                            echo "<option value='$count'>$value->name</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- #### Keep out the comment to add the Search filter and modify the ajax call in the file /js/code.js -->
                <!--<div class="form-group col-md-6">
                    <label for="inputCity" class="col-form-label">Search by writing</label>
                    <input type="email" class="form-control" id="inputEmail4" placeholder="">
                </div>-->
                <div class="col-auto">
                    <!-- This button call a function in the file /js/code.js to permit to do an ajax call and retrive
                    the information about the badges. -->
                    <button class="btn btn-primary" onclick="searchBadges()">Search</button>
                </div>
            </div>
        </div>
    </div>

    <div id="show-search-badge" class="container">
        <?php
        $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;

        // This is a query that permit to retrieve all badges.
        $wp_query = new WP_Query(array(
            'post_type' => 'open-badge',
            'orderby' => 'name',
            'order' => 'ASC',
            'posts_per_page' => 16,
            'paged' => $paged
        ));

        if ($wp_query->have_posts()) : ?>
            <div class="row">
                <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

                    <?php get_template_part('content', 'badge-preview'); ?>

                <?php endwhile; ?>
            </div>

            <?php wp_reset_postdata(); ?>
            <div class="content-pagination">
                <?php get_template_part('content', 'pagination'); ?>
            </div>

        <?php else : ?>
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
        <?php endif; ?>

    </div>

</div>


<?php get_footer(); ?>
