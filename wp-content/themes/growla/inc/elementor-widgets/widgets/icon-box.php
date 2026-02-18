<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class IconBox extends \Elementor\Widget_Base {

  public function get_name(){
    return 'growla_icon_box';
  }

  public function get_title() {
    return esc_html__('Icon Box', 'growla');
  }

  public function get_icon() {
    return 'eicon-icon-box';
  }

  public function get_categories(){
    return ['gfxpartner'];
  }

  private function content_controls() {
    $this->start_controls_section(
        'content',
        [
            'label' => esc_html__('Content', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT
        ]
    );

    $this->add_control(
        'icon',
        [
            'label' => __('Icon', 'growla'),
            'type' => \Elementor\Controls_Manager::ICONS,
        ]
    );

    $this->add_control(
        'heading',
        [
            'label' => esc_html__( 'Text', 'growla' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default' => 'Default Heading',
            'dynamic' => [
                'active' => true,
            ],
        ]
    );

    $this->add_control(
        'textarea',
        [
            'label' => esc_html__( 'Content', 'growla' ),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'Default Content',
            'dynamic' => [
                'active' => true,
            ],
        ]
    );

    $this->add_control(
        'link',
        [
            'label' => esc_html__('Link', 'growla'),
            'type' => \Elementor\Controls_Manager::URL,
            'dynamic' => [
                'active' => true,
            ],
        ]
    );

    $this->end_controls_section();
  }

  private function general_styles() {
    $this->start_controls_section(
        'general_style',
        [
          'label' => esc_html__('General', 'growla'),
          'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_control(
        'background_color',
        [
          'label' => esc_html__('Background color', 'growla'),
          'type' => \Elementor\Controls_Manager::COLOR,
          'selectors' => [
            '{{WRAPPER}} .growla-icon-box' => 'background-color : {{VALUE}};'
          ]
          
        ]
      );

    $this->add_control(
        'outline_color',
        [
          'label' => esc_html__('Outline color', 'growla'),
          'type' => \Elementor\Controls_Manager::COLOR,
          'selectors' => [
            '{{WRAPPER}} .growla-icon-box:hover' => 'outline-color : {{VALUE}};'
          ]
          
        ]
      );

    $this->end_controls_section();
  }

  private function icon_styles() {
    $this->start_controls_section(
        'icon_style',
        [
          'label' => esc_html__('Icon', 'growla'),
          'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_control(
        'icon_size',
        [
            'label' => esc_html__( 'Icon Size', 'growla' ),
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
                '{{WRAPPER}} .growla-icon-box-icon svg' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->start_controls_tabs( 'icon_tabs' );
    
    $this->start_controls_tab(
        'icon_normal',
        [
            'label' => esc_html__( 'Normal', 'growla' ),
        ]
    );

    $this->add_control(
        'icon_color_normal',
        [
        'label' => esc_html__('Text color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-icon-box .growla-icon-box-icon svg' => 'fill : {{VALUE}} !important;',
            '{{WRAPPER}} .growla-icon-box .growla-icon-box-icon svg path' => 'fill : {{VALUE}} !important;'
        ]
        
        ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
        'icon_hover',
        [
            'label' => esc_html__( 'Hover', 'growla' ),
        ]
    );

    $this->add_control(
        'icon_color_hover',
        [
        'label' => esc_html__('Text color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-icon-box:hover .growla-icon-box-icon svg' => 'fill : {{VALUE}} !important;',
            '{{WRAPPER}} .growla-icon-box:hover .growla-icon-box-icon svg path' => 'fill : {{VALUE}} !important;'
        ]
        
        ]
    );

    $this->end_controls_tab();

    $this->end_controls_tabs();

    $this->end_controls_section();
  }

  private function heading_styles() {
    $this->start_controls_section(
        'heading_style',
        [
          'label' => esc_html__('Heading', 'growla'),
          'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'heading_typography',
            'label' => esc_html__('Typography', 'growla'),
            'selector' => '{{WRAPPER}} .growla-icon-box-content h6',
        ]
    );

    $this->add_control(
        'heading_color',
        [
          'label' => esc_html__('Color', 'growla'),
          'type' => \Elementor\Controls_Manager::COLOR,
          'selectors' => [
            '{{WRAPPER}} .growla-icon-box-content h6' => 'color : {{VALUE}};'
          ]
          
        ]
      );


    $this->end_controls_section();
  }

  private function content_styles() {
    $this->start_controls_section(
        'content_style',
        [
          'label' => esc_html__('Content', 'growla'),
          'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'content_typography',
            'label' => esc_html__('Typography', 'growla'),
            'selector' => '{{WRAPPER}} .growla-icon-box-content p',
        ]
    );

    $this->add_control(
        'content_color',
        [
          'label' => esc_html__('Color', 'growla'),
          'type' => \Elementor\Controls_Manager::COLOR,
          'selectors' => [
            '{{WRAPPER}} .growla-icon-box-content p' => 'color : {{VALUE}};'
          ]
          
        ]
      );


    $this->end_controls_section();
  }

  private function style_controls() {
    $this->general_styles();
    $this->icon_styles();
    $this->heading_styles();
    $this->content_styles();
  }

  protected function register_controls(){
    $this->content_controls();
    $this->style_controls();
  }
  

  protected function render(){
    $settings = $this->get_settings_for_display();
    $attribute_id = 'link';
    $is_link_empty = true;

    $this->add_render_attribute($attribute_id, 'class', 'growla-icon-box');

    if ( $settings['link']['is_external'] ) {
        $this->add_render_attribute($attribute_id, 'target', '_blank');
    }

    if ( $settings['link']['nofollow'] ) {
        $this->add_render_attribute($attribute_id, 'rel', 'nofollow');
    }

    if ( !empty( $settings['link']['url'] ) ) {
        $this->add_render_attribute($attribute_id, 'href', $settings['link']['url']);
        $is_link_empty = false;
    }
  ?>
    <?php if ( $is_link_empty ): ?>
        <div class="growla-icon-box">
    <?php else: ?>
        <a <?php $this->print_render_attribute_string($attribute_id);  ?>>
    <?php endif; ?>
    
        <?php if ( ! empty( $settings['icon']['value'] ) ): ?>
        <div class="growla-icon-box-icon">
            <?php growla_render_icon( $settings['icon'] ); ?>
        </div>
        <?php endif; ?>

        <?php if ( ! empty( $settings['heading'] ) || ! empty( $settings['textarea'] ) ): ?>
        <div class="growla-icon-box-content">
            <?php if ( ! empty( $settings['heading'] ) ): ?>
                <h6><?php echo esc_html( $settings['heading'] ); ?></h6>
            <?php endif; ?>

            <?php if ( ! empty( $settings['textarea'] ) ): ?>
                <p><?php echo esc_html( $settings['textarea'] ); ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    <?php if ( $is_link_empty ): ?>
        </div>
    <?php else: ?>
        </a>
    <?php endif; ?>
    <?php
  }
}
