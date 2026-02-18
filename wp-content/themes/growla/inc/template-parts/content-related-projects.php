<?php

    $display = true;

    if ( class_exists( 'Redux' ) ) {
        global $growla_opt;
        $display = $growla_opt['meta_project_rp_switch'];
		$growla_opt['prs_subheading_txt'] = __( '// WORKS', 'growla' );
		$growla_opt['prs_heading_txt'] = __( 'Other Projects', 'growla' );
	}

    if ( '1' != $display ) return;
    
    $prev_icon = 'default-prev';
    $next_icon = 'default-next';

    // id for the slider
    $id = 'related-project';

    // settings for the content
    $settings = [
        'subheading' => $growla_opt['prs_subheading_txt'],
        'heading' => $growla_opt['prs_heading_txt'],
        'prev_icon' => $prev_icon,
        'next_icon' => $next_icon,
        'animate_heading' => $growla_opt['prs_heading_animate'] ?? false
    ];

    // options for the slider
    $options = [
        'loop' => false,
        'speed' => 1000,
        'slidesPerView' => 2,
        'spaceBetween'=> 30,
        'resizeObserver' => true,
        'navigation' => [
            'nextEl' => '.slider-nav-' . $id  . ' .slider-nav-next',
            'prevEl' => '.slider-nav-' . $id  . ' .slider-nav-prev'
        ],
        'breakpoints' => [
            '0' => [
                'slidesPerView' => 1,
                'centeredSlides' => true,
                'initialSlide' => 1,
                'spaceBetween'=> 33,
            ],
            '992' => [
                'slidesPerView' => 2,
                'centeredSlides' => false
            ]
        ]
    ];

    // main class list
    $class_list = [
        'project-slider',
        'swiper',
        'slider-'.$id
    ];

    $categories = get_the_category();

    $args = array(
        'posts_per_page' => 4,
        'post_type' => esc_attr('project'),
        'post_status'    => 'publish',
        'post__not_in' => [ $post->ID ],
		'ignore_sticky_posts' => 1,
		'cat' => !empty( $categories ) ? $categories[0]->term_id : null
    );
    
    $rp_query = new \WP_Query( $args );

    if ( ! $rp_query->have_posts() ) return;

?>

<div class="related-projects">
    <div class="related-projects-wrapper">
        <div class="growla-container">
            <div>
                <!-- header - start -->
                <?php
                    get_template_part( 
                        '/inc/template-parts/elementor/slider', 
                        'header',
                        array(
                            'settings' => $settings,
                            'id' => $id
                        )
                    );
                ?>
                <!-- header - end -->
                <!-- slider - start -->
                <div class='<?php echo esc_attr( implode(' ', $class_list) ); ?>'>
                    <div class='swiper-wrapper'>
                        <?php
                            while ( $rp_query->have_posts() ) {
                                $rp_query->the_post();

                                echo wp_kses( '<div class="swiper-slide">', 'general' );
                                get_template_part( 
                                    '/inc/template-parts/content', 
                                    'project',
                                    array(
                                        'layout_style' => 'vertical'
                                    )
                                );
                                echo wp_kses( '</div>', 'general' );
                            } wp_reset_postdata();
                        ?>
                    </div>
                </div>
                <!-- slider - end -->
            </div>
        </div>
    </div>
</div>
<?php growla_slider( 'related-project', $options ); ?>