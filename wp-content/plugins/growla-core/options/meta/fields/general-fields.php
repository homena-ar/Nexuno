<?php

if ( ! class_exists( 'Redux' ) ) {
	return;
}

if ( !function_exists( 'growla_meta_general_fields' ) ) {
    function growla_meta_general_fields() {
        $fields = [
            [
                'id'       => 'meta_primary_color',
                'type'     => 'color',
                'title'    => esc_html__('Primary color', 'growla-core'), 
                'subtitle' => esc_html__('This changes the theme and elementor\'s primary color for this page', 'growla-core'),
                'validate' => 'color',
                'default'  => '',
                'output'   => [ '--color-primary' => ':root', '--e-global-color-primary' => 'body.elementor-page' ]
            ]
        ];

        return $fields;
    }
}