<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class Illustration extends \Elementor\Widget_Base {

  public function get_name(){
    return 'growla_illustration';
  }

  public function get_title() {
    return esc_html__('Illustration', 'growla');
  }

  public function get_icon() {
    return 'eicon-integration';
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
			'first_image',
			[
				'label' => esc_html__( 'First Image', 'growla' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
                'dynamic' => [
                    'active' => true,
                ],
			]
		);

        $this->add_control(
			'second_image',
			[
				'label' => esc_html__( 'Second Image', 'growla' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
                'dynamic' => [
                    'active' => true,
                ],
			]
		);
    
        $this->end_controls_section();
    }

    private function style_controls() {
        $this->start_controls_section(
            'style',
            [
            'label' => esc_html__('Style', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'box_color',
			[
				'label' => esc_html__( 'Color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .growla-illustration' => '--box-color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_section();
    }

  protected function register_controls(){
    $this->content_controls();
    $this->style_controls();
  }
  
  protected function render(){
    $settings = $this->get_settings_for_display();
  ?>
    <div class="growla-illustration">
        <div class="growla-illustration-first-image">
            <div class="growla-illustration-first-image-wrapper">
                <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'growla-illustration-img-1', 'first_image' ); ?>
            </div>
        </div>
        <div class="growla-illustration-second-image">
            <div class="growla-illustration-second-image-wrapper">
                <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'growla-illustration-img-2', 'second_image' ); ?>
            </div>
        </div>
        <div class="growla-illustration-boxes">
            <div class="growla-illustration-box-row growla-illustration-box-row-end">
                <div class="growla-illustration-box"></div>
                <div class="growla-illustration-box growla-illustration-box-filled"></div>
            </div>
            <div class="growla-illustration-box-row growla-illustration-box-row-2">
                <div class="growla-illustration-box growla-illustration-box-filled"></div>
                <div class="growla-illustration-box"></div>
            </div>
            <div class="growla-illustration-box-row growla-illustration-box-row-space-between">
                <div class="growla-illustration-box growla-illustration-box-filled"></div>
                <div class="growla-illustration-box"></div>
            </div>
            <div class="growla-illustration-box-row growla-illustration-box-row-center">
                <div class="growla-illustration-box"></div>
            </div>
        </div>
    </div>
    <?php
  }
}
