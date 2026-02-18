<?php


if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class growlaImageCarousel {
    public static function init() {
        add_action( 
            'elementor/element/image-carousel/section_image_carousel/before_section_end', 
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

        if ( $instance->get_name() != 'image-carousel' ) {
            return;
        }

        $settings = $instance->get_settings_for_display();

        $navigation_bottom = $settings['growla_navigation_bottom_position'] ?? '';
        $navigation_bottom_class = 'growla-carousel-navigation-bottom';

		if ( ! empty( $navigation_bottom ) && $navigation_bottom === 'yes' ) {
			$instance->add_render_attribute(
				'carousel-wrapper', 'class', [ $navigation_bottom_class ]
			);
		}
	
    }

    public static function controls( $instance, $args ) {

        $instance->add_control(
			'growla_section_heading',
			[
				'label' => esc_html__( 'Growla', 'growla' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $instance->add_responsive_control(
			'growla_image_carousel_overflow',
			[
				'label' => esc_html__( 'Overflow', 'growla' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'hidden',
				'options' => [
					'hidden'  => esc_html__( 'Hidden', 'growla' ),
					'visible' => esc_html__( 'Visible', 'growla' ),
				],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container' => 'overflow: {{VALUE}};'
                ]
			]
		);

        $instance->add_control(
			'growla_navigation_bottom_position',
			[
				'label' => esc_html__( 'Display navigation below carousel', 'growla' ),
                'description' => esc_html__( 'This will override any other position applied to navigation.', 'growla' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'growla' ),
				'label_off' => esc_html__( 'No', 'growla' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$instance->add_control(
			'growla_image_carousel_space_between',
			[
				'label' => esc_html__( 'Space between', 'growla' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'rem' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-inner' => 'margin: 0 {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$instance->add_responsive_control(
			'growla_image_carousel_height',
			[
				'label' => esc_html__( 'Height', 'growla' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'rem' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-slide-inner' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .swiper-slide-inner img' => 'height: 100%; object-fit: cover;',
				],
			]
		);

    }

}

growlaImageCarousel::init();