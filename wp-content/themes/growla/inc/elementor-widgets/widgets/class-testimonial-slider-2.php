<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class Testimonial_Slider_2 extends \Elementor\Widget_Base {

    public function get_name() {
        return 'growla_testimonial_slider_2';
    }

    public function get_title() {
        return esc_html__('Testimonials 2', 'growla');
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

        $repeater->add_control(
            'testimonial_slide_desgination',
            [
                'label' => esc_html__( 'Designation', 'growla' ),
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
              'label' => __( 'Testimonials', 'growla' ),
              'type' => \Elementor\Controls_Manager::REPEATER,
              'fields' => $repeater->get_controls(),
              'title_field' => __ ( 'Slide','growla' ),
            ]
          );
      
        $this->end_controls_section();
    }

    private function general_settings() {
        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__('General', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
        
        $this->add_control(
			'icon',
			array(
				'label' => esc_html__( 'Icon', 'growla' ),
				'type'  => \Elementor\Controls_Manager::ICONS,
			)
		);

        $this->end_controls_section();
    }

    protected function register_controls() {
        growla_heading_data_controls( $this );
        $this->general_settings();
        $this->testimonial_content_controls();
        growla_slider_controls( $this, array(), 3 );

        $this->general_styles();
        growla_heading_style_controls( $this );
        $this->testimonial_styles();
        $this->name_styles();
        $this->designation_styles();
        $this->icon_styles();
        growla_slide_nav_styles( $this );    
  }

  private function testimonial_styles() {
    $this->start_controls_section(
        'testimonial_styles',
        array(
            'label' => esc_html__( 'Testimonial', 'growla' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        )
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'testimonial_typography',
            'selector' => '{{WRAPPER}} .testimonial-slide-2 p',
        ]
    );
    
    $this->add_control(
        'testimonial_color',
        [
            'label' => esc_html__( 'Color', 'growla' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .testimonial-slide-2 p' => 'color: {{VALUE}}',
            ],
        ]
    );

    $this->end_controls_section();
  }

  private function name_styles() {
    $this->start_controls_section(
        'name_styles',
        array(
            'label' => esc_html__( 'Name', 'growla' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        )
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'name_typography',
            'selector' => '{{WRAPPER}} .testimonial-slide-2 h5',
        ]
    );
    
    $this->add_control(
        'name_color',
        [
            'label' => esc_html__( 'Color', 'growla' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .testimonial-slide-2 h5' => 'color: {{VALUE}}',
            ],
        ]
    );

    $this->end_controls_section();
  }

  private function designation_styles() {
    $this->start_controls_section(
        'designation_styles',
        array(
            'label' => esc_html__( 'Designation', 'growla' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        )
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'designation_typography',
            'selector' => '{{WRAPPER}} .testimonial-slide-2 h6',
        ]
    );
    
    $this->add_control(
        'designation_color',
        [
            'label' => esc_html__( 'Color', 'growla' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .testimonial-slide-2 h6' => 'color: {{VALUE}}',
            ],
        ]
    );

    $this->end_controls_section();
  }

  private function icon_styles() {
    $this->start_controls_section(
        'icon_styles',
        array(
            'label' => esc_html__( 'Icon', 'growla' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        )
    );

    $this->add_control(
        'icon_color',
        [
            'label' => esc_html__( 'Background Color', 'growla' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .testimonial-slide-2 .icon svg' => 'fill: {{VALUE}}',
                '{{WRAPPER}} .testimonial-slide-2 .icon' => 'color: {{VALUE}}',
            ],
        ]
    );
    
    $this->add_control(
        'icon_background_color',
        [
            'label' => esc_html__( 'Background Color', 'growla' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .testimonial-slide-2 .icon' => 'background-color: {{VALUE}}',
            ],
        ]
    );

    $this->end_controls_section();
  }

  private function general_styles() {
    $this->start_controls_section(
        'general_styles',
        array(
            'label' => esc_html__( 'General', 'growla' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        )
    );

    $this->add_control(
        'block_background_color',
        [
            'label' => esc_html__( 'Background Color', 'growla' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .testimonial-slide-2' => 'background-color: {{VALUE}}'
            ],
        ]
    );
    
    $this->add_control(
        'block_separator_color',
        [
            'label' => esc_html__( 'Separator Color', 'growla' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .testimonial-slide-2--details' => 'border-color: {{VALUE}}'
            ],
        ]
    );

    $this->end_controls_section();
  }

    private function the_testimonial( $item ) {
        $settings = $this->get_settings_for_display();
    ?>
        <div class="swiper-slide">
            <div class="testimonial-slide-2">
                <p><?php echo esc_html( $item['testimonial_slide_content'] ) ?></p>
                <div class="testimonial-slide-2--details">
                    <h5><?php echo esc_html( $item['testimonial_slide_name'] ) ?></h5>
                    <h6><?php echo esc_html( $item['testimonial_slide_desgination'] ) ?></h6>
                </div>
                <?php if ( ! empty( $settings['icon']['value'] ) ): ?>
                    <div class="icon">
                        <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], array( 'aria-hidden' => 'true' ) ); ?>
                    </div>
                <?php endif; ?>
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

        $options = growla_slider_options( $settings, $id, [
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

        // main class list
        $class_list = [
            'slider',
            'testimonial-slider-2',
            'swiper',
            'slider-'.$id
        ];

    ?>
        <div class="<?php echo esc_html( implode(' ', $class_list) ); ?>">
            <div class="swiper-wrapper">
                <?php $this->all_the_testimonials(); ?>
            </div>
        </div>
        <?php
        growla_slider($id, $options );
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();

        $prev_icon = $settings['prev_icon'];
        $next_icon = $settings['next_icon'];
    ?>
    <div class="testimonial-2-main-wrapper">
        <?php
            get_template_part( 'inc/template-parts/elementor/slider', 'header', array( 
                'settings' => $settings,
                'id' => $id
             ) );
            $this->the_testimonial_slider();
        ?>
    </div>
    <?php
    }

}
