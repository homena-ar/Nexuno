<?php

if ( ! defined('ABSPATH') ) exit; // Exit if accessed directly

class FormWidget extends WP_Widget {

    // constructor
    public function __construct() {
        parent::__construct(
            'growla_form_widget',
            esc_html__( 'Growla: Form Widget', 'growla-core'),
            [
                'classname' => 'growla-form-widget',
                'description' => esc_html__( 'Widget to add a contact form in a sidebar.', 'growla-core' )
            ]
        );
    }

    // front end of the widget
    public function widget( $args, $instance ) {
        // before content
        echo $args['before_widget'];

        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $form = ! empty( $instance['form'] ) ? $instance['form'] : '';
        $image = ! empty( $instance['image'] ) ? $instance['image'] : '';

        ?>
        <?php if ( $image ): ?>
            <div class="growla-form-widget-icon">
                <img src="<?php echo esc_url( $image ); ?>" alt="icon" />
            </div>
        <?php endif; ?>
        <?php

        if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

        ?> 
            <div class="contact-form">
                <?php echo do_shortcode('[contact-form-7 id="' . absint( $form ) . '"]'); ?>
            </div>
        <?php

        // after content
        echo $args['after_widget'];
    }

    // back end of the widget
    public function form( $instance ) {
        // default values
        $instance = wp_parse_args( 
            (array) $instance, 
            [ 
                'title' => '',
                'form' => '',
                'image' => ''
        ] );
        $contact_forms = $this->get_contact_form();
        $image = ! empty( $instance['image'] ) ? $instance['image'] : '';
        ?>
        <!-- title field - start -->
        <p>
			<label 
            for="<?php echo $this->get_field_id( 'title' ); ?>">
                <?php _e( 'Title:' ); ?>
            </label>

			<input 
            class="widefat" 
            id="<?php echo $this->get_field_id( 'title' ); ?>" 
            name="<?php echo $this->get_field_name( 'title' ); ?>" 
            type="text" 
            value="<?php echo esc_attr( $instance['title'] ); ?>"
            />
		</p>
        <!-- title field - end -->

        <!-- form field - start -->
        <p>
            <label 
            for="<?php echo $this->get_field_id( 'form' ); ?>">
                <?php _e( 'Form:' ); ?>
            </label>

            <select
            class="widefat" 
            name="<?php echo $this->get_field_name( 'form' ); ?>"
            id="<?php echo $this->get_field_id( 'form' ); ?>" 
            >
                <?php foreach ( $contact_forms as $key => $form ): ?>
                    <option
                    <?php echo esc_attr( $key == $instance['form'] ? 'selected ' : '' );  ?>
                    value="<?php echo esc_attr( $key ); ?>"
                    >
                        <?php echo esc_html( $form ); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <br/>
        </p>
        <!-- form field - end -->

        <p>
            <label for="<?php echo $this->get_field_id('image'); ?>"><?php _e('Image:'); ?></label>
            <input class="widefat image-upload" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="text" value="<?php echo esc_url($image); ?>" style="margin-bottom: 5px;">
            <button class="upload-image-button button button-primary"><?php esc_html_e('Upload Image', 'growla-core'); ?></button>
        </p>
        <script>
            jQuery(document).ready(function($){
                var customUploader;

                // Function to open or reuse the media uploader
                function openMediaUploader(button) {
                    // Reuse the existing uploader, if it exists
                    if (customUploader) {
                        customUploader.open();
                        return;
                    }

                    // Create the media uploader
                    customUploader = wp.media({
                        title: 'Select an Icon',
                        library: { type: 'image' },
                        button: {
                            text: 'Use this image as an icon'
                        },
                        multiple: false
                    }).on('select', function() {
                        var attachment = customUploader.state().get('selection').first().toJSON();
                        if (attachment.url.match(/\.(svg)$/i)) { // Check if the URL ends with .svg
                            var inputField = $(button).prev('input');
                            inputField.val(attachment.url);
                            inputField.trigger('change'); // Trigger change to activate the Save button
                        } else {
                            alert("Please select an SVG file."); // Alert the user if the file is not SVG
                        }
                    }).open();
                }

                // Attach event listener to your upload button
                $(document).on('click', '.upload-image-button', function(e) {
                    e.preventDefault(); // Prevent the default button action
                    openMediaUploader(this); // Pass the button to the function
                });
            });
        </script>
        <?php
    }

    // update widget
    public function update( $new_instance, $old_instance ) {
        $instance                 = $old_instance;
		$instance['title']        = sanitize_text_field( $new_instance['title'] );
		$instance['form']         = sanitize_text_field( $new_instance['form'] );
        $instance['image'] = ( ! empty( $new_instance['image'] ) ) ? esc_url_raw( $new_instance['image'] ) : '';

		return $instance;
    }

    // get contact forms
    public function get_contact_form() {
        $args = [
            'post_type' => 'wpcf7_contact_form', 
            'posts_per_page' => -1
        ];

        $catlist = [];
    
        if ( $categories = get_posts( $args ) ) {
            foreach ( $categories as $category ) {
                ( int ) $catlist[ $category->ID ] = $category->post_title;
            }
        }
        else {
            ( int ) $catlist[ '0' ] = esc_html__( 'No contact From 7 form found', 'growla-core' );
        }

        return $catlist;
    }

}
