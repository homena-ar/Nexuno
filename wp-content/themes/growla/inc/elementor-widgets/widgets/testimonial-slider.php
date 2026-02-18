<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class TestimonialSlider extends \Elementor\Widget_Base {

    public function get_name() {
        return 'growla_testimonial_slider';
    }

    public function get_title() {
        return esc_html__('Testimonials', 'growla');
    }

    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_categories() {
        return ['gfxpartner'];
    }

    private function testimonial_content_controls() {
        $this->start_controls_section(
            'testimonial_content',
            [
                'label' => esc_html__('Testimonials', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'testimonial_slide_image',
            [
                'label' => __( 'Choose Image', 'growla' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'testimonial_slide_content',
            [
                'label' => esc_html__( 'Testimonial', 'growla' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 10,
                'placeholder' => esc_html__( 'Type your testimonial here', 'growla' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'testimonial_slide_name',
            [
                'label' => esc_html__( 'Name', 'growla' ),
                'type' => \Elementor\Controls_Manager::TEXT,            
                'placeholder' => esc_html__( 'Type your name here', 'growla' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'testimonial_slides_repeater',
            [
              'label' => __( 'Image slides', 'growla' ),
              'type' => \Elementor\Controls_Manager::REPEATER,
              'fields' => $repeater->get_controls(),
              'title_field' => __ ( 'Slide','growla' ),
            ]
          );
      
        $this->end_controls_section();
    }

    private function testimonial_style_controls() {
        $this->start_controls_section(
            'testimonial_style',
            array(
                'label' => esc_html__( 'Testimonial', 'growla' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'testimonial_typography',
                'selector' => '{{WRAPPER}} .testimonial-main-wrapper .testimonial-slider p',
            ]
        );

        $this->add_control(
            'testimonial_color',
            [
                'label' => esc_html__( 'Color', 'growla' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-main-wrapper .testimonial-slider p' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();
    }

    private function name_style_controls() {
        $this->start_controls_section(
            'name_style',
            array(
                'label' => esc_html__( 'Name', 'growla' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'selector' => '{{WRAPPER}} .testimonial-main-wrapper .testimonial-slider h5',
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => esc_html__( 'Color', 'growla' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-main-wrapper .testimonial-slider h5' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();
    }

    protected function register_controls() {
        growla_subheading_content_controls( $this );
        $this->testimonial_content_controls();
        growla_slider_controls( $this );

        growla_subheading_style_controls( $this );
        $this->testimonial_style_controls();
        $this->name_style_controls();
        growla_slide_nav_styles( $this );
  }

    private function the_testimonial( $item ) {
    ?>
        <div class="swiper-slide">
            <div class="testimonial-slide">
                <p><?php echo esc_html( $item['testimonial_slide_content'] ) ?></p>
                <h5 class="mini-heading-01"><?php echo esc_html( $item['testimonial_slide_name'] ) ?></h5>
            </div>
        </div>
    <?php
    }

    private function all_the_testimonials() {
        $settings = $this->get_settings_for_display();
        $items = $settings['testimonial_slides_repeater'];

        if ( is_array( $items ) || is_object( $items ) ) {
            foreach ( $items as $item ) {
                $this->the_testimonial( $item );
            }
        }
    }
  
    private function the_testimonial_slider() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();

        // main class list
        $class_list = [
            'slider',
            'testimonial-slider',
            'swiper',
            'testimonial-slider-'.$id
        ];

        $subheading_tag = $settings['subheading_tag'] ?? 'h6';

    ?>
        <div class="testimonial-slider-wrapper">
            <div class="growla-heading">
                <<?php echo esc_html( $subheading_tag ); ?> class="growla-heading--sub mini-heading-02">

                <?php if ( ! empty( $settings['subheading'] ) ) : ?>
                    <?php echo esc_html( $settings['subheading'] ); ?>
                <?php endif; ?>

                </<?php echo esc_html( $subheading_tag ); ?>>
            </div>

            <div class="<?php echo esc_html( implode(' ', $class_list) ); ?>">
                <div class="swiper-wrapper">
                    <?php $this->all_the_testimonials(); ?>
                </div>
            </div>
        </div>
        <?php
    }

    private function testimonial_slider_script() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();

        $options_1 = growla_slider_options( $settings, $id, [
            'spaceBetween' => 30,
            'breakpoints' => [
                '0' => [
                    'slidesPerView' => 1,
                    'centeredSlides' => true,
                    'spaceBetween' => 15,
                ],
                '500' => [
                    'slidesPerView' => 1,
                    'centeredSlides' => true,
                    'spaceBetween' => 30,
                ],
                '758' => [
                    'slidesPerView' => 1.9,
                    'centeredSlides' => true
                ],
                '992' => [
                    'slidesPerView' => $settings['slides_per_view'],
                    'centeredSlides' => false
                ]
            ]
        ] );

        $options_2 = [
            'speed' => 500,
            'loop' => false,
            'direction' => 'vertical',
            'autoHeight' => true,
            'slidesPerView' => 4,
            'spaceBetween' => 22,
            'centeredSlide' => true,
            'breakpoints' => [
                '0' => [
                    'direction' => 'horizontal',
                    'slidesPerView' => 4,
                ],
                '768' => [
                    'direction' => 'horizontal',
                    'slidesPerView' => 8,
                ],
                '992' => [
                    'direction' => 'vertical'
                ]
            ]
        ];

        $selector_1 = 'testimonial-slider-' . $id;
        $selector_2 = 'testimonial-image-slider-' . $id;

        growla_thumbs_slider( $options_1, $options_2, $selector_1, $selector_2 );
    }

    private function the_images_slider() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();
        $items = $settings['testimonial_slides_repeater'];

        if ( ! is_array( $items ) ) {
            return;
        }

        $class_list = [
            'slider',
            'testimonial-image-slider',
            'swiper',
            'testimonial-image-slider-'.$id
        ];
        ?>
        <div class="<?php echo esc_html( implode(' ', $class_list) ); ?>">
            <div class="swiper-wrapper">
                <?php foreach ( $items as $item ): ?>
                <div class="swiper-slide">
                    <div class="testimonial-image-wrapper">
                        <?php 
                            echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( 
                                $item, 
                                'full', 
                                'testimonial_slide_image'
                            ); 
                        ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    private function images_slider_script() {
        $id = $this->get_id();
        $options = [
            'speed' => true,
            'loop' => false,
            'direction' => 'vertical',
            'slidesPerView' => 'auto',
            'spaceBetween' => 22,
            'slidesPerGroup' => 4,
            'breakpoints' => [
                '0' => [
                    'enabled' => true,
                ],
                '992' => [
                    'enabled' => false
                ]
            ]

        ];
        growla_slider( $id, $options, 'testimonial-image-slider' );
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();

        $prev_icon = $settings['prev_icon'];
        $next_icon = $settings['next_icon'];
    ?>
    <div class="testimonial-main-wrapper">
        <div class="testimonial-wrapper">
            <?php
                $this->the_images_slider();
                $this->the_testimonial_slider();
                growla_get_slider_navigation( $id, $prev_icon, $next_icon );
            ?>
        </div>
        <?php
            $this->testimonial_slider_script();
        ?>
    </div>
    <?php
    }

}
