<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'growla_slider' ) ) :
    function growla_slider( $id, $options, $selector = '' ) {
        if ( empty( $selector ) ) {
            $selector = 'slider-' . $id;
        } else {
            $selector = $selector . '-' . $id;
        }

        ob_start();
        ?>
        (function() {
            'use strict';

            const selector = '.<?php echo esc_html( $selector ); ?>';

            // options
            let options = <?php echo wp_json_encode( $options ); ?>;

            // slider init
            new Swiper(selector, options);
        })();
        <?php
        $inline_script = ob_get_clean();

        wp_add_inline_script( 'growla-main', $inline_script );
    }
endif;


if ( ! function_exists( 'growla_thumbs_slider' ) ) :
    function growla_thumbs_slider( $options_1, $options_2, $selector_1, $selector_2 ) {
        // Start output buffering
        ob_start();
        ?>
        (function() {
            'use strict';

            const selector1 = '.<?php echo esc_html( $selector_1 ); ?>';
            const selector2 = '.<?php echo esc_html( $selector_2 ); ?>';
             
            const options1 = <?php echo wp_json_encode( $options_1 ); ?>;
            const options2 = <?php echo wp_json_encode( $options_2 ); ?>;

            const element1 = document.querySelector(selector1);
            const element2 = document.querySelector(selector2);
            
            new Swiper(element2, options2);

            options1.thumbs = {
                swiper: element2.swiper,
            };

            new Swiper(element1, options1);
        })();
        <?php
        // Capture the output and clean the buffer
        $inline_script = ob_get_clean();

        // Add the inline script to the 'growla-main' script handle
        wp_add_inline_script( 'growla-main', $inline_script );
    }
endif;


if ( ! function_exists( 'growla_slider_pagination' ) ) {
	function growla_slider_pagination( $settings, $id ) {
		if ( $settings['rs_pagination'] != 'yes' ) {
			return;
		}
		?>
		<div class="slider-pagination slider-pagination-<?php echo esc_attr( $id ); ?>"></div>
		<?php
	}
}

