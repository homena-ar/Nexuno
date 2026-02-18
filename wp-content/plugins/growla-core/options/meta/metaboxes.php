<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Redux_Metaboxes' ) ) {
	return;
}

require_once( plugin_dir_path( __FILE__ ) . 'fields/general-fields.php' );
require_once( plugin_dir_path( __FILE__ ) . 'fields/header-fields.php' );
require_once( plugin_dir_path( __FILE__ ) . 'fields/page-header-fields.php' );
require_once( plugin_dir_path( __FILE__ ) . 'fields/footer-fields.php' );
require_once( plugin_dir_path( __FILE__ ) . 'fields/post-fields.php' );
require_once( plugin_dir_path( __FILE__ ) . 'fields/project-fields.php' );

// metaboxes for all post types
Redux_Metaboxes::set_box(
	$opt_name,
	array(
		'id'         => 'growla_meta_box',
		'title'      => esc_html__( 'General Options', 'growla-core' ),
		'post_types' => array( 'page', 'post', 'project' ),
		'position'   => 'normal',
		'priority'   => 'high',
		'sections'   => array(
            array(
				'title'  => esc_html__( 'General', 'growla-core' ),
				'id'     => 'growla_meta_section_general',
				'icon'   => 'el-icon-cogs',
				'fields' => growla_meta_general_fields(),
			),
			array(
				'title'  => esc_html__( 'Header', 'growla-core' ),
				'id'     => 'growla_meta_section_header',
				'icon'   => 'el-icon-cogs',
				'fields' => growla_meta_header_fields(),
			),
			array(
				'title'  => esc_html__( 'Page header', 'growla-core' ),
				'id'     => 'growla_meta_section_page_header',
				'icon'   => 'el-icon-cogs',
				'fields' => growla_meta_page_header_fields(),
			),
			array(
				'title'  => esc_html__( 'Footer', 'growla-core' ),
				'id'     => 'growla_meta_section_footer',
				'icon'   => 'el-icon-cogs',
				'fields' => growla_meta_footer_fields(),
			),
		),
	)
);

// metaboxes for posts
Redux_Metaboxes::set_box(
	$opt_name,
	array(
		'id'         => 'growla_meta_box_post',
		'title'      => esc_html__( 'Post Options', 'growla-core' ),
		'post_types' => array( 'post' ),
		'position'   => 'normal',
		'priority'   => 'high',
		'sections'   => array(
			array(
				'title'  => esc_html__( 'Post', 'growla-core' ),
				'id'     => 'growla_meta_section_post_sec',
				'icon'   => 'el-icon-cogs',
				'fields' => growla_meta_post_fields(),
			)
		),
	)
);

// metaboxes for projects
Redux_Metaboxes::set_box(
	$opt_name,
	array(
		'id'         => 'growla_meta_box_projects',
		'title'      => esc_html__( 'Projects Options', 'growla-core' ),
		'post_types' => array( 'project' ),
		'position'   => 'normal',
		'priority'   => 'high',
		'sections'   => array(
			array(
				'title'  => esc_html__( 'Project', 'growla-core' ),
				'id'     => 'growla_meta_section_project_sec',
				'icon'   => 'el-icon-cogs',
				'fields' => growla_meta_project_fields(),
			)
		),
	)
);