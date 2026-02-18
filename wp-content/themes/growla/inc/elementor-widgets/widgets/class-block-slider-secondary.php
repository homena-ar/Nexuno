<?php
/**
 * Elementor: Block Slider Secondary
 *
 * @package growla
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Growla_Elementor_Widget_Loader
 */
class Block_Slider_Secondary extends \Elementor\Widget_Base {

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'growla_block_slider_secondary';
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Block Slider Secondary', 'growla' );
	}

	/**
	 * Get icon
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-posts-carousel';
	}

	/**
	 * Get categories
	 *
	 * @return array
	 */
	public function get_categories() {
		return array( 'gfxpartner' );
	}

	/**
	 * Registers controls
	 *
	 * @return void
	 */
	protected function register_controls() {
        growla_heading_data_controls( $this );
        $this->general_settings();
		$this->content_settings();
        growla_slider_controls($this, array( 'slider_enabled' => 'yes' ), 3);

        growla_heading_style_controls( $this );
        $this->box_style();
        $this->box_icon_style();
        $this->box_heading_style();
        $this->box_content_style();
        $this->box_content_2_style();
        growla_slide_nav_styles( $this );
	}

	/**
	 * Registers content settings
	 *
	 * @return void
	 */
	private function content_settings() {
		$this->start_controls_section(
			'content',
			array(
				'label' => esc_html__( 'Content', 'growla' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'heading',
			array(
				'label'       => esc_html__( 'Heading', 'growla' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'Heading',
                'dynamic' => [
                    'active' => true,
                ],
			)
		);

		growla_tag_select( $repeater, 'heading_tag', esc_html__( 'Tag', 'growla' ), 'h4' );

		$repeater->add_control(
			'icon',
			array(
				'label' => esc_html__( 'Icon', 'growla' ),
				'type'  => \Elementor\Controls_Manager::ICONS,
			)
		);

		$repeater->add_control(
			'content',
			array(
				'label'       => esc_html__( 'Content', 'growla' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default'     => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sit amet tortor volutpat, lobortis massa vitae, vehicula augue. Nullam ac blandit magna, eget congue risus. Donec rhoncus arcu a maximus mattis. Ut ut cursus magna. Integer ut diam malesuada, mollis velit a, sodales lacus. Nullam lobortis ac sem a accumsan.',
                'dynamic' => [
                    'active' => true,
                ],
            )
		);

        $repeater->add_control(
			'content_2',
			array(
				'label'       => esc_html__( 'Content 2', 'growla' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'label_block' => true,
				'default'     => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sit amet tortor volutpat, lobortis massa vitae, vehicula augue. Nullam ac blandit magna, eget congue risus. Donec rhoncus arcu a maximus mattis. Ut ut cursus magna. Integer ut diam malesuada, mollis velit a, sodales lacus. Nullam lobortis ac sem a accumsan.',
                'dynamic' => [
                    'active' => true,
                ],
            )
		);

		$this->add_control(
			'blocks',
			array(
				'label'       => __( 'Blocks', 'growla' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{ heading }}',
			)
		);

		$this->end_controls_section();
	}

    private function general_settings() {
        $this->start_controls_section(
			'general',
			array(
				'label' => esc_html__( 'General', 'growla' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

        $this->add_control(
			'slider_enabled',
			[
				'label' => esc_html__( 'Slider', 'growla' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'growla' ),
				'label_off' => esc_html__( 'No', 'growla' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->start_controls_tabs( 'general_tabs' );

        $this->start_controls_tab(
            'normal',
            [
                'label' => esc_html__( 'Normal', 'growla' ),
            ]
        );

        $this->add_control(
			'click_icon_normal',
			array(
				'label' => esc_html__( 'Icon', 'growla' ),
				'type'  => \Elementor\Controls_Manager::ICONS,
			)
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'active',
            [
                'label' => esc_html__( 'Hover', 'growla' ),
            ]
        );

        $this->add_control(
			'click_icon_active',
			array(
				'label' => esc_html__( 'Icon', 'growla' ),
				'type'  => \Elementor\Controls_Manager::ICONS,
			)
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    private function box_style() {
        $this->start_controls_section(
            'box_styles',
            array(
                'label' => esc_html__( 'Box Styles', 'growla' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'box_background_color',
            [
                'label' => esc_html__( 'Background Color', 'growla' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .growla-block-slide-2' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'box_outline_color',
            [
                'label' => esc_html__( 'Outline Color', 'growla' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .growla-block-slide-2' => '--outline-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'box_separator_color',
            [
                'label' => esc_html__( 'Separator Color', 'growla' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .growla-block-slide-2--content-icon-border' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->icon_state_styles();
        
        $this->end_controls_section();
    }

    private function box_icon_style() {
        $this->start_controls_section(
            'box_icon',
            array(
                'label' => esc_html__( 'Box Icon', 'growla' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'box_icon_color',
            [
                'label' => esc_html__( 'Color', 'growla' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .growla-block-slide-2--icon svg' => 'fill: {{VALUE}}; color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'box_icon_background_color',
            [
                'label' => esc_html__( 'Background Color', 'growla' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .growla-block-slide-2--icon' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();
    }

    private function box_heading_style() {
        $this->start_controls_section(
            'box_heading',
            array(
                'label' => esc_html__( 'Box Heading', 'growla' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_heading_typography',
                'selector' => '{{WRAPPER}} .growla-block-slide-2--content-heading',
            ]
        );

        $this->add_control(
            'box_heading_color',
            [
                'label' => esc_html__( 'Color', 'growla' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .growla-block-slide-2--content-heading' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();
    }

    private function box_content_style() {
        $this->start_controls_section(
            'box_content',
            array(
                'label' => esc_html__( 'Box Content', 'growla' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_content_typography',
                'selector' => '{{WRAPPER}} .growla-block-slide-2--content p',
            ]
        );

        $this->add_control(
            'box_content_color',
            [
                'label' => esc_html__( 'Color', 'growla' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .growla-block-slide-2--content p' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();
    }

    private function box_content_2_style() {
        $this->start_controls_section(
            'box_2_content',
            array(
                'label' => esc_html__( 'Box Content 2', 'growla' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'box_content_2_typography',
                'selector' => '{{WRAPPER}} .growla-block-slide-2--content-inner-2 p',
            ]
        );

        $this->add_control(
            'box_content_2_color',
            [
                'label' => esc_html__( 'Color', 'growla' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .growla-block-slide-2--content-inner-2 p' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();
    }

    private function icon_state_styles() {
        $this->start_controls_tabs( 'icon_tabs' );
    
        $this->start_controls_tab(
            'normal_icon_tab',
            [
                'label' => esc_html__( 'Normal', 'growla' ),
            ]
        );

        $this->add_control(
            'normal_icon_color',
            [
            'label' => esc_html__('Icon Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-block-slide-2--content-icon .normal-icon svg' => 'fill : {{VALUE}}; color: {{VALUE}};'
            ]
            
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'normal_icon_active',
            [
                'label' => esc_html__( 'Active', 'growla' ),
            ]
        );

        $this->add_control(
            'active_icon_color',
            [
            'label' => esc_html__('Icon Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-block-slide-2--content-icon .active-icon svg' => 'color : {{VALUE}} !important; fill : {{VALUE}} !important;'
            ]
            
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
    }


	/**
	 * Renders the widget markup
	 *
	 * @return void
	 */
	protected function render() {
        $settings = $this->get_settings_for_display();
        $slider_enabled = $settings['slider_enabled'] === 'yes';
        if ( $slider_enabled ) {
            $this->render_slider();
        } else {
            $this->render_grid();
        }
	}

    private function render_grid() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();
        ?>
        <div class="growla-block-grid-2">
            <?php get_template_part( 'inc/template-parts/elementor/slider', 'header', array( 
                'settings' => $settings,
                'id' => $id
             ) ) ?>
            <div class="growla-block-grid-2-wrapper">
                <?php foreach ( $settings['blocks'] as $block ): ?>
                    <div class="growla-block-grid-2-block-wrapper">
                        <?php $this->render_block( $block ); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    private function render_slider() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();

        // options for the slider
        $options = growla_slider_options($settings, $id, 
            [
                'spaceBetween' => 30,
                'breakpoints' => [
                    '0' => [
                        'slidesPerView' => 1,
                        'centeredSlides' => true
                    ],
                    '500' => [
                        'slidesPerView' => 1.2,
                        'centeredSlides' => true
                    ],
                    '992' => [
                        'slidesPerView' => $settings['slides_per_view'],
                        'centeredSlides' => false
                    ]
                ]
            ]
        );

        // main class list
        $class_list = [
            'growla-slider',
            'swiper',
            'growla-block-slider-2',
            'slider-' . $id,
        ];

        ?>
        <div class="growla-block-slider-2-wrapper">
            <?php get_template_part( 'inc/template-parts/elementor/slider', 'header', array( 
                'settings' => $settings,
                'id' => $id
             ) ) ?>
            <div class="<?php echo esc_html(implode(' ', $class_list)); ?>">
                <div class="swiper-wrapper">
                <?php foreach ( $settings['blocks'] as $block ): ?>
                    <div class="swiper-slide">
                        <?php $this->render_block( $block ); ?>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
		<?php
            growla_slider($id, $options);
    }

	/**
	 * Renders each slide
	 *
	 * @param  number $index - current slide number.
	 * @param  array  $block - block array.
	 * @return void
	 */
	private function render_block( $block ) {
        $settings = $this->get_settings_for_display();

		$heading     = $block['heading'] ?? '';
		$heading_tag = $block['heading_tag'] ?? '';
		$content     = $block['content'] ?? '';
		$content_2     = $block['content_2'] ?? '';
		$icon        = $block['icon'] ?? array();

        $click_icon_normal = $settings['click_icon_normal'];
        $click_icon_active = $settings['click_icon_active'];

		?>
            <div class="growla-block-slide-2">

                <?php if ( ! empty( $icon['value'] ) ) : ?>
                    <div class="growla-block-slide-2--icon growla-block-slide-2--icon-top">
                        <?php \Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?>
                    </div>

                    <div class="growla-block-slide-2--icon growla-block-slide-2--icon-bottom">
                        <?php \Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?>
                    </div>
                <?php endif; ?>

                <div class="growla-block-slide-2--content">
                        
                        <div class="growla-block-slide-2--content-wrapper">
                            <div class="growla-block-slide-2--content-inner">
                                <?php if ( ! empty( $heading ) ) : ?>
                                    <<?php echo esc_html( $heading_tag ); ?> class="growla-block-slide-2--content-heading">
                                        <?php echo esc_html( $heading ); ?>
                                    </<?php echo esc_html( $heading_tag ); ?>>
                                <?php endif; ?>

                                <?php if ( ! empty( $content ) ) : ?>
                                <p>
                                    <?php echo wp_kses( $content, 'post' ); ?>
                                </p>
                                <?php endif; ?>
                            </div>

                            <div class="growla-block-slide-2--content-inner-2">
                                <?php if ( ! empty( $content_2 ) ) : ?>
                                <p>
                                    <?php echo wp_kses( $content_2, 'post' ); ?>
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if ( ! empty( $click_icon_normal ) || ! empty( $click_icon_active ) ): ?>
                        <div class="growla-block-slide-2--content-icon">
                            <div class="growla-block-slide-2--content-icon-border"></div>
                            <div class="growla-block-slide-2--content-icon-wrapper">
                                <?php if ( ! empty( $click_icon_normal ) ): ?>
                                <div class="normal-icon">
                                    <?php \Elementor\Icons_Manager::render_icon( $click_icon_normal, array( 'aria-hidden' => 'true' ) ); ?>
                                </div>
                                <?php endif; ?>

                                <?php if ( ! empty( $click_icon_active ) ): ?>
                                <div class="active-icon">
                                    <?php \Elementor\Icons_Manager::render_icon( $click_icon_active, array( 'aria-hidden' => 'true' ) ); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                </div>
            </div>
		<?php
	}
}
