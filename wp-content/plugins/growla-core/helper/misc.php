<?php

if ( !function_exists( 'get_growla_headers' ) ) {
    function get_growla_headers() {
        $args = [
            'post_type'     => 'header',
            'numberposts'   => -1,
            'post_status'   => 'publish'
        ];

        $posts = get_posts( $args );

        $result = [];

        foreach ( $posts as $post ) {
            $result[ $post->ID ] = $post->post_title;            
        }

        return $result;
    }
}

if ( !function_exists( 'get_growla_footers' ) ) {
    function get_growla_footers() {
        $args = [
            'post_type'     => 'footer',
            'numberposts'   => -1,
            'post_status'   => 'publish'
        ];

        $posts = get_posts( $args );

        $result = [];

        foreach ( $posts as $post ) {
            $result[ $post->ID ] = $post->post_title;
        }

        return $result;
    }
}

if ( ! function_exists( 'growla_cc_mime_types' ) ) {
	function growla_cc_mime_types( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
}
add_filter( 'upload_mimes', 'growla_cc_mime_types' );