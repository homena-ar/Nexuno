<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Team_2 extends \Elementor\Widget_Base

{

    public function get_name()
    {
        return 'growla_team_2';
    }

    public function get_title()
    {
        return esc_html__('Team 2', 'growla');
    }

    public function get_icon()
    {
        return 'eicon-user-circle-o';
    }

    public function get_categories()
    {
        return ['gfxpartner'];
    }

    protected function register_controls()
    {
        $this->general_settings();
        growla_heading_data_controls( $this );
        $this->team_members_controls();
        growla_slider_controls( $this, array(), 3 );

        growla_heading_style_controls( $this );
        $this->team_general_styles();
        $this->team_name_styles();
        $this->team_designation_styles();
        $this->team_social_styles();
        $this->team_icon_styles();
        growla_slide_nav_styles( $this );

    }

    private function general_settings() {
        $this->start_controls_section(
			'general',
			array(
				'label' => esc_html__( 'General', 'growla' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
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

    private function team_members_controls() {
        $this->start_controls_section(
            'team_member_content',
            [
                'label' => esc_html__('Team Members', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => __( 'Choose Image', 'growla' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label' => esc_html__( 'Name', 'growla' ),
                'type' => \Elementor\Controls_Manager::TEXT,            
                'placeholder' => esc_html__( 'Type name here', 'growla' ),
            ]
        );

        $repeater->add_control(
            'designation',
            [
                'label' => esc_html__( 'Designation', 'growla' ),
                'type' => \Elementor\Controls_Manager::TEXT,            
                'placeholder' => esc_html__( 'Type designation here', 'growla' ),
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => esc_html__( 'Content', 'growla' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,            
                'placeholder' => esc_html__( 'Type designation here', 'growla' ),
            ]
        );

        $repeater->add_control(
			'social_icon_1',
			[
				'label' => esc_html__( 'Social Icon 1', 'growla' ),
				'type' => \Elementor\Controls_Manager::ICONS,				
			]
		);

        $repeater->add_control(
			'social_link_1',
			[
				'label' => esc_html__( 'Social Link 1', 'growla' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'label_block' => true,
			]
		);

        $repeater->add_control(
			'social_icon_2',
			[
				'label' => esc_html__( 'Social Icon 2', 'growla' ),
				'type' => \Elementor\Controls_Manager::ICONS,				
			]
		);

        $repeater->add_control(
			'social_link_2',
			[
				'label' => esc_html__( 'Social Link 2', 'growla' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'label_block' => true,
			]
		);

        $repeater->add_control(
			'social_icon_3',
			[
				'label' => esc_html__( 'Social Icon 3', 'growla' ),
				'type' => \Elementor\Controls_Manager::ICONS,				
			]
		);

        $repeater->add_control(
			'social_link_3',
			[
				'label' => esc_html__( 'Social Link 3', 'growla' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'label_block' => true,
			]
		);

        $repeater->add_control(
			'social_icon_4',
			[
				'label' => esc_html__( 'Social Icon 4', 'growla' ),
				'type' => \Elementor\Controls_Manager::ICONS,				
			]
		);

        $repeater->add_control(
			'social_link_4',
			[
				'label' => esc_html__( 'Social Link 4', 'growla' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'label_block' => true,
			]
		);

        $this->add_control(
            'team_member_slides_repeater',
            [
              'label' => __( 'Team members', 'growla' ),
              'type' => \Elementor\Controls_Manager::REPEATER,
              'fields' => $repeater->get_controls(),
              'title_field' => __ ( 'Member','growla' ),
            ]
        );

        $this->end_controls_section();
    }

    private function member_social( $member ) {

        $COUNT = 4;

        ?>
        <ul class="team-member-2-social">
            <?php
                for ($i = 1; $i <= $COUNT; $i++):
                    $icon_key = 'social_icon_' . $i;
                    $link_key = 'social_link_' . $i;
                    $attribute_key = 'button_attr_' . $i;

                    if ( ! array_key_exists( $icon_key, $member ) || ! array_key_exists( $link_key, $member ) ) {
                        continue;
                    }

                    if ( empty( $member[$icon_key]['value'] ) || empty( $member[$link_key]['url'] ) ) {
                        continue;
                    }

                    $target = $member[$link_key]['is_external'] ? ' target="_blank"' : '';
                    $nofollow = $member[$link_key]['nofollow'] ? ' rel="nofollow"' : '';
                    $url = ' href='.esc_url( $member[$link_key]['url'] );
            ?>
                <li>
                    <a 
                        <?php echo esc_attr($url); ?>
                        <?php echo esc_attr($target); ?>
                        <?php echo esc_attr($nofollow); ?>
                    >
                        <?php
                            \Elementor\Icons_Manager::render_icon( 
                                $member[$icon_key], 
                                [ 'aria-hidden' => 'true' ]
                            ); 
                        ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
        <?php
    }

    private function the_team_member( $member ) {
        $settings = $this->get_settings_for_display();

        $click_icon_normal = $settings['click_icon_normal'];
        $click_icon_active = $settings['click_icon_active'];

        $image = \Elementor\Group_Control_Image_Size::get_attachment_image_html( 
            $member, 
            'full', 
            'image' 
        );

        ?>
        <div class="swiper-slide">
            <div class="team-member-2">
                <div class="team-member-2-wrapper">
                    <div class="team-member-2-image">
                        <?php echo wp_kses( $image, 'post' ); ?>
                    </div>
                    <div class="team-member-2-content">
                        <div class="team-member-2-content-inner-1">
                            <h4><?php echo esc_html( $member['name'] ); ?></h4>
                            <p class="mini-paragraph"><?php echo esc_html( $member['designation'] ); ?></p>
                        </div>

                        <div class="team-member-2-content-inner-2">
                            <?php if ( $member['content'] ): ?>
                            <p><?php echo wp_kses( $member['content'], 'post' ); ?></p>
                            <?php endif; ?>

                            <?php $this->member_social( $member ); ?>
                        </div>

                    </div>
                </div>
                <div class="team-member-2-icon">
                    <div class="team-member-2-icon-border"></div>
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
                <div class="team-member-2-small-thumbnail">
                    <?php echo wp_kses( $image, 'post' ); ?>
                </div>
            </div>
        </div>
        <?php
    }

    private function team_slider() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();
        $items = $settings['team_member_slides_repeater'];

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

        $class_list = [
            'slider',
            'team-slider',
            'swiper',
            'slider-'.$id
        ];

        if ( is_array( $items ) || is_object( $items ) ):
        ?>
        <div class="<?php echo esc_html( implode(' ', $class_list) ); ?>">
            <div class="swiper-wrapper">
            <?php
                foreach ( $items as $item ) {
                    $this->the_team_member( $item );
                }
            ?>
            </div>
        </div>
        <?php
        endif;
        growla_slider($id, $options );
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();
    ?>
    <div class="team-member-2-slider-wrapper">
        <?php 
            get_template_part( 'inc/template-parts/elementor/slider', 'header', array( 
                'settings' => $settings,
                'id' => $id
            ) );
            $this->team_slider();
        ?>
    </div>
    <?php
    }

    private function team_general_styles() {
        $this->start_controls_section(
            'general_styles',
            [
                'label' => esc_html__('General', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'background_color',
            [
              'label' => esc_html__('Background Color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .team-member-2' => 'background-color : {{VALUE}};'
              ]
              
            ]
        );
        
        $this->add_control(
            'separator_color',
            [
              'label' => esc_html__('Separator Color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .team-member-2-icon-border' => 'background-color : {{VALUE}};'
              ]
              
            ]
        );

        $this->end_controls_section();
    }

    private function team_name_styles() {
        $this->start_controls_section(
            'name_styles',
            [
                'label' => esc_html__('Name', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'label' => esc_html__('Typography', 'growla'),
                'selector' => '{{WRAPPER}} .team-member-2-content h4',
            ]
        ); 
        
        $this->add_control(
            'name_color',
            [
              'label' => esc_html__('Color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .team-member-2-content h4' => 'color : {{VALUE}};'
              ]
              
            ]
        );

        $this->end_controls_section();
    }

    private function team_designation_styles() {
        $this->start_controls_section(
            'designation_styles',
            [
                'label' => esc_html__('Desgination', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'desgination_typography',
                'label' => esc_html__('Typography', 'growla'),
                'selector' => '{{WRAPPER}} .team-member-2-content p.mini-paragraph',
            ]
        ); 
        
        $this->add_control(
            'designation_color',
            [
              'label' => esc_html__('Color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .team-member-2-content p.mini-paragraph' => 'color : {{VALUE}};'
              ]
              
            ]
        );

        $this->end_controls_section();
    }

    private function team_content_styles() {
        $this->start_controls_section(
            'content_styles',
            [
                'label' => esc_html__('Content', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__('Typography', 'growla'),
                'selector' => '{{WRAPPER}} .team-member-2-content-inner-2 p',
            ]
        ); 
        
        $this->add_control(
            'content_color',
            [
              'label' => esc_html__('Color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .team-member-2-content-inner-2 p' => 'color : {{VALUE}};'
              ]
              
            ]
        );

        $this->end_controls_section();
    }

    private function team_social_styles() {
        $this->start_controls_section(
            'social_styles',
            [
                'label' => esc_html__('Social', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'social_icon_tabs' );
    
        $this->start_controls_tab(
            'social_normal',
            [
                'label' => esc_html__( 'Normal', 'growla' ),
            ]
        );

        $this->add_control(
            'social_icon_color_normal',
            [
            'label' => esc_html__('Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .team-member-2-content li' => 'color : {{VALUE}}; fill : {{VALUE}};'
            ]
            
            ]
        );

        $this->add_control(
            'social_icon_background_color_normal',
            [
            'label' => esc_html__('Background Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .team-member-2-content li' => 'background-color : {{VALUE}};'
            ]
            
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'social_hover',
            [
                'label' => esc_html__( 'Hover', 'growla' ),
            ]
        );

        $this->add_control(
            'social_icon_color_hover',
            [
            'label' => esc_html__('Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .team-member-2-content li:hover' => 'color : {{VALUE}}; fill : {{VALUE}};'
            ]
            
            ]
        );

        $this->add_control(
            'social_icon_background_color_hover',
            [
            'label' => esc_html__('Bacckground Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .team-member-2-content li:hover' => 'background-color : {{VALUE}};'
            ]
            
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    private function team_icon_styles() {
        $this->start_controls_section(
            'icon_styles',
            [
                'label' => esc_html__('Icon', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'icon_tabs' );
    
        $this->start_controls_tab(
            'icon_normal',
            [
                'label' => esc_html__( 'Normal', 'growla' ),
            ]
        );

        $this->add_control(
            'icon_color_normal',
            [
            'label' => esc_html__('Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .team-member-2-icon .normal-icon svg' => 'fill : {{VALUE}};'
            ]
            
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_active',
            [
                'label' => esc_html__( 'Active', 'growla' ),
            ]
        );

        $this->add_control(
            'icon_color_active',
            [
            'label' => esc_html__('Color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .team-member-2-icon .active-icon svg' => 'fill : {{VALUE}};'
            ]
            
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }
}
