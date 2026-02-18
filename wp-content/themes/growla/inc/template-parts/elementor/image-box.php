<?php
    $item = $args['item'];
?>
<div class="image-box-wrapper">
    <div class="image-box">
        <?php if ( !empty( $item['image_box_image'] ) ): ?>
        <div class="image-box-image">
            <?php
                echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( 
                    $item, 
                    'full', 
                    'image_box_image' 
                ); 
            ?>
        </div>
        <?php endif; ?>
        <div class="image-box-content">
            <div class="image-box-content-inner">
                <?php growla_render_icon( $item['image_box_icon'] ); ?>
                <h4><?php echo esc_html( $item['image_box_title'] ); ?></h4>
                <div class="content">
                    <p><?php echo esc_html( $item['image_box_content'] ); ?></p>
                    <?php 
                        if ( ! empty( $item['image_box_link_text'] ) && ! empty( $item['image_box_link'] ) ): 
                    ?>
                    <a href="<?php echo esc_url( $item['image_box_link']['url'] ); ?>">
                        <?php echo esc_html( $item['image_box_link_text'] ); ?>
                    </a>
                    <?php endif; ?>
                </div>
                <div class="reveal"></div>
            </div>
        </div>
        <div class="image-box-bg"></div>
    </div>
</div>