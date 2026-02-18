<?php

	$display_header = true;
	$heading        = null;
	$bg_img         = array();
    $illustration   = 'none';

if ( class_exists( 'Redux' ) ) {
    global $growla_opt;
    $display_header = $growla_opt['meta_page_header_switch'] ?? true;
    $heading = $growla_opt['meta_page_header_heading'] ?? '';
    $bg_img = $growla_opt['meta_page_header_background'] ?? '';
    $illustration = $growla_opt['meta_page_header_illustration'] ?? 'none';
}

$is_search = is_search();
$is_archive = is_archive();
$is_404 = is_404();

if ( ! $display_header && ! $is_search && ! $is_archive && ! $is_404 ) {
	return;
}

if ( $is_search ) {
	$heading = __( 'Search result', 'growla' );
}

if ( $is_archive ) {
	$heading = __( 'Archives', 'growla' );
}

if ( $is_404 ) {
	$heading = __( 'Not Found', 'growla' );
}

if ( ( $is_search || $is_archive ) && class_exists( 'Redux' ) ) {
    $illustration = $growla_opt['search_page_header_illustration'] ?? 'none';
}
?>

<div class="page-header">
	<div class="page-header-wrapper" 
	style="<?php echo esc_attr( growla_build_background_properties( $bg_img ) ); ?>"
	>
		<div class="growla-container">
            <div class="page-header-content">
                <div class="page-title">
                    <h1>
                    <?php
                    if ( ! empty( $heading ) ) {
                        // custom heading
                        echo esc_html( $heading );
                    } else {
                        // dynamic heading
                        $type = get_post_type();
                        if ( $type == 'page' ) {
                            the_title();
                        } elseif ( is_home() ) {
                            $title = single_post_title( '', false );
                            if ( empty( $title ) ) {
                                $title = __( 'Journal', 'growla' );
                            }
                            echo esc_html( $title, 'growla' );
                        } else {
                            echo esc_html( ucfirst( $type ) );
                        }
                    }
                    ?>
                    </h1>
                </div>
                <div class="breadcrumbs">
                    <?php growla_breadcrumbs(); ?>
                </div>
            </div>
		</div>
	</div>
    
    <?php if ( $illustration !== 'none' ): ?>
    <div class="page-header-illustration">
        <?php get_template_part( 'inc/template-parts/illustrations/illustration', $illustration ); ?>
    </div>
    <?php endif; ?>
</div>
