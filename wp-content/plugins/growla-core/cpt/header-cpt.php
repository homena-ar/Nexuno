<?php

if ( !function_exists( 'get_growla_header_cpt' ) ) {    
    /**
     * get_growla_header_cpt
     *
     * creates and returns arguments for the creationg of the 'header' CPT.
     * 
     * @return void
     */
    function get_growla_header_cpt() {

        $labels = [
            'name'               => __( 'Headers', 'growla-core' ),
            'singular_name'      => __( 'Header', 'growla-core' ),
            'add_new'            => __( 'Add New', 'growla-core' ),
            'add_new_item'       => __( 'Add New Header', 'growla-core' ),
            'edit_item'          => __( 'Edit Header', 'growla-core' ),
            'new_item'           => __( 'New Header', 'growla-core' ),
            'all_items'          => __( 'All Headers', 'growla-core' ),
            'view_item'          => __( 'View Header', 'growla-core' ),
            'search_items'       => __( 'Search Headers', 'growla-core' ),
            'not_found'          => __( 'No Headers found', 'growla-core' ),
            'not_found_in_trash' => __( 'No Headers found in the Trash', 'growla-core' ), 
            'menu_name'          => __( 'Headers', 'growla-core' )
        ];

        $args = [
            'labels'                => $labels,
            'description'           => __( 'Holds our headers and header specific data', 'growla-core'),
            'public'                => true,
            'menu_position'         => 4,
            'show_in_nav_menus'     => false,
            'exclude_from_search'   => true,
            'menu_icon'             => 'dashicons-table-row-after',
            'supports'              => array( 'title', 'editor' )            
        ];

        return $args;
        
    }
}
