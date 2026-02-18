<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class Projects extends \Elementor\Widget_Base{

    public function get_name(){
        return 'growla_projects';
    }
 
    public function get_title(){
        return __( 'Projects', 'growla' );
    }

    public function get_icon(){
        return 'eicon-single-page';
    }

    public function get_categories(){
        return ['gfxpartner'];
    }

    private function get_projects_options() {
        $this->start_controls_section(
            'project_section',
            [
                'label' => __( 'Project Options', 'growla' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    
        $this->add_control(
            'important_note',
            [
                'label' => esc_html__( 'Important Note', 'growla' ),
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<p style="margin-top: 20px; line-height: normal;">' . __( 'You can customize these projects by going to the \'Projects\' (menu to the left) in the admin dashboard.', 'growla' ) . '</p>'
            ]
        );
    
        $this->add_control(
            'growla_projects_number',
            [
                'label' => __( 'Projects per page', 'growla' ),
                'type'  => \Elementor\Controls_Manager::NUMBER,
                'min'			=> -1,
                'default' => 3
            ]
        );
    
        $this->add_control(
            'growla_projects_order',
            [
                'label' => __( 'Order', 'growla' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'DESC' => 'descending',
                    'ASC' => 'ascending',
                ],
                'default' => 'DESC',
            ]
        );
    
        $this->add_control(
            'growla_projects_sort',
            [
                'label' => __( 'Sorting projects by', 'growla' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'date' => 'date',
                    'modified' => 'last modified date',
                    'rand' => 'Random',
                    'title' => 'title',
                    'comment_count' => 'number of comments',
                ],
                'default' => 'date',
            ]
        );
    
        $this->end_controls_section();
    }

    private function load_more_controls() {
        $this->start_controls_section(
            'load_more_section',
            [
                'label' => __( 'Load more', 'growla' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );
    
        $this->add_control(
            'lm_switch',
            [
                'label' => esc_html__( 'Display load more button', 'growla' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'growla' ),
                'label_off' => esc_html__( 'Hide', 'growla' ),
                'return_value' => 'yes',
                'default' => 'no'
            ]
        );
    
        $this->add_control(
            'load_more_text',
            [
                'label' => esc_html__( 'Text', 'growla' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'LOAD MORE', 'growla' )
            ]
        );

        $this->add_control(
            'load_more_icon',
            [
                'label' => __('Icon', 'growla'),
                'type' => \Elementor\Controls_Manager::ICONS
            ]
        );
    
        $this->end_controls_section();
    }

    private function load_more_style_controls() {
        $this->start_controls_section(
            'load_more_style_section',
            [
                'label' => __( 'Load more', 'growla' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [ 'ps_switch!' => 'yes', 'lm_switch' => 'yes' ]
            ]
        );
    
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_text',
                'label' => esc_html__('Text', 'growla'),
                'selector' => '{{WRAPPER}} .load-more-button',
            ]
        );
    
        $this->add_responsive_control(
          'button_align',
          [
              'label'         => esc_html__( 'Alignment', 'growla' ),
              'type'          => \Elementor\Controls_Manager::CHOOSE,
              'options'       => [
                  'left'      => [
                      'title'=> __( 'Left', 'growla' ),
                      'icon' => 'fa fa-align-left',
                  ],
                  'center'    => [
                      'title'=> __( 'Center', 'growla' ),
                      'icon' => 'fa fa-align-center',
                  ],
                  'right'     => [
                      'title'=> __( 'Right', 'growla' ),
                      'icon' => 'fa fa-align-right',
                  ],
              ],
              'default'       => 'center',
              'selectors'     => [
                  '{{WRAPPER}} .load-more-row > div' => 'text-align: {{VALUE}};',
              ],
          ]
        );
    
        $this->add_responsive_control(
                'width',
                [
                    'label' => esc_html__( 'Width', 'growla' ),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%', 'rem' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 5,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
              'rem' => [
                'min' => 0,
                'max' => 100
              ]
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .load-more-button' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );
    
        $this->start_controls_tabs( 'button_tabs' );
        
        $this->start_controls_tab(
            'button_normal',
            [
                'label' => esc_html__( 'Normal', 'growla' ),
            ]
        );
    
        $this->add_control(
            'button_text_color',
            [
              'label' => esc_html__('Text color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .load-more-button' => 'color : {{VALUE}} !important; fill : {{VALUE}} !important;'
              ]
              
            ]
        );
    
        $this->add_control(
          'button_bg_color',
          [
            'label' => esc_html__('Background color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
              '{{WRAPPER}} .load-more-button' => 'background-color : {{VALUE}}'
            ]
            
          ]
        );
    
        $this->end_controls_tab();
    
        $this->start_controls_tab(
            'button_hover',
            [
                'label' => esc_html__( 'Hover', 'growla' ),
            ]
        );
    
        $this->add_control(
            'button_text_color_hover',
            [
              'label' => esc_html__('Text hover color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .load-more-button:hover' => 'color : {{VALUE}} !important; fill : {{VALUE}} !important;'
              ]
              
            ]
        );
    
        $this->add_control(
          'button_bg_color_hover',
          [
            'label' => esc_html__('Background color', 'growla'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
              '{{WRAPPER}} .load-more-button:hover' => 'background-color : {{VALUE}}'
            ]
            
          ]
        );
    
        $this->end_controls_tab();
    
        $this->end_controls_tabs();
    
        $this->end_controls_section();
    
    }

    private function project_styles() {
        $this->start_controls_section(
            'project_styles',
            [
                'label' => __( 'Project Styles', 'growla' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
			'layout_style',
			[
				'label' => esc_html__( 'Layout Style', 'growla' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => esc_html__( 'Horizontal', 'growla' ),
					'vertical' => esc_html__( 'Vertical', 'growla' ),
				]
			]
		);

        $this->add_control(
            'display_layout_switcher',
            [
                'label' => esc_html__( 'Display layout switcher', 'growla' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'growla' ),
                'label_off' => esc_html__( 'Hide', 'growla' ),
                'return_value' => 'yes',
                'default' => 'no'
            ]
        );

        $this->start_controls_tabs( 'layout_switcher_tabs' );
        
        $this->start_controls_tab(
            'layout_switcher_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'growla' ),
                'condition' => [ 'display_layout_switcher' => 'yes' ]
            ]
        );
    
        $this->add_control(
            'layout_switcher_icon_color_normal',
            [
              'label' => esc_html__('Icon color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .project-list-layout-horizontal' => 'fill : {{VALUE}};',
                '{{WRAPPER}} .project-list-layout-vertical' => 'fill : {{VALUE}};'
              ],
              'condition' => [ 'display_layout_switcher' => 'yes' ]
            ]
        );

        $this->end_controls_tab();
    
        $this->start_controls_tab(
            'layout_switcher_active',
            [
                'label' => esc_html__( 'Active', 'growla' ),
                'condition' => [ 'display_layout_switcher' => 'yes' ]
            ]
        );
    
        $this->add_control(
            'layout_switcher_icon_color_active',
            [
              'label' => esc_html__('Icon color', 'growla'),
              'type' => \Elementor\Controls_Manager::COLOR,
              'selectors' => [
                '{{WRAPPER}} .project-list-layout-horizontal.project-list-layout-active' => 'fill : {{VALUE}};',
                '{{WRAPPER}} .project-list-layout-horizontal:hover' => 'fill : {{VALUE}};',
                '{{WRAPPER}} .project-list-layout-vertical.project-list-layout-active' => 'fill : {{VALUE}};',
                '{{WRAPPER}} .project-list-layout-vertical:hover' => 'fill : {{VALUE}};'
              ],
              'condition' => [ 'display_layout_switcher' => 'yes' ]
            ]
        );
    
        $this->end_controls_tab();
    
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function register_controls() {

        $this->get_projects_options();
        $this->load_more_controls();

        $this->project_styles();

        growla_heading_data_controls( $this );
        growla_heading_style_controls( $this );

    }
  
    private function the_projects( $pre_tag = '', $post_tag = '' ) {
        $settings = $this->get_settings_for_display();

        $args = array(
            'posts_per_page' => esc_attr($settings['growla_projects_number']),
            'orderby'     => esc_attr($settings['growla_projects_sort']),
            'order'       => esc_attr($settings['growla_projects_order']),      
            'post_type' => esc_attr('project'),
            'post_status'    => 'publish'
        );
        
        $query = new \WP_Query( $args );

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                if ( !empty( $pre_tag ) ) echo wp_kses( $pre_tag, 'general' );
                get_template_part( 
                    '/inc/template-parts/content', 
                    'project'
                );
                if ( !empty( $post_tag ) ) echo wp_kses( $post_tag, 'general' );
            }
            wp_reset_postdata();
        }
    }

    private function the_projects_list() {
        $settings = $this->get_settings_for_display();

        $layout_style = $settings['layout_style'];

        // total projects
        $max = wp_count_posts('project')->publish;

        $nonce = wp_create_nonce( 'projects-load-more' );

        $this->add_render_attribute( 'project_list', 'class', array( 'project-list-wrapper', 'project-list-' . $layout_style ) );
        $this->add_render_attribute( 'project_list', 'data-max', $max );
        $this->add_render_attribute( 'project_list', 'data-nonce', $nonce );

    ?>
        <div <?php $this->print_render_attribute_string( 'project_list' );  ?>>
            <?php $this->the_projects() ?>
        </div>
    <?php
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
    ?>
        <div class="project-list">
            <?php 
                $this->render_project_header();
                $this->the_projects_list();
                $this->render_load_more();
            ?>
        </div>
    <?php
    }

    private function render_load_more() {
        $settings = $this->get_settings_for_display();

        $url = home_url() . '/wp-admin/admin-ajax.php';

        // total projects
        $max = wp_count_posts('project')->publish;

        $icon = $settings['load_more_icon'];

        if ( 
            $settings['lm_switch'] == 'yes' && 
            // show if there is something to load more
            (int) $settings['growla_projects_number'] < $max  ): ?>
        <div class="load-more-row">
            <a
            href="<?php echo esc_url( $url ); ?>"
            class="growla-button-border load-more-button gfx-titan-preloader-ignore">
                <span><?php echo esc_html( $settings['load_more_text'] ); ?></span>
                <?php if ( ! empty( $icon ) ): ?>
                    <span class="icon">
                        <?php
                            // icon
                            \Elementor\Icons_Manager::render_icon( 
                                $icon, 
                                [ 'aria-hidden' => 'true' ]
                            ); 
                        ?>
                    </span>
                <?php endif; ?>
            </a>
        </div>
        <?php endif;
    }

    private function render_project_header() {
        $settings = $this->get_settings_for_display();

        if ( 
            empty( $settings['subheading'] ) && 
            empty( $settings['heading'] ) &&
            $settings['display_layout_switcher'] !== 'yes'
        ) {
            return;
        }

        $active_class = 'project-list-layout-active';
        $layout_style = $settings['layout_style'];
        $horizontal_class = array( 'project-list-layout-horizontal' );
        $vertical_class = array( 'project-list-layout-vertical' );

        if ( $layout_style === 'horizontal' ) {
            $horizontal_class[] = $active_class;   
        } else {
            $vertical_class[] = $active_class; 
        }
        

    ?>
        <div class="project-list-header">
            <?php growla_heading( $settings ); ?>

            <?php if ( $settings['display_layout_switcher'] === 'yes' ): ?>
            <div class="project-list-layout-switcher">
                <div class="<?php echo esc_attr( implode( ' ', $vertical_class ) ); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>format-columns</title><path d="M3,3H11V5H3V3M13,3H21V5H13V3M3,7H11V9H3V7M13,7H21V9H13V7M3,11H11V13H3V11M13,11H21V13H13V11M3,15H11V17H3V15M13,15H21V17H13V15M3,19H11V21H3V19M13,19H21V21H13V19Z" /></svg>
                </div>
                <div class="<?php echo esc_attr( implode( ' ', $horizontal_class ) ); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>format-align-justify</title><path d="M3,3H21V5H3V3M3,7H21V9H3V7M3,11H21V13H3V11M3,15H21V17H3V15M3,19H21V21H3V19Z" /></svg>
                </div>
            </div>
            <?php endif; ?>
        </div>
    <?php
    }
}

