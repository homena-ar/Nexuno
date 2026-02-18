<?php

    require_once( get_template_directory() . '/inc/template-tags.php' );

    $settings = $args['settings'];
    $id = $args['id'];

    $prev_icon = $settings['prev_icon'];
    $next_icon = $settings['next_icon'];

?>

<div class="slider-header">
    <?php growla_heading( $settings ); ?>

    <?php if ( !empty( $prev_icon ) || !empty( $next_icon ) ): ?>
        <?php growla_get_slider_navigation( $id, $prev_icon, $next_icon ) ?>
    <?php endif; ?>
</div>