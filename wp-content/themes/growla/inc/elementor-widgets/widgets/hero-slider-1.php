<?php

if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class HeroSlider1 extends \Elementor\Widget_Base {

  public function get_name(){
    return 'growla_hero_slider_1';
  }

  public function get_title() {
    return esc_html__( 'Hero Slider 1', 'growla' );
  }

  public function get_icon() {
    return 'eicon-slider-3d';
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

      $repeater = new \Elementor\Repeater();
  
      $repeater->add_control(
          'hs_content_type',
          [
              'label'       => esc_html__( 'Type', 'growla' ),
              'type'        => \Elementor\Controls_Manager::SELECT,
              'default'     => 'text',
              'options'     => [
                  'text' => esc_html__( 'Text', 'growla' ),
                  'template' => esc_html__( 'Template', 'growla' ),
              ],
          ]
      );
  
      $repeater->add_control(
          'hs_wysiwyg',
          [
              'label' => esc_html__('Content', 'growla'),
              'type' => \Elementor\Controls_Manager::WYSIWYG,
              'rows' => 10,
              'placeholder' => esc_html__('Type your content here', 'growla'),
              'default' => 'Heading',
              'condition' => [
                  'hs_content_type' => 'text'
              ],
              'dynamic' => [
                'active' => true,
                ],
          ]
      );
  
      $repeater->add_control(
          'hs_content_template',
          [
              'label'       => esc_html__( 'Template', 'growla' ),
              'type'        => \Elementor\Controls_Manager::SELECT,
              'default'     => '0',
              'options'     => growla_get_elementor_templates(),
              'description' => esc_html__( 'You can create new templates or customize existing templates by going to the \'Templates\' menu item (Besides the \'Elementor\' menu item) on the dashboard.', 'growla' ),
              'condition' => [
                  'hs_content_type' => 'template'
              ]
          ]
      );

      $repeater->add_control(
        'hs_content_animation_notice',
        [
            'type' => \Elementor\Controls_Manager::NOTICE,
            'notice_type' => 'info',
            'dismissible' => false,
            'heading' => esc_html__( 'Animating slide content', 'growla' ),
            'content' => esc_html__( 'To animate any content present within the template, you can add this class \'growla-animate-slide\'', 'growla' ),
        ]
    );

      $repeater->add_control(
        'hs_illustration',
        [
            'label' => esc_html__( 'Illustration', 'growla' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'none',
            'options' => [
                'none' => esc_html__( 'None', 'growla' ),
                'waves'  => esc_html__( 'Waves', 'growla' ),
                'boxes-1' => esc_html__( 'Boxes 1', 'growla' ),
                'boxes-2' => esc_html__( 'Boxes 2', 'growla' ),
                'lines' => esc_html__( 'Lines', 'growla' ),
            ]
        ]
    );

    $repeater->add_control(
        'hs_video_background',
        [
            'label' => esc_html__( 'Video Background', 'growla' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__( 'Yes', 'growla' ),
            'label_off' => esc_html__( 'No', 'growla' ),
            'return_value' => 'yes',
            'default' => 'no',
        ]
    );

    $repeater->add_control(
        'hs_video',
        [
            'label' => esc_html__( 'Choose Video', 'growla' ),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'media_type' => 'video',
            'dynamic' => [
                'active' => true,
            ],
            'condition' => [
                'hs_video_background' => 'yes'
            ],
        ]
    );

    $repeater->add_control(
        'hs_video_overlay',
        [
            'label' => esc_html__( 'Video Color', 'growla' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'condition' => [
                'hs_video_background' => 'yes'
            ],
        ]
    );

    $repeater->add_control(
        'hs_bg_img',
        [
            'label' => esc_html__( 'Choose Image', 'growla' ),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'dynamic' => [
                'active' => true,
            ],
            'condition' => [
                'hs_video_background!' => 'yes'
            ],
        ]
    );
  
      $this->add_control(
          'hs_repeater',
          [
              'label' => __('Slides', 'growla'),
              'type' => \Elementor\Controls_Manager::REPEATER,
              'fields' => $repeater->get_controls(),
              'title_field' => __('Slide', 'growla'),
          ]
      );
  
      $this->end_controls_section();
  }

  private function general_style_controls() {
    $this->start_controls_section(
        'general_styles',
        [
            'label' => esc_html__('General', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_responsive_control(
        'slide_padding',
        [
            'label' => esc_html__( 'Slide Padding', 'growla' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'rem' ],
            'selectors' => [
                '{{WRAPPER}} .hero-slider .hero-slide-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_control(
        'full_screen_slide',
        [
            'label' => esc_html__( 'Full Screen Slides', 'growla' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__( 'Yes', 'growla' ),
            'label_off' => esc_html__( 'No', 'growla' ),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );
    
    $this->end_controls_section();
  }

  private function slider_navigation_controls() {
    $this->start_controls_section(
        'hs_slider_navigation',
        [
            'label' => esc_html__('Slider Navigation', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT
        ]
    );

    $this->add_control(
        'caption',
        [
            'label' => esc_html__( 'Caption', 'growla' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( 'Example Caption', 'growla' ),
        ]
    );

    $this->add_control(
        'navigation',
        array(
            'label'        => __( 'Slider navigation', 'growla' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => __( 'yes', 'growla' ),
            'label_off'    => __( 'no', 'growla' ),
            'return_value' => 'yes',
        )
    );

    $this->add_control(
        'navigation_type',
        [
            'label' => esc_html__( 'Navigation Type', 'growla' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'text',
            'options' => [
                'text' => esc_html__( 'Text', 'growla' ),
                'icon' => esc_html__( 'Icon', 'growla' ),
            ],
            'condition' => array( 'navigation' => 'yes' ),
        ]
    );

    $this->add_control(
        'prev_text',
        [
            'label' => esc_html__( 'Previous text', 'growla' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( 'PREV', 'growla' ),
            'condition' => array( 'navigation' => 'yes', 'navigation_type' => 'text' ),
        ]
    );

    $this->add_control(
        'next_text',
        [
            'label' => esc_html__( 'Next text', 'growla' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( 'NEXT', 'growla' ),
            'condition' => array( 'navigation' => 'yes', 'navigation_type' => 'text' ),
        ]
    );

    $this->add_control(
        'prev_icon',
        array(
            'label'     => __( 'Previous icon', 'growla' ),
            'type'      => \Elementor\Controls_Manager::ICONS,
            'condition' => array( 'navigation' => 'yes', 'navigation_type' => 'icon' ),
        )
    );

    $this->add_control(
        'next_icon',
        array(
            'label'     => __( 'Next icon', 'growla' ),
            'type'      => \Elementor\Controls_Manager::ICONS,
            'condition' => array( 'navigation' => 'yes', 'navigation_type' => 'icon' ),
        )
    );

    $this->add_control(
        'navigation_separator',
        [
            'label' => esc_html__( 'Separator', 'growla' ),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( '|', 'growla' ),
            'condition' => array( 'navigation' => 'yes' ),
        ]
    );

    $this->end_controls_section();
  }

  private function content_style_controls() {
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
            'name' => 'content_typography',
            'selector' => '{{WRAPPER}} .hero-slider .hero-slide-content .text',
        ]
    );
    
    $this->add_control(
        'content_color',
        [
            'label' => esc_html__( 'Color', 'growla' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hero-slider .hero-slide-content .text' => 'color: {{VALUE}}',
            ],
        ]
    );

    $this->end_controls_section();
  }

  private function slider_navigation_style_controls() {
    $this->start_controls_section(
        'slider_navigation_styles',
        [
            'label' => esc_html__('Slider Navigation', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'slider_navigation_typography',
            'selector' => '{{WRAPPER}} .hero-slider .slider-nav-text div',
        ]
    );
    
    $this->add_control(
        'slider_navigation_color',
        [
            'label' => esc_html__( 'Color', 'growla' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hero-slider .slider-nav-text div' => 'color: {{VALUE}}',
            ],
        ]
    );

    $this->end_controls_section();
  }

  private function slider_caption_style_controls() {
    $this->start_controls_section(
        'slider_caption_styles',
        [
            'label' => esc_html__('Slider Caption', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'slider_caption_typography',
            'selector' => '{{WRAPPER}} .hero-slider .hero-slider-nav .slider-caption',
        ]
    );
    
    $this->add_control(
        'slider_caption_color',
        [
            'label' => esc_html__( 'Color', 'growla' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hero-slider .hero-slider-nav .slider-caption' => 'color: {{VALUE}}',
            ],
        ]
    );

    $this->end_controls_section();
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

  private function box_1_illustration_styles() {
    $this->start_controls_section(
        'box_1_illustration_styles',
        [
            'label' => esc_html__('Box 1 Illustration', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_control(
        'box_1_color_primary',
        [
            'label' => esc_html__( 'Primary Color', 'growla' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .illustration-boxes-1' => '--color-primary: {{VALUE}};',
            ],
        ]
    );

    $this->end_controls_section();
  }

  private function box_2_illustration_styles() {
    $this->start_controls_section(
        'box_2_illustration_styles',
        [
            'label' => esc_html__('Box 2 Illustration', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_control(
        'box_2_color_primary',
        [
            'label' => esc_html__( 'Primary Color', 'growla' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .illustration-boxes-2' => '--color-primary: {{VALUE}};',
            ],
        ]
    );

    $this->end_controls_section();
  }

  private function lines_illustration_styles() {
    $this->start_controls_section(
        'lines_illustration_styles',
        [
            'label' => esc_html__('Lines Illustration', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_control(
        'lines_color_primary',
        [
            'label' => esc_html__( 'Primary Color', 'growla' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .illustration-lines' => '--color-primary: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        'lines_color_secondary',
        [
            'label' => esc_html__( 'Secondary Color', 'growla' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .illustration-lines' => '--color-secondary: {{VALUE}};',
            ],
        ]
    );

    $this->end_controls_section();
  }

  protected function register_controls(){
    $this->content_controls();
    growla_slider_controls( $this, array(), 1, false );
    $this->slider_navigation_controls();

    $this->general_style_controls();
    $this->content_style_controls();
    $this->slider_navigation_style_controls();
    $this->slider_caption_style_controls();
    $this->waves_illustration_styles();
    $this->lines_illustration_styles();
    $this->box_1_illustration_styles();
    $this->box_2_illustration_styles();
  }

  private function render_slide($item) {
    ?>
    <?php if ( $item['hs_content_type'] == 'text' ): ?>
        <div class="content-slide-inner text">
            <?php echo wp_kses( $item['hs_wysiwyg'], 'post' ); ?>
        </div>
    <?php elseif ( $item['hs_content_type'] == 'template' ): ?>
        <div class="content-slide-inner template">
            <?php
                $args = array(
                    'post_type' => 'elementor_library',
                    'posts_per_page' => 1,
                    'p' => $item['hs_content_template']
                );

                $query = new WP_Query($args);

                echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $item['hs_content_template'], true );
            ?>
        </div>
    <?php endif; ?>
    <?php
  }

  private function render_navigation() {
    $settings = $this->get_settings_for_display();
    $id = $this->get_id();

    $caption = $settings['caption'];

    if ( 'yes' != $settings['navigation'] && ! empty( $caption ) ) {
        return;
    } 

    $type = $settings['navigation_type'];

    $prev_text = $settings['prev_text'];
    $prev_icon = $settings['prev_icon'];

    $next_text = $settings['next_text'];
    $next_icon = $settings['next_icon'];

    $separator = $settings['navigation_separator'];

    $this->add_render_attribute( 'slider-navigation', 'class', [
        'slider-nav',
        'slider-nav-'.$id
    ]);

    if ( 'text' === $type ) {
        $this->add_render_attribute( 'slider-navigation', 'class', [
            'slider-nav-text'
        ]);
    }

    ?>
    <div class="slider-nav-wrapper">
        <div class="growla-container">
            <div class="hero-slider-nav">

                <?php if ( ! empty( $caption ) ): ?>
                <div class="slider-caption">
                    <?php echo esc_html( $caption ); ?>
                </div>
                <?php endif; ?>

                <?php if ( 'yes' === $settings['navigation'] ): ?>
                <div <?php $this->print_render_attribute_string( 'slider-navigation' );  ?>>

                    <?php if ( ! empty( $prev_text ) || ! empty( $prev_icon ) ): ?>
                    <div class="slider-nav-btn slider-nav-prev">
                        <?php
                            if ( 'text' === $type ) {
                                echo esc_html( $prev_text );
                            } else {
                                growla_render_icon( $prev_icon );
                            }
                        ?>
                    </div>
                    <?php endif; ?>

                    <?php if ( ! empty( $separator ) ): ?>
                        <div class="slider-nav-separator">
                            <?php echo esc_html( $separator ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( ! empty( $next_text ) || ! empty( $next_icon ) ): ?>
                    <div class="slider-nav-btn slider-nav-next">
                        <?php
                            if ( 'text' === $type ) {
                                echo esc_html( $next_text );
                            } else {
                                growla_render_icon( $next_icon );
                            }
                        ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <?php
  }

  private function render_illustration( $item ) {
    if ( empty( $item['hs_illustration'] ) || $item['hs_illustration'] === 'none' ) return;
    get_template_part( 'inc/template-parts/illustrations/illustration', $item['hs_illustration'] );
  }

  protected function content_slider() {
    $settings = $this->get_settings_for_display();
    $id = $this->get_id();

    $this->add_render_attribute( 'hs_slider', 'class', [
        'slider',
        'slider-'.$id,
        'swiper'
    ]);

    // options for the image slider
    $options = growla_slider_options( $settings, $id );

    $prev_icon = $settings['prev_icon'];
    $next_icon = $settings['next_icon'];

    ?>
    <div <?php $this->print_render_attribute_string( 'hs_slider' );  ?>>
        <div class="swiper-wrapper">
            <!-- slides - start -->
            <?php foreach ( $settings['hs_repeater'] as $item ): ?>
            <div class="swiper-slide">
                <div class="hero-slide">
                    <div class="hero-slide-bg">
                        <?php 
                        if 
                        ( 
                            'yes' === $item['hs_video_background'] && 
                            ! empty($item['hs_video']['url']) 
                        ):
                        ?>
                            <?php if ( ! empty( $item['hs_video_overlay'] ) ): ?>
                                <div class="hero-slide-video-overlay" style="background-color: <?php echo esc_attr( $item['hs_video_overlay'] ); ?>"></div>
                            <?php endif; ?>
                            <video autoplay muted loop playsinline webkit-playsinline class="hero-slide-video">
                                <source src="<?php echo esc_url( $item['hs_video']['url'] ); ?>" type="video/mp4">
                            </video>
                        <?php else:
                            echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( 
                                $item, 
                                'full', 
                                'hs_bg_img'
                            ); 
                        endif;
                        ?>
                    </div>
                    <div class="growla-container">
                        <div class="hero-slide-content">
                            <?php $this->render_slide($item); ?>
                        </div>
                    </div>
                    <div class="hero-illustration">
                        <?php $this->render_illustration( $item ); ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <!-- slides - end -->
            
        </div>
        <?php $this->render_navigation(); ?>
    </div>
    <?php
        growla_slider( $id, $options );
  }

  protected function render() {
    $settings = $this->get_settings_for_display();

    $classes = array( 'hero-slider' );

    if ( $settings['full_screen_slide'] === 'yes' ) {
        $classes[] = 'hero-slider-full-screen';
    }

    ?>
    <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
        <!-- slider - start -->
        <?php
            $this->content_slider();
        ?>
        <!-- slider - end -->
    </div>
    <?php
  }
}
