<?php
/**
 * Elementor: Progress Bar
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
class Counter extends \Elementor\Widget_Base {

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'growla_counter';
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Counter', 'growla' );
	}

	/**
	 * Get icon
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-counter';
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
		$this->counter_styles();
        $this->counter_label_styles();
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

		// Add a text control
        $this->add_control( 
            'text',
            [
                'label' => __( 'Text', 'growla' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __( 'Default text', 'growla' ),
                'dynamic' => [
                    'active' => true,
                    ],
            ]
        );

        $this->add_control(
			'value',
			[
				'label' => esc_html__( 'value', 'growla' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10000,
				'step' => 1,
				'default' => 100,
                'dynamic' => [
                    'active' => true,
                ],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Registers style settings
	 *
	 * @return void
	 */
	private function counter_styles() {
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
                'name' => 'counter_text_typography',
                'label' => esc_html__('Typography', 'growla'),
                'selector' => '{{WRAPPER}} .growla-counter-value',
            ]
        );

        $this->add_control(
            'counter_text_color',
            [
            'label' => esc_html__('Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-counter-value' => 'color : {{VALUE}};'
            ]
            
            ]
        );

        $this->add_control(
            'counter_border_color',
            [
            'label' => esc_html__('Border color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-counter-value' => 'border-color : {{VALUE}};'
            ]
            
            ]
        );

		$this->end_controls_section();
	}

    private function counter_label_styles() {
		$this->start_controls_section(
			'counter_label_styles',
			array(
				'label' => esc_html__( 'Label', 'growla' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'counter_label_typography',
                'label' => esc_html__('Typography', 'growla'),
                'selector' => '{{WRAPPER}} .growla-counter-text',
            ]
        );

        $this->add_control(
            'counter_label_color',
            [
            'label' => esc_html__('Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-counter-text' => 'color : {{VALUE}};'
            ]
            
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
		?>
		<div class="growla-counter">
            <?php if ( ! empty( $settings['value'] ) ): ?>
            <div class="growla-counter-value" data-value="<?php echo esc_attr( $settings['value'] ); ?>">
                0
            </div>
            <?php endif; ?>
            <div class="growla-counter-text">
                <?php echo esc_html( $settings['text'] ); ?>
            </div>
        </div>
		<?php
	}
}
