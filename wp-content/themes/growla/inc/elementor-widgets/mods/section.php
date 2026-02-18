<?php


if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class growlaSectionMod {
    public static function init() {
        add_action( 
            'elementor/element/container/section_layout_container/before_section_end', 
            [ __CLASS__, 'controls' ], 
            10, 
            2 
        );

        add_action( 
            'elementor/frontend/container/before_render', 
            [ __CLASS__, 'section_attribute' ]
        );

		add_action(
			'elementor/element/container/section_layout_container/after_section_end',
			[ __CLASS__, 'nav_style_controls' ],
			99,
			2
		);
		
    }

    public static function section_attribute( $instance ) {

        $settings = $instance->get_settings_for_display();

        $full_width = $settings['growla_full_width_container'] ?? '';
        $full_width_class = 'growla-full-width-container';

		if ( ! empty( $full_width ) && $full_width === 'yes' ) {
			$instance->add_render_attribute(
				'_wrapper', 'class', [ $full_width_class ]
			);
		}

		if ( !empty( $settings['growla_nav_sec_sticky'] ) ) {
			$instance->add_render_attribute(
				'_wrapper', 'class', [
					$settings['growla_nav_sec_sticky'] === 'sticky-nav' ? 
					$settings['growla_nav_sec_sticky'] : 
					''
				]
			);
		}

        $grow_animation = $settings['growla_grow_animation'] ?? '';
        $grow_animation_class = 'growla-grow-section';

        if ( ! empty( $grow_animation ) && $grow_animation === 'yes' ) {
			$instance->add_render_attribute(
				'_wrapper', 'class', [ $grow_animation_class ]
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

        $instance->add_control(
			'growla_full_width_container',
			[
				'label' => esc_html__( 'Full Width', 'growla' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'growla' ),
				'label_off' => esc_html__( 'No', 'growla' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $instance->add_control(
			'growla_grow_animation',
			[
				'label' => esc_html__( 'Grow Animation', 'growla' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'growla' ),
				'label_off' => esc_html__( 'No', 'growla' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		if ( get_post_type() == 'header' ) {

			$instance->add_control(
				'growla_nav_sec_sticky',
				[
					'label' => esc_html__( 'Sticky', 'growla' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'growla' ),
					'label_off' => esc_html__( 'Hide', 'growla' ),
					'return_value' => 'sticky-nav',
					'default' => 'not-sticky-nav',
				]
			);
		}
    }

	public static function nav_style_controls( $instance, $args ) {

		// if ( get_post_type() != 'header' ) return;

		$condition = [
			'growla_nav_sec_sticky' => 'sticky-nav'
		];

		$instance->start_controls_section(
			'growla_nav_style_sec',
			[
			  'label' => esc_html__('growla', 'growla'),
			  'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			  'condition' => $condition
			]
		);

		$instance->start_controls_tabs( 'button_tabs' );

		$instance->start_controls_tab(
			'growla_nav_bg_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'growla' ),
				'condition' => $condition
			]
		);

		$instance->add_control(
			'growla_nav_bg_normal',
			[
				'label' => esc_html__( 'Color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}' => 'background-color: {{VALUE}} !important',
				],
				'condition' => $condition
			]
		);

		$instance->add_control(
			'growla_section_height',
			[
				'label' => esc_html__( 'Height', 'growla' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,						
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'rem' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} > .elementor-container' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} > .e-con-inner' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => $condition
			]
		);

		$instance->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'growla_nav_bg_normal_border_type',
				'selector' => '{{WRAPPER}}',
				'condition' => $condition
			]
		);

		$instance->end_controls_tab();

		$instance->start_controls_tab(
			'growla_nav_bg_tab_sticky',
			[
				'label' => esc_html__( 'Sticky', 'growla' ),
				'condition' => $condition
			]
		);

		$instance->add_control(
			'growla_nav_bg_sticky',
			[
				'label' => esc_html__( 'Color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.sticky-nav.scrolled' => 'background-color: {{VALUE}} !important',
				],
				'condition' => $condition
			]
		);

		$instance->add_control(
			'growla_section_height_sticky',
			[
				'label' => esc_html__( 'Height', 'growla' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,						
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'rem' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.sticky-nav.scrolled > .elementor-container' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.sticky-nav.scrolled > .e-con-inner' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => $condition
			]
		);

		$instance->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'growla_nav_bg_sticky_border_type',
				'selector' => '{{WRAPPER}}.sticky-nav.scrolled',
				'condition' => $condition
			]
		);

		$instance->end_controls_tab();

		$instance->end_controls_tabs();

		$instance->end_controls_section();

	}
}

growlaSectionMod::init();