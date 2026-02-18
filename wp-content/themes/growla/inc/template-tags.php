<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package growla
 */

if ( ! function_exists( 'growla_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function growla_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'growla' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'growla_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function growla_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'growla' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'growla_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function growla_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'growla' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'growla' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'growla' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'growla' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'growla' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'growla' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'growla_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function growla_post_thumbnail( $size = 'growla-post-thumbnail-size', $anchor = true ) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

        $thumbnail_url = get_the_post_thumbnail_url();

        if ( $thumbnail_url && strtolower( substr( $thumbnail_url, -4 ) ) === '.gif' ) {
            $size = 'full';
        }

		?>
		<div class="post-thumbnail">
            <?php if ( $anchor ): ?>
                <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
            <?php endif; ?>
		
                <?php
                    the_post_thumbnail(
                        $size,
                        array(
                            'alt' => the_title_attribute(
                                array(
                                    'echo' => false,
                                )
                            ),
                        )
                    );
                ?>

            <?php if ( $anchor ): ?>
                </a>
            <?php endif; ?>
        </div>
		<?php
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

if ( ! function_exists( 'growla_paginate' ) ):
	function growla_paginate( $query = '', $prev = '', $next = '' ) {

		if ( $prev != '' ) {
			echo wp_kses( $prev, 'post' );
		}

		if( $query == '' ) {
			global $wp_query;
			$query = $wp_query;
		}

		$args =  array(
			'base'			=> str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
			'total'			=> $query->max_num_pages,
			'current'		=> growla_get_page_query(),
			'format'		=> '/page/%#%',
			'show_all'		=> false,
			'type'			=> 'list',
			'end_size'		=> 2,
			'mid_size'		=> 1,
			'add_args'		=> false,
			'add_fragment'	=> '',
			'prev_text'		=> '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>arrow-left</title><path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z" /></svg>',
			'next_text'		=> '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>arrow-right</title><path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" /></svg>',
		) ;


		?>
		<div class="pagination">
			<?php echo paginate_links( $args ); ?>
		</div>
		<?php

		if ( $next != '' ) {
			echo wp_kses( $next, 'post' );
		}
	}
endif;

function wrapStringWithSpans($inputString) {
    $output = '';
    $tagStack = [];
    $inWord = false;
    $length = strlen($inputString);
    $entityBuffer = '';

    for ($i = 0; $i < $length; $i++) {
        $char = $inputString[$i];

        if ($char === '<') {
            // Start of tag, push '<' onto the stack
            array_push($tagStack, $char);
            $output .= $char;
        } elseif ($char === '>') {
            // End of tag, pop '<' from the stack
            array_pop($tagStack);
            $output .= $char;
        } elseif (empty($tagStack)) {
            // Not inside a tag
            if ($char === ' ') {
                // If character is a space and not inside a word
                if ($inWord) {
                    $output .= '</span>'; // Close previous word span
                    $inWord = false;
                }
                $output .= '<span class="growla-character">&nbsp;</span>'; // Add space wrapped in a span
            } elseif ($char === '&') {
                $entityBuffer .= $char;
            } elseif ( $char === ';' && $entityBuffer !== '' ) {
                $entityBuffer .= $char;
                $output .= '<span class="growla-character">' . $entityBuffer . '</span>';
                $entityBuffer = ''; // Reset entity buffer
            } elseif ( $entityBuffer !== '' ) {
                $entityBuffer .= $char;
            } else {
                // If character is not a space
                if (!$inWord) {
                    // If not already in a word, start a new word span
                    $output .= '<span class="growla-word">';
                    $inWord = true;
                }
                $output .= '<span class="growla-character">' . $char . '</span>'; // Wrap character in span
            }
        } else {
            // Inside a tag, simply output the character
            $output .= $char;
        }
    }

    if ($inWord) {
        // If we are still inside a word at the end, close the word span
        $output .= '</span>';
    }

    return $output;
}

function wrapWordsWithSpans($inputString) {
    $output = '';
    // Split the input string into words
    $words = preg_split('/\s+/', $inputString, -1, PREG_SPLIT_NO_EMPTY);

    foreach ($words as $word) {
        $output .= '<span>' . $word . '</span> ';
    }

    return $output;
}

if ( !function_exists( 'growla_heading' ) ) {
	function growla_heading( $settings = null ) {
		if ( $settings == null ) return;

        if ( empty( $settings['subheading'] ) && empty( $settings['heading'] ) ) {
			return;
		}

        $is_animated = $settings['animate_heading'] === 'yes' || $settings['animate_heading'] === '1' ? true : false;

        $class_list = array( 'growla-heading' );

        if ( $is_animated ) {
            $class_list[] = 'growla-animated-heading';
        }

		$subheading_tag = $settings['subheading_tag'] ?? 'h6';
	?>
	<div class="<?php echo esc_attr( implode( ' ', $class_list ) ); ?>">
        <<?php echo esc_html( $subheading_tag ); ?> class="growla-heading--sub mini-heading-02">

            <?php if ( ! empty( $settings['subheading'] ) ) : ?>
                <?php echo esc_html( $settings['subheading'] ); ?>
            <?php endif; ?>
            
        </<?php echo esc_html( $subheading_tag ); ?>>

        <?php if ( ! empty( $settings['heading'] ) ) : ?>
            <div class="growla-heading--content">
                <?php echo wp_kses( $is_animated ? wrapStringWithSpans( $settings['heading'] ) : $settings['heading'], 'post' ); ?>
            </div>    
        <?php endif; ?>
    </div>
	<?php
	}
}

if ( !function_exists( 'growla_breadcrumbs' ) ) {
	function growla_breadcrumbs() {
	?>
		<ul>

			<?php
				// front page
				if ( is_front_page() ):
			?>
				<li><?php echo esc_html__( 'Home', 'growla' ); ?></li>
			<?php else: ?>
				<li>
					<a href="<?php echo esc_url( home_url() ) ?>">
						<?php echo esc_html__( 'Home', 'growla' ); ?>
					</a>
				</li>
			<?php endif; // front page ?>

			<?php
				// single post
				if ( is_singular( 'post' ) ):
					$categories = get_the_category();
			?>
				<?php if ( !empty( $categories ) ): ?>
					<li>
						<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>">
							<?php echo esc_html( $categories[0]->name ); ?>
						</a>
					</li>
				<?php endif; // categories ?>

			<?php endif; // single post ?>

			<?php 
				// for pages that are not front page
				if ( is_page() && !is_front_page() ):
					$post = get_post( get_the_ID() );
					// compute parent pages
					if ( $post->post_parent ) {
						$parent_id = $post->post_parent;
						$links = [];
						// loop through all parent pages
						while ( $parent_id ) {
							$parent = get_post( $parent_id );
                            $title = get_the_title( $parent->ID );
                            if ( empty( $title ) ) {
                                continue;
                            }
							$links[] = '<li><a href="' . get_permalink( $parent->ID ) . '">' . $title . '</a></li>';
							$parent_id = $parent->post_parent;
						}
						// reverse array
						$links = array_reverse( $links );

						// output parent pages links
						if ( is_array( $links ) || is_object( $links ) ) {
							foreach ( $links as $link ) {
								echo wp_kses( $link, 'general' );
							}
						}
					}
			?>
				<li><?php the_title(); ?></li>
			<?php endif; // for pages that are not front page ?>

			<?php
				// search page
				if ( is_search() ):
			?>
				<li><?php echo esc_html__( 'Search result', 'growla' ) ?></li>
			<?php endif; // search page ?>

			<?php
				// 404 page
				if ( is_404() ):
			?>
				<li><?php echo esc_html__( '404', 'growla' ) ?></li>
			<?php endif; // 404 page ?>

			<?php 
				// archive page
				if ( is_archive() ): 
			?>
				<li><?php the_archive_title(); ?></li>
			<?php endif; // archive page ?>

			<?php
				// cpt
				if ( is_single() && get_post_type() != 'post' && get_post_type() != 'attachment' ):
			?>
				<li><?php the_title(); ?></li>
			<?php endif; // cpt ?>

		</ul>
	<?php
	}
}

if ( !function_exists( 'growla_get_slider_navigation' ) ) {
	function growla_get_slider_navigation( $id, $prev_icon, $next_icon ) {
		$class_list = array(
			'slider-nav',
			'slider-nav-'.$id
		);
	?>
	<div class="<?php echo esc_attr( implode(' ', $class_list) ); ?>">

		<?php if ( !empty( $prev_icon ) ): ?>
			<div class="slider-nav-btn slider-nav-prev">
				<?php
					growla_render_icon( $prev_icon );
				?>
			</div>
		<?php endif; ?>
			
		<?php if ( !empty( $next_icon ) ): ?>
			<div class="slider-nav-btn slider-nav-next">
				<?php 
					growla_render_icon( $next_icon );
				?>
			</div>
		<?php endif; ?>

	</div>
	<?php
	}
}

if ( !function_exists('growla_get_the_date') ) {
	function growla_get_the_date( $type = 'default' ) {
		if ( $type == 'default' ) {
			return '<span class="default">' . get_the_date() . '</span>';
		}

		$result = 
			'<span class="wrapper">' .
				'<span class="day">' . 
					get_the_date( 'd' ) . 
				'</span>
				<span class="month">' . 
					get_the_date( 'M' ) . 
				'</span>' .
			'</span>';

		return $result;
	}
}

if ( !function_exists('growla_the_logo') ):
function growla_the_logo() {
	if ( has_custom_logo() ):
		the_custom_logo();
	else:
	?>
		<div class="logo logo-text">
			<a href="<?php echo esc_url( home_url() ); ?>">
				<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
			</a>
		</div>
	<?php
	endif;
}
endif;