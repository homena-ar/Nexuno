<?php

if ( !function_exists( 'get_growla_footer_cpt' ) ) {    
    /**
     * get_growla_header_cpt
     *
     * creates and returns arguments for the creationg of the 'header' CPT.
     * 
     * @return void
     */
    function get_growla_footer_cpt() {

        $labels = [
            'name'               => __( 'Footers', 'growla-core' ),
            'singular_name'      => __( 'Footer', 'growla-core' ),
            'add_new'            => __( 'Add New', 'growla-core' ),
            'add_new_item'       => __( 'Add New Footer', 'growla-core' ),
            'edit_item'          => __( 'Edit Footer', 'growla-core' ),
            'new_item'           => __( 'New Footer', 'growla-core' ),
            'all_items'          => __( 'All Footers', 'growla-core' ),
            'view_item'          => __( 'View Footer', 'growla-core' ),
            'search_items'       => __( 'Search Footers', 'growla-core' ),
            'not_found'          => __( 'No Footers found', 'growla-core' ),
            'not_found_in_trash' => __( 'No Footers found in the Trash', 'growla-core' ), 
            'menu_name'          => __( 'Footers', 'growla-core' ),
        ];

        $args = [
            'labels'                => $labels,
            'description'           => __( 'Holds our footers and footer specific data', 'growla-core'),
            'public'                => true,
            'menu_position'         => 4,
            'show_in_nav_menus'     => false,
            'exclude_from_search'   => true,
            'menu_icon'             => 'dashicons-table-row-before',
            'supports'              => array( 'title', 'editor' )   
        ];

        return $args;
        
    }
}
