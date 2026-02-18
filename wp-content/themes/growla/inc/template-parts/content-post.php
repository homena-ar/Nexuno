<?php
    $title = trim( get_the_title() );

    $date_format = 'default';
    if ( !empty( $args['date_format'] ) && $args['date_format'] == 'custom'  ) {
        $date_format = 'custom';
    }

    $class = [
        'single-blog-post',
        'hover',
        ! has_post_thumbnail() ? 'no-mt'  : ''
    ];
    
?>
<div <?php post_class( $class ); ?>>
    <div class="thumbnail <?php echo esc_attr( ! has_post_thumbnail() ? 'no-thumbnail' : '' ); ?>">
        <?php growla_post_thumbnail(); ?>
        <div class="date">
            <a href="<?php echo esc_url( home_url( get_the_date('Y/m/d') ) ); ?>">
                <?php echo wp_kses( growla_get_the_date( $date_format ), 'post' ); ?>
            </a>
        </div>
    </div>

    <a class="content" href="<?php the_permalink(); ?>">
        <?php if ( ! empty( $title ) ): ?>
            <h6><?php echo esc_html( $title ); ?></h6>
        <?php endif; ?>
        
        <?php if ( has_excerpt() ): ?>
            <p><?php the_excerpt(); ?></p>    
        <?php endif; ?>

        <div class="icon-wrapper">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>arrow-right</title><path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" /></svg>
            </div>
        </div>
    </a>
</div>