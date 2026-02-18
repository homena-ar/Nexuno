<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package growla
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function growla_body_classes( $classes ) {
	global $growla_opt;

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'growla_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function growla_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'growla_pingback_header' );

if ( !function_exists( 'get_redux_field' ) ) {
	function get_redux_field( $field, $default ) {
		if ( !class_exists( 'Redux' ) ) {
			return $default;
		}

		global $growla_opt;
		
		if ( isset( $growla_opt[$field] ) ) {
			return $growla_opt[$field];
		} else {
			return $default;
		}
	}
}

if ( ! function_exists( 'growla_get_page_query' ) ) {
	function growla_get_page_query() {
		if ( get_query_var('paged') ) {
			return get_query_var('paged');
		} elseif ( get_query_var('page') ) {
			return get_query_var('page');
		} else {
			return 1;
		}
	}
}

if ( ! function_exists('growla_truncate_title') ) {
	function growla_truncate_title( $title, $id ) {
		if ( is_single( $id ) )
			return $title;
		
		$max = 51;
		if( strlen( $title ) > $max ) {
			return substr( $title, 0, $max ). " ...";
		} else {
			return $title;
		}
	}
}
add_filter( 'the_title', 'growla_truncate_title', 10, 2 );


if ( ! function_exists( 'growla_build_background_properties' ) ) {
    function growla_build_background_properties( $field ) {
        if ( empty( $field ) || ! is_array( $field ) ) {
            return '';
        }

        $result = '';

        foreach ($field as $key => $value) {
            // Check if the value is a non-empty string
            if ( !is_string($value) || empty( $value )) {
                continue;
            }

            if ( $key === 'background-image' ) {
                $value = 'url(\'' . $value . '\')';
            }

            // Concatenate key and value with the specified separator
            $result .= $key . ':' . $value . ';';
        }

        return $result;
    }
}