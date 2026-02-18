<?php

if ( ! class_exists( 'Redux' ) ) {
	return;
}

if ( !function_exists( 'growla_meta_project_fields' ) ) {
    function growla_meta_project_fields() {
        $fields = [
            [
                'id'       => 'meta_project_rp_switch',
                'type'     => 'switch', 
                'title'    => esc_html__('Display related projects', 'growla-core'),
                'default'  => true,
            ],
            [
                'id'       => 'meta_project_content_heading',
                'type'     => 'text', 
                'title'    => esc_html__('Content Heading', 'growla-core'),
                'default'  => __( 'Project Scope', 'growla-core' ),
            ],
            [
                'id'       => 'meta_project_info',
                'type'     => 'repeater', 
                'title'    => esc_html__('Metadata', 'growla-core'),
                'group_values' => true,
                'fields'   => [
                    [
                        'id'    => 'meta_project_detail_title',
                        'type'  => 'text',
                        'title' => esc_html__('Title', 'growla-core')
                    ],
                    [
                        'id'    => 'meta_project_detail_value',
                        'type'  => 'text',
                        'title' => esc_html__('Value', 'growla-core')
                    ]
                ]
            ]
            // [
            //     'id'       => 'meta_project_rp_heading',
            //     'type'     => 'text', 
            //     'title'    => esc_html__('Heading', 'growla-core'),
            //     'default'  => __( 'Other Projects', 'growla-core' ),
            // ],
            // [
            //     'id'       => 'meta_project_slider_bg',
            //     'type'     => 'background',
            //     'title'    => esc_html__('Background', 'growla-core'),
            //     'output'   => '.related-projects-wrapper',
            //     'compiler' => true
            // ]
        ];

        return $fields;
    }
}