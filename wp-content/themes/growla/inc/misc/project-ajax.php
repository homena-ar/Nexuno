<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'growla_projects_load_more' ) ) {
    function growla_projects_load_more() {
        $nonce_check = check_ajax_referer( 'projects-load-more', 'security' );
        if ( ! $nonce_check ) exit;

        $offset = $_POST['offset'];

        $args = [
			'post_type'      => 'project',
			'post_status'    => 'publish',
			'posts_per_page' => '4',
			'orderby'	 => 'date',
			'order'	 	 => 'DESC',
			'offset'	 => $offset,
		];

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                get_template_part( 
                    '/inc/template-parts/content', 
                    'project' 
                );
                echo esc_html( '--splitter--' );
            }
            wp_reset_postdata();
        }

        exit;
    }
}
add_action( 'wp_ajax_growla_projects_load_more', 'growla_projects_load_more' );
add_action( 'wp_ajax_nopriv_growla_projects_load_more', 'growla_projects_load_more' );