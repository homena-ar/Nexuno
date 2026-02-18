<?php
/**
 * Growla elementor functions
 *
 * @package growla
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Growla_Elementor_Widget_Loader
 */
class Growla_Elementor_Widget_Loader {

	/**
	 * Instance variable
	 *
	 * @var Growla_Elementor_Widget_Loader
	 */
	private static $_instance = null;

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Retrieves the instance
	 *
	 * @return Growla_Elementor_Widget_Loader
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Initializes all the functions
	 *
	 * @return void
	 */
	public function init() {
		// require the elementor util file.
		$this->require_util_files();

		// require mods.
		$this->growla_elementor_mods();

		// register all theme widgets.
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ), 99 );

		// add the category to the elementor dashboard.
		add_action( 'elementor/init', array( $this, 'elementor_widget_category' ) );
	}


	/**
	 * Includes widget files
	 *
	 * @return void
	 */
	private function include_widgets_files() {
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/class-heading.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/class-block-slider.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/class-block-slider-secondary.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/class-progress-bar.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/class-counter.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/button.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/testimonial-slider.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/class-testimonial-slider-2.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/client-slider.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/blog.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/projects.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/team.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/class-team-2.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/menu.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/contact-form-7.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/hero-slider-1.php';

		require_once get_template_directory() . '/inc/elementor-widgets/widgets/hamburger.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/hamburger-close.php';
		require_once get_template_directory() . '/inc/elementor-widgets/widgets/icon-box.php';

        require_once get_template_directory() . '/inc/elementor-widgets/widgets/class-illustration.php';
        require_once get_template_directory() . '/inc/elementor-widgets/widgets/class-tabs.php';
        require_once get_template_directory() . '/inc/elementor-widgets/widgets/class-collapse-tab.php';
        require_once get_template_directory() . '/inc/elementor-widgets/widgets/class-award.php';
        require_once get_template_directory() . '/inc/elementor-widgets/widgets/contact-form-7-tabs.php';
        require_once get_template_directory() . '/inc/elementor-widgets/widgets/full-screen-menu.php';
        require_once get_template_directory() . '/inc/elementor-widgets/widgets/waves-illustration.php';
	}

	/**
	 * Registers widgets
	 *
	 * @return void
	 */
	public function register_widgets() {
		$this->include_widgets_files();

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Heading() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Block_Slider() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Block_Slider_Secondary() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Progress_Bar() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Counter() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Projects() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Button() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \TestimonialSlider() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Testimonial_Slider_2() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \ClientSlider() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Blog() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Team() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Team_2() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Menu() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \ContactForm7() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \HeroSlider1() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Illustration() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Tabs() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \CollapseTab() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Award() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Hamburger() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \HamburgerClose() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \IconBox() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \ContactFormTabs() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \FullScreenMenu() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \WavesIllustration() );
	}

	/**
	 * Registers the widget category
	 *
	 * @return void
	 */
	public function elementor_widget_category() {
		\Elementor\Plugin::$instance->elements_manager->add_category(
			'gfxpartner',
			array(
				'title' => esc_html__( 'Gfxpartner', 'growla' ),
				'icon'  => 'fa fa-plug',
			),
			1
		);
	}

	/**
	 * Requires util files
	 *
	 * @return void
	 */
	private function require_util_files() {
		require_once __DIR__ . '/elementor-util.php';
	}

	/**
	 * Requires all Elementor modifications
	 *
	 * @return void
	 */
	public function growla_elementor_mods() {
		require_once get_template_directory() . '/inc/elementor-widgets/mods/section.php';
		require_once get_template_directory() . '/inc/elementor-widgets/mods/video.php';
		require_once get_template_directory() . '/inc/elementor-widgets/mods/image-carousel.php';
		require_once get_template_directory() . '/inc/elementor-widgets/mods/icon-list.php';
		require_once get_template_directory() . '/inc/elementor-widgets/mods/social-list.php';
        require_once get_template_directory() . '/inc/elementor-widgets/mods/accordion.php';
        require_once get_template_directory() . '/inc/elementor-widgets/mods/heading.php';
	}
}

Growla_Elementor_Widget_Loader::instance();
