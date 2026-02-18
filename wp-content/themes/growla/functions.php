<?php
/**
 * growla functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package growla
 */

/**
 * General hooks for this theme.
 */
require get_template_directory() . '/inc/misc/general-hooks.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/misc/template-functions.php';

/**
 * Comments utilities
 */
require get_template_directory() . '/inc/misc/comments-util.php';

/**
 * elementor widgets.
 */
require get_template_directory() . '/inc/elementor-widgets/class-growla-elementor-widget-loader.php';

/**
 * installation
 */
require get_template_directory() . '/inc/installation/install-init.php';

/**
 * project ajax
 */
require get_template_directory() . '/inc/misc/project-ajax.php';

/**
 * CF7 hooks for this theme.
 */
require get_template_directory() . '/inc/misc/cf7-hooks.php';