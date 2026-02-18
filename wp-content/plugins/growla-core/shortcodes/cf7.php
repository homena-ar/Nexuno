<?php

function growla_contact_form_row_shortcode($atts, $content = null) {
    // Process the inner content, including executing nested shortcodes.
    $content = do_shortcode($content);

    // Create the div wrapper with optional classes.
    $output = '<div class="growla-contact-form-row">' . $content . '</div>';

    return $output;
}
add_shortcode('growla_contact_form_row', 'growla_contact_form_row_shortcode');

function growla_contact_form_column_shortcode($atts, $content = null) {
    // Process the inner content, including executing nested shortcodes.
    $content = do_shortcode($content);

    // Create the div wrapper with optional classes.
    $output = '<div class="growla-contact-form-column">' . $content . '</div>';

    return $output;
}
add_shortcode('growla_contact_form_column', 'growla_contact_form_column_shortcode');