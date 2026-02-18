<?php

if ( ! class_exists( 'Redux' ) ) {
	return;
}

if ( !function_exists( 'growla_meta_header_fields' ) ) {
    function growla_meta_header_fields() {
        $headers = get_growla_headers();

        $fields = [
            [
                'id'       => 'meta_header_select',
                'type'     => 'select',
                'title'    => esc_html__('Select Header for desktop', 'growla-core'), 
                'subtitle' => esc_html__('Select the header that you want to be displayed', 'growla-core'),
                'options'  => $headers,
                'default'  => ''
            ],
            [
                'id'       => 'meta_header_mobile_select',
                'type'     => 'select',
                'title'    => esc_html__('Select Header for mobile', 'growla-core'), 
                'subtitle' => esc_html__('Select the header that you want to be displayed on smaller devices like mobile.', 'growla-core'),
                'options'  => $headers,
                'default'  => ''
            ]
        ];

        return $fields;
    }
}