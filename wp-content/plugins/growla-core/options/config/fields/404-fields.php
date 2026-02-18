<?php

if ( ! class_exists( 'Redux' ) ) {
	return;
}

if ( !function_exists( 'growla_404_fields' ) ) {
    function growla_404_fields() {
        $fields = array(
			array(
				'id'       => '404_page_header_desktop',
				'type'     => 'select',
				'title'    => esc_html__('Select Desktop Header', 'growla-core'), 
				'options'  => get_growla_headers()
			),
			array(
				'id'       => '404_page_header_mobile',
				'type'     => 'select',
				'title'    => esc_html__('Select Mobile Header', 'growla-core'), 
				'options'  => get_growla_headers()
			),
			array(         
				'id'       	=> '404_background',
				'type'     	=> 'background',
				'title'    	=> esc_html__('Background', 'growla-core'),
				'output'	=> array( '.error-page' )
			),
            array(         
				'id'       	=> '404_button_1_text',
				'type'     	=> 'text',
				'title'    	=> esc_html__('Button 1 Text', 'growla-core')
			),
            array(         
				'id'       	=> '404_button_1_link',
				'type'     	=> 'text',
				'title'    	=> esc_html__('Button 1 Link', 'growla-core')
			),
            array(         
				'id'       	=> '404_button_2_text',
				'type'     	=> 'text',
				'title'    	=> esc_html__('Button 2 Text', 'growla-core')
			),
            array(         
				'id'       	=> '404_button_2_link',
				'type'     	=> 'text',
				'title'    	=> esc_html__('Button 2 Link', 'growla-core')
			),
			array(
				'id'       => '404_page_footer',
				'type'     => 'select',
				'title'    => esc_html__('Select Footer', 'growla-core'), 
				'options'  => get_growla_footers(),
			),
            array(
                'id'       => '404_page_header_illustration',
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