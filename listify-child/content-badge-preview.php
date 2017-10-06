<?php
/**
 * The template for displaying the preview of each badges.
 *
 *
 *
 * @package Listify Child Theme
 * @since 0.1
 * @version 0.1
 */


?>

<div class="col-md-3 col-sm-4  badge-preview">
    <div class="badge-preview-in">
        <a href="<?php the_permalink(); ?>">
            <div class="bp-logo">
				<?php the_post_thumbnail('thumbnail'); ?>
            </div>
            <hr class="sep-badge-previw">
            <div class="bp-title">
				<?php the_title(); ?>
            </div>
        </a>
    </div>
</div>