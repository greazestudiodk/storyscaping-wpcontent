<?php
namespace MarvyElementor\animation;

if( !defined( 'ABSPATH' ) ) exit;
use Elementor\Controls_Manager;

class MarvyTopologyAnimation {

  public function __construct(){
    add_action('elementor/frontend/section/before_render', array($this, 'before_render'), 1);
    add_action('elementor/element/section/section_layout/after_section_end',array($this,'register_controls'), 1 );
  }

  public function register_controls($element)
  {
    $element->start_controls_section('marvy_topology_animation_section',
      [
        'label' => __('<div style="float: right"><img src="'.plugin_dir_url(__DIR__).'assets/images/logo.png" height="15px" width="15px" style="float:left;" alt=""></div> Topology Animation', 'marvy-lang'),
        'tab' => Controls_Manager::TAB_LAYOUT
      ]
    );

    $element->add_control('marvy_enable_topology_animation',
      [
        'label' => esc_html__('Enable Topology Animation', 'marvy-lang'),
        'type' => Controls_Manager::SWITCHER,
      ]
    );

    $element->add_control(
      'marvy_topology_animation_color',
      [
        'label' => esc_html__('Color', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#88964d',
        'condition' => [
          'marvy_enable_topology_animation' => 'yes',
        ]
      ]
    );

    $element->add_control(
      'marvy_topology_animation_background_color',
      [
        'label' => esc_html__('Background Color', 'marvy-lang'),
        'type' => Controls_Manager::COLOR,
        'default' => '#002222',
        'condition' => [
          'marvy_enable_topology_animation' => 'yes',
        ]
      ]
    );

    $element->end_controls_section();

  }

  public function before_render($element) {
    $settings = $element->get_settings();

    if ($settings['marvy_enable_topology_animation'] === 'yes') {
      $element->add_render_attribute(
        '_wrapper',
        [
          'data-marvy_enable_topology_animation' => 'true',
          'data-marvy_topology_animation_color' => $settings['marvy_topology_animation_color'],
          'data-marvy_topology_animation_background_color' => $settings['marvy_topology_animation_background_color']
        ]
      );
    } else {
      $element->add_render_attribute('_wrapper', 'data-marvy_enable_topology_animation', 'false');
    }
  }
}
