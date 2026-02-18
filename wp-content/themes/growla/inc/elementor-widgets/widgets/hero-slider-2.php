<?php

if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class HeroSlider2 extends \Elementor\Widget_Base {

  public function get_name(){
    return 'growla_hero_slider_2';
  }

  public function get_title() {
    return esc_html__( 'Hero Slider 2', 'growla' );
  }

  public function get_icon() {
    return 'eicon-slider-device';
  }

  public function get_categories(){
    return ['gfxpartner'];
  }

  protected function register_controls(){

    // content -  start

    $this->start_controls_section(
      'content',
      [
        'label' => esc_html__('Content', 'growla'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT
      ]
    );

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
        'hs2_content_type',
        [
            'label'       => esc_html__( 'Type', 'growla' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => 'type_1',
            'options'     => [
                'text' => esc_html__( 'Text', 'growla' ),
                'template' => esc_html__( 'Template', 'growla' ),
            ],
        ]
    );

    $repeater->add_control(
        'hs2_wysiwyg',
        [
            'label' => esc_html__('Content', 'growla'),
            'type' => \Elementor\Controls_Manager::WYSIWYG,
            'rows' => 10,
            'placeholder' => esc_html__('Type your content here', 'growla'),
            'condition' => [
                'hs2_content_type' => 'text'
            ]
        ]
    );

    $repeater->add_control(
        'hs2_content_template',
        [
            'label'       => esc_html__( 'Template', 'growla' ),
            'type'        => \Elementor\Controls_Manager::SELECT,
            'default'     => '0',
            'options'     => growla_get_elementor_templates(),
            'description' => esc_html__( 'You can create new templates or customize existing templates by going to the \'Templates\' menu item (Besides the \'Elementor\' menu item) on the dashboard.', 'growla' ),
            'condition' => [
                'hs2_content_type' => 'template'
            ]
        ]
    );

    $repeater->add_control(
        'hs2_image',
        [
            'label' => __( 'Choose Image', 'growla' ),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
        ]
    );

    $this->add_control(
        'hs2_repeater',
        [
            'label' => __('Slides', 'growla'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => __('Slide', 'growla'),
        ]
    );

    $this->end_controls_section();

    // content -  end

    // slider - start

    $this->start_controls_section(
        'hs2_slider_options',
        [
            'label' => esc_html__('Slider', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT
        ]
    );

    growla_slider_controls( $this );
    
    $this->end_controls_section();

    // slider end

    $this->start_controls_section(
        'image_styles',
        [
          'label' => esc_html__('Image', 'growla'),
          'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_control(
        'image_border_radius',
        [
            'label' => esc_html__( 'Border radius', 'growla' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'rem' ],
            'selectors' => [
                '{{WRAPPER}} .hs2-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->end_controls_section();

    // slider nav - start

    growla_slide_nav_styles( $this );

    // slider nav - end

    // slider pagination - start

    growla_slide_pagination_styles( $this );

    // slider pagination - end
  
  }

  protected function content_slider() {
    $settings = $this->get_settings_for_display();
    $id = $this->get_id() . rand( 0, 999 );

    $options_test = [
        'rs_slides_per_view' => 1
    ];

    $settings = array_merge( $settings, $options_test );

    $this->add_render_attribute( 'hs2_content_slider', 'class', [
        'slider',
        'slider-'.$id,
        'hs2-content'
    ]);

    // options for the image slider
    $options = growla_slider_options( $settings, $id, 
        [
            'initialSlide' => 1,
            'effect' => 'fade',
            'fadeEffect' => [
                'crossFade' => true
            ]
        ]
    );

    $class_list = array(
        'slider-nav',
        'slider-nav-'.$id
    );

    $prev_icon = $settings['rs_prev_icon'];
    $next_icon = $settings['rs_next_icon'];

    ?>
    <div <?php $this->print_render_attribute_string( 'hs2_content_slider' );  ?>>
        <div class="row d-flex align-items-lg-center">
            <div class="col-lg-10">
                <div class="hs2-content-wrapper">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">

                            <!-- slides - start -->
                            <?php 
                                $index = 0;
                                foreach ( $settings['hs2_repeater'] as $item ):
                            ?>
                            <div class="swiper-slide">
                                <div class="content <?php echo esc_attr( $index == 1 ? 'first-render' : '' ); ?>">
                                    <?php
                                        if ( $item['hs2_content_type'] == 'text' ):
                                    ?>
                                        <div class="content-inner text">
                                            <?php echo wp_kses( $item['hs2_wysiwyg'], 'post' ); ?>
                                        </div>
                                    <?php
                                        elseif ( $item['hs2_content_type'] == 'template' ):
                                    ?>
                                        <div class="content-inner template">
                                            <?php
                                                $content = 
                                                \Elementor\Plugin::instance()->frontend->
                                                get_builder_content_for_display( $item['hs2_content_template'] );
                                                echo wp_kses( $content, 'elementor-template' );
                                            ?>
                                        </div>
                                    <?php
                                        endif;
                                    ?>
                                </div>
                            </div>
                            <?php $index++; endforeach; ?>
                            <!-- slides - end -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 d-lg-inline-flex justify-content-lg-end">
                <div class="<?php echo esc_attr( implode(' ', $class_list) ); ?>">

                    <?php if ( !empty( $prev_icon ) ): ?>
                        <div class="slider-nav-btn slider-nav-prev">
                            <?php growla_render_icon( $prev_icon ); ?>
                        </div>
                    <?php endif; ?>
                        
                    <?php if ( !empty( $next_icon ) ): ?>
                        <div class="slider-nav-btn slider-nav-next">
                            <?php growla_render_icon( $next_icon ); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
    <?php
        growla_slider( $id, $options );
  }

  protected function image_slider() {
    $settings = $this->get_settings_for_display();
    $id = $this->get_id() . rand( 0, 999 );
    
    $options_test = [
        'rs_slides_per_view' => 1
    ];

    $settings = array_merge( $settings, $options_test );

    $this->add_render_attribute('hs2_slider', 'class', [
        'slider',
        'slider-'.$id,
        'hs2-image'
    ]);

    // options for the image slider
    $options = growla_slider_options( $settings, $id, 
        [
            'spaceBetween' => 30,
            'slideToClickedSlide' => true,
            'initialSlide' => 1,
            'slidesPerGroup' => 1,
        ]
    );

    ?>

    <div <?php $this->print_render_attribute_string( 'hs2_slider' );  ?>>
        <div class="hs2-image-wrapper">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <!-- slides - start -->
                    <?php foreach ( $settings['hs2_repeater'] as $item ): ?>
                    <div class="swiper-slide">
                        <div class="image">
                            <?php 
                                echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( 
                                    $item, 
                                    'full', 
                                    'hs2_image' 
                                ); 
                            ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <!-- slides - end -->
                </div>
            </div>
        </div>
    </div>

    <?php
        growla_slider($id, $options);
  }
  
  protected function render() {
    $settings = $this->get_settings_for_display();
    $id = $this->get_id() . rand( 0, 999 );

    $this->add_render_attribute('hs2_container', 'class', [
        'hs2'        
    ]);

    $this->add_render_attribute('hs2_container', 'id', [
        'hs2-'.$id
    ]);


    ?>
    <div <?php $this->print_render_attribute_string( 'hs2_container' );  ?>>
        <!-- slider - start -->
        <?php
            $this->content_slider();
            $this->image_slider();
        ?>
        <!-- slider - end -->
    </div>
    <?php
  }
}
