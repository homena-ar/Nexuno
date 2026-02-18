<?php

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

class ClientSlider extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'growla_client_slider';
    }

    public function get_title()
    {
        return __('Client Slider', 'growla');
    }

    public function get_icon()
    {
        return 'eicon-logo';
    }

    public function get_categories()
    {
        return ['gfxpartner'];
    }

    private function content_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Slides', 'growla'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'cs_image',
            [
                'label' => __('Choose Image', 'growla'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'cs_link',
            [
                'label' => __('Link', 'growla'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'growla'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'cs_repeater',
            [
                'label' => __('Client slides', 'growla'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => __('Client', 'growla'),
            ]
        );

        $this->end_controls_section();
    }

    protected function register_controls()
    {
        growla_heading_data_controls( $this );
        growla_heading_style_controls( $this );
        $this->content_controls();
        growla_slider_controls( $this, array(), 4 );
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();

        // options for the slider
        $options = growla_slider_options($settings, $id, 
            [
                'spaceBetween' => 0,
                'breakpoints' => [
                    '0' => [
                        'slidesPerView' => 1,
                        'centeredSlides' => true
                    ],
                    '500' => [
                        'slidesPerView' => 1.2,
                        'centeredSlides' => true
                    ],
                    '992' => [
                        'slidesPerView' => $settings['slides_per_view'],
                        'centeredSlides' => false
                    ]
                ]
            ]
        );

        // main class list
        $class_list = [
            'client-slider',
        ];

        $slider_class = [
            'swiper',
            'slider-' . $id,
        ]

        ?>
    <div class="<?php echo esc_html(implode(' ', $class_list)); ?>">
        <!-- header - start -->
        <?php
            get_template_part(
                '/inc/template-parts/elementor/slider',
                'header',
                array(
                    'settings' => $settings,
                    'id' => $id,
                )
            );
        ?>
        <!-- header - end -->
        <!-- slider - start -->
        <div class="<?php echo esc_html(implode(' ', $slider_class)); ?>">
            <div class="swiper-wrapper">
                <?php
                    if ( is_array( $settings['cs_repeater'] ) || is_object( $settings['cs_repeater'] ) ):
                        foreach ( $settings['cs_repeater'] as $item ):
                            $target = $item['cs_link']['is_external'] ? ' target="_blank"' : '';
                            $nofollow = $item['cs_link']['nofollow'] ? ' rel="nofollow"' : '';
                ?>
                    <!-- slide - start -->
                    <div class="swiper-slide">
                        <div class="client-slide">
                            <?php if (!empty($item['cs_link']['url'])): ?>
                                <a
                                    href="<?php echo esc_url($item['cs_link']['url']); ?>"
                                    class="client-image"
                                    <?php echo esc_attr($target); ?>
                                    <?php echo esc_attr($nofollow); ?>
                                >
                            <?php endif;?>

                            <?php
                                echo
                                \Elementor\Group_Control_Image_Size::get_attachment_image_html(
                                    $item,
                                    'full',
                                    'cs_image'
                                );
                            ?>

                            <?php if (!empty($item['cs_link']['url'])): ?>
                                </a>
                            <?php endif;?>
                        </div>
                    </div>
                    <!-- slide - end -->
                <?php endforeach; endif; ?>
            </div>
        </div>
        <!-- slider - end -->
    </div>
    <?php
        growla_slider($id, $options);
    }
}
