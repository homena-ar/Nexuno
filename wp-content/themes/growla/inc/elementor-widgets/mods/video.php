<?php


if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class growlaVideoMod {
    public static function init() {
        // data controls
        add_action( 
            'elementor/element/video/section_image_overlay/before_section_end', 
            [ __CLASS__, 'controls' ], 
            10, 
            2 
        );

        // style controls
        add_action( 
            'elementor/element/video/section_video_style/after_section_end', 
            [ __CLASS__, 'style_controls' ], 
            10, 
            2 
        );

        add_filter( 
            'elementor/widget/render_content', 
            [ __CLASS__, 'render_content' ], 
            10, 
            2
        );
    }


    public static function render_content( $widget_content, $widget ) {
        $settings = $widget->get_settings_for_display();

        if ( $widget->get_name() === 'video' && $settings['growla_show_illustration'] === 'yes' ) {
        
            $widget_content .= '<div class="growla-video-illustration">';
                $widget_content .= '<div class="growla-video-illustration-box-1"></div>';
                $widget_content .= '<div class="growla-video-illustration-box-2"></div>';
            $widget_content .= '</div>';

            return $widget_content;
        }
        
        return $widget_content;
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
			'growla_show_illustration',
			[
				'label' => esc_html__( 'Show Illustration', 'growla' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'growla' ),
				'label_off' => esc_html__( 'Hide', 'growla' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

    }

    public static function style_controls( $instance ) {

        $instance->start_controls_section(
            'growla_video_styles',
            [
              'label' => esc_html__('Growla: Video', 'growla'),
              'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $instance->add_responsive_control(
			'growla_video_width',
			[
				'label' => esc_html__( 'Width', 'growla' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
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
                    '{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-widget-container' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $instance->add_responsive_control(
			'growla_video_height',
			[
				'label' => esc_html__( 'Height', 'growla' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
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
                    '{{WRAPPER}}' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-wrapper' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-wrapper' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-widget-container' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $instance->add_control(
            'growla_video_illustration_box_color',
            [
            'label' => esc_html__('Illustration Box Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-video-illustration' => '--box-color : {{VALUE}};'
            ]
            
            ]
        );

        $instance->end_controls_section();
    }

}

growlaVideoMod::init();