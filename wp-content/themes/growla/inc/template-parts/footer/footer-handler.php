<?php

if ( !class_exists( 'Redux' ) ) {
    $growla_opt = [];
    $growla_opt['meta_footer_select'] = 'default';
} else {
    global $growla_opt;
}

$footer_id = ! empty( $growla_opt['meta_footer_select'] ) ? $growla_opt['meta_footer_select'] : 'default';

// 404 page
if ( is_404() && class_exists( 'Redux' ) ) {
    $footer_id = ( ! empty( $growla_opt['404_page_footer'] ) ) ? $growla_opt['404_page_footer'] : '';
}

// search page
if ( ( is_search() || is_archive() ) && class_exists( 'Redux' ) ) {
    $footer_id = ( ! empty( $growla_opt['search_page_footer'] ) ) ? $growla_opt['search_page_footer'] : 'default';
}

// don't display the footer if the post type is header and footer.
if ( is_singular( 'header' ) || is_singular( 'footer' ) || is_singular( 'elementor_library' ) ) {
    wp_footer();
    return;
}

// default footer
if ( ! empty( $footer_id ) && $footer_id == 'default' ):
    get_template_part( 'inc/template-parts/footer/footer', 'default' );
    get_template_part( 'inc/template-parts/footer/footer', 'mouse-trail' );
    wp_footer();
    return;
endif;

// custom footer
if ( !empty( $footer_id ) ):
    get_template_part( 'inc/template-parts/footer/footer', 'mouse-trail' );
?>
<div class="footer-wrapper" id="footer-wrapper">
    <div id="footer-spacer"></div>
    <div id="footer-content-wrapper" class="footer-content-wrapper">
        <?php
            get_template_part( 
                'inc/template-parts/footer/footer', 
                'custom', 
                [ 'footer_id' => $footer_id ] 
            );
            wp_footer();
        ?>
    </div>
</div>
<?php
    return;
endif;

get_template_part( 'inc/template-parts/footer/footer', 'mouse-trail' );
wp_footer();