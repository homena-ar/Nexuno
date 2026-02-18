<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package growla
 */

get_header();

if ( ! class_exists( 'Redux' ) ) {
    $growla_opt                               = array();
	$growla_opt['404_button_1_text']           = '';
	$growla_opt['404_button_1_link']           = '';
	$growla_opt['404_button_2_text']           = '';
	$growla_opt['404_button_2_link']           = '';
} else {
    global $growla_opt;
}

$error_top_heading = __( '404 Error.', 'growla' );
$error_heading = __( 'The page you’re looking for doesn’t exist', 'growla' );
$error_paragraph = __( 'We\'re sorry for the inconvenience. The page you\'e looking for doesn\'t exist or has been removed.', 'growla' );

$display_first_button = ! empty( $growla_opt['404_button_1_text'] ) && ! empty( $growla_opt['404_button_1_link'] );
$display_second_button = ! empty( $growla_opt['404_button_2_text'] ) && ! empty( $growla_opt['404_button_2_link'] );

$illustration = $growla_opt['404_page_header_illustration'] ?? 'none';

?>

<div class="error-page">
    <div class="growla-container">
        <div class="error-page-content">
            <?php if ( ! empty( $error_top_heading ) ): ?>
            <h1 class="error-page-top-heading"><?php echo esc_html( $error_top_heading ); ?></h1>
            <?php endif; ?>

            <?php if ( ! empty( $error_heading ) ): ?>
            <h1><?php echo esc_html( $error_heading ); ?></h1>
            <?php endif; ?>

            <?php if ( $display_first_button || $display_second_button ): ?>
            <div class="growla-button-group">
                <?php if ( $display_first_button ): ?>
                <a class="growla-button-border" href="<?php echo esc_url( $growla_opt['404_button_1_link'] ); ?>">
                    <span>
                        <?php echo esc_html( $growla_opt['404_button_1_text'] ); ?>
                    </span>
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>arrow-right</title><path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" /></svg>
                    </span>
                </a>
                <?php endif; ?>

                <?php if ( $display_second_button ): ?>
                <a class="growla-button-border growla-button-border-white" href="<?php echo esc_url( $growla_opt['404_button_2_link'] ); ?>">
                    <span>
                        <?php echo esc_html( $growla_opt['404_button_2_text'] ); ?>
                    </span>
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>arrow-right</title><path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" /></svg>
                    </span>
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </div>
    </div>
    <?php if ( $illustration !== 'none' ): ?>
    <div class="page-header-illustration">
        <?php get_template_part( 'inc/template-parts/illustrations/illustration', $illustration ); ?>
    </div>
    <?php endif; ?>
</div>

<?php
get_footer();
