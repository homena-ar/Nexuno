<?php

if ( ! class_exists( 'Redux' ) ) {
	return;
}

if ( !function_exists( 'growla_meta_post_fields' ) ) {
    function growla_meta_post_fields() {
        $fields = [
            [
                'id'       => 'meta_post_date_select',
                'type'     => 'select',
                'title'    => esc_html__('Select Date format', 'growla-core'), 
                'subtitle' => esc_html__('Select the type of date format', 'growla-core'),
                'options'  => [
                    'demo' => 'Demo',
                    'default' => 'Default'
                ],
                'default'  => 'demo'
            ],
            [
                'id'       => 'meta_post_rs_switch',
                'type'     => 'switch', 
                'title'    => esc_html__('Display related slider', 'growla-core'),
                'default'  => true,
            ]
        ];

        return $fields;
    }
}