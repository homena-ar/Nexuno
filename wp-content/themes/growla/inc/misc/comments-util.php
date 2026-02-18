<?php

if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if ( !function_exists( 'growla_comment_style' ) ) {
function growla_comment_style( $comment, $args, $depth ) {

    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    $is_pingback = $comment->comment_type == 'pingback';
    $is_traceback = $comment->comment_type == 'trackback';

    ?>
    <div
        <?php comment_class(array(empty( $args['has_children'] ) ? '' : 'has-reply', 'comment')) ?> 
        id="comment-<?php comment_ID() ?>"
    >
        <div class="parent--comment">

            <?php if ( !$is_pingback && !$is_traceback ): ?>
                <!-- comment image - start -->
                <div class="comment--avatar">
                    <?php
                    // if the commenter has a gravatar, then display it otherwise display a default image
                    if (
                        $comment->user_id || 
                        email_exists( $comment->comment_author_email ) || 
                        growla_validate_gravatar( $comment->comment_author_email )
                        ): 
                    ?>
                        <?php echo get_avatar( $comment, 100, '', '', '' ); ?>
                    <?php else: ?>
                        <img 
                        src="<?php echo esc_url( get_template_directory_uri().'/inc/assets/images/comment_placeholder.jpg' ); ?>" 
                        alt="comment-image">
                    <?php endif; ?>
                </div>
                <!-- comment image - end -->
            <?php endif; ?>
            
            <div class="comment--content" role="complementary">

                <div class="comment-inner-wrapper">
                    <a href="<?php comment_author_url(); ?>">
                        <h4 class="name"><?php comment_author(); ?></h4>
                    </a>
                    <?php if ( !$is_pingback && !$is_traceback ): ?>
                        <h5 class="date"><?php comment_date(); ?></h5>
                    <?php endif; ?>
                </div>

                <?php if ($comment->comment_approved == '0') : ?>
                    <p class="comment-meta-item paragraph dark"><?php echo esc_html__('Your comment is awaiting moderation.', 'growla') ?></p>
                <?php else: ?>

                    <?php 
                        if 
                        (   ( $comment->comment_type == 'pingback' || $comment->comment_type == 'trackback' ) 
                            && !$args['short_ping']
                        )
                        {
                            comment_text();
                        }

                        if 
                        ( $comment->comment_type != 'pingback' && $comment->comment_type != 'trackback' )
                        {
                            comment_text();
                        }
                    ?>

                <?php endif; ?>

                <?php if ( !$is_pingback && !$is_traceback ): ?>
                    <div class="reply-button">                        
                    <?php comment_reply_link(
                        array_merge( 
                            $args,
                            [
                                'add_below' => 'comment', 
                                'depth' => $depth, 
                                'max_depth' => $args['max_depth']
                            ]
                        )
                        ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php }
    // one closing div tag is not added, because WordPress adds one and then there is an extra closing div tag
}
/****************************************
comment fields
****************************************/
if (!function_exists('growla_default_comment_fields')) {
function growla_default_comment_fields($fields) {
    // author field
    $fields['author'] = '
                <div class="form-control form-control--author">
                    <input 
                    type="text"
                    required 
                    class="form-input" 
                    id="author" 
                    name="author"
                    placeholder="' . __('Name *', 'growla') . '">
                    <label for="author" class="form-label">' . __('Name *', 'growla') . '</label>
                </div> <!--.form-floating-->';

    // email field
    $fields['email'] = '
                    <div class="form-control form-control--email">
                        <input 
                        required
                        type="email" 
                        class="form-input" 
                        id="email" 
                        name="email"
                        placeholder="' . __('Email *', 'growla') . '">
                        <label for="email" class="form-label">' . __('Email *', 'growla') . '</label>
                    </div> <!--.form-floating-->';

    // url field
    unset( $fields['url'] );

    // comment content field
    $fields['comment_field'] ='
                    <div class="form-control form-areas">
                        <textarea 
                        required
                        class="form-input" 
                        placeholder="' . __('Write your comment *', 'growla') . '" 
                        name="comment"
                        id="comment"
                        ></textarea>
                        <label for="comment" class="form-label">' . __('Write your comment *', 'growla') . '</label>
                    </div> <!--.form-floating-->';
    
    // cookies field
    $fields['cookies'] = '
            <div class="cookies-consent"> 
                <label for="wp-comment-cookies-consent" class="paragraph">'
                    .__('Save my name and email in this browser for the next time I comment.', 'growla').'
                    <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes">
                    <span class="checkmark"></span>
                </label>
            </div> <!--.cookies-consent-->';
   
    return $fields;
  }
}
// add_action('comment_form_default_fields', 'growla_default_comment_fields');

if (!function_exists('growla_comment_fields')) {
// move the cookies checkbox to the end of fields
function growla_comment_fields($fields) {
    $comment_field = $fields['comment'];
    $cookie_field = $fields['cookies'];
    unset($fields['cookies']);
    unset($fields['comment']);
    $fields['comment'] = $comment_field;
    $fields['cookies'] = $cookie_field;
    return $fields;
}
}
add_action('comment_form_fields', 'growla_comment_fields', 99, 1);

if (!function_exists('growla_validate_gravatar')) {
function growla_validate_gravatar($email) {
    $hash = md5($email);
    $uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
    $headers = @get_headers($uri);
    if (empty($headers)) {
        $has_valid_avatar = FALSE;
        return $has_valid_avatar;
    }
    if (!preg_match("|200|", $headers[0])) {
        $has_valid_avatar = FALSE;
    } else {
        $has_valid_avatar = TRUE;
    }
    return $has_valid_avatar;
}
}