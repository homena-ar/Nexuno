<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class HamburgerClose extends \Elementor\Widget_Base {

  public function get_name(){
    return 'growla_hamburger_close';
  }

  public function get_title() {
    return esc_html__('Hamburger close', 'growla');
  }

  public function get_icon() {
    return 'eicon-close';
  }

  public function get_categories(){
    return ['gfxpartner'];
  }

  protected function register_controls(){

    // button content -  start

    $this->start_controls_section(
      'button_content',
      [
        'label' => esc_html__('Content', 'growla'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT
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

    // button content -  end

    // button style -  start

    $this->start_controls_section(
        'button_custom_style',
        [
          'label' => esc_html__('Style', 'growla'),
          'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_control(
			'size',
			[
				'label' => esc_html__( 'Size', 'growla' ),
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
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .hamburger-close i' => 'font-size: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

    $this->add_responsive_control(
      'align',
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
              '{{WRAPPER}} .hamburger-close' => 'text-align: {{VALUE}};',
          ],
      ]
    );

    $this->add_control(
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
						'max' => 100,
					],
				],
				'selectors' => [
          '{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
          '{{WRAPPER}} div' => 'width: {{SIZE}}{{UNIT}};',
				],
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
						'step' => 5,
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
					'{{WRAPPER}} .hamburger-close' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

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
            '{{WRAPPER}} .icon' => 'color : {{VALUE}} !important; fill : {{VALUE}} !important;'
          ]
          
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
          'label' => esc_html__('Text hover color', 'growla'),
          'type' => \Elementor\Controls_Manager::COLOR,
          'selectors' => [
            '{{WRAPPER}} .icon:hover' => 'color : {{VALUE}} !important; fill : {{VALUE}} !important;'
          ]
          
        ]
    );

    $this->end_controls_tab();

    $this->end_controls_tabs();  

    $this->end_controls_section();

    // button style -  end
  
  }
  

  protected function render(){
    $settings = $this->get_settings_for_display();
 
  ?>
    <div class="hamburger-close">
        <?php
          // icon
          \Elementor\Icons_Manager::render_icon( 
            $settings['button_icon'], 
            [ 'aria-hidden' => 'true', 'class' => 'icon' ]
          ); 
        ?>
    </div>
    <?php
  }
}
