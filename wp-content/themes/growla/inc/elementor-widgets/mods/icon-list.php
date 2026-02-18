<?php


if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class growlaIconListMod {
    public static function init() {
        add_action( 
            'elementor/element/icon-list/section_text_style/before_section_end', 
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
			'growla_bar_color',
			[
				'label' => esc_html__( 'Bar color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a .elementor-icon-list-text::after' => 'background-color: {{VALUE}}',
				],
			]
		);

        $instance->add_control(
			'growla_bar_margin',
			[
				'label' => esc_html__( 'Bar margin', 'growla' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} a .elementor-icon-list-text::after' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$instance->add_control(
			'growla_text_margin',
			[
				'label' => esc_html__( 'Text margin', 'growla' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'rem' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

    }

}

growlaIconListMod::init();