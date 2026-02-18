<?php


/****************************************
enqueue parent stylesheet
****************************************/
function growla_child_enqueue() {
    $parent_handle = 'growla-style';
    $theme = wp_get_theme();
    $version = $theme->get('Version');

    wp_enqueue_style( $parent_handle, get_template_directory_uri() . '/inc/assets/dist/style.css', array(), $version );
    wp_enqueue_style('growla-child-style', get_stylesheet_uri(), array($parent_handle), $version );
}
add_action( 'wp_enqueue_scripts', 'growla_child_enqueue' );