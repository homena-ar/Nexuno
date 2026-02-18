<?php
    get_header();
    if ( have_posts() ) {
        while( have_posts() ) {
            the_post();
    ?>
        <div class="growla-elementor-template-wrapper">
            <?php the_content(); ?>
        </div>
    <?php
        }
    }
    get_footer();
?>