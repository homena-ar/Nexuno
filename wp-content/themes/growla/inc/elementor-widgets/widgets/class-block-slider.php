<?php
/**
 * Elementor: Block Slider
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
class Block_Slider extends \Elementor\Widget_Base {

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'growla_block_slider';
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Block Slider', 'growla' );
	}

	/**
	 * Get icon
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-carousel';
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
		$this->content_settings();
        $this->icon_settings();
        $this->counter_settings();
        $this->heading_settings();
        $this->content_style_settings();
        growla_slider_controls($this, array( 'slider_enabled' => 'yes' ), 1.5);
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

        $this->add_control(
            'display_count',
            [
                'label' => esc_html__( 'Show Count', 'growla' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'growla' ),
                'label_off' => esc_html__( 'Hide', 'growla' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Choose Image', 'growla' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
                'dynamic' => [
                    'active' => true,
                ],
			)
		);

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

		growla_tag_select( $repeater, 'heading_tag', esc_html__( 'Tag', 'growla' ), 'h3' );

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
			'link',
			[
				'label' => esc_html__( 'Link', 'growla' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
			]
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

    private function icon_settings() {
        $this->start_controls_section(
			'icon',
			array(
				'label' => esc_html__( 'Icon', 'growla' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Color', 'growla' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .growla-block-slide--icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__( 'Background Color', 'growla' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .growla-block-slide--icon' => 'background-color: {{VALUE}}',
                ],
            ]
        );

		$this->end_controls_section();
    }

    private function counter_settings() {
        $this->start_controls_section(
			'counter_styles',
			array(
				'label' => esc_html__( 'Counter', 'growla' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'counter_typography',
                'selector' => '{{WRAPPER}} .growla-block-slide--content-index',
            ]
        );
        
        $this->add_control(
            'counter_color',
            [
                'label' => esc_html__( 'Color', 'growla' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .growla-block-slide--content-index' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->end_controls_section();
    }

    private function heading_settings() {
        $this->start_controls_section(
			'heading_styles',
			array(
				'label' => esc_html__( 'Heading', 'growla' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .growla-block-slide--content-heading',
            ]
        );
        
        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__( 'Color', 'growla' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .growla-block-slide--content-heading' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->end_controls_section();
    }

    private function content_style_settings() {
        $this->start_controls_section(
			'content_styles',
			array(
				'label' => esc_html__( 'Content', 'growla' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .growla-block-slide--content p',
            ]
        );
        
        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Color', 'growla' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .growla-block-slide--content p' => 'color: {{VALUE}}',
                ],
            ]
        );

		$this->end_controls_section();
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
        $index_enabled = $settings['display_count'] === 'yes';
        ?>
        <div class="growla-block-grid">
            <?php 
                foreach ( $settings['blocks'] as $index => $block ) {
                    $this->render_block( $index_enabled ? $index + 1 : null, $block );
                }
            ?>
        </div>
        <?php
    }

    private function render_slider() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();
        $index_enabled = $settings['display_count'] === 'yes';

        // options for the slider
        $options = growla_slider_options($settings, $id, 
            [
                'spaceBetween' => 30,
                'breakpoints' => [
                    '0' => [
                        'slidesPerView' => 1
                    ],
                    '500' => [
                        'slidesPerView' => 1.2
                    ],
                    '992' => [
                        'slidesPerView' => $settings['slides_per_view']
                    ]
                ]
            ]
        );

        // main class list
        $class_list = [
            'growla-slider',
            'swiper',
            'growla-block-slider',
            'slider-' . $id,
        ];
        ?>
        <div class="<?php echo esc_html(implode(' ', $class_list)); ?>">
            <div class="swiper-wrapper">
			<?php foreach ( $settings['blocks'] as $index => $block ): ?>
                <div class="swiper-slide">
                    <?php $this->render_block( $index_enabled ? $index + 1 : null, $block ); ?>
                </div>
            <?php endforeach; ?>
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
	private function render_block( $index, $block ) {
		$heading     = $block['heading'] ?? '';
		$heading_tag = $block['heading_tag'] ?? '';
		$content     = $block['content'] ?? '';
		$icon        = $block['icon'] ?? array();
		$image       = $block['image'] ?? array( 'id' => '' );

		$image_markup = wp_get_attachment_image( $image['id'], array( 772, 458 ) );

        $link_exists = !empty( $block['link']['url'] );
        $attribute_slug = 'block-wrapper-' . $index;

        $this->add_render_attribute($attribute_slug, 'class', 'growla-block-slide');
        if ( $block['link']['is_external'] ) $this->add_render_attribute($attribute_slug, 'target', '_blank');
        if ( $block['link']['nofollow'] ) $this->add_render_attribute($attribute_slug, 'rel', 'nofollow');
        if ( $link_exists ) $this->add_render_attribute($attribute_slug, 'href', $block['link']['url']);

        $tag_name = 'div';

        if ( $link_exists ) {
            $tag_name = 'a';
        }

		?>
            <<?php echo esc_html( $tag_name . ' ' ); $this->print_render_attribute_string($attribute_slug);  ?>>
                <?php if ( ! empty( $image['id'] ) ) : ?>
                <div class="growla-block-slide--thumbnail">
                    <?php echo wp_kses( $image_markup, 'post' ); ?>
                    
                    <?php if ( ! empty( $icon ) ) : ?>
                    <div class="growla-block-slide--icon">
                        <?php \Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <div class="growla-block-slide--content">
                    <?php 
                        if ( ! empty( $index ) ) :
                            $index = $index < 9 ? '0' . $index : $index;
                    ?>
                        <div class="growla-block-slide--content-index-wrapper">
                            <span class="growla-block-slide--content-index">
                                <?php echo esc_html( $index ); ?>
                            </span>
                           
                        </div>
                    <?php endif; ?>

                    <div class="growla-block-slide--content-inner">
                        
                        <?php if ( ! empty( $heading ) ) : ?>
                            <<?php echo esc_html( $heading_tag ); ?> class="growla-block-slide--content-heading">
                                <?php echo esc_html( $heading ); ?>
                            </<?php echo esc_html( $heading_tag ); ?>>
                        <?php endif; ?>

                        <?php if ( ! empty( $content ) ) : ?>
                        <p>
                            <?php echo esc_html( $content ); ?>
                        </p>
                        <?php endif; ?>

                    </div>
                </div>
            </<?php echo esc_html( $tag_name ); ?>>
		<?php
	}
}
