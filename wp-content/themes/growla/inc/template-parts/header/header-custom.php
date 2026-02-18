<?php

$header_id = $args['header_id'];

echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $header_id, true );