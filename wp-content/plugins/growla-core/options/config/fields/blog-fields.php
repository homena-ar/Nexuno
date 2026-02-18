<?php

if ( ! class_exists( 'Redux' ) ) {
	return;
}

if ( !function_exists( 'growla_blog_fields' ) ) {
    function growla_blog_fields() {
        $fields = array(
            array(
    			'id' 		=> 'brs_heading_subheading',
    			'type' 		=> 'text',
    			'title' 	=> __( 'Subheading' , 'growla-core' ),
				'default'	=> __( '// NEWS', 'growla-core' )
			),
			array(
    			'id' 		=> 'brs_heading_txt',
    			'type' 		=> 'text',
    			'title' 	=> __( 'Heading' , 'growla-core' ),
				'default'	=> __( 'Similar News.', 'growla-core' )
			),
			array(
				'id' 		=> 'brs_heading_typo',
				'type' 		=> 'typography',
				'title' 	=> __( 'Typography' , 'growla-core' ),
				'output'	=> array( '.related-blog .growla-heading' ),
                'color'     => false
			),
            array(
    			'id' 		=> 'brs_heading_animate',
    			'type' 		=> 'switch',
    			'title' 	=> __( 'Animate Heading' , 'growla-core' ),
				'default'	=> true
			),
			array(
				'id'       	=> 'brs_nav_icon_color',
				'type'     	=> 'color',
				'title'    	=> esc_html__('Navigation icon normal color', 'growla-core'), 				
				'validate' 	=> 'color',
				'output'	=> array(
					'color'	=> '.related-blog .slider-nav-btn',
					'fill'	=> '.related-blog .slider-nav-btn'
				)
			),
			array(
				'id'       	=> 'brs_nav_icon_hover_color',
				'type'     	=> 'color',
				'title'    	=> esc_html__('Navigation icon hover color', 'growla-core'), 				
				'validate' 	=> 'color',
				'output'	=> array(
					'color'	=> '.related-blog .slider-nav-btn:hover',
					'fill'	=> '.related-blog .slider-nav-btn:hover'
				)
			)
        );

        return $fields;
    }
}