<?php
namespace MarvyElementor\animation;

if( !defined( 'ABSPATH' ) ) exit;
use Elementor\Controls_Manager;

class MarvyWavesAnimation {

  public function __construct(){
    add_action('elementor/frontend/section/before_render', array($this, 'before_render'), 1);
    add_action('elementor/element/section/section_layout/after_section_end',array($this,'register_controls'), 1 );
  }

  public function register_controls($element)
  {
    $element->start_controls_section('marvy_waves_animation_section',
      [
        'label' => __('<div style="float: right"><img src="'.plugin_dir_url(__DIR__).'assets/images/logo.png" height="15px" width="15px" style="float:left;" alt=""></div> Waves Animation', 'marvy-lang'),
        'tab' => Controls_Manager::TAB_LAYOUT
      ]
    );

    $element->add_control('marvy_enable_waves_animation',
      [
        'label' => esc_html__('Enable Waves Animation', 'marvy-lang'),
        'type' => Controls_Manager::SWITCHER,
      ]
    );

    $element->add_control(
      'marvy_waves_animation_color',
      [
        'label' => esc_html__('Color', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#005588',
        'condition' => [
          'marvy_enable_waves_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_waves_animation_shininess',
      [
        'label' => esc_html__('Shininess', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 30,
        'min' => 0,
        'max' => 150,
        'step' => 10,
        'condition' => [
          'marvy_enable_waves_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_waves_animation_wave_height',
      [
        'label' => esc_html__('Wave Height', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 15,
        'min' => 0,
        'max' => 40,
        'step' => 5,
        'condition' => [
          'marvy_enable_waves_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_waves_animation_wave_speed',
      [
        'label' => esc_html__('Wave Speed', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 1,
        'min' => 0,
        'max' => 2,
        'step' => 0.1,
        'condition' => [
          'marvy_enable_waves_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_waves_animation_zoom',
      [
        'label' => esc_html__('Zoom', 'marvy-lang'),
        'type' => Controls_Manager::NUMBER,
        'default' => 1,
        'min' => 0,
        'max' => 1.8,
        'step' => 0.1,
        'condition' => [
          'marvy_enable_waves_animation' => 'yes',
        ]
      ]
    );

    $element->end_controls_section();

  }

  public function before_render($element) {
    $settings = $element->get_settings();

    if ($settings['marvy_enable_waves_animation'] === 'yes') {
      $element->add_render_attribute(
        '_wrapper',
        [
          'data-marvy_enable_waves_animation' => 'true',
          'data-marvy_waves_animation_color' => $settings['marvy_waves_animation_color'],
          'data-marvy_waves_animation_shininess' => $settings['marvy_waves_animation_shininess'],
          'data-marvy_waves_animation_wave_height' => $settings['marvy_waves_animation_wave_height'],
          'data-marvy_waves_animation_wave_speed' => $settings['marvy_waves_animation_wave_speed'],
          'data-marvy_waves_animation_zoom' => $settings['marvy_waves_animation_zoom']
        ]
      );
    } else {
      $element->add_render_attribute('_wrapper', 'data-marvy_enable_waves_animation', 'false');
    }
  }
}
