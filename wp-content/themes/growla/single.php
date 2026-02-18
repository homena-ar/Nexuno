<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package growla
 */

	get_header();

	get_template_part( 'inc/template-parts/page', 'header' );

	$date_format = 'default';
	$date_format_field = get_post_meta(get_the_ID(), 'theme_specified_date_format', true);

	if ( !class_exists( 'Redux' ) ) {
		$growla_opt = [];
		$growla_opt['meta_post_date_select'] = 'default';
	} else {
		global $growla_opt;
	}

    if ( $growla_opt['meta_post_date_select'] !== 'default' ) {
		$date_format = 'custom';
    }

	// pagination
    $pagination = [
		'before'=> '
			<div class="post-nav-links">
				<h6>'.__('Pages', 'growla').': </h6>
				<div class="post-nav-links-inner">', 
		'after' => '
				</div>
			</div>'
	];

	$date_class = 'date-' . $date_format;

	$is_paginated = ( ! empty( get_next_posts_link() ) ) || ( ! empty( get_previous_posts_link() ) );
?>

	<?php while ( have_posts() ): the_post(); ?>
	
	<div class="blog-detail">
		<div class="blog-detail-wrapper">
			<div class="growla-container">
				<!-- thumbnail - start -->
                <div class="blog-detail-thumbnail <?php echo esc_attr( ! has_post_thumbnail() ? 'no-thumbnail growla-container-small' : '' ); ?>">
                    <?php growla_post_thumbnail( 'growla-post-detail-thumbnail-size' ); ?>
                    <div class="date <?php echo esc_attr( $date_class ); ?>">
                        <a href="<?php echo esc_url( home_url( get_the_date('Y/m/d') ) ); ?>">
                            <?php echo wp_kses( growla_get_the_date( $date_format ), 'post' ); ?>
                        </a>
                    </div>
                </div>
				<!-- thumbnail - end -->
				<?php if ( ! empty( get_the_title() ) ): ?>
				<!-- title - start -->
				<div class="growla-container-small">
                    <div class="blog-detail-content">
                        <?php
                            the_title( '<h1>', '</h1>' ); 
                        ?>
                    </div>
                </div>
				<!-- title - end -->
				<?php endif; ?>

				<?php if ( ! empty( get_the_content() ) ): ?>
				<!-- content - start -->
				<div <?php post_class(array('blog-detail-content-wrapper', 'growla-container-small')); ?>>
                    <?php the_content(); ?>
                </div>
				<!-- content - end -->
				<?php endif; ?>

				<?php if ( $is_paginated || has_tag() ): ?>
				<!-- details - start -->
				<div class="growla-container-small">
					<div class="<?php echo esc_attr( $col_class ); ?>">
						<!-- blog pagination - start -->
						<div class="pagination-container">
							<?php wp_link_pages($pagination); ?>
						</div>
						<!-- blog pagination - end -->

						<?php if ( has_tag() ): ?>
						<!-- post tags - start -->
						<div class="post-tags">
							<?php the_tags( '<h6>' . __( 'Tags', 'growla' ) . ': </h6><ul><li>', '</li><li>', '</li></ul>'); ?>
						</div>
						<!-- post tags - end -->
						<?php endif; ?>
					</div>
				</div>
				<!-- details - end -->
				<?php endif; ?>
			</div>
		</div>
	</div>

    <?php get_template_part( 'inc/template-parts/content', 'related-blog' ) ?>

	<?php 
		if ( comments_open() || get_comments_number() != 0 ) {
			comments_template();
		}
	?>

	<?php endwhile; ?>

	


<?php
get_footer();
