<?php
/**
 * The template for displaying the preview of a badge in the list of the all badges.
 *
 *
 * @package Listify
 */
?>

<div class="col-md-3 col-sm-4  badge-preview">
    <div class="badge-preview-in">
        <a href="<?php the_permalink(); ?>">
            <div class="bp-logo">
                <img src="">
				<?php the_post_thumbnail('thumbnail'); ?>
            </div>
            <hr class="sep-badge-previw">
            <div class="bp-title">
				<?php the_title(); ?>
            </div>
        </a>
    </div>
</div>