<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class ContactFormTabs extends \Elementor\Widget_Base {

	public function get_name() {
		return 'contact_form_tab_growla';
	}

	public function get_title() {
		return esc_html__( 'Contact From 7 Tabs', 'growla' );
	}

	public function get_icon() {
		return 'eicon-tabs';
	}

	public function get_categories() {
		return [ 'gfxpartner' ];
	}

	protected function get_selector_array( $selectors, $property ) {
		$result = [];

		foreach ( $selectors as $selector ) {
			$result[ $selector ] = $property;
		}

		return $result;
	}

    private function content_controls() {
        $this->start_controls_section(
            'content',
            [
                'label' => esc_html__( 'Content', 'growla' ), 
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'growla' ),
				'type' => \Elementor\Controls_Manager::ICONS
			]
		);

        $repeater->add_control(
			'label',
			[
				'label' => esc_html__( 'Title', 'growla' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Default title', 'growla' ),
				'placeholder' => esc_html__( 'Type your title here', 'growla' ),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
			]
		);

        $repeater->add_control(
            'form_id',
            [
                'label' => esc_html__( 'Select contact form', 'growla' ),
                'description' => esc_html__('Contact form 7 must be installed for this widget to work','growla'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => $this->get_contact_form_7_forms(),
                'label_block' => true
            ]
        );

        $this->add_control(
            'contact_forms',
            [
              'label' => __( 'Forms', 'growla' ),
              'type' => \Elementor\Controls_Manager::REPEATER,
              'fields' => $repeater->get_controls(),
              'title_field' => __ ( 'Form','growla' ),
            ]
        );

        $this->end_controls_section();
    }

    private function tabs_styles() {
        $this->start_controls_section(
            'tab_styles',
            [
              'label' => esc_html__('Tabs', 'growla'),
              'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tab_text_typography',
                'label' => esc_html__('Typography', 'growla'),
                'selector' => '{{WRAPPER}} .contact-form-tabs-navigation-item',
            ]
        );

        $this->start_controls_tabs( 'tab_style_tabs' );
    
        $this->start_controls_tab(
            'tab_normal',
            [
                'label' => esc_html__( 'Normal', 'growla' ),
            ]
        );

        $this->add_control(
            'tab_text_color_normal',
            [
            'label' => esc_html__('Text color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .contact-form-tabs-navigation-item' => 'color : {{VALUE}};'
            ]
            
            ]
        );

        $this->add_control(
            'tab_icon_color_normal',
            [
            'label' => esc_html__('Icon color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .contact-form-tabs-navigation-item svg' => 'fill : {{VALUE}};'
            ]
            
            ]
        );

        $this->add_control(
            'tab_border_color_normal',
            [
            'label' => esc_html__('Border color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .contact-form-tabs-navigation-item' => 'border-color : {{VALUE}};'
            ]
            
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_active',
            [
                'label' => esc_html__( 'Active', 'growla' ),
            ]
        );

        $this->add_control(
            'tab_text_color_active',
            [
            'label' => esc_html__('Text color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .contact-form-tabs-navigation-item.active' => 'color : {{VALUE}};',
                '{{WRAPPER}} .contact-form-tabs-navigation-item:hover' => 'color : {{VALUE}};'
            ]
            
            ]
        );

        $this->add_control(
            'tab_icon_color_active',
            [
            'label' => esc_html__('Icon color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .contact-form-tabs-navigation-item.active svg' => 'fill : {{VALUE}};',
                '{{WRAPPER}} .contact-form-tabs-navigation-item:hover svg' => 'fill : {{VALUE}};'
            ]
            
            ]
        );

        $this->add_control(
            'tab_border_color_active',
            [
            'label' => esc_html__('Border color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .contact-form-tabs-navigation-item.active' => 'border-color : {{VALUE}};',
                '{{WRAPPER}} .contact-form-tabs-navigation-item:hover' => 'border-color : {{VALUE}};'
            ]
            
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

	protected function register_controls() {
        $this->content_controls();

        $this->tabs_styles();

        growla_cf7_field_styles( $this );
        growla_cf7_textarea_styles( $this );
        growla_cf7_dropdown_styles( $this );
        growla_cf7_button_styles( $this );
	}

    protected function get_contact_form_7_forms() {

        $args = array('post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1);

        $catlist=[];
    
        if ( $categories = get_posts( $args ) ){
            foreach ( $categories as $category ) {
                ( int ) $catlist[ $category->ID ] = $category->post_title;
            }
        }
        else {
            ( int ) $catlist[ '0' ] = esc_html__( 'No contact From 7 form found', 'growla' );
        }

        return $catlist;
    }


	protected function render() {			
		$settings = $this->get_settings();
  ?>
    <div class="contact-form-tabs">
        <?php $this->render_navigation(); ?>
        <?php $this->render_tabs(); ?>
    </div>
  <?php
    }

    private function render_navigation() {
        $settings = $this->get_settings();
        $id = $this->get_id(); 
        ?>
        <div class="contact-form-tabs-navigation">
            <?php  
                foreach ( $settings['contact_forms'] as $index => $item ):
                    $is_active = $index == 0;
                    $target_id = '#contact-form-tab-' . $id . $index;

                    $classes = array( 'contact-form-tabs-navigation-item' );

                    if ( $is_active ) {
                        $classes[] = 'active';
                    }
            ?>
                <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" data-target="<?php echo esc_attr( $target_id ); ?>">
                    <?php
                        // icon
                        \Elementor\Icons_Manager::render_icon( 
                            $item['icon'], 
                            [ 'aria-hidden' => 'true' ]
                        ); 
                    ?>
                    <?php if ( ! empty( $item['label'] ) ): ?>
                        <?php echo esc_html( $item['label'] ); ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }

    private function render_tabs() {
        $settings = $this->get_settings();
        $id = $this->get_id(); 
        ?>
        <div class="contact-form-tabs-content">
            <?php 
                foreach ( $settings['contact_forms'] as $index => $item ):
                    $is_active = $index == 0;
                    $shortcode_tag = '[contact-form-7 id="'. $item['form_id'] .'"]';
                    $tab_id = 'contact-form-tab-' . $id . $index;

                    $classes = array( 'contact-form-tab' );

                    if ( $is_active ) {
                        $classes[] = 'active';
                    }
            ?>
            <div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" id="<?php echo esc_attr( $tab_id ); ?>">
                <?php echo do_shortcode( $shortcode_tag );  ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}

