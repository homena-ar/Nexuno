<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Team extends \Elementor\Widget_Base

{

    public function get_name()
    {
        return 'growla_team';
    }

    public function get_title()
    {
        return esc_html__('Team', 'growla');
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

        $this->general_content_controls();
        $this->social_content_controls();
        $this->name_style_controls();
        $this->designation_style_controls();
        $this->social_links_style_controls();
    }

    private function general_content_controls() {
        $this->start_controls_section(
            'general_content',
            [
                'label' => esc_html__('General', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'image',
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

        $this->add_control(
            'name',
            [
                'label' => esc_html__( 'Name', 'growla' ),
                'type' => \Elementor\Controls_Manager::TEXT,            
                'placeholder' => esc_html__( 'Type name here', 'growla' ),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'designation',
            [
                'label' => esc_html__( 'Designation', 'growla' ),
                'type' => \Elementor\Controls_Manager::TEXT,            
                'placeholder' => esc_html__( 'Type designation here', 'growla' ),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function social_content_controls() {
        $this->start_controls_section(
            'social',
            [
                'label' => esc_html__('Social', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'social_icon',
            [
                'label' => __('Icon', 'growla'),
                'type' => \Elementor\Controls_Manager::ICONS
            ]
        );

        $repeater->add_control(
            'social_link',
            [
                'label' => esc_html__('Link', 'growla'),
                'type' => \Elementor\Controls_Manager::URL
            ]
        );

        $this->add_control(
            'social_repeater',
            [
              'label' => __( 'Social', 'growla' ),
              'type' => \Elementor\Controls_Manager::REPEATER,
              'fields' => $repeater->get_controls(),
              'title_field' => esc_html__( 'Social', 'growla' ),
            ]
        );


        $this->end_controls_section();
    }

    private function name_style_controls() {
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
                'selector' => '{{WRAPPER}} .team-member-content h4',
            ]
        ); 
        
        $this->add_control(
            'name_color',
            [
              'label' => esc_html__('Color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .team-member-content h4' => 'color : {{VALUE}};'
              ]
              
            ]
        );

        $this->end_controls_section();
    }

    private function designation_style_controls() {
        $this->start_controls_section(
            'designation_styles',
            [
                'label' => esc_html__('Designation', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'designation_typography',
                'label' => esc_html__('Typography', 'growla'),
                'selector' => '{{WRAPPER}} .team-member-content p',
            ]
        ); 
        
        $this->add_control(
            'designation_color',
            [
              'label' => esc_html__('Color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .team-member-content p' => 'color : {{VALUE}};'
              ]
              
            ]
        );

        $this->end_controls_section();
    }

    private function social_links_style_controls() {
        $this->start_controls_section(
            'social_links_styles',
            [
                'label' => esc_html__('Social Links', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'social_icon_tabs' );

        $this->start_controls_tab(
            'social_icon_normal',
            [
                'label' => esc_html__( 'Normal', 'growla' ),
            ]
        );

        $this->add_control(
            'social_icon_color_normal',
            [
              'label' => esc_html__('Social icon color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .team-member-content li' => 'color : {{VALUE}}; fill : {{VALUE}};',
              ]
              
            ]
        );

        $this->add_control(
            'social_icon_bg_color_normal',
            [
              'label' => esc_html__('Social icon background color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .team-member-content li' => 'background-color : {{VALUE}};'
              ]
              
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'social_icon_hover',
            [
                'label' => esc_html__( 'Hover', 'growla' ),
            ]
        );

        $this->add_control(
            'social_icon_color_hover',
            [
              'label' => esc_html__('Social icon color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .team-member-content li:hover' => 'color : {{VALUE}}; fill : {{VALUE}};',
              ]
              
            ]
        );

        $this->add_control(
            'social_icon_bg_color_hover',
            [
              'label' => esc_html__('Social icon background color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .team-member-content li:hover' => 'background-color : {{VALUE}};'
              ]
              
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $class_list = array( 'team-member' );
    ?>
    <div class="<?php echo esc_attr( implode( ' ', $class_list ) ); ?>">
        <?php if ( ! empty( $settings['image'] ) ): ?>
        <div class="team-member-image">
            <?php
                echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( 
                    $settings, 
                    'full', 
                    'image' 
                );
            ?>
        </div>
        <?php endif; ?>
        <div class="team-member-content">
            <h4><?php echo esc_html( $settings['name'] ); ?></h4>
            <p class="mini-paragraph"><?php echo esc_html( $settings['designation'] ); ?></p>
            <?php $this->render_social_icons(); ?>
        </div>
    </div>
    <?php
    }

    private function render_social_icons() {
        $settings = $this->get_settings_for_display();
        $social_repeater = $settings['social_repeater'];
    ?>
        <?php if ( !empty( $social_repeater ) ): ?>
            <ul class="team-member-social">
                <?php 
                    foreach ( $social_repeater as $social ):
                        if ( empty( $social['social_link']['url'] ) ) continue;
                        $target = $social['social_link']['is_external'] ? ' target="_blank"' : '';
                        $nofollow = $social['social_link']['nofollow'] ? ' rel="nofollow"' : '';
                        $url = ' href='.esc_url( $social['social_link']['url'] );
                ?>
                    <li>
                        <a
                            <?php echo esc_attr($url); ?>
                            <?php echo esc_attr($target); ?>
                            <?php echo esc_attr($nofollow); ?>
                        >
                            <?php 
                                \Elementor\Icons_Manager::render_icon( 
                                    $social['social_icon'], 
                                    [ 'aria-hidden' => 'true' ]
                                ); 
                            ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php
    }
}
