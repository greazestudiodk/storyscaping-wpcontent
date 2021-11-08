<?php
namespace MarvyElementor\animation;

if( !defined( 'ABSPATH' ) ) exit;
use Elementor\Controls_Manager;

class MarvyDropAnimation {

  public function __construct(){
    add_action('elementor/frontend/section/before_render', array($this, 'before_render'), 1);
    add_action('elementor/element/section/section_layout/after_section_end',array($this,'register_controls'), 1 );
  }

  public function register_controls($element)
  {
    $element->start_controls_section('marvy_drop_animation_section',
      [
        'label' => __('<div style="float: right"><img src="'.plugin_dir_url(__DIR__).'assets/images/logo.png" height="15px" width="15px" style="float:left;" alt=""></div> Drops Animation', 'marvy-lang'),
        'tab' => Controls_Manager::TAB_LAYOUT
      ]
    );

    $element->add_control('marvy_enable_drop_animation',
      [
        'label' => esc_html__('Enable Drops Animation', 'marvy-lang'),
        'type' => Controls_Manager::SWITCHER,
      ]
    );

    $element->add_control(
      'marvy_drop_animation_types',
      [
        'label' => esc_html__('Shape Type', 'marvy-lang'),
        'type' => Controls_Manager::SELECT,
        'default' => 'dotWithLine',
        'options' => [
          'dotWithLine' => esc_html__('Dot With Line', 'marvy-lang'),
          'onlyLine' => esc_html__('Only Line', 'marvy-lang'),
          'onlyDot' => esc_html__('Only Dot', 'marvy-lang'),
          'candleShape' => esc_html__('Candle Shape', 'marvy-lang')
        ],
        'condition' => [
          'marvy_enable_drop_animation' => 'yes'
        ]
      ]
    );

    $element->add_control(
      'marvy_drop_animation_line_color',
      [
        'label' => esc_html__('Line Color First', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#3f87b1',
        'condition' => [
          'marvy_enable_drop_animation' => 'yes',
          'marvy_drop_animation_types!' => 'onlyDot',
        ]
      ]
    );

    $element->add_control(
      'marvy_drop_animation_line_color_second',
      [
        'label' => esc_html__('Line Color Second', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#dedede',
        'condition' => [
          'marvy_enable_drop_animation' => 'yes',
          'marvy_drop_animation_types!' => 'onlyDot',
        ]
      ]
    );

    $element->add_control(
      'marvy_drop_animation_drop_dot_color',
      [
        'label' => esc_html__('Dot Color', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#0851ff',
        'condition' => [
          'marvy_enable_drop_animation' => 'yes',
          'marvy_drop_animation_types!' => 'onlyLine'
        ]
      ]
    );

    $element->add_control(
      'marvy_drop_animation_drop_dot_size',
      [
        'label' => esc_html__('Dot Size', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 0.9,
        'min' => 0,
        'max' => 2,
        'step' => 0.1,
        'condition' => [
          'marvy_enable_drop_animation' => 'yes',
          'marvy_drop_animation_types!' => ['onlyLine','candleShape']
        ]
      ]
    );

    $element->add_control(
      'marvy_drop_animation_drop_speed',
      [
        'label' => esc_html__('Speed', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 4,
        'min' => 1,
        'max' => 10,
        'step' => 1,
        'condition' => [
          'marvy_enable_drop_animation' => 'yes'
        ]
      ]
    );

    $element->end_controls_section();

  }

  public function before_render($element) {
    $settings = $element->get_settings();

    if ($settings['marvy_enable_drop_animation'] === 'yes') {
      $element->add_render_attribute(
        '_wrapper',
        [
          'data-marvy_enable_drop_animation' => 'true',
          'data-marvy_drop_animation_types' => $settings['marvy_drop_animation_types'],
          'data-marvy_drop_animation_line_color' => $settings['marvy_drop_animation_line_color'],
          'data-marvy_drop_animation_line_color_second' => $settings['marvy_drop_animation_line_color_second'],
          'data-marvy_drop_animation_drop_dot_color' => $settings['marvy_drop_animation_drop_dot_color'],
          'data-marvy_drop_animation_drop_dot_size' => $settings['marvy_drop_animation_drop_dot_size'],
          'data-marvy_drop_animation_drop_speed' => $settings['marvy_drop_animation_drop_speed'],
        ]
      );
    } else {
      $element->add_render_attribute('_wrapper', 'data-marvy_enable_drop_animation', 'false');
    }
  }
}
