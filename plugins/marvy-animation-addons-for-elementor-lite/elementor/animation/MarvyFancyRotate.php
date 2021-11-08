<?php
namespace MarvyElementor\animation;

if( !defined( 'ABSPATH' ) ) exit;

use Elementor\Controls_Manager;

class MarvyFancyRotate {

  public function __construct(){
    add_action('elementor/frontend/section/before_render', array($this, 'before_render'), 1);
    add_action('elementor/element/section/section_layout/after_section_end',array($this,'register_controls'), 1 );
  }

  public function register_controls($element)
  {
    $element->start_controls_section('marvy_fancy_rotate_section',
      [
        'label' => __('<div style="float: right"><img src="'.plugin_dir_url(__DIR__).'assets/images/logo.png" height="15px" width="15px" style="float:left;" alt=""></div> Fancy Rotate Animation', 'marvy-lang'),
        'tab' => Controls_Manager::TAB_LAYOUT
      ]
    );

    $element->add_control('marvy_enable_fancy_rotate',
      [
        'label' => esc_html__('Enable Fancy Rotate Animation', 'marvy-lang'),
        'type' => Controls_Manager::SWITCHER,
      ]
    );

    $element->add_control('marvy_enable_fancy_rotate_circle',
      [
        'label' => esc_html__('Show Circle', 'marvy-lang'),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'yes',
        'condition' => [
          'marvy_enable_fancy_rotate' => 'yes',
        ]
      ]
    );

    $element->add_control('marvy_enable_fancy_rotate_particle',
      [
        'label' => esc_html__('Show Particle', 'marvy-lang'),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'yes',
        'condition' => [
          'marvy_enable_fancy_rotate' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_fancy_rotate_first_color',
      [
        'label' => esc_html__('First Particle Color', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#ec542f',
        'condition' => [
          'marvy_enable_fancy_rotate' => 'yes',
          'marvy_enable_fancy_rotate_particle' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_fancy_rotate_second_color',
      [
        'label' => esc_html__('Second Particle Color', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#ffffff',
        'condition' => [
          'marvy_enable_fancy_rotate' => 'yes',
          'marvy_enable_fancy_rotate_particle' => 'yes',
        ]
      ]
    );

    $element->end_controls_section();

  }

  public function before_render($element) {
    $settings = $element->get_settings();
      if ($settings['marvy_enable_fancy_rotate'] === 'yes') {
          $element->add_render_attribute(
              '_wrapper',
              [
                  'data-marvy_enable_fancy_rotate' => 'true',
                  'data-marvy_enable_fancy_rotate_circle' => $settings['marvy_enable_fancy_rotate_circle'],
                  'data-marvy_enable_fancy_rotate_particle' => $settings['marvy_enable_fancy_rotate_particle'],
                  'data-marvy_fancy_rotate_first_color' => $settings['marvy_fancy_rotate_first_color'],
                  'data-marvy_fancy_rotate_second_color' => $settings['marvy_fancy_rotate_second_color'],
              ]
          );
      } else {
          $element->add_render_attribute('_wrapper', 'data-marvy_enable_fancy_rotate', 'false');
      }

  }
}
