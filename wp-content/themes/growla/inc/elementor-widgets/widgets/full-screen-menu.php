<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class FullScreenMenu extends \Elementor\Widget_Base {

  public function get_name(){
    return 'growla_full_screen_menu';
  }

  public function get_title() {
    return esc_html__('Full Screen Menu', 'growla');
  }

  public function get_icon() {
    return 'eicon-slider-full-screen';
  }

  public function get_categories(){
    return ['gfxpartner'];
  }

  private function button_content_controls() {
        $this->start_controls_section(
            'button_content',
            [
            'label' => esc_html__('Content', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );


        $this->add_control(
            'button_text',
            [
            'label' => esc_html__('Text', 'growla'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => 'Button text'
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__('Link', 'growla'),
                'type' => \Elementor\Controls_Manager::URL,
            
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' => __('Icon', 'growla'),
                'type' => \Elementor\Controls_Manager::ICONS
            ]
        );

        $this->end_controls_section();
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
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'growla' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
			'logo',
			[
				'label' => esc_html__( 'Choose Image', 'growla' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

        $this->add_control(
			'menu_select',
			[
				'label' => esc_html__( 'Menu', 'growla' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => growla_get_nav_menu_names(),
			]
		);

        $this->add_control(
            'menu_label',
            [
                'label' => esc_html__('Menu Label', 'growla'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'MENU'
            ]
        );

        $this->end_controls_section();

        $this->main_menu_controls();

        $this->sub_menu_controls();
        
    }


    private function main_menu_controls() {

        $this->start_controls_section(
            'main_menu_styles',
            [
                'label' => esc_html__('Main Menu', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_main_menu_typography',
				'selector' => '{{WRAPPER}} .growla-full-screen-nav-content-menu > ul > li > a',
			]
		);


        $this->start_controls_tabs( 'main_menu_tabs' );

        $this->start_controls_tab(
            'main_menu_normal',
            [
                'label' => esc_html__( 'Normal', 'growla' ),
            ]
        );

        $this->add_control(
			'main_menu_text_color',
			[
				'label' => esc_html__( 'Text Color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .growla-full-screen-nav-content-menu > ul > li > a' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'growla' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
                    'rem' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
                    '{{WRAPPER}} .growla-full-screen-nav-content-menu > ul > li' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .growla-full-screen-nav-content-menu > ul > li > a' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'main_menu_hover',
            [
                'label' => esc_html__( 'Hover', 'growla' ),
            ]
        );

        $this->add_control(
			'main_menu_text_color_hover',
			[
				'label' => esc_html__( 'Text Color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .growla-full-screen-nav-content-menu > ul > li > a:hover' => 'color: {{VALUE}}',
				],
			]
		); 

        $this->add_control(
			'main_menu_underline_color_hover',
			[
				'label' => esc_html__( 'Underline Color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .growla-full-screen-nav-content-menu > ul > li > a::after' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();
    }

    private function sub_menu_controls() {
        $this->start_controls_section(
            'sub_menu_styles',
            [
                'label' => esc_html__('Sub Menu', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_sub_menu_typography',
				'selector' => '{{WRAPPER}} .growla-full-screen-nav-content-menu > ul > li > .sub-menu > li > a',
			]
		);

        $this->start_controls_tabs( 'sub_menu_tabs' );

        $this->start_controls_tab(
            'sub_menu_normal',
            [
                'label' => esc_html__( 'Normal', 'growla' ),
            ]
        );

        $this->add_control(
			'sub_menu_text_color',
			[
				'label' => esc_html__( 'Text Color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .growla-full-screen-nav-content-menu > ul > li > .sub-menu > li > a' => 'color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sub_menu_hover',
            [
                'label' => esc_html__( 'Hover', 'growla' ),
            ]
        );

        $this->add_control(
			'sub_menu_text_color_hover',
			[
				'label' => esc_html__( 'Text Color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .growla-full-screen-nav-content-menu > ul > li > .sub-menu > li > a:hover' => 'color: {{VALUE}}',
				],
			]
		); 

        $this->add_control(
			'sub_menu_underline_color_hover',
			[
				'label' => esc_html__( 'Underline Color', 'growla' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .growla-full-screen-nav-content-menu > ul > li > .sub-menu > li > a:hover' => 'text-decoration-color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();

		$this->end_controls_section();
    }


  protected function register_controls(){
    $this->content_controls();
    $this->button_content_controls();
  }
  
  protected function render(){
    $settings = $this->get_settings_for_display();

  ?>
    <div class="growla-full-screen-nav">
        <div class="growla-full-screen-nav-trigger">
            <div class="growla-full-screen-nav-trigger-bar-wrapper">
                <?php if ( ! empty( $settings['menu_label'] ) ): ?>
                    <span class="growla-full-screen-nav-trigger-bar-text">
                        <?php echo esc_html( $settings['menu_label'] ); ?>
                    </span>
                <?php endif;  ?>
                <div class="growla-full-screen-nav-trigger-bar growla-full-screen-nav-trigger-bar-first"></div>
                <div class="growla-full-screen-nav-trigger-bar growla-full-screen-nav-trigger-bar-second"></div>
            </div>
        </div>
        <div class="growla-full-screen-nav-content">
            <div class="growla-full-screen-nav-content-inner"></div>
            <div class="growla-full-screen-nav-content-container growla-container">
                <div class="growla-full-screen-nav-content-wrapper">
                    <div class="growla-full-screen-nav-content-logo">
                        <?php
                            $this->add_render_attribute( 'image', 'src', $settings['logo']['url'] );
                            $this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $settings['logo'] ) );
                            $this->add_render_attribute( 'image', 'title', \Elementor\Control_Media::get_image_title( $settings['logo'] ) );
                            echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'full', 'logo' );
                        ?>
                    </div>
                    <?php if ( ! empty( $settings['menu_select'] ) ): ?>
                    <div class="growla-full-screen-nav-content-menu">
                        <?php
                            wp_nav_menu([
                                'menu' => $settings['menu_select'],
                                'container' => '',
                                'theme_location' => 'primary-menu',
                            ]);
                        ?>
                    </div>
                    <?php endif; ?>
                    <?php

                    if ( !empty( $settings['button_link']['url'] ) ):
                    
                        $this->add_render_attribute('button_attr', 'class', array('growla-button', 'growla-button-icon-hover'));

                        if ( $settings['button_link']['is_external'] )
                        $this->add_render_attribute('button_attr', 'target', '_blank');
                    
                        if ( $settings['button_link']['nofollow'] )
                        $this->add_render_attribute('button_attr', 'rel', 'nofollow');
                    
                        $this->add_render_attribute('button_attr', 'href', $settings['button_link']['url']);
                    
                        $icon = $settings['button_icon'];
                    ?>
                    <a <?php $this->print_render_attribute_string('button_attr');  ?>>
                        <span><?php echo esc_html( $settings['button_text'] ); ?></span>
                        
                        <?php if ( ! empty( $icon ) ): ?>
                            <span class="icon">
                                <?php
                                    // icon
                                    \Elementor\Icons_Manager::render_icon( 
                                        $settings['button_icon'], 
                                        [ 'aria-hidden' => 'true' ]
                                    ); 
                                ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    <?php else: ?>
                        <div></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ( ! empty( $settings['image']['url'] ) ): ?>
                <div class="growla-full-screen-nav-content-image">
                    <?php
                        $this->add_render_attribute( 'image', 'src', $settings['image']['url'] );
                        $this->add_render_attribute( 'image', 'alt', \Elementor\Control_Media::get_image_alt( $settings['image'] ) );
                        $this->add_render_attribute( 'image', 'title', \Elementor\Control_Media::get_image_title( $settings['image'] ) );
                        echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'full', 'image' );
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
  }
}
