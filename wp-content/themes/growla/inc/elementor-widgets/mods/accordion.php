<?php


if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class growlaAccordionMod {
    public static function init() {
        add_action( 
            'elementor/element/accordion/section_toggle_style_icon/before_section_end', 
            [ __CLASS__, 'icon_controls' ], 
            10, 
            2 
        );

        add_action( 
            'elementor/element/accordion/section_title_style/before_section_end', 
            [ __CLASS__, 'general_controls' ], 
            10, 
            2 
        );
    }

    public static function general_controls( $instance, $args ) {

        $instance->add_control(
			'growla_accordion_general_style_heading',
			[
				'label' => esc_html__( 'Growla', 'growla' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $instance->add_control(
			'space_between',
			[
				'label' => esc_html__( 'Space between', 'growla' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-accordion .elementor-accordion-item:nth-child(n+2)' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

    }

    public static function icon_controls( $instance, $args ) {

        $instance->add_control(
			'growla_accordion_icon_style_heading',
			[
				'label' => esc_html__( 'Growla', 'growla' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $instance->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Size', 'growla' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon *' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

        

    }
}

growlaAccordionMod::init();