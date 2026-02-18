<?php

if ( ! class_exists( 'Redux' ) ) {
	return;
}

if ( !function_exists( 'growla_project_fields' ) ) {
    function growla_project_fields() {
        $fields = array(
            array(
    			'id' 		=> 'prs_subheading_txt',
    			'type' 		=> 'text',
    			'title' 	=> __( 'Subheading' , 'growla-core' ),
				'default'	=> __( '// WORKS', 'growla-core' )
			),
			array(
    			'id' 		=> 'prs_heading_txt',
    			'type' 		=> 'text',
    			'title' 	=> __( 'Heading' , 'growla-core' ),
				'default'	=> __( 'Other Projects', 'growla-core' )
			),
            array(
    			'id' 		=> 'prs_heading_animate',
    			'type' 		=> 'switch',
    			'title' 	=> __( 'Animate Heading' , 'growla-core' ),
				'default'	=> true
			),
			array(
				'id' 		=> 'prs_heading_typo',
				'type' 		=> 'typography',
				'title' 	=> __( 'Heading Typography' , 'growla-core' ),
				'output'	=> array( '.related-projects .growla-heading' )
			),
			array(
				'id'       	=> 'prs_nav_icon_color',
				'type'     	=> 'color',
				'title'    	=> esc_html__('Navigation icon normal color', 'growla'), 				
				'validate' 	=> 'color',
				'output'	=> array(
					'color'	=> '.related-projects .slider-nav-btn',
					'fill'	=> '.related-projects .slider-nav-btn'
				)
			),
			array(
				'id'       	=> 'prs_nav_icon_hover_color',
				'type'     	=> 'color',
				'title'    	=> esc_html__('Navigation icon hover color', 'growla'), 				
				'validate' 	=> 'color',
				'output'	=> array(
					'color'	=> '.related-projects .slider-nav-btn:hover',
					'fill'	=> '.related-projects .slider-nav-btn:hover'
				)
			),
		);

        return $fields;
    }
}