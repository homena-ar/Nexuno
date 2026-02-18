<?php
/**
 * Elementor: heading widget
 *
 * @package growla
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Growla_Elementor_Widget_Loader
 */
class Heading extends \Elementor\Widget_Base {

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'growla_heading';
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Heading', 'growla' );
	}

	/**
	 * Get icon
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-heading';
	}

	/**
	 * Get categories
	 *
	 * @return array
	 */
	public function get_categories() {
		return array( 'gfxpartner' );
	}

	/**
	 * Registers controls
	 *
	 * @return void
	 */
	protected function register_controls() {
		growla_heading_data_controls( $this );
        growla_heading_style_controls( $this );
	}

	/**
	 * Renders the widget markup
	 *
	 * @return void
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
        growla_heading($settings);
	}
}
