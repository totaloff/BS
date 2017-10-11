<?php

# Template Name: Home

?>

<?php get_header(); ?>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div id="page-<?php the_ID(); ?>" class="begin-content general-font-area">
                    <?php the_content(); ?>
                </div>
    <?php endwhile; ?>

    <?php endif; ?>


<?php get_footer(); ?>
