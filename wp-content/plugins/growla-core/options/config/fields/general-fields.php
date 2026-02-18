<?php

if ( ! class_exists( 'Redux' ) ) {
	return;
}

if ( !function_exists( 'growla_general_fields' ) ) {
    function growla_general_fields() {
        $fields = [
            [  
                'title'       => __( 'Global font select', 'growla-core' ),
                'type'        => 'typography',
                'id'          => 'global_font_select',
                'google'      => true, 
                'font-backup' => true,
                'font-style'  => false,
                'font-weight' => false,
                'font-size'   => false,
                'line-height' => false,
                'word-spacing'=> false,
                'letter-spacing'=> false,
                'text-align'  => false,
                'text-transform'=> false,
                'color'       => false,
                'output'      => [ 'body' ],
                'subtitle'    => __( 'Select the font to be used in the theme.', 'growla-core' )
            ],
            [
                'id'       => 'primary_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Primary Color', 'growla-core' ),
                'subtitle' => esc_html__( 'This color may not override the primary color in elementor pages.', 'growla-core' ),
                'validate' => 'color',
                'output'   => [ '--color-primary' => ':root' ]
            ]
        ];

        return $fields;
    }
}