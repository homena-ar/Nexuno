<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class Award extends \Elementor\Widget_Base {

    public function get_name(){
        return 'growla_award';
    }

    public function get_title() {
        return esc_html__('Award', 'growla');
    }

    public function get_icon() {
        return 'eicon-star';
    }

    public function get_categories(){
        return ['gfxpartner'];
    }

    private function button_content_controls() {
        $this->start_controls_section(
            'content',
            [
                'label' => esc_html__('Content', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT
            ]
        );


        $this->add_control(
            'award_time',
            [
                'label' => esc_html__('Time', 'growla'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Time'
            ]
        );

        $this->add_control(
            'award_title',
            [
                'label' => esc_html__('Title', 'growla'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Award'
            ]
        );

        $this->add_control(
            'award_presenter',
            [
                'label' => esc_html__('Presenter', 'growla'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default' => 'Presenter'
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'growla'),
                'type' => \Elementor\Controls_Manager::URL,
            
            ]
        );

        $this->end_controls_section();
    }

    protected function register_controls(){
        $this->button_content_controls();
    }

    protected function render(){
        $settings = $this->get_settings_for_display();

        $attribute_key = 'link_attr';
        $is_link_url_empty = true;

        $this->add_render_attribute($attribute_key, 'class', 'growla-award');

        if ( ! empty ( $settings['link']['is_external'] ) ) {
            $this->add_render_attribute($attribute_key, 'target', '_blank');
        }

        if ( ! empty( $settings['link']['nofollow'] ) ) {
            $this->add_render_attribute($attribute_key, 'rel', 'nofollow');
        }

        if ( !empty( $settings['link']['url'] ) ) {
            $this->add_render_attribute($attribute_key, 'href', $settings['link']['url']);
            $is_link_url_empty = false;
        }

        ?>
            <?php if ( $is_link_url_empty ): ?>
                <div class="growla-award">
            <?php else: ?>
                <a <?php $this->print_render_attribute_string( $attribute_key ); ?>>
            <?php endif; ?>

                <?php if ( ! empty( $settings['award_time'] ) ): ?>
                <h6 class="growla-award-time">
                    <?php echo esc_html( $settings['award_time'] ); ?>
                </h6>
                <?php endif; ?>

                <?php if ( ! empty( $settings['award_title'] ) ): ?>
                <h6 class="growla-award-title">
                    <?php echo esc_html( $settings['award_title'] ); ?>
                </h6>
                <?php endif; ?>

                <?php if ( ! empty( $settings['award_presenter'] ) ): ?>
                <h6 class="growla-award-presenter">
                    <?php echo esc_html( $settings['award_presenter'] ); ?>
                </h6>
                <?php endif; ?>

            <?php if ( $is_link_url_empty ): ?>
                </div>
            <?php else: ?>
                </a>
            <?php endif; ?>
        <?php
    }
}
