<?php

    $layout_style = 'horizontal';

    if ( ! empty( $args['layout_style'] ) ) {
        $layout_style = $args['layout_style'];
    }

    $title = trim( get_the_title() );

    $post_categories = get_the_terms( $post->ID, 'category' );
    $categories = '';
    if ( ! empty( $post_categories ) && ! is_wp_error( $post_categories ) ) {
        $categories = join( ' · ', wp_list_pluck( $post_categories, 'name' ) );
    }

    $class = ['project-single', 'project-single-' . $layout_style];


?>
<a href="<?php the_permalink(); ?>" class="<?php echo esc_attr( implode( ' ', $class ) ); ?>">
    <?php growla_post_thumbnail( 'growla-project-thumbnail-size', false ); ?>

    <div class="project-content">
        <?php if ( !empty( $title ) ): ?>
            <h4><?php echo esc_html( $title ); ?></h4> 
        <?php endif; ?>

        <?php if ( !empty( $categories ) ): ?>
            <p class="mini-paragraph categories">
                <?php echo esc_html( $categories ); ?>
            </p>
        <?php endif; ?>
        
        <div class="project-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>arrow-right</title><path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" /></svg>
        </div>
    </div>
</a>