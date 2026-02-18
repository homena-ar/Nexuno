<?php

require_once( plugin_dir_path( __FILE__ ) . 'form-widget.php' );
require_once( plugin_dir_path( __FILE__ ) . 'recent-posts-widget.php' );
require_once( plugin_dir_path( __FILE__ ) . 'archives-widget.php' );

function growla_core_widgets_init() {
    register_widget( new \FormWidget() );
    register_widget( new \RecentPosts() );
    register_widget( new \ArchiveWidget() );
}

add_action( 'widgets_init', 'growla_core_widgets_init' );