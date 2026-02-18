<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class Tabs extends \Elementor\Widget_Base {

  public function get_name(){
    return 'growla_tabs';
  }

  public function get_title() {
    return esc_html__('Tabs', 'growla');
  }

  public function get_icon() {
    return 'eicon-tabs';
  }

  public function get_categories(){
    return ['gfxpartner'];
  }

  private function content_controls() {
    $this->start_controls_section(
        'tab_content',
        [
            'label' => esc_html__('Content', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT
        ]
    );

    $repeater = new \Elementor\Repeater();

    $repeater->start_controls_tabs( 'tab_tabs' );

    $this->option_tab( $repeater );
    $this->content_tab( $repeater );

    $repeater->end_controls_tabs();

    $this->add_control(
        'tabs_repeater',
        [
          'label' => __( 'Tabs', 'growla' ),
          'type' => \Elementor\Controls_Manager::REPEATER,
          'fields' => $repeater->get_controls(),
          'title_field' => __( '{{ tab_option_label }}','growla' ),
        ]
    );

    $this->end_controls_section();
  }

  private function option_tab( $instance ) {
    $instance->start_controls_tab(
        'option_tab',
        [
            'label' => esc_html__( 'Option', 'growla' ),
        ]
    );

    $instance->add_control(
        'tab_option_icon',
        [
            'label' => __('Icon', 'growla'),
            'type' => \Elementor\Controls_Manager::ICONS
        ]
    );

    $instance->add_control(
        'tab_option_label',
        [
            'label' => __('Label', 'growla'),
            'type' => \Elementor\Controls_Manager::TEXT
        ]
    );

    $instance->end_controls_tab();
  }

  private function content_tab( $instance ) {
    $instance->start_controls_tab(
        'content_tab',
        [
            'label' => esc_html__( 'Content', 'growla' ),
        ]
    );

    $instance->add_control(
        'tab_content_thumbnail',
        [
            'label' => esc_html__( 'Choose Image', 'growla' ),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
        ]
    );

    $instance->add_control(
        'tab_content_data',
        [
            'label' => esc_html__( 'Content', 'growla' ),
            'type' => \Elementor\Controls_Manager::WYSIWYG,
            'default' => wp_kses( '<p>' . __( 'Default Content', 'growla' ) . '</p>', 'post' ),
            'placeholder' => esc_html__( 'Type your content here', 'growla' ),
        ]
    );

    $instance->end_controls_tab();
  }

  private function style_controls() {
    $this->start_controls_section(
        'tab_styles',
        [
            'label' => esc_html__('Tab', 'growla'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'tab_text_typography',
            'label' => esc_html__('Typography', 'growla'),
            'selector' => '{{WRAPPER}} .growla-tabs-options li span',
        ]
    );

    $this->start_controls_tabs( 'tab_style_tabs' );

    $this->start_controls_tab(
        'tab_normal',
        [
            'label' => esc_html__( 'Normal', 'growla' ),
        ]
    );

    $this->add_control(
        'tab_text_color_normal',
        [
        'label' => esc_html__('Text color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-tabs-options li span' => 'color : {{VALUE}};'
        ]
        
        ]
    );

    $this->add_control(
        'tab_icon_color_normal',
        [
        'label' => esc_html__('Icon color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-tabs-options li .icon svg' => 'fill : {{VALUE}};'
        ]
        
        ]
    );

    $this->add_control(
        'tab_icon_background_color_normal',
        [
        'label' => esc_html__('Icon background color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-tabs-options li .icon' => 'background-color : {{VALUE}};'
        ]
        
        ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
        'tab_active',
        [
            'label' => esc_html__( 'Active', 'growla' ),
        ]
    );

    $this->add_control(
        'tab_text_color_active',
        [
        'label' => esc_html__('Text color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-tabs-options li.growla-tab-option-active span' => 'color : {{VALUE}};',
            '{{WRAPPER}} .growla-tabs-options li:hover span' => 'color : {{VALUE}};'
        ]
        
        ]
    );

    $this->add_control(
        'tab_icon_color_active',
        [
        'label' => esc_html__('Icon color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-tabs-options li.growla-tab-option-active .icon svg' => 'fill : {{VALUE}};',
            '{{WRAPPER}} .growla-tabs-options li:hover .icon svg' => 'fill : {{VALUE}};'
        ]
        
        ]
    );

    $this->add_control(
        'tab_icon_background_color_active',
        [
        'label' => esc_html__('Icon background color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-tabs-options li.growla-tab-option-active .icon' => 'background-color : {{VALUE}};',
            '{{WRAPPER}} .growla-tabs-options li:hover .icon' => 'background-color : {{VALUE}};'
        ]
        
        ]
    );

    $this->end_controls_tab();

    $this->end_controls_tabs();

    $this->end_controls_section();
  }

  private function content_styles() {
    $this->start_controls_section(
        'content_styles',
        [
          'label' => esc_html__('Content', 'growla'),
          'tab' => \Elementor\Controls_Manager::TAB_STYLE
        ]
    );

    $this->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'content_paragraph_typography',
            'label' => esc_html__('Paragraph Typography', 'growla'),
            'selector' => '{{WRAPPER}} .growla-tab-content p',
        ]
    );

    $this->add_control(
        'content_paragraph_color',
        [
        'label' => esc_html__('Paragraph Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-tab-content p' => 'color : {{VALUE}};'
        ]
        
        ]
    );

    $this->add_control(
        'content_heading_color',
        [
        'label' => esc_html__('Heading Color', 'growla'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .growla-tab-content h1' => 'color : {{VALUE}};',
            '{{WRAPPER}} .growla-tab-content h2' => 'color : {{VALUE}};',
            '{{WRAPPER}} .growla-tab-content h3' => 'color : {{VALUE}};',
            '{{WRAPPER}} .growla-tab-content h4' => 'color : {{VALUE}};',
            '{{WRAPPER}} .growla-tab-content h5' => 'color : {{VALUE}};',
            '{{WRAPPER}} .growla-tab-content h6' => 'color : {{VALUE}};'
        ]
        
        ]
    );

    $this->end_controls_section();
  }

  protected function register_controls(){
    $this->content_controls();
    $this->style_controls();
    $this->content_styles();
  }

  private function generate_tab_id( $key, $isOption = false ) {
    $id = $this->get_id();
    $target_id = '';
    if ( $isOption ) {
        $target_id = 'growla-option-' . $id . '-' . $key;
    } else {
        $target_id = 'growla-tab-' . $id . '-' . $key;
    }
    return $target_id;
  }
  
  protected function render(){
    $settings = $this->get_settings_for_display();
    $id = $this->get_id();

    $repeater = $settings['tabs_repeater'];

    if ( empty( $repeater ) ) return;
  ?>
    <div class="growla-tabs">
        <ul class="growla-tabs-options" id="<?php echo esc_attr( 'tab-options-' . $id ); ?>">
            <?php 
                foreach ( $repeater as $key => $option ):
                    $icon = $option['tab_option_icon'];
                    $label = $option['tab_option_label'];

                    $is_active = $key === 0;

                    $class = '';
                    if ( $is_active ) {
                        $class = 'growla-tab-option-active';
                    }


                    $target_id = '#' . $this->generate_tab_id( $key );
                    $option_id = $this->generate_tab_id( $key, true );
            ?>
                <li 
                    class="<?php echo esc_attr( $class ); ?>"
                    id="<?php echo esc_attr( $option_id ); ?>"
                    data-target="<?php echo esc_attr( $target_id ); ?>" 
                    data-value="<?php echo esc_attr( $target_id ); ?>"
                    data-selected="<?php echo esc_attr( $is_active ? 'selected' : '' ) ?>"
                >
                    <?php if ( ! empty( $icon ) ): ?>
                    <div class="icon">
                        <?php
                            \Elementor\Icons_Manager::render_icon( 
                                $icon, 
                                [ 'aria-hidden' => 'true' ]
                            ); 
                        ?>
                    </div>
                    <?php endif; ?>

                    <span>
                        <?php echo esc_html( $label ); ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="growla-tabs-select">
            <select data-source-selector="li" data-source-target="#<?php echo esc_attr( 'tab-options-' . $id ) ?>">
                <?php 
                    foreach ( $repeater as $key => $option ):
                        $is_active = $key === 0;
                        $target_id = '#' . $this->generate_tab_id( $key );
                        $option_id = $this->generate_tab_id( $key, true );
                ?>
                    <option 
                        value="<?php echo esc_attr( $target_id ); ?>"
                        data-option="<?php echo esc_attr( $option_id ); ?>"
                        <?php echo esc_attr( $is_active ? 'selected data-selected' : '' ); ?>
                    >
                        &nbsp;
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="growla-tabs-content">
            <?php 
                foreach ( $repeater as $key => $tab ):
                    $content = $tab['tab_content_data'];
                    $is_active = $key === 0;

                    $class = array( 'growla-tab' );

                    if ( $is_active ) {
                        $class[] = 'growla-tab-active';
                    }

                    $target_id = $this->generate_tab_id( $key );
            ?>
                <div class="<?php echo esc_attr( implode( ' ', $class ) ); ?>" id="<?php echo esc_attr( $target_id ); ?>">
                    <?php
                        echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( 
                            $tab, 
                            'growla-tabs-thumbnail', 
                            'tab_content_thumbnail'
                        ); 
                    ?>

                    <?php if ( ! empty( $content ) ): ?>
                    <div class="growla-tab-content">
                        <?php echo wp_kses( $content, 'post' ); ?>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
  }
}
