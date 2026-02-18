<?php

$footer_id = $args['footer_id'];

if ( ! class_exists('Elementor\Plugin') ) {
    return;
}

echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $footer_id, true );