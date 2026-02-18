<?php

function growla_add_form_tag_email() {
    wpcf7_add_form_tag(
        array( 'growla_text', 'growla_text*', 'growla_email', 'growla_email*', 'growla_textarea', 'growla_textarea*' ),
        'growla_basic_input_field_handler',
        array( 'name-attr' => true )
    );

    wpcf7_add_form_tag(
        array( 'growla_submit' ),
        'growla_submit_handler',
        array( 'name-attr' => false )
    );

    wpcf7_add_form_tag(
        array( 'growla_select', 'growla_select*' ),
        'growla_select_handler',
        array( 'name-attr' => true )
    );

    wpcf7_add_form_tag(
        array( 'growla_file', 'growla_file*' ),
        'growla_file_upload_handler',
        array( 'name-attr' => true )
    );
}

add_action( 'wpcf7_init', 'growla_add_form_tag_email' );

// --- Custom Validation for Required Growla Fields ---
if ( function_exists('wpcf7_add_form_tag') && class_exists('WPCF7_FormTag') ) {
    function growla_validate_required_field( $result, $tag ) {
        $tag = new WPCF7_FormTag( $tag );
        $name = $tag->name;
        $value = isset( $_POST[$name] ) ? trim( $_POST[$name] ) : '';
        if ( $tag->is_required() && $value === '' ) {
            $message = function_exists('wpcf7_get_message') ? wpcf7_get_message( 'invalid_required' ) : __( 'This field is required.', 'growla' );
            $result->invalidate( $tag, $message );
        }
        // Additional email format validation for growla_email*
        if ( in_array( $tag->type, array( 'growla_email*', 'growla_email' ), true ) && $value !== '' ) {
            if ( ! is_email( $value ) ) {
                $message = __( 'Please enter a valid email address.', 'growla' );
                $result->invalidate( $tag, $message );
            }
        }
        return $result;
    }

    function growla_validate_required_file_field( $result, $tag ) {
        $tag = new WPCF7_FormTag( $tag );
        $name = $tag->name;
        $file_uploaded = isset( $_FILES[$name] ) && !empty( $_FILES[$name]['name'] );
        if ( $tag->is_required() && !$file_uploaded ) {
            $message = function_exists('wpcf7_get_message') ? wpcf7_get_message( 'invalid_required' ) : __( 'This field is required.', 'growla' );
            $result->invalidate( $tag, $message );
        }
        return $result;
    }

    // Register validation for both normal and post-validation hooks
    $growla_required_tags = array('growla_text*', 'growla_email*', 'growla_textarea*', 'growla_select*');
    foreach ($growla_required_tags as $tag) {
        add_filter( 'wpcf7_validate_' . $tag, 'growla_validate_required_field', 10, 2 );
        add_filter( 'wpcf7_validate_' . $tag . '_post', 'growla_validate_required_field', 10, 2 );
    }
    add_filter( 'wpcf7_validate_growla_file*', 'growla_validate_required_file_field', 20, 2 );
    add_filter( 'wpcf7_validate_growla_file*_post', 'growla_validate_required_file_field', 20, 2 );
}

function growla_basic_input_field_handler( $tag ) {
    $tag = new WPCF7_FormTag($tag);

    if ( empty( $tag->name ) ) {
        return '';
    }

    // Prepare the ID and class attributes
    $validation_error = wpcf7_get_validation_error( $tag->name );
    $class = wpcf7_form_controls_class( $tag->type );

    $id = $tag->get_id_option();
    $class .= ' ' . $tag->get_class_option();
    $type = 'text';

    if ( 'growla_email' === $tag->type || 'growla_email*' === $tag->type ) {
        $type = 'email';
    }

    // Basic attributes
    $atts = array();
    $atts['size'] = $tag->get_size_option( '40' ); // Default size
    $atts['class'] = $tag->get_class_option( $class );
    $atts['id'] = $tag->get_id_option();
    $atts['tabindex'] = $tag->get_option( 'tabindex', 'int', true );

    // Name and value
    $atts['name'] = $tag->name;
    $value = (string) reset( $tag->values );
    $placeholder = '';
    if ( $tag->has_option( 'placeholder' ) ) {
        $placeholder = $value;
        $value = '';
    }
    $atts['value'] = $value;

    // Required field
    if ( $tag->is_required() ) {
        $atts['aria-required'] = 'true';
        $atts['required'] = 'required';
    }

    // Additional attributes
    $atts = wpcf7_format_atts( $atts );

    if ( 'growla_textarea' === $tag->type || 'growla_textarea*' === $tag->type ) {
        $html = sprintf(
            '<div class="wpcf7-form-control-wrap form-control form-areas %1$s">
                <textarea 
                    class="form-input" 
                    placeholder="%3$s" 
                    id="%1$s-field"
                    %2$s
                ></textarea>
                <label for="%1$s-field" class="form-label">%3$s</label>
                %4$s
            </div>',
            sanitize_html_class( $tag->name ),
            $atts,
            $placeholder,
            $validation_error
        );
    } else {
        $html = sprintf(
            '<div class="wpcf7-form-control-wrap form-control %1$s">
            <input 
                type="%2$s" 
                class="form-input" 
                id="%1$s-field"
                placeholder="%4$s"
                %3$s>
                <label for="%1$s-field" class="form-label">%4$s</label>
                %5$s
            </div>',
            sanitize_html_class( $tag->name ),
            esc_attr( $type ),
            $atts,
            $placeholder,
            $validation_error
        );
    }

    return $html;
}

