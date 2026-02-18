<?php

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.1' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function growla_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on growla, use a find and replace
		* to change 'growla' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'growla', get_template_directory() . '/inc/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary-menu' => esc_html__( 'Primary Menu', 'growla' ),
			'default-menu' => esc_html__( 'Default Menu', 'growla' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	add_image_size( 'growla-post-thumbnail-size', 370, 296, true );
	add_image_size( 'growla-recent-post-thumbnail-size', 70, 70, true );
	add_image_size( 'growla-post-detail-thumbnail-size', 1170, 547, true );
	add_image_size( 'growla-project-thumbnail-size', 652, 487, true );
	add_image_size( 'growla-project-detail-thumbnail-size', 1170, 878, array( 'center', 'top' ) );
	add_image_size( 'growla-slider-1', 970, 478, true );
	add_image_size( 'growla-illustration-img-1', 466, 433, true );
	add_image_size( 'growla-illustration-img-2', 336, 233, true );
	add_image_size( 'growla-tabs-thumbnail', 770, 447, true );

	remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'growla_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function growla_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'growla_content_width', 640 );
}
add_action( 'after_setup_theme', 'growla_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function growla_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'growla' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Widgets added here will be displayed on the blogs page.', 'growla' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Search Sidebar', 'growla' ),
			'id'            => 'search_sidebar',
			'description'   => esc_html__( 'Widgets added here will be displayed on the search page.', 'growla' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Archives Sidebar', 'growla' ),
			'id'            => 'archive_sidebar',
			'description'   => esc_html__( 'Widgets added here will be displayed on the archives page.', 'growla' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'growla_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function growla_scripts() {
	wp_enqueue_style( 'growla-fonts', growla_fonts_url(), array(), _S_VERSION, 'all' );
	wp_enqueue_style( 'swiper', get_template_directory_uri() . '/inc/assets/css/swiper-bundle.min.css', array(), '11.0.5' );
	wp_enqueue_style( 'tom-select', get_template_directory_uri() . '/inc/assets/css/tom-select.min.css', array(), '2.3.1' );
	wp_enqueue_style( 'growla-style', get_template_directory_uri() . '/inc/assets/dist/style.css', array(), _S_VERSION );
	wp_style_add_data( 'growla-style', 'rtl', 'replace' );

	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/inc/assets/js/plugins/swiper-bundle.min.js', array(), '11.0.5', true );
	wp_enqueue_script( 'gsap', get_template_directory_uri() . '/inc/assets/js/plugins/gsap.min.js', array(), '3.12.5', true );
	wp_enqueue_script( 'scrolltrigger', get_template_directory_uri() . '/inc/assets/js/plugins/scrollTrigger.min.js', array(), '3.12.5', true );
	wp_enqueue_script( 'tom-select', get_template_directory_uri() . '/inc/assets/js/plugins/tom-select.min.js', array(), '2.3.1', true );
	wp_enqueue_script( 'lenis', get_template_directory_uri() . '/inc/assets/js/plugins/lenis.min.js', array(), '1.0.40', true );
	wp_enqueue_script( 'growla-main', get_template_directory_uri() . '/inc/assets/dist/app.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'growla_scripts', 99 );

if ( ! function_exists( 'growla_fonts_url' ) ) {
	/**
	 * get the url for the theme font
	 *
	 * @return string
	 */
	function growla_fonts_url() {
		$fonts_url = '';
		$font      = '';
		$subsets   = 'latin,latin-ext';
		/* translators: If there are characters in your language that are not supported by Spartan, translate this to 'off'. Do not translate into your own language. */
		$font = 'Manrope:400,500,600,700,800,900&display=swap';

		if ( $font ) {
			$fonts_url = add_query_arg(
				array(
					'family' => $font,
					'subset' => $subsets,
				),
				'//fonts.googleapis.com/css'
			);
		}
		return esc_url_raw( $fonts_url );
	}
}


if ( ! function_exists( 'growla_kses_allowed_html' ) ) {
	/**
	 * Get the allowed tags for a certain context
	 *
	 * @param  mixed $tags
	 * @param  mixed $context
	 * @return mixed
	 */
	function growla_kses_allowed_html( $tags, $context ) {
		switch ( $context ) {
			case 'general':
				$tags = wp_kses_allowed_html( 'post' );
				return $tags;
			case 'elementor-general':
				$tags = wp_kses_allowed_html( 'post' );
				unset( $tags['p'] );
				$tags = array_merge(
					$tags,
					array(
						'input' => array(
							'type'    => array(),
							'name'    => array(),
							'value'   => array(),
							'checked' => array(),
						),
					)
				);
				return $tags;
			case 'elementor-template':
				$tags = wp_kses_allowed_html( 'post' );
				$tags = array_merge(
					$tags,
					array(
						'style'    => array(),
						'script'   => array(),
						'form'     => array(
							'name'       => true,
							'class'      => true,
							'id'         => true,
							'rel'        => true,
							'action'     => true,
							'enctype'    => true,
							'method'     => true,
							'novalidate' => true,
							'target'     => true,
						),
						'button'   => array(
							'autofocus'      => true,
							'autocomplete'   => true,
							'disabled'       => true,
							'form'           => true,
							'formaction'     => true,
							'formenctype'    => true,
							'formmethod'     => true,
							'formnovalidate' => true,
							'formtarget'     => true,
							'name'           => true,
							'type'           => true,
							'value'          => true,
							'class'          => true,
							'id'             => true,
						),
						'input'    => array(
							'class'          => true,
							'id'             => true,
							'name'           => true,
							'value'          => true,
							'type'           => true,
							'placeholder'    => true,
							'required'       => true,
							'width'          => true,
							'title'          => true,
							'tabindex'       => true,
							'step'           => true,
							'src'            => true,
							'size'           => true,
							'readonly'       => true,
							'pattern'        => true,
							'multiple'       => true,
							'minlength'      => true,
							'maxlength'      => true,
							'min'            => true,
							'max'            => true,
							'list'           => true,
							'inputmod'       => true,
							'height'         => true,
							'formtarget'     => true,
							'formnovalidate' => true,
							'formmethod'     => true,
							'formenctype'    => true,
							'formaction'     => true,
							'form'           => true,
							'disabled'       => true,
							'dirname'        => true,
							'checked'        => true,
							'capture'        => true,
							'autofocus'      => true,
							'autocomplete'   => true,
							'alt'            => true,
							'accept'         => true,
						),
						'textarea' => array(
							'class'        => true,
							'id'           => true,
							'name'         => true,
							'placeholder'  => true,
							'required'     => true,
							'autocomplete' => true,
							'autocorrect'  => true,
							'autofocus'    => true,
							'cols'         => true,
							'disabled'     => true,
							'form'         => true,
							'maxlength'    => true,
							'minlength'    => true,
						),
						'label'    => array(
							'for' => true,
						),
						'svg'      => array(
							'class'           => true,
							'aria-hidden'     => true,
							'aria-labelledby' => true,
							'role'            => true,
							'xmlns'           => true,
							'width'           => true,
							'height'          => true,
							'viewbox'         => true,
						),
						'g'        => array( 'fill' => true ),
						'title'    => array( 'title' => true ),
						'path'     => array(
							'd'    => true,
							'fill' => true,
						),

					)
				);
				return $tags;
			case 'wysiwyg-heading-removal':
				$tags = wp_kses_allowed_html( 'post' );
				unset( $tags['h1'] );
				unset( $tags['h2'] );
				unset( $tags['h3'] );
				unset( $tags['h4'] );
				unset( $tags['h5'] );
				unset( $tags['h6'] );
				return $tags;
			case 'br-allowed':
				$tags = array(
					'br' => array(),
				);
				return $tags;
			case 'anchor-allowed':
				$tags = array(
					'a' => array(
						'href'  => array(),
						'class' => array(),
						'id'    => array(),
					),
				);
				return $tags;
			default:
				return $tags;
		}
	}
}
add_filter( 'wp_kses_allowed_html', 'growla_kses_allowed_html', 10, 2 );

function growla_channel_nav_class( $classes, $item, $args, $depth ) {

	$is_swiper_container = in_array( 'swiper-container', explode( ' ', $args->container_class ) );

	if ( ! $is_swiper_container ) {
		return $classes;
	}

	if ( $depth == 0 ) {
		$classes[] = 'swiper-slide';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'growla_channel_nav_class', 10, 4 );


/**
 * Allow SVG
 */
if ( ! function_exists( 'growla_check_filetype_and_ext' ) ) {
	function growla_check_filetype_and_ext( $data, $file, $filename, $mimes ) {

		global $wp_version;
		if ( $wp_version !== '4.7.1' ) {
			return $data;
		}

		$filetype = wp_check_filetype( $filename, $mimes );

		return array(
			'ext'             => $filetype['ext'],
			'type'            => $filetype['type'],
			'proper_filename' => $data['proper_filename'],
		);
	}
}
add_filter( 'wp_check_filetype_and_ext', 'growla_check_filetype_and_ext', 10, 4 );

function growla_add_custom_class_to_menu_link( $item_output, $item, $depth, $args ) {
	// Check if the current menu item has children
	if ( in_array( 'menu-item-has-children', $item->classes ) ) {
		// Add custom class to the anchor tag
		$item_output = str_replace( '<a ', '<a class="gfx-titan-preloader-ignore" ', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'growla_add_custom_class_to_menu_link', 10, 4 );

function growla_add_editor_styles() {
	add_editor_style( 'inc/assets/dist/editor-style.css' );
}
add_action( 'admin_init', 'growla_add_editor_styles' );
