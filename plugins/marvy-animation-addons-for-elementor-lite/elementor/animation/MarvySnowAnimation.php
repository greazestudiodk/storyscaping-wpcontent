<?php

namespace MarvyElementor\animation;

if (!defined('ABSPATH')) exit;

use Elementor\Controls_Manager;

class MarvySnowAnimation
{

    public function __construct()
    {
        add_action('elementor/frontend/section/before_render', array($this, 'before_render'), 1);
        add_action('elementor/element/section/section_layout/after_section_end', array($this, 'register_controls'), 1);
    }

    public function register_controls($element)
    {
        $element->start_controls_section('marvy_snow_animation_section',
            [
                'label' => __('<div style="float: right"><img src="' . plugin_dir_url(__DIR__) . 'assets/images/logo.png" height="15px" width="15px" style="float:left;" alt=""></div> Snow Animation', 'marvy-lang'),
                'tab' => Controls_Manager::TAB_LAYOUT
            ]
        );

        $element->add_control('marvy_enable_snow_animation',
            [
                'label' => esc_html__('Enable Snow Animation', 'marvy-lang'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $element->add_control(
            'marvy_snow_animation_count',
            [
                'label' => esc_html__('Count', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 200,
                'min' => 1,
                'max' => 1000,
                'step' => 100,
                'condition' => [
                    'marvy_enable_snow_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_snow_animation_size',
            [
                'label' => esc_html__('Size', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'min' => 1,
                'max' => 50,
                'condition' => [
                    'marvy_enable_snow_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_snow_animation_color',
            [
                'label' => esc_html__('Color', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'condition' => [
                    'marvy_enable_snow_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_snow_animation_shadow_color',
            [
                'label' => esc_html__('Shadow Color', 'marvy-lang'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'condition' => [
                    'marvy_enable_snow_animation' => 'yes',
                ]
            ]
        );

        $element->add_control(
            'marvy_snow_animation_shadow_size',
            [
                'label' => esc_html__('Shadow Size', 'marvy-lang'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'min' => 0,
                'max' => 50,
                'condition' => [
                    'marvy_enable_snow_animation' => 'yes',
                ]
            ]
        );

        $element->end_controls_section();

    }

    public function before_render($element)
    {
        $settings = $element->get_settings();

        if ($settings['marvy_enable_snow_animation'] === 'yes') {
            $element->add_render_attribute(
                '_wrapper',
                [
                    'data-marvy_enable_snow_animation' => 'true',
                    'data-marvy_snow_animation_count' => $settings['marvy_snow_animation_count'],
                    'data-marvy_snow_animation_size' => $settings['marvy_snow_animation_size'],
                    'data-marvy_snow_animation_color' => $settings['marvy_snow_animation_color'],
                    'data-marvy_snow_animation_shadow_color' => $settings['marvy_snow_animation_shadow_color'],
                    'data-marvy_snow_animation_shadow_size' => $settings['marvy_snow_animation_shadow_size']
                ]
            );
        } else {
            $element->add_render_attribute('_wrapper', 'data-marvy_enable_snow_animation', 'false');
        }
    }
}
