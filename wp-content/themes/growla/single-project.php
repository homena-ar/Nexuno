<?php

    get_header();

    while ( have_posts() ):
        the_post();

        get_template_part( 'inc/template-parts/page', 'header' );

        $title = get_the_title();
        
        $categories = get_the_category();

        $meta_repeater_raw = array();
        $meta_repeater = array();

        $content_heading = '';

        if ( class_exists( 'Redux' ) ) {
            global $growla_opt;
            $meta_repeater_raw = $growla_opt['meta_project_info'];
            $content_heading = $growla_opt['meta_project_content_heading'];
        }

        if ( 
            ! empty( $meta_repeater_raw ) && 
            array_key_exists( 'meta_project_detail_title', $meta_repeater_raw ) && 
            array_key_exists( 'meta_project_detail_value', $meta_repeater_raw ) 
        ) {
            $meta_repeater = array_combine( $meta_repeater_raw['meta_project_detail_title'], $meta_repeater_raw['meta_project_detail_value'] );
        }

?>
    <div class="project-detail">
        <div class="growla-container">

            <!-- project title - start -->
            <div class="project-detail-header">
                <?php if ( ! empty( $title ) ): ?>
                    <h1 class="project-detail-title"><?php echo esc_html( $title ); ?></h1>
                <?php endif; ?>

                <?php if ( ! empty( $categories ) ): ?>
                    <p class="mini-parapgrah project-detail-categories">
                        <?php echo wp_kses( join( '<span>·</span>', wp_list_pluck( $categories, 'name' ) ), 'post' ); ?>
                    </p>
                <?php endif; ?>
            </div>
            <!-- project title - end -->

            <?php if ( has_post_thumbnail() ):  ?>
            <!-- project thumbnail - start -->
            <div class="project-detail-thumbnail">
                <?php growla_post_thumbnail( 'growla-project-detail-thumbnail-size' ); ?>
            </div>
            <!-- project thumbnail - end -->
            <?php endif; ?>

            <?php if ( ! empty( $content_heading ) ): ?>
                <h3 class="project-detail-content-heading">
                    <?php echo esc_html( $content_heading ); ?>
                </h3>
            <?php endif; ?>

            <!-- project inner content - start -->
            <div class="project-detail-inner">
                <!-- project content - start -->
                <div class="project-detail-content">
                    <?php the_content(); ?>
                </div>
                <!-- project content - end -->

                <!-- project sidebar - start -->
                <div class="project-detail-sidebar">
                    <div class="detail">
                        <span class="title"><?php echo esc_html__( 'Date', 'growla' ); ?>:</span>
                        <span><?php echo esc_html( get_the_date() ); ?></span>
                    </div>
                    <?php
                        if ( ! empty( $meta_repeater ) ):
                            foreach ( $meta_repeater as $title => $value ):
                                if ( empty( $title ) || empty( $value ) ) {
                                    continue;
                                }
                        ?>
                            <div class="detail">
                                <span class="title"><?php echo esc_html( $title ); ?></span>
                                <span><?php echo esc_html( $value ); ?></span>
                            </div>
                        <?php
                            endforeach;
                        endif;
                    ?>
                </div>
                <!-- project sidebar - end -->
            </div>
            <!-- project inner content - end -->

        </div>
    </div>

    
<?php
    get_template_part( 'inc/template-parts/content', 'related-projects' );

    endwhile;

    get_footer();