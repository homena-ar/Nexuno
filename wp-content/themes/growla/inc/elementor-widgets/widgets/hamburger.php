<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Hamburger extends \Elementor\Widget_Base

{

    public function get_name()
    {
        return 'growla_hamburger_menu';
    }

    public function get_title()
    {
        return esc_html__('Hamburger Menu', 'growla');
    }

    public function get_icon()
    {
        return 'eicon-menu-bar';
    }

    public function get_categories()
    {
        return ['gfxpartner'];
    }

    protected function register_controls()
    {

        // content - start

        $this->start_controls_section(
            'header',
            [
                'label' => esc_html__('Content', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'content_template',
            [
                'label'       => esc_html__( 'Template', 'growla' ),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => '0',
                'options'     => growla_get_elementor_templates(),
                'description' => esc_html__( 'You can create new templates or customize existing templates by going to the \'Templates\' menu item (Besides the \'Elementor\' menu item) on the dashboard.', 'growla' ),
            ]
        );

        $this->end_controls_section();

        // content - end

        // style - start

        $this->start_controls_section(
            'style',
            [
                'label' => esc_html__('Style', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'direction',
			[
				'label' => esc_html__( 'Direction', 'growla' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => esc_html__( 'Left', 'growla' ),
					'right' => esc_html__( 'Right', 'growla' ),
				],
			]
		);

        // tabs - start

        $this->start_controls_tabs( 'icon_color' );

        $this->start_controls_tab(
            'icon_normal',
            [
                'label' => esc_html__( 'Normal', 'growla' ),
            ]
        );

        $this->add_control(
			'icon_color_normal',
			[
				'label' => esc_html__( 'Icon Color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bars .bar' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_sticky',
            [
                'label' => esc_html__( 'Sticky', 'growla' ),
            ]
        );

        $this->add_control(
			'icon_color_sticky',
			[
				'label' => esc_html__( 'Icon Color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'.sticky-nav.scrolled .elementor-element-{{ID}} .bars .bar' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        // tabs - end

        $this->add_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'growla' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'rem', 'vw' ],
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
					'{{WRAPPER}} .hamburger-content' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'growla' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'rem', 'vh' ],
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
					'{{WRAPPER}} .hamburger' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        // style - end

    }

    private function get_nav_menu_names() {
        $data = get_terms( 'nav_menu', [ 'hide_empty' => true ] );
        $result = [];
        if ( is_array( $data ) || is_object( $data ) ) {
            foreach( $data as $obj ) {
                $result[ $obj->term_id ] = $obj->name;
            }
        }
        return $result;
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('main_class', 'class', [ 'hamburger', 'direction-' . $settings['direction'] ]);
    ?>
        <div
        <?php $this->print_render_attribute_string('main_class');  ?>
        >
            <div class="hamburger-wrapper">
                <div class="hamburger-icon">
                    <svg 
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        width="27px" height="11px">
                        <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
                        d="M-0.003,8.932 L26.997,8.932 L26.997,10.932 L-0.003,10.932 L-0.003,8.932 ZM26.997,0.932 L26.997,2.932 L-0.003,2.932 L-0.003,0.932 L26.997,0.932 Z"/>
                    </svg>
                </div>
                <div class="hamburger-content">
                <?php
                    $content = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( 
                        $settings['content_template']
                    );
                    echo wp_kses( $content, 'elementor-template' );
                ?>
                </div>
                <div class="hamburger-overlay"></div>
            </div>
        </div>
    <?php
    }
}
