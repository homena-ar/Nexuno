<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class CollapseTab extends \Elementor\Widget_Base {

  public function get_name(){
    return 'growla_collapse_tab';
  }

  public function get_title() {
    return esc_html__('Collapse Tab', 'growla');
  }

  public function get_icon() {
    return 'eicon-tabs';
  }

  public function get_categories(){
    return ['gfxpartner'];
  }

  private function content_controls() {
    $this->start_controls_section(
        'content_section',
        [
        'label' => esc_html__('Content', 'growla'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT
        ]
    );

    $this->add_control(
        'heading',
        [
            'label' => esc_html__('Heading', 'growla'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default' => 'Sample heading',
            'dynamic' => [
                'active' => true,
                ],
        ]
    );

    growla_tag_select( $this, 'heading_tag', esc_html__( 'Tag', 'growla' ), 'h3' );

    $this->add_control(
        'subheading',
        [
            'label' => esc_html__('Subheading', 'growla'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default' => 'Sample subheading',
            'dynamic' => [
                'active' => true,
                ],
        ]
    );

    $this->add_control(
        'excerpt',
        [
            'label' => esc_html__( 'Excerpt', 'growla' ),
            'type' => \Elementor\Controls_Manager::WYSIWYG,
            'default' => wp_kses( '<p>' . __( 'Default excerpt', 'growla' ) . '</p>', 'post' ),
            'placeholder' => esc_html__( 'Type your excerpt here', 'growla' ),
            
        ]
    );

    $this->add_control(
        'content',
        [
            'label' => esc_html__( 'Content', 'growla' ),
            'type' => \Elementor\Controls_Manager::WYSIWYG,
            'default' => wp_kses( '<p>' . __( 'Default description', 'growla' ) . '</p>', 'post' ),
            'placeholder' => esc_html__( 'Type your description here', 'growla' ),
        ]
    );

    $this->end_controls_section();
  }

  private function icon_controls() {
    $this->start_controls_section(
        'icon_section',
        [
        'label' => esc_html__('Icon', 'growla'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT
        ]
    );

    $this->start_controls_tabs( 'button_tabs' );
    
    $this->start_controls_tab(
        'icon_normal_tab',
        [
            'label' => esc_html__( 'Normal', 'growla' ),
        ]
    );

    $this->add_control(
        'normal_icon',
        [
            'label' => __('Icon', 'growla'),
            'type' => \Elementor\Controls_Manager::ICONS
        ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
        'icon_active_tab',
        [
            'label' => esc_html__( 'Active', 'growla' ),
        ]
    );

    $this->add_control(
        'active_icon',
        [
            'label' => __('Icon', 'growla'),
            'type' => \Elementor\Controls_Manager::ICONS
        ]
    );

    $this->end_controls_tab();

    $this->end_controls_tabs();

    $this->end_controls_section();
  }

  private function general_styles() {
    $this->start_controls_section(
        'general_styles',
        [
          'label' => esc_html__('General', 'growla'),
          'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_control(
        'background_color',
        [
        'label' => esc_html__('Background Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-collapse' => 'background-color : {{VALUE}};'
        ]
        
        ]
    );

    $this->end_controls_section();
  }

  private function heading_styles() {
    $this->start_controls_section(
        'heading_styles',
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
            'selector' => '{{WRAPPER}} .growla-collapse-heading',
        ]
    );

    $this->add_control(
        'heading_color',
        [
        'label' => esc_html__('Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-collapse-heading' => 'color : {{VALUE}};'
        ]
        
        ]
    );

    $this->end_controls_section();
  }

  private function subheading_styles() {
    $this->start_controls_section(
        'subheading_styles',
        [
          'label' => esc_html__('Subheading', 'growla'),
          'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'subheading_typography',
            'label' => esc_html__('Typography', 'growla'),
            'selector' => '{{WRAPPER}} .growla-collapse-inner > h6',
        ]
    );

    $this->add_control(
        'subheading_color',
        [
        'label' => esc_html__('Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-collapse-inner > h6' => 'color : {{VALUE}};'
        ]
        
        ]
    );

    $this->end_controls_section();
  }

  private function excerpt_styles() {
    $this->start_controls_section(
        'excerpt_styles',
        [
          'label' => esc_html__('Excerpt', 'growla'),
          'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'excerpt_typography',
            'label' => esc_html__('Typography', 'growla'),
            'selector' => '{{WRAPPER}} .growla-collapse-excerpt *',
        ]
    );

    $this->add_control(
        'excerpt_color',
        [
        'label' => esc_html__('Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-collapse-excerpt *' => 'color : {{VALUE}};'
        ]
        
        ]
    );

    $this->end_controls_section();
  }

  private function content_styles() {
    $this->start_controls_section(
        'content_styles',
        [
          'label' => esc_html__('Content', 'growla'),
          'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'content_paragraph_typography',
            'label' => esc_html__('Paragraph Typography', 'growla'),
            'selector' => '{{WRAPPER}} .growla-collapse-content p',
        ]
    );

    $this->add_control(
        'content_paragraph_color',
        [
        'label' => esc_html__('Paragraph Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-collapse-content p' => 'color : {{VALUE}};'
        ]
        
        ]
    );

    $this->add_control(
        'content_heading_color',
        [
        'label' => esc_html__('Heading Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-collapse-content h1' => 'color : {{VALUE}};',
            '{{WRAPPER}} .growla-collapse-content h2' => 'color : {{VALUE}};',
            '{{WRAPPER}} .growla-collapse-content h3' => 'color : {{VALUE}};',
            '{{WRAPPER}} .growla-collapse-content h4' => 'color : {{VALUE}};',
            '{{WRAPPER}} .growla-collapse-content h5' => 'color : {{VALUE}};',
            '{{WRAPPER}} .growla-collapse-content h6' => 'color : {{VALUE}};'
        ]
        
        ]
    );

    $this->end_controls_section();
  }

  private function icon_styles() {
    $this->start_controls_section(
        'icon_styles',
        [
          'label' => esc_html__('Icon', 'growla'),
          'tab' => \Elementor\Controls_Manager::TAB_STYLE
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
        'label' => esc_html__('Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-collapse .growla-collapse-icon div *' => 'color : {{VALUE}}; fill : {{VALUE}};'
        ]
        
        ]
    );

    $this->add_control(
        'icon_background_color_normal',
        [
        'label' => esc_html__('Background Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-collapse .growla-collapse-icon' => 'background-color : {{VALUE}};'
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
        'label' => esc_html__('Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-collapse:hover .growla-collapse-icon div *' => 'color : {{VALUE}}; fill : {{VALUE}};'
        ]
        
        ]
    );

    $this->add_control(
        'icon_background_color_hover',
        [
        'label' => esc_html__('Background Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-collapse:hover .growla-collapse-icon' => 'background-color : {{VALUE}};'
        ]
        
        ]
    );

    $this->end_controls_tab();

    $this->end_controls_tabs();

    $this->end_controls_section();
  }

  protected function register_controls(){
    $this->content_controls();
    $this->icon_controls();

    $this->general_styles();
    $this->heading_styles();
    $this->subheading_styles();
    $this->excerpt_styles();
    $this->content_styles();
    $this->icon_styles();
  }
  
  protected function render(){
    $settings = $this->get_settings_for_display();

  ?>
    <div class="growla-collapse">
        <div class="growla-collapse-inner">
            <?php if ( ! empty( $settings['heading'] ) ): ?>
            <<?php echo esc_html( $settings['heading_tag'] ); ?> class="growla-collapse-heading">
                <?php echo esc_html( $settings['heading'] ); ?>
            </<?php echo esc_html( $settings['heading_tag'] ); ?>>
            <?php endif; ?>

            <?php if ( ! empty( $settings['subheading'] ) ): ?>
            <h6>
                <?php echo esc_html( $settings['subheading'] ); ?>
            </h6>
            <?php endif; ?>

            <div class="growla-collapse-content-wrapper">
                <div class="growla-collapse-excerpt">
                    <?php echo do_shortcode( wp_kses( $settings['excerpt'], 'post' ) ); ?>
                </div>

                <div class="growla-collapse-content">
                    <?php echo do_shortcode( wp_kses( $settings['content'] , 'post' ) ); ?>
                </div>
            </div>
        </div>

        <?php if ( ! empty( $settings['normal_icon']['value'] ) || ! empty( $settings['active_icon']['value'] ) ): ?>
        <div class="growla-collapse-icon">
            <?php if ( ! empty( $settings['normal_icon'] ) ): ?>
            <div class="normal-icon">
                <?php
                    \Elementor\Icons_Manager::render_icon( 
                        $settings['normal_icon'], 
                        [ 'aria-hidden' => 'true' ]
                    ); 
                ?>
            </div>
            <?php endif; ?>
            <?php if ( ! empty( $settings['active_icon'] ) ): ?>
            <div class="active-icon">
                <?php
                    \Elementor\Icons_Manager::render_icon( 
                        $settings['active_icon'], 
                        [ 'aria-hidden' => 'true' ]
                    ); 
                ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php
  }
}
