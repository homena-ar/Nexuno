<?php

if ( ! class_exists( 'Redux' ) ) {
	return;
}

if ( !function_exists( 'growla_meta_footer_fields' ) ) {
    function growla_meta_footer_fields() {
        $fields = [
            [
                'id'       => 'meta_footer_select',
                'type'     => 'select',
                'title'    => esc_html__('Select Option', 'growla-core'), 
                'subtitle' => esc_html__('Select the footer that you want to be displayed', 'growla-core'),
                'options'  => get_growla_footers(),
                'default'  => ''
            ]
        ];

        return $fields;
    }
}