<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class Blog extends \Elementor\Widget_Base{

    public function get_name(){
        return 'growla_blog';
    }
 
    public function get_title(){
        return __( 'Blog', 'growla' );
    }

    public function get_icon(){
        return 'eicon-post-list';
    }

    public function get_categories(){
        return ['gfxpartner'];
    }

    private function content_controls() {
        $this->start_controls_section(
            'blog_section',
            [
                'label' => __( 'Post Options', 'growla' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
    
        $this->add_control(
            'growla_blog_column',
            [
                'label' => __( 'Columns', 'growla' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'blog-wrapper-column-3',
                'options' => [
                    'blog-wrapper-column-2'  => __( '2', 'growla' ),
                    'blog-wrapper-column-3' => __( '3', 'growla' )
                ],
            ]
        );
    
        $this->add_control(
            'growla_posts_number',
            [
                'label' => __( 'Posts per page', 'growla' ),
                'type'  => \Elementor\Controls_Manager::NUMBER,
                'min'			=> -1,
                'default' => 3
            ]
        );
    
        $this->add_control(
            'growla_posts_order',
            [
                'label' => __( 'Order posts', 'growla' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'DESC' => 'descending',
                    'ASC' => 'ascending',
                ],
                'default' => 'DESC',
            ]
        );
    
        $this->add_control(
            'growla_posts_sort',
            [
                'label' => __( 'Sorting posts by', 'growla' ),
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
    
        $this->add_control(
            'show_pagination',
            [
                'label' => __( 'Show pagination', 'growla' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'growla' ),
                'label_off' => __( 'Hide', 'growla' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
    
        $this->add_control(
            'custom_date_format',
            [
                'label' => __( 'Custom date format', 'growla' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'growla' ),
                'label_off' => __( 'No', 'growla' ),
                'return_value' => 'custom',
                'default' => 'custom',
            ]
        );
    
        $this->end_controls_section();
    }

    protected function register_controls() {
        $this->content_controls();

        $this->title_styles();
        $this->date_styles();
        $this->author_styles();
        $this->pagination_styles();
    }
  

  protected function render(){
    $settings = $this->get_settings_for_display();
    $id = $this->get_id();

    $paged = growla_get_page_query();
    
    $args = array(
      'posts_per_page' => esc_attr($settings['growla_posts_number']),
      'orderby'     => esc_attr($settings['growla_posts_sort']),
      'order'       => esc_attr($settings['growla_posts_order']),      
      'post_type' => esc_attr('post'),
      'paged' => $paged,
      'post_status'    => 'publish'
    );
      
    $query = new \WP_Query( $args );


    $wrapper_class = array(
        'blog-wrapper',
        $settings['growla_blog_column']
    );

  ?>
    <div class="<?php echo esc_attr( implode( ' ', $wrapper_class ) ); ?>">
        <?php 
            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    $query->the_post();
                    get_template_part( 
                        '/inc/template-parts/content', 
                        'post',
                        [
                            'date_format' => $settings['custom_date_format']
                        ]
                    );
                } 
                wp_reset_postdata();
            }
        ?>
    </div>
    <?php 
        if ( $settings['show_pagination'] == 'yes' ) {
            growla_paginate( $query );
        }
    ?>
  <?php
  }

  private function title_styles() {
    $this->start_controls_section(
        'blog_title_style_section',
        [
            'label' => __('Title', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
          'name' => 'blog_title_format',
          'label' => __('Typography', 'growla'),
          'selector' => '{{WRAPPER}} .single-blog-post h4',
      ]
    );

    $this->add_control(
      'blog_title_color',
      [
        'label' => __('Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .single-blog-post h4' => 'color : {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_section();
  }

  private function date_styles() {
    $this->start_controls_section(
        'blog_date_style_section',
        [
            'label' => __('Date', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
          'name' => 'blog_date_format',
          'label' => __('Typography', 'growla'),
          'selector' => '{{WRAPPER}} .single-blog-post .content .details .date',
      ]
    );

    $this->add_control(
      'blog_date_color',
      [
        'label' => __('Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .single-blog-post .content .details .date' => 'color : {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
        'blog_date_bg_color',
        [
          'label' => __('Background Color', 'growla'),
          'type' => \Elementor\Controls_Manager::COLOR,
          'selectors' => [
            '{{WRAPPER}} .single-blog-post .content .details .date' => 'background-color : {{VALUE}}',
          ],
        ]
      );

    $this->end_controls_section();
  }

  private function author_styles() {
    $this->start_controls_section(
        'blog_author_style_section',
        [
            'label' => __('Author', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
          'name' => 'blog_author_format',
          'label' => __('Typography', 'growla'),
          'selector' => '{{WRAPPER}} .single-blog-post .details h6',
      ]
    );

    $this->add_control(
      'blog_author_color',
      [
        'label' => __('Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .single-blog-post .details h6' => 'color : {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_section();
  }

  private function pagination_styles() {
    $this->start_controls_section(
        'blog_pagination_style_section',
        [
            'label' => __('Pagination', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );
  
    $this->add_responsive_control(
      'pagination_align',
      [
          'label'         => esc_html__( 'Alignment', 'growla' ),
          'type'          => \Elementor\Controls_Manager::CHOOSE,
          'options'       => [
              'margin-right: auto;'      => [
                  'title'=> __( 'Left', 'growla' ),
                  'icon' => 'eicon-h-align-left',
              ],
              'margin-left: auto; margin-right: auto;'    => [
                  'title'=> __( 'Center', 'growla' ),
                  'icon' => 'eicon-h-align-center',
              ],
              'margin-left: auto;'     => [
                  'title'=> __( 'Right', 'growla' ),
                  'icon' => 'eicon-h-align-right',
              ],
          ],        
          'selectors'     => [
              '{{WRAPPER}} .page-numbers' => '{{VALUE}};',
          ],
      ]
    );
  
    $this->start_controls_tabs( 'pagination_tabs' );
  
    $this->start_controls_tab(
      'pagination_normal',
      [
          'label' => esc_html__( 'Normal', 'growla' ),
      ]
    );
  
    $this->add_control(
      'pagination_color_normal',
      [
        'label' => esc_html__('Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .pagination li' => 'color : {{VALUE}};'
        ]
        
      ]
    );
  
    $this->add_control(
      'pagination_background_color_normal',
      [
        'label' => esc_html__('Background color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .pagination li' => 'background-color : {{VALUE}};',        
        ]
        
      ]
    );
  
    $this->add_control(
      'pagination_prev_next_color_normal',
      [
        'label' => esc_html__('Prev/Next color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .pagination li *.prev' => 'color : {{VALUE}}; fill : {{VALUE}};',
          '{{WRAPPER}} .pagination li *.next' => 'color : {{VALUE}}; fill : {{VALUE}};'
        ]
        
      ]
    );
  
    $this->add_control(
      'pagination_prev_next_bg_color_normal',
      [
        'label' => esc_html__('Prev/Next Background color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .pagination li *.prev' => 'background-color : {{VALUE}};',
          '{{WRAPPER}} .pagination li *.next' => 'background-color : {{VALUE}};'
        ]
        
      ]
    );
  
    $this->end_controls_tab();
  
    $this->start_controls_tab(
      'pagination_hover',
      [
          'label' => esc_html__( 'Hover', 'growla' ),
      ]
    );
  
    $this->add_control(
      'pagination_color_hover',
      [
        'label' => esc_html__('Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .pagination li:hover' => 'color : {{VALUE}};',
          '{{WRAPPER}} .pagination li:focus' => 'color : {{VALUE}};',
          '{{WRAPPER}} .pagination li *.current' => 'color : {{VALUE}};'
        ]
        
      ]
    );
  
    $this->add_control(
      'pagination_background_color_hover',
      [
        'label' => esc_html__('Background color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .pagination li:hover' => 'background-color : {{VALUE}};',
          '{{WRAPPER}} .pagination li:focus' => 'background-color : {{VALUE}};',
          '{{WRAPPER}} .pagination li *.current' => 'background-color : {{VALUE}};'
        ]
        
      ]
    );
  
    $this->add_control(
      'pagination_prev_next_color_hover',
      [
        'label' => esc_html__('Prev/Next color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .pagination li *.prev:hover' => 'color : {{VALUE}}; fill : {{VALUE}};',
          '{{WRAPPER}} .pagination li *.next:hover' => 'color : {{VALUE}}; fill : {{VALUE}};'
        ]
        
      ]
    );
  
    $this->add_control(
      'pagination_prev_next_bg_color_hover',
      [
        'label' => esc_html__('Prev/Next Background color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .pagination li *.prev:hover' => 'background-color : {{VALUE}};',
          '{{WRAPPER}} .pagination li *.next:hover' => 'background-color : {{VALUE}};'
        ]
        
      ]
    );
  
    $this->end_controls_tab();
  
    $this->end_controls_tabs();
  
    $this->end_controls_section();
  }
}

