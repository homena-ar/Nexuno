<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://devs.redux.io/
 *
 * @package Redux Framework
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Redux' ) ) {
	return;
}

$opt_name = 'growla_opt';

// Uncomment to disable demo mode.
Redux::disable_demo();

$dir = dirname( __FILE__ ) . DIRECTORY_SEPARATOR;


// Used to except HTML tags in description arguments where esc_html would remove.
$kses_exceptions = array(
	'a'      => array(
		'href' => array(),
	),
	'strong' => array(),
	'br'     => array(),
	'code'   => array(),
);

/*
 * ---> BEGIN ARGUMENTS
 */

/**
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://devs.redux.io/core/arguments/
 */
$theme = wp_get_theme(); // For use with some settings. Not necessary.

// TYPICAL -> Change these values as you need/desire.
$args = array(
	// This is where your data is stored in the database and also becomes your global variable name.
	'opt_name'                  => $opt_name,

	// Name that appears at the top of your panel.
	'display_name'              => $theme->get( 'Name' ),

	// Version that appears at the top of your panel.
	'display_version'           => $theme->get( 'Version' ),

	// Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only).
	'menu_type'                 => 'menu',

	// Show the sections below the admin menu item or not.
	'allow_sub_menu'            => true,

	// The text to appear in the admin menu.
	'menu_title'                => esc_html__( 'Growla Options', 'growla-core' ),

	// The text to appear on the page title.
	'page_title'                => esc_html__( 'Growla Options', 'growla-core' ),

	// Disable to create your own Google fonts loader.
	'disable_google_fonts_link' => false,

	// Show the panel pages on the admin bar.
	'admin_bar'                 => true,

	// Icon for the admin bar menu.
	'admin_bar_icon'            => 'dashicons-portfolio',

	// Priority for the admin bar menu.
	'admin_bar_priority'        => 100,

	// Sets a different name for your global variable other than the opt_name.
	'global_variable'           => $opt_name,

	// Show the time the page took to load, etc. (forced on while on localhost or when WP_DEBUG is enabled).
	'dev_mode'                  => false,

	// Enable basic customizer support.
	'customizer'                => false,

	// Allow the panel to open expanded.
	'open_expanded'             => false,

	// Disable the save warning when a user changes a field.
	'disable_save_warn'         => false,

	// Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	'page_priority'             => 99,

	// For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters.
	'page_parent'               => 'themes.php',

	// Permissions needed to access the options panel.
	'page_permissions'          => 'manage_options',

	// Specify a custom URL to an icon.
	'menu_icon'                 => '',

	// Force your panel to always open to a specific tab (by id).
	'last_tab'                  => '',

	// Icon displayed in the admin panel next to your menu_title.
	'page_icon'                 => 'icon-themes',

	// Page slug used to denote the panel, will be based off page title, then menu title, then opt_name if not provided.
	'page_slug'                 => $opt_name,

	// On load save the defaults to DB before user clicks save.
	'save_defaults'             => true,

	// Display the default value next to each field when not set to the default value.
	'default_show'              => false,

	// What to print by the field's title if the value shown is default.
	'default_mark'              => '*',

	// Shows the Import/Export panel when not used as a field.
	'show_import_export'        => true,

	// The time transients will expire when the 'database' arg is set.
	'transient_time'            => 60 * MINUTE_IN_SECONDS,

	// Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output.
	'output'                    => true,

	// Allows dynamic CSS to be generated for customizer and google fonts,
	// but stops the dynamic CSS from going to the page head.
	'output_tag'                => true,

	// Disable the footer credit of Redux. Please leave if you can help it.
	'footer_credit'             => '',

	// If you prefer not to use the CDN for ACE Editor.
	// You may download the Redux Vendor Support plugin to run locally or embed it in your code.
	'use_cdn'                   => true,

	// Set the theme of the option panel.  Use 'wp' to use a more modern style, default is classic.
	'admin_theme'               => 'wp',

	// Enable or disable flyout menus when hovering over a menu with submenus.
	'flyout_submenus'           => true,

	// Mode to display fonts (auto|block|swap|fallback|optional)
	// See: https://developer.mozilla.org/en-US/docs/Web/CSS/@font-face/font-display.
	// 'font_display'              => 'swap',
	'show_options_object'		=> false,
	// HINTS.
	'hints'                     => array(
		'icon'          => 'el el-question-sign',
		'icon_position' => 'right',
		'icon_color'    => 'lightgray',
		'icon_size'     => 'normal',
		'tip_style'     => array(
			'color'   => 'red',
			'shadow'  => true,
			'rounded' => false,
			'style'   => '',
		),
		'tip_position'  => array(
			'my' => 'top left',
			'at' => 'bottom right',
		),
		'tip_effect'    => array(
			'show' => array(
				'effect'   => 'slide',
				'duration' => '500',
				'event'    => 'mouseover',
			),
			'hide' => array(
				'effect'   => 'slide',
				'duration' => '500',
				'event'    => 'click mouseleave',
			),
		),
	),

	// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
	// possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
	'database'                  => '',
	'network_admin'             => true,
	'search'                    => true,
);

