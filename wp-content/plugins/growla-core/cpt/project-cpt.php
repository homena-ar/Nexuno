<?php

if ( !function_exists( 'get_growla_project_cpt' ) ) {    
    /**
     * get_growla_project_cpt
     *
     * creates and returns arguments for the creationg of the 'project' CPT.
     * 
     * @return void
     */
    function get_growla_project_cpt() {

        $labels = [
            'name'               => __( 'Projects', 'growla-core' ),
            'singular_name'      => __( 'Project', 'growla-core' ),
            'add_new'            => __( 'Add New', 'growla-core' ),
            'add_new_item'       => __( 'Add New Project', 'growla-core' ),
            'edit_item'          => __( 'Edit Project', 'growla-core' ),
            'new_item'           => __( 'New Project', 'growla-core' ),
            'all_items'          => __( 'All Projects', 'growla-core' ),
            'view_item'          => __( 'View Project', 'growla-core' ),
            'search_items'       => __( 'Search Projects', 'growla-core' ),
            'not_found'          => __( 'No Projects found', 'growla-core' ),
            'not_found_in_trash' => __( 'No Projects found in the Trash', 'growla-core' ), 
            'menu_name'          => __( 'Projects', 'growla-core' ),            
        ];

        $args = [
            'labels'                => $labels,
            'description'           => __( 'Holds our projects and project specific data', 'growla-core'),
            'public'                => true,
            'menu_position'         => 4,
            'show_in_nav_menus'     => true,
            'taxonomies'            => array( 'category' ),
            'menu_icon'             => 'dashicons-marker',
            'supports'              => array( 'title', 'editor', 'thumbnail' ),
        ];

        return $args;
        
    }
}
