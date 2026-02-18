<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package growla
 */

	get_header();

	get_template_part( 'inc/template-parts/page', 'header' );

	$query = new WP_Query([
        'post_type' => 'post',
        'post_status'=> 'publish',
        'paged' => $paged
    ]);

	$content_class = 'growla-column-8 growla-column-991-12';
	$single_blog_class = 'growla-column-6 growla-column-991-12';

	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_class = 'growla-column-12 growla-column-991-12';
		$single_blog_class = 'growla-column-4 growla-column-991-12';
	}


	$error_heading = __( 'We\'re sorry, but there is no content available.', 'growla' );
	$error_paragraph = __( 'Can\'t find what you need? Take a moment and do a search again below or alternatively you can start from our', 'growla' );

?>

<div class="search">
	<?php if ( $query->have_posts() ): ?>
		<div class="search-wrapper">
			<div class="growla-container growla-container-grid">
                <!-- content - start -->
                <div class="<?php echo esc_attr( $content_class ); ?>">
                    <div class="growla-container-grid">
                        <?php while ( $query->have_posts() ): 
                            $query->the_post();
                        ?>
                            <div class="<?php echo esc_attr( $single_blog_class ); ?>">
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
                        <?php  endwhile;  wp_reset_postdata(); ?>
                    </div>
                    <?php growla_paginate( $query ); ?>
                </div>
                <!-- content - end -->
                <!-- sidebar - start -->
                <?php if ( is_active_sidebar( 'sidebar-1' ) ): ?>
                <div class="growla-column-4 growla-column-991-12">
                    <div class="sidebar-container">
                        <?php dynamic_sidebar( 'sidebar-1' ); ?>
                    </div>
                </div>
                <?php endif; ?>
                <!-- sidebar - end -->
			</div>
		</div>
	<?php else: ?>
        <div class="search-wrapper">
			<div class="growla-container-small">
				<!-- search error - start -->
                <div class="search-error">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path d="M571.3 324.7l-63.1-64c-6.25-6.25-16.37-6.25-22.62 0l-63.1 64c-6.25 6.25-6.25 16.38 0 22.62s16.38 6.25 22.62 0L480 310.6V336c0 79.41-64.59 144-144 144h-32V224h64C376.8 224 384 216.8 384 208S376.8 192 368 192h-64V158.4c36.47-7.434 64-39.75 64-78.38c0-44.11-35.89-80-79.1-80S208 35.89 208 80c0 38.63 27.53 70.95 64 78.38V192h-64C199.2 192 192 199.2 192 208S199.2 224 208 224h64v256h-32C160.6 480 96 415.4 96 336V310.6l36.69 36.69C135.8 350.4 139.9 352 144 352s8.184-1.562 11.31-4.688c6.25-6.25 6.254-16.38 .0037-22.62l-63.1-64c-6.25-6.25-16.37-6.25-22.62 0l-63.1 64c-6.25 6.25-6.256 16.38-.0059 22.62s16.38 6.25 22.62 0L64 310.6V336C64 433 142.1 512 240 512h95.1C433 512 512 433 512 336V310.6l36.69 36.69C551.8 350.4 555.9 352 559.1 352s8.189-1.562 11.31-4.688C577.6 341.1 577.6 330.9 571.3 324.7zM240 80C240 53.53 261.5 32 288 32s48 21.53 48 48S314.5 128 288 128S240 106.5 240 80z"/>
                        </svg>
                    </div>
                    <h2 class="heading"><?php echo esc_html( $error_heading ); ?></h2>
                    <p>
                        <?php echo esc_html( $error_paragraph ); ?>
                        <a href="<?php echo esc_url( home_url() ); ?>">
                            <?php echo __( 'homepage', 'growla' ); ?>
                        </a>
                    </p>
                </div>
                <!-- search error - end -->
			</div>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();
