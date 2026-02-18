<?php

if ( ! class_exists( 'Redux' ) ) {
	return;
}

if ( !function_exists( 'growla_search_fields' ) ) {
    function growla_search_fields() {
        $fields = array(
			array(
				'id'       => 'search_page_header_desktop',
				'type'     => 'select',
				'title'    => esc_html__('Select Desktop Header', 'growla-core'), 
				'options'  => get_growla_headers()
			),
			array(
				'id'       => 'search_page_header_mobile',
				'type'     => 'select',
				'title'    => esc_html__('Select Mobile Header', 'growla-core'), 
				'options'  => get_growla_headers()
			),
			array(         
				'id'       	=> 'search_page_header_background',
				'type'     	=> 'background',
				'title'    	=> esc_html__('Page header background', 'growla-core'),
				'output'	=> array( '.search .page-header-wrapper', '.archive .page-header-wrapper' )
			),
			array(
				'id'       => 'search_page_footer',
				'type'     => 'select',
				'title'    => esc_html__('Select Footer', 'growla-core'), 
				'options'  => get_growla_footers(),
			),
            array(
                'id'       => 'search_page_header_illustration',
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
            )
		);

        return $fields;
    }
}