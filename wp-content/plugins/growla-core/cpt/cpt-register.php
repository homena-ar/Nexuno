<?php

require_once( plugin_dir_path( __FILE__ ) . 'project-cpt.php' );
require_once( plugin_dir_path( __FILE__ ) . 'header-cpt.php' );
require_once( plugin_dir_path( __FILE__ ) . 'footer-cpt.php' );

if ( !function_exists( 'growla_register_cpt' ) ) {    
    /**
     * growla_register_cpt
     *
     * Registers CPTs needed for the growla theme
     * 
     * @return void
     */
    function growla_register_cpt() {
        // project cpt
        register_post_type( 'project', get_growla_project_cpt() );

        // header
        register_post_type( 'header', get_growla_header_cpt() );

        // footer
        register_post_type( 'footer', get_growla_footer_cpt() );
    }
}
add_action( 'init', 'growla_register_cpt' );


if ( !function_exists( 'growla_elementor_cpt_support' ) ){    
    /**
     * growla_elementor_cpt_support
     * 
     * adds elementor support for CPTs added by the plugin
     * 
     * @return void
     */
    function growla_elementor_cpt_support() {
        
        $cpt_support = get_option( 'elementor_cpt_support' );
        
        if( !$cpt_support ) {
            $cpt_support = [ 'page', 'post', 'project', 'header' ];
            update_option( 'elementor_cpt_support', $cpt_support );
        }
        else if( !in_array( 'project', $cpt_support ) ) {
            $cpt_support[] = 'project';
            update_option( 'elementor_cpt_support', $cpt_support );
        }
        else if( ! in_array( 'header', $cpt_support ) ) {
            $cpt_support[] = 'header';
            update_option( 'elementor_cpt_support', $cpt_support );
        }
        else if( ! in_array( 'footer', $cpt_support ) ) {
            $cpt_support[] = 'footer';
            update_option( 'elementor_cpt_support', $cpt_support );
        }
    
    }
}
add_action( 'init', 'growla_elementor_cpt_support' );