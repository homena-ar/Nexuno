<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class Button extends \Elementor\Widget_Base {

  public function get_name(){
    return 'growla_button';
  }

  public function get_title() {
    return esc_html__('Button', 'growla');
  }

  public function get_icon() {
    return 'eicon-button';
  }

  public function get_categories(){
    return ['gfxpartner'];
  }

    private function button_content_controls() {
        $this->start_controls_section(
            'button_content',
            [
            'label' => esc_html__('Content', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
    
    
        $this->add_control(
            'button_text',
            [
            'label' => esc_html__('Text', 'growla'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Button text',
            'dynamic' => [
                'active' => true,
                ],
            ]
        );
    
        $this->add_control(
            'button_link',
            [
                'label' => esc_html__('Link', 'growla'),
                'type' => \Elementor\Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
            
            ]
        );
    
        $this->add_control(
            'button_icon',
            [
                'label' => __('Icon', 'growla'),
                'type' => \Elementor\Controls_Manager::ICONS
            ]
        );
    
        $this->end_controls_section();
    }

    private function button_style_controls() {
        $this->start_controls_section(
            'button_custom_style',
            [
                'label' => esc_html__('Style', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_text',
                'label' => esc_html__('Text', 'growla'),
                'selector' => '{{WRAPPER}} .growla-button',
            ]
        );

        $this->add_responsive_control(
            'button_align',
            [
                'label'         => esc_html__( 'Alignment', 'growla' ),
                'type'          => \Elementor\Controls_Manager::CHOOSE,
                'options'       => [
                    'left'      => [
                        'title'=> __( 'Left', 'growla' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center'    => [
                        'title'=> __( 'Center', 'growla' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right'     => [
                        'title'=> __( 'Right', 'growla' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default'       => 'center',
                'selectors'     => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__( 'Width', 'growla' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'rem' ],
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
            'rem' => [
            'min' => 0,
            'max' => 100
            ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .growla-button' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'growla' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .growla-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'hover_style',
			[
				'label' => esc_html__( 'Hover Style', 'growla' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'background',
				'options' => [
					'background' => esc_html__( 'Background', 'growla' ),
					'icon' => esc_html__( 'Icon', 'growla' ),
                    'underline' => esc_html__( 'Underline', 'growla' ),
				]
			]
		);

        $this->button_state_style_controls();

    $this->end_controls_section();
    }

    private function button_state_style_controls() {
        $this->start_controls_tabs( 'button_tabs' );
    
        $this->start_controls_tab(
            'button_normal',
            [
                'label' => esc_html__( 'Normal', 'growla' ),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
            'label' => esc_html__('Text color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-button' => '--button-color: {{VALUE}};'
            ]
            
            ]
        );

        $this->add_control(
            'button_background_color',
            [
            'label' => esc_html__('Background color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-button' => 'background-color: {{VALUE}};'
            ]
            
            ]
        );

        $this->add_control(
            'button_icon_color',
            [
            'label' => esc_html__('Icon color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-button .icon' => '--button-icon-color: {{VALUE}};'
            ]
            
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .growla-button',
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_hover',
            [
                'label' => esc_html__( 'Hover', 'growla' ),
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
            'label' => esc_html__('Text color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-button-background-hover:hover' => '--button-hover-color: {{VALUE}};'
            ]
            
            ]
        );

        $this->add_control(
            'button_background_color_hover',
            [
            'label' => esc_html__('Background color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-button-background-hover:hover::before' => 'background-color: {{VALUE}};'
            ]
            
            ]
        );

        $this->add_control(
            'button_icon_color_hover',
            [
            'label' => esc_html__('Icon color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-button-background-hover:hover .icon' => '--button-hover-icon-color: {{VALUE}};'
            ]
            
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border_hover',
                'selector' => '{{WRAPPER}} .growla-button-background-hover:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
    }

  protected function register_controls(){
    $this->button_content_controls();
    $this->button_style_controls();
  }
  
  protected function render(){
    $settings = $this->get_settings_for_display(); 

    if ( $settings['button_link']['is_external'] )
      $this->add_render_attribute('button_attr', 'target', '_blank');

    if ( $settings['button_link']['nofollow'] )
      $this->add_render_attribute('button_attr', 'rel', 'nofollow');

    if ( !empty( $settings['button_link']['url'] ) )
      $this->add_render_attribute('button_attr', 'href', $settings['button_link']['url']);
 
    $icon = $settings['button_icon'];

    $class_list = array( 'growla-button', 'growla-button-' . $settings['hover_style'] . '-hover' );

    $this->add_render_attribute('button_attr', 'class', $class_list);

  ?>
    <a <?php $this->print_render_attribute_string('button_attr');  ?>>
        <span><?php echo esc_html( $settings['button_text'] ); ?></span>
        
        <?php if ( ! empty( $icon['value'] ) ): ?>
            <span class="icon">
                <?php
                    // icon
                    \Elementor\Icons_Manager::render_icon( 
                        $settings['button_icon'], 
                        [ 'aria-hidden' => 'true' ]
                    ); 
                ?>
            </span>
        <?php endif; ?>
    </a>
    <?php
  }
}
