<?php

    if ( ! class_exists( 'Redux' ) ) {
        $growla_opt                               = array();
        $growla_opt['404_page_header_desktop']    = 'default';
        $growla_opt['404_page_header_mobile']     = 'default';
        $growla_opt['search_page_header_desktop'] = 'default';
        $growla_opt['search_page_header_mobile']  = 'default';
        $growla_opt['preloader_switch']           = true;
    } else {
        global $growla_opt;
    }

    $header_id        = ( ! empty( $growla_opt['meta_header_select'] ) ) ? $growla_opt['meta_header_select'] : 'default';
    $header_mobile_id = ( ! empty( $growla_opt['meta_header_mobile_select'] ) ) ? $growla_opt['meta_header_mobile_select'] : 'default';

    if ( is_404() && class_exists( 'Redux' ) ) {
        $header_id        = ( ! empty( $growla_opt['404_page_header_desktop'] ) ) ? $growla_opt['404_page_header_desktop'] : 'default';
        $header_mobile_id = ( ! empty( $growla_opt['404_page_header_mobile'] ) ) ? $growla_opt['404_page_header_mobile'] : 'default';
    }

    if ( ( is_search() || is_archive() ) && class_exists( 'Redux' ) ) {
        $header_id        = ( ! empty( $growla_opt['search_page_header_desktop'] ) ) ? $growla_opt['search_page_header_desktop'] : 'default';
        $header_mobile_id = ( ! empty( $growla_opt['search_page_header_mobile'] ) ) ? $growla_opt['search_page_header_mobile'] : 'default';
    }

    $scrollbar_class   = ' enabled-sticky-nav';
    $header_body_class = 'header-default';

    if ( $header_id != 'default' ) {
        $header_body_class = 'header-custom';
    }

    // don't display the header if the post type is header and footer.
	if ( ! is_singular( 'header' ) && ! is_singular( 'footer' ) && ! is_singular( 'elementor_library' ) ) :
?>
    <div 
    class="
        header-wrapper 
        desktop 
    <?php echo esc_attr( ! empty( $header_id ) && $header_id == 'default' ? 'header-wrapper-default' : '' ); ?>
        "
    >
        <div class="header">
        <?php

        if ( ! empty( $header_id ) && $header_id == 'default' ) {
            // default navigation.
            get_template_part( 'inc/template-parts/header/header', 'default' );
        } elseif ( ! empty( $header_id ) ) {
            // custom navigation.
            get_template_part(
                'inc/template-parts/header/header',
                'custom',
                array( 'header_id' => $header_id )
            );
        }

        ?>
        </div>
    </div>

    <div class="header-wrapper mobile">
        <div class="header">
            <?php

            if ( ! empty( $header_mobile_id ) && $header_mobile_id == 'default' ) {
                // default navigation.
                get_template_part( 'inc/template-parts/header/header', 'default' );
            } elseif ( ! empty( $header_mobile_id ) ) {
                // custom navigation.
                get_template_part(
                    'inc/template-parts/header/header',
                    'custom',
                    array( 'header_id' => $header_mobile_id )
                );
            }

            ?>
        </div>
    </div>
<?php endif; ?>