if ( ! function_exists( 'growla_slider_controls' ) ) {
	function growla_slider_controls( $instance = null, $condition = array(), $default_slides_per_view = 1, $navigation_control_active = true ) {
		if ( $instance == null ) {
			return;
		}

        $instance->start_controls_section(
			'slider_controls',
			array(
				'label' => esc_html__( 'Slider Controls', 'growla' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => $condition,
			)
		);

		$instance->add_control(
			'slides_per_view',
			array(
				'label'     => esc_html__( 'Slides per view', 'growla' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 1,
                'default'   => $default_slides_per_view,
				'condition' => $condition,
			)
		);

        if ( $navigation_control_active ) {
            $instance->add_control(
                'navigation',
                array(
                    'label'        => __( 'Slider navigation', 'growla' ),
                    'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'     => __( 'yes', 'growla' ),
                    'label_off'    => __( 'no', 'growla' ),
                    'return_value' => 'yes',
                    'condition'    => $condition,
                )
            );
    
            $instance->add_control(
                'prev_icon',
                array(
                    'label'     => __( 'Navigation previous icon', 'growla' ),
                    'type'      => \Elementor\Controls_Manager::ICONS,
                    'condition' => array_merge( array( 'navigation' => 'yes' ), $condition ),
                )
            );
    
            $instance->add_control(
                'next_icon',
                array(
                    'label'     => __( 'Navigation next icon', 'growla' ),
                    'type'      => \Elementor\Controls_Manager::ICONS,
                    'condition' => array_merge( array( 'navigation' => 'yes' ), $condition ),
                )
            );
        }

		$instance->add_control(
			'pagination',
			array(
				'label'        => __( 'Slider Pagination', 'growla' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'yes', 'growla' ),
				'label_off'    => __( 'no', 'growla' ),
				'return_value' => 'yes',
				'condition'    => $condition,
			)
		);

		$instance->add_control(
			'autoplay',
			array(
				'label'        => __( 'Slider autoplay', 'growla' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'yes', 'growla' ),
				'label_off'    => __( 'no', 'growla' ),
				'return_value' => 'yes',
				'condition'    => $condition,
			)
		);

		$instance->add_control(
			'autoplay_delay',
			array(
				'label'       => __( 'Delay', 'growla' ),
				'description' => __( '1000 represents 1 second', 'growla' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 60000,
				'step'        => 500,
				'default'     => 2000,
				'condition'   => $condition,
			)
		);

		$instance->add_control(
			'speed',
			array(
				'label'       => __( 'Speed', 'growla' ),
				'description' => __( '1000 represents 1 second', 'growla' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 60000,
				'step'        => 500,
				'default'     => 1000,
				'condition'   => $condition,
			)
		);

		$instance->add_control(
			'loop',
			array(
				'label'        => __( 'Slider loop', 'growla' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'yes', 'growla' ),
				'label_off'    => __( 'no', 'growla' ),
				'return_value' => 'yes',
				'condition'    => $condition,
			)
		);

        $instance->add_control(
			'overflow',
			array(
				'label'        => __( 'Slider overflow', 'growla' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'yes', 'growla' ),
				'label_off'    => __( 'no', 'growla' ),
				'return_value' => 'yes',
				'condition'    => $condition,
                'selectors' => array(
                    '{{WRAPPER}} .swiper' => 'overflow: visible',
                    '{{WRAPPER}} .swiper-wrapper' => 'overflow: visible',
                ),
			)
		);

        $instance->end_controls_section();
	}
}

if ( ! function_exists( 'growla_slider_options' ) ) {
	function growla_slider_options( $settings, $id, $other = null ) {

		if ( empty( $settings ) ) {
			return;
		}

		$options = array(
			'loop'           => $settings['loop'] ? true : false,
			'speed'          => $settings['speed'],
			'slidesPerView'  => $settings['slides_per_view'],
			'spaceBetween'   => 0,
		);

		// slider autoplay
		if ( $settings['autoplay'] == 'yes' ) {
			$delay_arr = array(
				'autoplay' => array(
					'delay'                => $settings['autoplay_delay'],
					'disableOnInteraction' => false,
				),
			);
			$options   = array_merge( $options, $delay_arr );
		}

		// slider navigation
		if ( $settings['navigation'] == 'yes' && ! empty( $id ) ) {
			$navigation = array(
				'navigation' => array(
					'nextEl' => '.slider-nav-' . $id . ' .slider-nav-next',
					'prevEl' => '.slider-nav-' . $id . ' .slider-nav-prev',
				),
			);
			$options    = array_merge( $options, $navigation );
		}

		// slider pagination
		if ( ! empty( $settings['pagination'] ) && $settings['pagination'] == 'yes' && ! empty( $id ) ) {
			$pagination = array(
				'pagination' => array(
					'el'   => '.slider-pagination-' . $id,
					'type' => 'bullets',
				),
			);
			$options    = array_merge( $options, $pagination );
		}

		if ( $other != null ) {
			$options = array_merge( $options, $other );
		}

		return $options;
	}
}

if ( ! function_exists( 'growla_slide_nav_styles' ) ) {
	function growla_slide_nav_styles( $instance ) {
		if ( empty( $instance ) ) {
			return;
		}

		$instance->start_controls_section(
			'rs_nav_styles',
			array(
				'label'     => __( 'Navigation', 'growla' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array( 'navigation' => 'yes' ),
			)
		);

		$instance->add_control(
			'rs_nav_icon_size',
			array(
				'label'      => esc_html__( 'Size', 'growla' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .slider-nav-btn .icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .slider-nav-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
				),
				'condition'  => array( 'navigation' => 'yes' ),
			)
		);

		$instance->start_controls_tabs( 'rs_nav_tabs' );

		$instance->start_controls_tab(
			'rs_nav_normal',
			array(
				'label'     => esc_html__( 'Normal', 'growla' ),
				'condition' => array( 'navigation' => 'yes' ),
			)
		);

		$instance->add_control(
			'rs_nav_normal_icon_color',
			array(
				'label'     => esc_html__( 'Color', 'growla' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slider-nav-btn .icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .slider-nav-btn svg' => 'fill: {{VALUE}};',
				),
				'condition' => array( 'navigation' => 'yes' ),
			)
		);

		$instance->add_control(
			'rs_nav_normal_icon_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'growla' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slider-nav-btn' => 'background-color: {{VALUE}};',
				),
				'condition' => array( 'navigation' => 'yes' ),
			)
		);

		$instance->end_controls_tab();

		$instance->start_controls_tab(
			'rs_nav_hover',
			array(
				'label'     => esc_html__( 'Hover', 'growla' ),
				'condition' => array( 'navigation' => 'yes' ),
			)
		);

		$instance->add_control(
			'rs_nav_hover_icon_color',
			array(
				'label'     => esc_html__( 'Color', 'growla' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slider-nav-btn:hover .icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .slider-nav-btn:hover svg' => 'fill: {{VALUE}};',
				),
				'condition' => array( 'navigation' => 'yes' ),
			)
		);

		$instance->add_control(
			'rs_nav_hover_icon_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'growla' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slider-nav-btn::after' => 'background-color: {{VALUE}};',
				),
				'condition' => array( 'navigation' => 'yes' ),
			)
		);

		$instance->end_controls_tab();

		$instance->end_controls_tabs();

		$instance->end_controls_section();
	}
}

if ( ! function_exists( 'growla_slide_pagination_styles' ) ) {
	function growla_slide_pagination_styles( $instance ) {
		if ( empty( $instance ) ) {
			return;
		}

		$instance->start_controls_section(
			'rs_pagination_styles',
			array(
				'label'     => __( 'Pagination', 'growla' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array( 'rs_pagination' => 'yes' ),
			)
		);

		$instance->add_control(
			'rs_pagination_icon_size',
			array(
				'label'      => esc_html__( 'Size', 'growla' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'rem' ),
				'range'      => array(
					'px'  => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					),
					'rem' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .slider-pagination .swiper-pagination-bullet' =>
					'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array( 'rs_pagination' => 'yes' ),
			)
		);

		$instance->start_controls_tabs( 'rs_pagination_tabs' );

		$instance->start_controls_tab(
			'rs_pagination_normal',
			array(
				'label'     => esc_html__( 'Normal', 'growla' ),
				'condition' => array( 'rs_pagination' => 'yes' ),
			)
		);

		$instance->add_control(
			'rs_pagination_normal_icon_color',
			array(
				'label'     => esc_html__( 'Color', 'growla' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slider-pagination .swiper-pagination-bullet:not(.swiper-pagination-bullet-active)' =>
					'background-color: {{VALUE}};',
				),
				'condition' => array( 'rs_pagination' => 'yes' ),
			)
		);

		$instance->end_controls_tab();

		$instance->start_controls_tab(
			'rs_pagination_hover',
			array(
				'label'     => esc_html__( 'Hover', 'growla' ),
				'condition' => array( 'rs_pagination' => 'yes' ),
			)
		);

		$instance->add_control(
			'rs_pagination_hover_icon_color',
			array(
				'label'     => esc_html__( 'Color', 'growla' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slider-pagination .swiper-pagination-bullet:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .slider-pagination .swiper-pagination-bullet-active:hover' => 'background-color: {{VALUE}};',
				),
				'condition' => array( 'rs_pagination' => 'yes' ),
			)
		);

		$instance->end_controls_tab();

		$instance->end_controls_tabs();

		$instance->end_controls_section();
	}
}

if ( ! function_exists( 'growla_subheading_content_controls' ) ) {
	function growla_subheading_content_controls( $instance = null, $condition = array() ) {

        $instance->start_controls_section(
			'subheading_content',
			array(
				'label' => esc_html__( 'Subheading', 'growla' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => $condition,
			)
		);

		$instance->add_control(
			'subheading',
			array(
				'label'       => esc_html__( 'Text', 'growla' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'Example Heading',
                'condition' => $condition,
                'dynamic' => [
                    'active' => true,
                ],
			)
		);

		growla_tag_select( $instance, 'subheading_tag', esc_html__( 'Tag', 'growla' ), 'h6' );

		$instance->end_controls_section();
    }
}

if ( ! function_exists( 'growla_heading_content_controls' ) ) {
    function growla_heading_content_controls( $instance = null, $condition = array() ) {

        $instance->start_controls_section(
            'heading_content',
            array(
                'label' => esc_html__( 'Heading', 'growla' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => $condition,
            )
        );

        $instance->add_control(
            'heading',
            array(
                'label'       => esc_html__( 'Text', 'growla' ),
                'type'        => \Elementor\Controls_Manager::WYSIWYG,
                'label_block' => true,
                'default'     => 'Example Heading',
                'condition' => $condition,
                'dynamic' => [
                    'active' => true,
                ],
            )
        );

        $instance->end_controls_section();
    }
}

if ( ! function_exists( 'growla_heading_data_controls' ) ) {
	function growla_heading_data_controls( $instance = null, $condition = array() ) {
		if ( $instance == null ) {
			return;
		}

		growla_subheading_content_controls( $instance, $condition );
        growla_heading_content_controls( $instance, $condition );
	}
}

if ( ! function_exists( 'growla_subheading_style_controls' ) ) {
	function growla_subheading_style_controls( $instance = null, $condition = array() ) {
        $instance->start_controls_section(
            'subheading_styles',
            array(
                'label' => esc_html__( 'Subheading', 'growla' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            )
        );

        $instance->add_control(
			'subheading_color',
			[
				'label' => esc_html__( 'Color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .growla-heading--sub' => 'color: {{VALUE}}',
				],
			]
		);

        $instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'subheading_typography',
				'selector' => '{{WRAPPER}} .growla-heading--sub',
			]
		);

        $instance->add_control(
			'subheading_gap',
			[
				'label' => esc_html__( 'Gap', 'growla' ),
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
					'{{WRAPPER}} .growla-heading--sub' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $instance->add_responsive_control(
			'subheading_text_align',
			[
				'label' => esc_html__( 'Alignment', 'growla' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'growla' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'growla' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'growla' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .growla-heading--sub' => 'text-align: {{VALUE}};',
				],
			]
		);

        $instance->end_controls_section();
    }
}

if ( ! function_exists( 'growla_main_heading_style_controls' ) ) {
	function growla_main_heading_style_controls( $instance = null, $condition = array() ) {
        $instance->start_controls_section(
            'heading_styles',
            array(
                'label' => esc_html__( 'Heading', 'growla' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            )
        );

        $instance->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .growla-heading--content *' => 'color: {{VALUE}}',
				],
			]
		);

        $instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'selector' => '{{WRAPPER}} .growla-heading--content *',
			]
		);

        $instance->add_control(
			'heading_underline_color',
			[
				'label' => esc_html__( 'Underline Color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .growla-heading--content span' => 'text-decoration-color: {{VALUE}} !important',
				],
			]
		);

        $instance->add_responsive_control(
			'heading_text_align',
			[
				'label' => esc_html__( 'Alignment', 'growla' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'growla' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'growla' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'growla' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .growla-heading--content' => 'text-align: {{VALUE}};',
				],
			]
		);

        $instance->end_controls_section();
    }
}

if ( ! function_exists( 'growla_heading_general_style_controls' ) ) {
    function growla_heading_general_style_controls( $instance = null, $condition = array() ) {
        $instance->start_controls_section(
            'heading_general_styles',
            array(
                'label' => esc_html__( 'General', 'growla' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => $condition,
            )
        );

        $instance->add_control(
			'animate_heading',
			[
				'label' => esc_html__( 'Animate', 'growla' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'growla' ),
				'label_off' => esc_html__( 'No', 'growla' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

        $instance->end_controls_section();
    }
}

if ( ! function_exists( 'growla_heading_style_controls' ) ) {
	function growla_heading_style_controls( $instance = null, $condition = array() ) {
		if ( $instance == null ) {
			return;
		}

        growla_heading_general_style_controls( $instance, $condition );
        growla_subheading_style_controls( $instance, $condition );
        growla_main_heading_style_controls( $instance, $condition );
	}
}

if ( ! function_exists( 'growla_get_elementor_templates' ) ) {
	function growla_get_elementor_templates() {
		$templates = \Elementor\Plugin::instance()->templates_manager->get_source( 'local' )->get_items();

		if ( empty( $templates ) ) {
			return array(
				'0' => __( 'There are no templates', 'growla' ),
			);
		}

		$template_lists = array(
			'0' => __( 'Select Template', 'growla' ),
		);

		if ( is_array( $template_lists ) ) {
			foreach ( $templates as $template ) {
				$template_lists[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
			}
		}

		return $template_lists;
	}
}

if ( ! function_exists( 'growla_render_icon' ) ) {
	function growla_render_icon( $icon ) {

		// default next icon
		if ( ! is_array( $icon ) && $icon == 'default-next' ) {
			?>
				<span class="icon-svg icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>arrow-right</title><path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" /></svg>
				</span>
			<?php
			return;
		}

		// default previous icon
		if ( ! is_array( $icon ) && $icon == 'default-prev' ) {
			?>
				<span class="icon-svg icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>arrow-left</title><path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z" /></svg>
				</span>
			<?php
			return;
		}

		// render icon from class
		if ( ! is_array( $icon ) && ! empty( $icon ) ) {
			?>
				<i class="<?php echo esc_attr( $icon ); ?>"></i>
			<?php
			return;
		}

		$is_svg = $icon['library'] == 'svg';

		if ( $is_svg ) {
			echo wp_kses( '<span class="icon-svg icon">', 'post' );
		}

		\Elementor\Icons_Manager::render_icon(
			$icon,
			array(
				'aria-hidden' => 'true',
				'class'       => 'icon',
			)
		);

		if ( $is_svg ) {
			echo wp_kses( '</span>', 'post' );
		}
	}
}

if ( ! function_exists( 'growla_get_nav_menu_names' ) ) {
	function growla_get_nav_menu_names() {
		$data   = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
		$result = array();
		if ( is_array( $data ) || is_object( $data ) ) {
			foreach ( $data as $obj ) {
				$result[ $obj->term_id ] = $obj->name;
			}
		}
		return $result;
	}
}

if ( ! function_exists( 'growla_tag_select' ) ) {
	/**
	 * growla_tag_select
	 *
	 * @param  mixed $instance
	 * @return void
	 */
	function growla_tag_select( $instance, $id, $label, $default_value ) {
		if ( null === $instance ) {
			return;
		}

		$instance->add_control(
			$id,
			array(
				'label'   => $label,
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => $default_value,
				'options' => array(
					'h1' => esc_html__( 'H1', 'growla' ),
					'h2' => esc_html__( 'H2', 'growla' ),
					'h3' => esc_html__( 'H3', 'growla' ),
					'h4' => esc_html__( 'H4', 'growla' ),
					'h5' => esc_html__( 'H5', 'growla' ),
					'h6' => esc_html__( 'H6', 'growla' ),
					'p'  => esc_html__( 'P', 'growla' ),
				),
			)
		);
	}
}

if ( ! function_exists( 'growla_cf7_field_styles' ) ) {
    function growla_cf7_field_styles( $instance ) {
        if ( null === $instance ) {
			return;
		}
        
        $instance->start_controls_section(
            'field_style',
            [
              'label' => esc_html__('Fields', 'growla'),
              'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $instance->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'field_typography',
                'label' => esc_html__('Typography', 'growla'),
                'selector' => '{{WRAPPER}} .form-label, {{WRAPPER}} .form-input',
            ]
        );

        $instance->add_control(
            'field_color',
            [
            'label' => esc_html__('Field Text Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .form-input' => 'color : {{VALUE}};'
            ]
            
            ]
        );

        $instance->add_control(
            'label_color',
            [
            'label' => esc_html__('Label Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .form-label' => 'color : {{VALUE}};'
            ]
            
            ]
        );

        $instance->add_control(
            'border_color',
            [
            'label' => esc_html__('Border Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .form-input' => 'border-color : {{VALUE}};'
            ]
            
            ]
        );


        $instance->end_controls_section();
    }
}

if ( ! function_exists( 'growla_cf7_textarea_styles' ) ) {
    function growla_cf7_textarea_styles( $instance ) {
        if ( null === $instance ) {
			return;
		}
        
        $instance->start_controls_section(
            'textarea_style',
            [
              'label' => esc_html__('Textarea', 'growla'),
              'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $instance->add_control(
			'textarea_min_height',
			[
				'label' => esc_html__( 'Minimum Height', 'growla' ),
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
					'{{WRAPPER}} .form-areas' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $instance->add_control(
			'textarea_max_height',
			[
				'label' => esc_html__( 'Maximum Height', 'growla' ),
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
					'{{WRAPPER}} .form-areas' => 'max-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $instance->end_controls_section();
    }
}

if ( ! function_exists( 'growla_cf7_button_styles' ) ) {
    function growla_cf7_button_styles( $instance ) {
        if ( null === $instance ) {
			return;
		}
        
        $instance->start_controls_section(
            'button_style',
            [
              'label' => esc_html__('Button', 'growla'),
              'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $instance->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_html__('Typography', 'growla'),
                'selector' => '{{WRAPPER}} button.wpcf7-submit',
            ]
        );

        $instance->add_control(
            'hover_color',
            [
            'label' => esc_html__('Hover Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} button.wpcf7-submit' => 'border-color : {{VALUE}};',
                '{{WRAPPER}} button.wpcf7-submit::before' => 'background-color : {{VALUE}};'
            ]
            
            ]
        );

        $instance->start_controls_tabs( 'button_tabs' );
    
        $instance->start_controls_tab(
            'button_normal',
            [
                'label' => esc_html__( 'Normal', 'growla' ),
            ]
        );

        $instance->add_control(
            'button_text_color',
            [
            'label' => esc_html__('Text color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} button.wpcf7-submit' => '--color : {{VALUE}};'
            ]
            
            ]
        );

        $instance->end_controls_tab();

        $instance->start_controls_tab(
            'button_hover',
            [
                'label' => esc_html__( 'Hover', 'growla' ),
            ]
        );

        $instance->add_control(
            'button_text_color_hover',
            [
            'label' => esc_html__('Text color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} button.wpcf7-submit:hover' => '--color : {{VALUE}};'
            ]
            
            ]
        );

        $instance->end_controls_tab();

        $instance->end_controls_tabs();

        $instance->end_controls_section();
    }
}

if ( ! function_exists( 'growla_cf7_dropdown_styles' ) ) {
    function growla_cf7_dropdown_styles( $instance ) {
        if ( null === $instance ) {
			return;
		}
        
        $instance->start_controls_section(
            'dropdown_style',
            [
              'label' => esc_html__('Dropdown', 'growla'),
              'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $instance->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'dropdown_typography',
                'label' => esc_html__('Label Typography', 'growla'),
                'selector' => '{{WRAPPER}} .growla-select .ts-control input',
            ]
        );

        $instance->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'option_typograhy',
                'label' => esc_html__('Option Typography', 'growla'),
                'selector' => '{{WRAPPER}} .growla-select .ts-dropdown .option',
            ]
        );

        $instance->start_controls_tabs( 'dropdown_tabs' );
    
        $instance->start_controls_tab(
            'dropdown_normal',
            [
                'label' => esc_html__( 'Normal', 'growla' ),
            ]
        );

        $instance->add_control(
            'option_color_normal',
            [
            'label' => esc_html__('Option Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-select .ts-dropdown' => 'color : {{VALUE}};'
            ]
            
            ]
        );

        $instance->add_control(
            'option_background_color_normal',
            [
            'label' => esc_html__('Option Background Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-select .ts-dropdown' => 'background-color : {{VALUE}};'
            ]
            
            ]
        );

        $instance->add_control(
            'border_color_normal',
            [
            'label' => esc_html__('Border Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-select .ts-control' => 'border-color : {{VALUE}};'
            ]
            
            ]
        );

    
        $instance->end_controls_tab();

        $instance->start_controls_tab(
            'dropdown_active',
            [
                'label' => esc_html__( 'Active', 'growla' ),
            ]
        );

        $instance->add_control(
            'option_color_active',
            [
            'label' => esc_html__('Option Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-select .ts-dropdown .active,{{WRAPPER}} .growla-select .ts-dropdown .ts-dropdown-content div:hover' => 'color : {{VALUE}};'
            ]
            
            ]
        );

        $instance->add_control(
            'option_background_color_active',
            [
            'label' => esc_html__('Option Background Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-select .ts-dropdown .active,{{WRAPPER}} .growla-select .ts-dropdown .ts-dropdown-content div:hover' => 'background-color : {{VALUE}};'
            ]
            
            ]
        );

        $instance->add_control(
            'border_color_active',
            [
            'label' => esc_html__('Border Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-select .input-active .ts-control' => 'border-color : {{VALUE}};'
            ]
            
            ]
        );

        $instance->end_controls_tab();

        $instance->end_controls_tabs();

        $instance->end_controls_section();
    }
}