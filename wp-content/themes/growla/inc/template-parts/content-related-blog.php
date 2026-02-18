<?php

$display_rs = true;
$subheading = __( '// NEWS', 'growla' );
$heading = __( 'Similar News.', 'growla' );
$animate_heading = false; 

if ( class_exists( 'Redux' ) ) {
    global $growla_opt;
    $display_rs = $growla_opt['meta_post_rs_switch'] === '1';
    $subheading = $growla_opt['brs_heading_subheading'] ?? '';
    $heading = $growla_opt['brs_heading_txt'] ?? '';
    $animate_heading = $growla_opt['brs_heading_animate'] ?? false;
}

$categories = get_the_category();

$args = [
    'posts_per_page' => 4,
    'post_type' => 'post',
    'post__not_in' => [ $post->ID ],
    'ignore_sticky_posts' => 1,
    'cat' => !empty( $categories ) ? $categories[0]->term_id : null
];

$rp_query = new WP_Query( $args );

if ( ! $display_rs || ! $rp_query->have_posts() ) {
    return;
}

$options = array(
    'subheading' => $subheading,
    'heading' => $heading,
    'subheading_tag' => 'h6',
    'prev_icon' => 'default-prev',
    'next_icon' => 'default-next',
    'animate_heading' => $animate_heading
);

$id = 'related_blog';

$slider_options = [
    'spaceBetween'		=> 30,
    'resizeObserver' 	=> true,
    'autoHeight'		=> true,
    'navigation' 		=> [
        'nextEl' 		=> '.slider-nav-'.$id.' .slider-nav-next',
        'prevEl' 		=> '.slider-nav-'.$id.' .slider-nav-prev',
    ],
    'breakpoints'		=> [
        '0' => [
            'slidesPerView'		=> 1,
            'centeredSlides'	=> true,
        ],
        '992' => [
            'slidesPerView'		=> 3,
            'centeredSlides'	=> false,
        ],
    ]
];

?>

<div class="related-blog-wrapper">
    <div class="related-blog">
        <div class="growla-container">
            <!-- header - start -->
            <?php
                get_template_part( 
                    '/inc/template-parts/elementor/slider', 
                    'header',
                    array(
                        'settings' => $options,
                        'id' => $id
                    )
                );
            ?>
            <!-- header - end -->
            <div class="swiper related-blog-slider slider-<?php echo esc_attr( $id ); ?>">
                <div class="swiper-wrapper">
                    <?php 
                        while ( $rp_query->have_posts() ): 
                        $rp_query->the_post();
                    ?>
                        <div class="swiper-slide">
                            <?php
                                get_template_part( 
                                    '/inc/template-parts/content', 
                                    'post',
                                    [
                                        'date_format' => 'custom'
                                    ]
                                );
                            ?>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php growla_slider( 'related_blog', $slider_options ); ?>