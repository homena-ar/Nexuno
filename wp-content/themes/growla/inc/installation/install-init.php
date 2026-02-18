<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once( get_template_directory() . '/inc/installation/class-tgm-plugin-activation.php' );

function growla_get_plugins() {
    return array(
        array(
            'name'         => esc_html__('Growla core', 'growla'),
            'slug'         => 'growla-core',
            'required'     => true,
            'source'       => esc_url( 'https://gfxpartner.com/product-plugins/growla-core-v1.0.1.zip' ),
            'version'      => '1.0.1',
        ),  
        array(
            'name'         => esc_html__('Elementor', 'growla'),
            'slug'         => 'elementor',
            'required'     => true,
        ),
        array(
            'name'         => esc_html__('Redux Framework', 'growla'),
            'slug'         => 'redux-framework',
            'required'     => true,
        ),
        array(
            'name'         => esc_html__('Contact Form 7', 'growla'),
            'slug'         => 'contact-form-7',
        ),
        array(
            'name'         => esc_html__('One Click Demo Import', 'growla'),
            'slug'         => 'one-click-demo-import',
        )
    );
    
}

/****************************************
TGM
****************************************/
function growla_register_required_plugins() {
    $plugins = growla_get_plugins();
	$config = array(
		'id' => 'tgmpa',
		'default_path' => '',
		'menu' => 'tgmpa-install-plugins',
		'has_notices' => true,
		'dismissable' => true,
		'dismiss_msg' => '',
		'is_automatic' => false,
		'message' => '',
	);
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'growla_register_required_plugins' );


/****************************************
One click demo import
****************************************/
function growla_ocdi_import_files() {
    $redundant_data = array(
        'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/data.wiedata.wie',
    );

	return array(
		array(
            'import_preview_image_url'   => get_template_directory_uri() . '/inc/assets/images/demo-img-1.jpg',
            'preview_url'                => 'https://www.gfxpartner.com/growla-1',
            'import_file_name'             => 'Azure',
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/demo-1/growla-demo-1.xml',
            'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/demo-1/growla-demo-1-customizer.dat',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/demo-1/growla-demo-1-widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => 
                    trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/demo-1/growla-demo-1-redux.json',
                    'option_name' => 'growla_opt',
                ),
            ),
        ),
        array(
            'import_preview_image_url'   => get_template_directory_uri() . '/inc/assets/images/demo-img-2.jpg',
            'preview_url'                => 'https://www.gfxpartner.com/growla-2',
            'import_file_name'             => 'Aurum',
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/demo-2/growla-demo-2.xml',
            'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/demo-2/growla-demo-2-customizer.dat',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/demo-2/growla-demo-2-widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => 
                    trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/demo-2/growla-demo-2-redux.json',
                    'option_name' => 'growla_opt',
                ),
            ),
        ),
        array(
            'import_preview_image_url'   => get_template_directory_uri() . '/inc/assets/images/demo-img-3.jpg',
            'preview_url'                => 'https://www.gfxpartner.com/growla-3',
            'import_file_name'             => 'Jade',
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/demo-3/growla-demo-3.xml',
            'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/demo-3/growla-demo-3-customizer.dat',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/demo-3/growla-demo-3-widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => 
                    trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/demo-3/growla-demo-3-redux.json',
                    'option_name' => 'growla_opt',
                ),
            ),
        ),
        array(
            'import_preview_image_url'   => get_template_directory_uri() . '/inc/assets/images/demo-img-4.jpg',
            'preview_url'                => 'https://www.gfxpartner.com/growla-4',
            'import_file_name'             => 'Rubin',
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/demo-4/growla-demo-4.xml',
            'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/demo-4/growla-demo-4-customizer.dat',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/demo-4/growla-demo-4-widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => 
                    trailingslashit( get_template_directory() ) . 'inc/installation/demo-data/demo-4/growla-demo-4-redux.json',
                    'option_name' => 'growla_opt',
                ),
            ),
        ),
	);
}
add_filter( 'pt-ocdi/import_files', 'growla_ocdi_import_files' );

function growla_ocdi_after_import_setup() {
	// Assign menus to their locations.
    $top_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
            'primary-menu' => $top_menu->term_id,
            'default-menu' => $top_menu->term_id,
		)
	);

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Home' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'growla_ocdi_after_import_setup' );
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
add_filter( 'ocdi/register_plugins', 'growla_get_plugins' );