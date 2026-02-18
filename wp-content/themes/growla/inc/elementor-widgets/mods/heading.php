<?php


if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class growlaHeadingMod {
    public static function init() {
        // data controls
        add_action( 
            'elementor/element/heading/section_title_style/before_section_end', 
            [ __CLASS__, 'controls' ], 
            10, 
            2 
        );

        add_action( 
            'elementor/frontend/before_render', 
            [ __CLASS__, 'section_attribute' ]
        );
    }

    public static function section_attribute( $instance ) {

        if ( $instance->get_name() != 'heading' ) {
            return;
        }

        $settings = $instance->get_settings_for_display();
        $underline_class = $settings['growla__underline_on_hover'] === 'yes' ? 'growla-heading-underline' : '';

		if ( ! empty( $underline_class ) ) {
			$instance->add_render_attribute(
				'title', 'class', [ $underline_class ]
			);
		}
	
    }

    public static function controls( $instance ) {

        $instance->add_control(
			'growla_counter_heading',
			[
				'label' => esc_html__( 'Growla', 'growla' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $instance->add_control(
			'growla__underline_on_hover',
			[
				'label' => esc_html__( 'Underline on hover', 'growla' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'growla' ),
				'label_off' => esc_html__( 'No', 'growla' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

    }

}

growlaHeadingMod::init();