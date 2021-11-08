<?php
namespace MarvyElementor\animation;

if( !defined( 'ABSPATH' ) ) exit;

use Elementor\Controls_Manager;

class MarvyFlyingObject {

  public function __construct(){
    add_action('elementor/frontend/section/before_render', array($this, 'before_render'), 1);
    add_action('elementor/element/section/section_layout/after_section_end',array($this,'register_controls'), 1 );
  }

  public function register_controls($element)
  {
    $element->start_controls_section('marvy_flying_object_section',
      [
        'label' => __('<div style="float: right"><img src="'.plugin_dir_url(__DIR__).'assets/images/logo.png" height="15px" width="15px" style="float:left;" alt=""></div> Flying Object Animation', 'marvy-lang'),
        'tab' => Controls_Manager::TAB_LAYOUT
      ]
    );

    $element->add_control('marvy_enable_flying_object',
      [
        'label' => esc_html__('Enable Flying Object Animation', 'marvy-lang'),
        'type' => Controls_Manager::SWITCHER
      ]
    );

    $element->add_control(
      'marvy_flying_object_shape',
      [
        'label' => esc_html__('Shape', 'marvy-lang'),
        'type' => Controls_Manager::SELECT,
        'default' => 'square',
        'options' => [
          'square' => esc_html__('Square', 'marvy-lang'),
          'circle' => esc_html__('Circle', 'marvy-lang')
        ],
        'condition' => [
          'marvy_enable_flying_object' => 'yes',
        ],
      ]
    );

    $element->add_control(
      'marvy_flying_object_shape_color',
      [
        'label' => esc_html__('Color', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#343bb4',
        'condition' => [
          'marvy_enable_flying_object' => 'yes',
        ]
      ]
    );

    $element->end_controls_section();

  }

  public function before_render($element) {
    $settings = $element->get_settings();

    if ($settings['marvy_enable_flying_object'] === 'yes') {
      $element->add_render_attribute(
        '_wrapper',
        [
          'data-marvy_enable_flying_object' => 'true',
          'data-marvy_flying_object_shape' => $settings['marvy_flying_object_shape'],
          'data-marvy_flying_object_shape_color' => $settings['marvy_flying_object_shape_color'],
        ]
      );
    } else {
      $element->add_render_attribute('_wrapper', 'data-marvy_enable_flying_object', 'false');
    }
  }
}
