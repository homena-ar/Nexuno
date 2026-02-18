<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package growla
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$submit_field = '
    <div class="form-submit-row">
		<div class="form-submit">
			%1$s %2$s
		</div>
		<div class="cancel"></div>
	</div>';

$default_comment_arguments = array(
    'fields' => [
        'author' => '<div class="form-control form-control--author">
            <input 
            type="text"
            required 
            class="form-input" 
            id="author" 
            name="author"
            placeholder="' . __('Name *', 'growla') . '">
            <label for="author" class="form-label">' . __('Name *', 'growla') . '</label>
        </div> <!--.form-floating-->',

        'email' => '<div class="form-control form-control--email">
            <input 
            required
            type="email" 
            class="form-input" 
            id="email" 
            name="email"
            placeholder="' . __('Email *', 'growla') . '">
            <label for="email" class="form-label">' . __('Email *', 'growla') . '</label>
        </div> <!--.form-floating-->',

        'cookies' => '<div class="cookies-consent"> 
            <label for="wp-comment-cookies-consent" class="paragraph">'
                .__('Save my name and email in this browser for the next time I comment.', 'growla').'
                <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes">
                <span class="checkmark"></span>
            </label>
        </div> <!--.cookies-consent-->',

        'url' => '',
    ],

    'comment_field' => '
	<div class="form-control form-areas">
                        <textarea 
                        required
                        class="form-input" 
                        placeholder="' . __('Write your comment *', 'growla') . '" 
                        name="comment"
                        id="comment"
                        ></textarea>
                        <label for="comment" class="form-label">' . __('Write your comment *', 'growla') . '</label>
                    </div> <!--.form-floating-->
	',

    'class_container' => 'comment-form--inner',
	'title_reply' => wp_kses( '<span class="comments-title">' . __('Post comment.', 'growla') . '</span>' , 'post' ),
    'comment_notes_before' => '',
    'cancel_reply_link' => esc_html__('CANCEL', 'growla'),
	'label_submit' => esc_html__('SUBMIT', 'growla'),
    'submit_field' => $submit_field,
);

$form_wrapper_class = array( 'comment-form--wrapper' );

if ( ! have_comments() ) {
    $form_wrapper_class[] = 'no-comments'; 
}

if ( is_user_logged_in() ) {
    $form_wrapper_class[] = 'logged-in-form'; 
}

?>

<!-- comments - start -->
<?php if ( have_comments() ) : ?>
<div class="comments-area">
	<div class="comments-area-wrapper">
		<div class="growla-container-small">
            <div class="comments-title">
                <?php
                    $growla_comment_count = get_comments_number();
                    if ( '1' === $growla_comment_count ) {
                        echo esc_html( $growla_comment_count . __( ' comment', 'growla' ) );
                    } else {
                        echo esc_html( $growla_comment_count . __( ' comments', 'growla' ) );
                    }
                ?>
            </div><!-- .comments-title -->

            <div class="comment-list">
                <?php
                    wp_list_comments(
                        array(
                            'short_ping' => true,
                            'callback' => 'growla_comment_style',
                            'style' => 'div'
                        )
                    );
                ?>
            </div><!-- .comment-list -->

            <?php the_comments_navigation(); ?>
		</div>
	</div>
</div>
<?php endif; // Check for have_comments(). ?>
<!-- comments - end -->

<!--
comment form - start
-->
<div class="<?php echo esc_attr( implode( ' ', $form_wrapper_class ) ); ?>">
    <div class="growla-container-small">
        <div class="comment-form">
            <?php
                comment_form($default_comment_arguments);
            ?>
        </div>
    </div>
</div>
<!--
comment form - end
-->