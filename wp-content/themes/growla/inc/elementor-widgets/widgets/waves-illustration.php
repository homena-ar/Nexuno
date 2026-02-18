<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class WavesIllustration extends \Elementor\Widget_Base {

  public function get_name(){
    return 'growla_waves_illustration';
  }

  public function get_title() {
    return esc_html__('Waves Illustration', 'growla');
  }

  public function get_icon() {
    return 'eicon-lottie';
  }

  public function get_categories(){
    return ['gfxpartner'];
  }

  private function waves_illustration_styles() {
    $this->start_controls_section(
        'waves_illustration_styles',
        [
            'label' => esc_html__('Waves Illustration', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_control(
        'waves_color',
        [
            'label' => esc_html__( 'Color', 'growla' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .waves-illustration path' => 'stroke: {{VALUE}} !important',
            ],
        ]
    );

    $this->end_controls_section();
  }

  protected function register_controls(){
    $this->waves_illustration_styles();
  }
  
  protected function render(){
    $settings = $this->get_settings_for_display();
    get_template_part( 'inc/template-parts/illustrations/illustration', 'waves' );
  }
}
