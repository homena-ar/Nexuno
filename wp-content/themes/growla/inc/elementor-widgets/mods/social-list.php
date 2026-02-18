<?php


if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class growlaSocialListMod {
    public static function init() {
        add_action( 
            'elementor/element/social-icons/section_social_hover/before_section_end', 
            [ __CLASS__, 'controls' ], 
            10, 
            2 
        );
    }

    public static function controls( $instance, $args ) {

        $instance->add_control(
			'growla_icon_list_heading',
			[
				'label' => esc_html__( 'Growla', 'growla' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $instance->add_control(
			'growla_social_icon_color',
			[
				'label' => esc_html__( 'Primary Color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-social-icon::before' => 'background-color: {{VALUE}}',
				],
			]
		);
    }

}

growlaSocialListMod::init();