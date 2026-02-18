<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Menu extends \Elementor\Widget_Base

{

    public function get_name()
    {
        return 'growla_menu';
    }

    public function get_title()
    {
        return esc_html__('Menu', 'growla');
    }

    public function get_icon()
    {
        return 'eicon-nav-menu';
    }

    public function get_categories()
    {
        return ['gfxpartner'];
    }

    protected function register_controls()
    {

        // content - start

        $this->start_controls_section(
            'content',
            [
                'label' => esc_html__('Content', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'menu_display_select',
			[
				'label' => esc_html__( 'Type', 'growla' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'desktop',
				'options' => [
                    'desktop' => esc_html__( 'Desktop', 'growla' ),
                    'mobile' => esc_html__( 'Mobile', 'growla' )
                ],
			]
		);

        $this->add_control(
			'menu_slider_mode',
			[
				'label' => esc_html__( 'Slider Mode', 'growla' ),
                'description' => esc_html__( 'When enabled, if the links take more width than the container, the menu will appear as a slider.', 'growla' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'growla' ),
				'label_off' => esc_html__( 'Hide', 'growla' ),
				'return_value' => 'yes',
				'default' => 'no',
                'condition' => [ 'menu_display_select' => 'desktop' ]
			]
		);

        $this->add_control(
			'menu_select',
			[
				'label' => esc_html__( 'Menu', 'growla' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => growla_get_nav_menu_names(),
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
			'height',
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
					'{{WRAPPER}}' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_type',
                'label' => esc_html__('Text', 'growla'),
                'selector' => '{{WRAPPER}} .navigation-menu > li > a',
            ]
        );

        

        $this->start_controls_tabs( 'menu_tabs' );
    
        $this->start_controls_tab(
            'menu_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'growla' ),
            ]
        );

        $this->add_control(
            'text_color_normal',
            [
              'label' => esc_html__('Text color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .navigation-menu > li > a' => 'color : {{VALUE}};'
              ]
              
            ]
        );

        $this->add_control(
            'dropdown_arrow_color_normal',
            [
              'label' => esc_html__('Arrow color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .navigation-menu > li.menu-item-has-children > a > .icon' => 'fill : {{VALUE}};'
              ]
              
            ]
        );

        $this->end_controls_tab(); // end tab

        $this->start_controls_tab(
            'menu_sticky_tab',
            [
                'label' => esc_html__( 'Sticky', 'growla' ),
            ]
        );

        $unq = $this->get_unique_selector();

        $this->add_control(
            'text_color_sticky',
            [
              'label' => esc_html__('Text color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '.sticky-nav.scrolled .elementor-element-{{ID}} .navigation-menu > li > a' => 'color : {{VALUE}} !important;'
              ]
              
            ]
        );

        $this->add_control(
            'dropdown_arrow_color_sticky',
            [
              'label' => esc_html__('Arrow color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '.sticky-nav.scrolled .elementor-element-{{ID}} .navigation-menu > li.menu-item-has-children > a > .icon' => 'fill : {{VALUE}};'
              ]
              
            ]
        );

        $this->end_controls_tab(); // end tab

        $this->end_controls_tabs(); // end tabs

        $this->end_controls_section();

        // style - end

        // style - start

        $this->start_controls_section(
            'dropdown_section',
            [
                'label' => esc_html__('Dropdown', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'dropdown_text_type',
                'label' => esc_html__('Text', 'growla'),
                'selector' => '{{WRAPPER}} .sub-menu li a',
            ]
        );

        $this->add_control(
            'dropdown_text_color',
            [
              'label' => esc_html__('Text color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .sub-menu li a' => 'color : {{VALUE}};'
              ]
              
            ]
        );

        $this->add_control(
			'dropdown_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sub-menu .submenu' => 'background-color: {{VALUE}}',
                    '.header .nav-dropdown-bg' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if ( empty( $settings['menu_select'] ) && ! is_nav_menu( $settings['menu_select'] ) ) return;

        $class = 'navigation-menu ' . $settings['menu_display_select'];
        $container_class = 'navigation-menu-wrapper menu-' . $this->get_id();

        if ( $settings['menu_display_select'] == 'desktop' ) {
            $container_class .= ' desktop-wrapper';

            if ( $settings['menu_slider_mode'] == 'yes' ) {
                $class .= ' swiper-wrapper';
                $container_class .= ' swiper';
            }
        }
    ?>
    <?php if ( $settings['menu_display_select'] == 'desktop' ): ?>
        <div class="navigation-slider-wrapper">
    <?php endif; ?>

        <?php
            wp_nav_menu([
                'menu' => $settings['menu_select'],
                'menu_class' => $class,
                'container_class' => $container_class,
                'theme_location' => 'primary-menu',
            ]);
        ?>

    <?php if ( $settings['menu_display_select'] == 'desktop' ): ?>
        </div>
    <?php endif; ?>
    <?php
    }
}
