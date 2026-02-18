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
class Progress_Bar extends \Elementor\Widget_Base {

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'growla_progress_bar';
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Progress Bar', 'growla' );
	}

	/**
	 * Get icon
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-skill-bar';
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
		$this->style_settings();
        $this->heading_settings();
        $this->counter_settings();
        $this->progress_bar_settings();
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

        // Add a slider control
        $this->add_control(
            'slider',
            [
                'label' => __( 'Slider', 'growla' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
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
	private function style_settings() {
		$this->start_controls_section(
			'style',
			array(
				'label' => esc_html__( 'General', 'growla' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

        $this->add_control(
            'background_color',
            [
            'label' => esc_html__('Background color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-progress-bar' => 'background-color : {{VALUE}};'
            ]
            
            ]
        );

		$this->end_controls_section();
	}

    private function heading_settings() {
		$this->start_controls_section(
			'heading_style',
			array(
				'label' => esc_html__( 'Heading', 'growla' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => esc_html__('Typography', 'growla'),
                'selector' => '{{WRAPPER}} .growla-progress-bar--header span',
            ]
        );

        $this->add_control(
            'heading_color',
            [
            'label' => esc_html__('Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-progress-bar--header span' => 'color : {{VALUE}};'
            ]
            
            ]
        );

		$this->end_controls_section();
	}

    private function counter_settings() {
		$this->start_controls_section(
			'counter_style',
			array(
				'label' => esc_html__( 'Counter', 'growla' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'counter_typography',
                'label' => esc_html__('Typography', 'growla'),
                'selector' => '{{WRAPPER}} .growla-progress-bar--value',
            ]
        );

        $this->add_control(
            'counter_color',
            [
            'label' => esc_html__('Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-progress-bar--value' => 'color : {{VALUE}};'
            ]
            
            ]
        );

		$this->end_controls_section();
	}

    private function progress_bar_settings() {
		$this->start_controls_section(
			'progress_bar_style',
			array(
				'label' => esc_html__( 'Progress Bar', 'growla' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

        $this->add_control(
            'progress_bar_color',
            [
            'label' => esc_html__('Background Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-progress-bar--bar' => 'background-color : {{VALUE}};'
            ]
            
            ]
        );

        $this->add_control(
            'progress_bar_fill_color',
            [
            'label' => esc_html__('Fill Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .growla-progress-bar--actual' => 'background-color : {{VALUE}};'
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
        
        if ( empty( $settings['slider']['size'] ) ) {
            $settings['slider']['size'] = 50;
        }

		?>
		<div class="growla-progress-bar">
            <div class="growla-progress-bar--header">
                <span><?php echo esc_html( $settings['text'] ); ?></span>
                <div class="growla-progress-bar--value" data-value="<?php echo esc_attr( $settings['slider']['size'] ); ?>">0%</div>
            </div>
            <div class="growla-progress-bar--bar">
                <div class="growla-progress-bar--actual"></div>
            </div>
        </div>
		<?php
	}
}