Redux::set_args( $opt_name, $args );

/*
 * ---> END ARGUMENTS
 */

/*
 * ---> START SECTIONS
 */

// -> START Basic Fields

require_once( plugin_dir_path( __FILE__ ) . 'fields/general-fields.php' );
require_once( plugin_dir_path( __FILE__ ) . 'fields/blog-fields.php' );
require_once( plugin_dir_path( __FILE__ ) . 'fields/project-fields.php' );
require_once( plugin_dir_path( __FILE__ ) . 'fields/404-fields.php' );
require_once( plugin_dir_path( __FILE__ ) . 'fields/search-fields.php' );

Redux::set_section(
	$opt_name,
	array(
		'title'            => esc_html__( 'General', 'growla-core' ),
		'id'               => 'growla_config_general',
		'desc'             => esc_html__( 'Customize general settings', 'growla-core' ),
		'customizer_width' => '400px',
		'icon'             => 'el el-home',
		'fields'           => growla_general_fields()
	)
);

// Redux::set_section(
// 	$opt_name,
// 	array(
// 		'title'            => esc_html__( 'Header', 'growla-core' ),
// 		'id'               => 'growla_config_header',
// 		'desc'             => esc_html__( 'Customize and Select headers', 'growla-core' ),
// 		'customizer_width' => '400px',
// 		'icon'             => 'el el-home',
// 		'fields'           => array(
//             array(
//                 'title'    => __( 'Sticky navigation', 'growla-core' ),
//                 'subtitle'     => __( 'If enabled, navigation will stick to the top when scrolled.', 'growla-core' ),
//                 'id'       => 'navigation_menu_sticky',
//                 'type'     => 'switch',
//                 'default'  => true
//             ),
// 		)
// 	)
// );

Redux::set_section(
	$opt_name,
	array(
		'title'            => esc_html__( 'Blog', 'growla-core' ),
		'id'               => 'growla_config_blog',
		'desc'             => esc_html__( 'Customize blog details', 'growla-core' ),
		'customizer_width' => '400px',
		'icon'             => 'el el-bold'
	)
);

Redux::set_section(
	$opt_name,
	array(
		'title'            	=> esc_html__( 'Related Slider', 'growla-core' ),
		'id'               	=> 'growla_config_blog_related_slider',
		'desc'             	=> esc_html__( 'Customize related slider', 'growla-core' ),
		'customizer_width' 	=> '400px',
		'icon'             	=> 'el el-bold',
		'subsection'		=> true,
		'fields'			=> growla_blog_fields()
	)
);

Redux::set_section(
	$opt_name,
	array(
		'title'            => esc_html__( 'Projects', 'growla-core' ),
		'id'               => 'growla_config_project',
		'desc'             => esc_html__( 'Customize project details', 'growla-core' ),
		'customizer_width' => '400px',
		'icon'             => 'el el-record'
	)
);

Redux::set_section(
	$opt_name,
	array(
		'title'            	=> esc_html__( 'Related Projects', 'growla-core' ),
		'id'               	=> 'growla_config_project_related_slider',
		'desc'             	=> esc_html__( 'Customize related slider', 'growla-core' ),
		'customizer_width' 	=> '400px',
		'icon'             	=> 'el el-record',
		'subsection'		=> true,
		'fields'			=> growla_project_fields()
	)
);

Redux::set_section(
	$opt_name,
	array(
		'title'            	=> esc_html__( '404', 'growla-core' ),
		'id'               	=> '404_settings',
		'customizer_width' 	=> '500px',
		'icon'             	=> 'el el-error',
		'fields'			=> growla_404_fields()
	)
);

Redux::set_section(
	$opt_name,
	array(
		'title'            	=> esc_html__( 'Search page', 'growla-core' ),
		'id'               	=> 'search_page_settings',
		'customizer_width' 	=> '500px',
		'icon'             	=> 'el el-search',
		'fields'			=> growla_search_fields()
	)
);

/**
 * Metaboxes
 */
require_once( plugin_dir_path( __FILE__ ) . '../meta/metaboxes.php' );

/*
 * <--- END SECTIONS
 */