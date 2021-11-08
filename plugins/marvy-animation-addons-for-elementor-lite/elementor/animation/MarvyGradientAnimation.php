<?php
namespace MarvyElementor\animation;

if( !defined( 'ABSPATH' ) ) exit;
use Elementor\Controls_Manager;

class MarvyGradientAnimation {

  public function __construct(){
    add_action('elementor/frontend/section/before_render', array($this, 'before_render'), 1);
    add_action('elementor/element/section/section_layout/after_section_end',array($this,'register_controls'), 1 );
  }

  public function register_controls($element)
  {
    $element->start_controls_section('marvy_gradient_animation_section',
      [
        'label' => __('<div style="float: right"><img src="'.plugin_dir_url(__DIR__).'assets/images/logo.png" height="15px" width="15px" style="float:left;" alt=""></div> Gradient Animation', 'marvy-lang'),
        'tab' => Controls_Manager::TAB_LAYOUT
      ]
    );

    $element->add_control('marvy_enable_gradient_animation',
      [
        'label' => esc_html__('Enable Gradient Background', 'marvy-lang'),
        'type' => Controls_Manager::SWITCHER,
      ]
    );

    $element->add_control(
      'marvy_gradient_animation_first_color',
      [
          'label' => esc_html__('Color 1', 'marvy-lang'),
          'type' => Controls_Manager::COLOR,
          'default' => '#ee7752',
          'condition' => [
              'marvy_enable_gradient_animation' => 'yes',
          ]
      ]
    );

    $element->add_control(
      'marvy_gradient_animation_second_color',
      [
          'label' => esc_html__('Color 2', 'marvy-lang'),
          'type' => Controls_Manager::COLOR,
          'default' => '#e73c7e',
          'condition' => [
              'marvy_enable_gradient_animation' => 'yes',
          ]
      ]
    );

    $element->add_control(
      'marvy_gradient_animation_third_color',
      [
          'label' => esc_html__('Color 3', 'marvy-lang'),
          'type' => Controls_Manager::COLOR,
          'default' => '#23a6d5',
          'condition' => [
              'marvy_enable_gradient_animation' => 'yes',
          ]
      ]
    );

    $element->add_control(
      'marvy_gradient_animation_fourth_color',
      [
          'label' => esc_html__('Color 4', 'marvy-lang'),
          'type' => Controls_Manager::COLOR,
          'default' => '#23d5ab',
          'condition' => [
              'marvy_enable_gradient_animation' => 'yes',
          ]
      ]
    );

    $element->add_control(
      'marvy_gradient_animation_degree',
      [
          'label' => esc_html__('Angle', 'marvy-lang'),
          'type' => Controls_Manager::SELECT,
          'default' => '45',
          'options' => [
              '45' => esc_html__('Right Bottom To Left Top', 'marvy-lang'),
              '90' => esc_html__('Right To Left', 'marvy-lang'),
              '135' => esc_html__('Right Top To Left Bottom', 'marvy-lang')
          ],
          'condition' => [
              'marvy_enable_gradient_animation' => 'yes'
          ]
      ]
    );

    $element->add_control(
      'marvy_gradient_animation_duration',
      [
          'label' => esc_html__('Duration', 'marvy-lang'),
          'type' => Controls_Manager::NUMBER,
          'default' => 15,
          'min' => 1,
          'max' => 50,
          'step' => 5,
          'condition' => [
              'marvy_enable_gradient_animation' => 'yes'
          ]
      ]
    );

    $element->end_controls_section();

  }

  public function before_render($element) {
    $settings = $element->get_settings();

    if ($settings['marvy_enable_gradient_animation'] === 'yes') {
      $element->add_render_attribute(
        '_wrapper',
        [
            'data-marvy_enable_gradient_animation' => 'true',
            'data-marvy_gradient_animation_first_color' => $settings['marvy_gradient_animation_first_color'],
            'data-marvy_gradient_animation_second_color' => $settings['marvy_gradient_animation_second_color'],
            'data-marvy_gradient_animation_third_color' => $settings['marvy_gradient_animation_third_color'],
            'data-marvy_gradient_animation_fourth_color' => $settings['marvy_gradient_animation_fourth_color'],
            'data-marvy_gradient_animation_degree' => $settings['marvy_gradient_animation_degree'],
            'data-marvy_gradient_animation_duration' => $settings['marvy_gradient_animation_duration']
        ]
      );
    } else {
      $element->add_render_attribute('_wrapper', 'data-marvy_enable_gradient_animation', 'false');
    }
  }
}
