<?php

if ( !function_exists( 'growla_meta_page_header_fields' ) ) {
    function growla_meta_page_header_fields() {
        $fields = [
            [
                'id'       => 'meta_page_header_switch',
                'type'     => 'switch', 
                'title'    => esc_html__('Display page header', 'growla-core'),
                'subtitle' => esc_html__('Choose whether to display the page header.', 'growla-core'),
                'default'  => true,
            ],
            [
                'id'       => 'meta_page_header_heading',
                'type'     => 'text',
                'title'    => esc_html__('Heading', 'growla-core'),
            ],
            [
                'id'       => 'meta_page_header_background',
                'type'     => 'background',
                'title'    => esc_html__('Background', 'growla-core'),
                'subtitle' => esc_html__('This background will appear in the page header', 'growla-core'),
                'output'   => [ '.page-header-wrapper' ]
            ],
            [
                'id'       => 'meta_page_header_illustration',
                'type'     => 'select',
                'title'    => esc_html__('Illustration', 'growla-core'),
                'options'  => [
                    'none' => esc_html__('None', 'growla-core'),
                    'waves' => esc_html__('Waves', 'growla-core'),
                    'boxes-1' => esc_html__('Boxes 1', 'growla-core'),
                    'boxes-2' => esc_html__('Boxes 2', 'growla-core'),
                    'lines' => esc_html__('Lines', 'growla-core'),
                ],
                'default' => 'none'
            ]
        ];

        return $fields;
    }
}