function growla_submit_handler( $tag ) {
    // Start building the submit button HTML
    $html = '<button type="submit" class="wpcf7-form-control wpcf7-submit">';

    // Button text: Use the first value in the $tag->values array as the button text
    // If no value is provided, default to "Submit"
    $button_text = !empty($tag->values[0]) ? $tag->values[0] : 'Submit';
    
    // Add the button text to the HTML
    $html .= '<span>' . esc_html($button_text) . '</span>';

    $html .= '<span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path></svg></span>';
    
    // Close the button tag
    $html .= '</button>';

    return $html;
}

function growla_select_handler( $tag ) {
    $tag = new WPCF7_FormTag($tag);

    if ( empty( $tag->name ) ) {
        return '';
    }

    $validation_error = wpcf7_get_validation_error($tag->name);

    $class = wpcf7_form_controls_class($tag->type);
    $required = $tag->is_required() ? 'required="true"' : '';

    // Handle options
    $options = (array) $tag->values;
    $values = (array) $tag->labels;

    $value = (string) reset( $tag->values );
    $placeholder = '';
    if ( $tag->has_option( 'placeholder' ) ) {
        $placeholder = $value;
        $value = '';
    }

    // Building the HTML string for select element
    $html = '';
    $html .= '<span class="wpcf7-form-control-wrap growla-select ' . $tag->name . '">';
    $html .= '<select name="' . $tag->name . '" class="' . $class . '"' . $required . '>';

    foreach ($options as $i => $option) {
        if ($option === $placeholder) {
            $html .= '<option value="">' . esc_html( $placeholder ) . '</option>';
            continue;
        }
        $selected = ($tag->has_option('default:' . ($i + 1)) ? ' selected="selected"' : '');
        $html .= '<option value="' . esc_attr($values[$i]) . '"' . $selected . '>' . esc_html($option) . '</option>';
    }

    $html .= '</select>';
    $html .= $validation_error;
    $html .= '</span>';

    return $html;
}

function growla_file_upload_handler( $tag ) {
    $tag = new WPCF7_FormTag($tag);

    if ( empty( $tag->name ) ) {
        return '';
    }

    $validation_error = wpcf7_get_validation_error($tag->name);
    $class = wpcf7_form_controls_class( $tag->type );
    $required = $tag->is_required() ? 'required="true"' : '';

    // Basic attributes
    $atts = array();
    $atts['class'] = $tag->get_class_option( $class );
    $atts['id'] = $tag->get_id_option();
    $atts['tabindex'] = $tag->get_option( 'tabindex', 'int', true );
    $atts['name'] = $tag->name;

    // Additional attributes
    $atts = wpcf7_format_atts( $atts );

    // Get custom label from the tag options
    $attach_label = $tag->values[0] ?? '';
    $attach_label = $attach_label ? esc_html($attach_label) : __( 'Attach File', 'growla' );

    // Default value for select_label
    $select_label =  __( 'Browse', 'growla' );

    $html = sprintf(
        '<div class="wpcf7-form-control-wrap wpcf7-form-control growla-file-upload">
            <input type="file" %1$s %2$s>
            <span class="label">%3$s</span>
            <div class="select-wrapper">
                <span>%4$s</span>
            </div>
            %5$s
        </div>',
        $atts,
        $required,
        $attach_label,
        $select_label,
        $validation_error
    );

    return $html;
}