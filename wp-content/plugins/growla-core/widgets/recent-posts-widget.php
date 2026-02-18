<?php 

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class RecentPosts extends WP_Widget {

    // constructor
    function __construct() {
        parent::__construct(
            'growla_recent_posts', 
            esc_html__( 'Growla: Recent Posts', 'growla-core' ), 
            [ 
                'classname'   => 'growla-recent-posts',
                'description' => esc_html__( 'Displays recent posts in the sidebar', 'growla-core' ),
            ]
        );
    }

    // front end of the widget
    public function widget( $args, $instance ) {
        $title = apply_filters( 
            'widget_title', 
            empty( $instance['title'] ) ? esc_html__( 'Recent posts', 'growla-core' ) : $instance['title'], 
            $instance, $this->id_base );

        echo $args['before_widget'];

        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title']; 
        }
        ?>
            <ul class="recent-posts">
                <?php 

                $r = new WP_Query(
                    apply_filters(
                        'widget_posts_args',
                        array(
                            'posts_per_page'      => $instance['posts_per_page'],
                            'post_type'           => 'post',
                            'no_found_rows'       => true,
                            'post_status'         => 'publish',
                            'ignore_sticky_posts' => true,
                        ),
                        $instance
                    )
                );

                // if there are no posts then return
                if ( ! $r->have_posts() ) {
                    return;
                }

                // loop through the posts
                foreach ( $r->posts as $recent_post ) : ?>
                <?php
                    $post_title   = get_the_title( $recent_post->ID );
                    $post_thumb   = get_the_post_thumbnail( $recent_post->ID, 'growla-recent-post-thumbnail-size' );
                    $title        = (!empty($post_title)) ? $post_title : __('(no title)', 'growla-core');
                ?>
                <li class="recent-posts-single"> 
                    <a href="<?php the_permalink( $recent_post->ID ); ?>">
                        <?php if( $post_thumb ): ?>
                            <div class="recent-posts-single--thumbnail">
                                <?php echo $post_thumb; ?>
                                <div class="hover">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M427.8 266.8l-160 176C264.7 446.3 260.3 448 256 448c-3.844 0-7.703-1.375-10.77-4.156c-6.531-5.938-7.016-16.06-1.078-22.59L379.8 272H16c-8.844 0-15.1-7.155-15.1-15.1S7.156 240 16 240h363.8l-135.7-149.3c-5.938-6.531-5.453-16.66 1.078-22.59c6.547-5.906 16.66-5.469 22.61 1.094l160 176C433.4 251.3 433.4 260.7 427.8 266.8z"/></svg>
                                </div>
                            </div>
                        <?php endif; // post thumbnail ?>
                        <div class="recent-posts-single--content">
                            <h6>
                                <?php echo esc_html( wp_trim_words( get_the_title( $recent_post->ID ), 8, '...') ); ?>
                            </h6>
                        </div>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php 

        echo $args['after_widget'];

    }

    // back end of the widget
    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? $instance['title'] : esc_html( 'Recent Posts', 'growla-core' );
        $posts_per_page = isset( $instance['posts_per_page'] ) ? $instance['posts_per_page'] : 3;
    ?>

        <p>
            <label>
                <?php esc_html_e( 'Title:', 'growla-core' ); ?>
            </label>
            <input
            class="widefat"
            id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" 
            name="<?php echo esc_attr($this->get_field_name('title')); ?>"
            type="text"
            value="<?php echo esc_attr($title); ?>"
            />
        </p>
        <p>
            <label>
                <?php esc_html_e( 'Number of posts to show:', 'growla-core' ); ?>
            </label> 
            <input 
            size="3"
            class="widefat"
            id="<?php echo esc_attr( $this->get_field_id('posts_per_page') ); ?>" 
            name="<?php echo esc_attr( $this->get_field_name('posts_per_page') ); ?>"
            type="text" 
            value="<?php echo esc_attr( $posts_per_page ); ?>" 
            />
        </p>
    
    <?php

    }

    // update widget
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['posts_per_page'] = ( ! empty( $new_instance['posts_per_page'] ) ) ? strip_tags( $new_instance['posts_per_page'] ) : '';
        return $instance;
    }

}