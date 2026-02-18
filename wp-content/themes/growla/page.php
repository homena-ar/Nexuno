<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package growla
 */

	get_header();

	get_template_part( 'inc/template-parts/page', 'header' );

	$is_elementor_page = false;
	if ( class_exists( 'Elementor\Plugin' ) ) {
        global $post;
		$is_elementor_page = Elementor\Plugin::$instance->documents->get( $post->ID )->is_built_with_elementor();
    }

	$comments_on = comments_open() || get_comments_number();

	while ( have_posts() ) :
		the_post();

		// default page markup
		if ( ! $is_elementor_page ): ?>
		<div
		class="default-page <?php echo esc_attr( ! $comments_on ? 'no-comments' : '' ); ?> <?php echo esc_attr( ( ! have_comments() ) && $comments_on ? 'only-comment-form' : '' ); ?>"
		>
			<div class="growla-container-small">
		<?php endif;

		get_template_part( 'inc/template-parts/content', 'page' );

		// default page markup
		if ( ! $is_elementor_page ): ?>
					</div>
		</div>
		<?php endif;

		// If comments are open or we have at least one comment, load up the comment template.
		if ( $comments_on ) :
			comments_template();
		endif;

	endwhile; // End of the loop.

get_footer();
