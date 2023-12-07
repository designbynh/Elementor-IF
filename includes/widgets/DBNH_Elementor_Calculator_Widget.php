<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DBNH_Elementor_Calculator_Widget extends \Elementor\Widget_Base {
	
	public function get_name() {
		return 'elementor-calculator'; // Updated widget name
	}
	
	public function get_title() {
		return esc_html__( 'Calculator Widget', 'elementor-calculator-widget' ); // Updated title
	}
	
	public function get_icon() {
		return 'eicon-calculator'; // Update icon if necessary
	}
	
	public function get_categories() {
		return [ 'general' ]; // Place your widget in the appropriate category
	}

	protected function register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Settings', 'elementor-calculator-widget' ),
			]
		);
		
		// Regular Price
		$this->add_control(
			'regular_price',
			[
				'label' => esc_html__( 'Regular Price', 'elementor-calculator-widget' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		
		// Sale Price
		$this->add_control(
			'sale_price',
			[
				'label' => esc_html__( 'Sale Price', 'elementor-calculator-widget' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		
		// Prefix
		$this->add_control(
			'prefix_text',
			[
				'label' => esc_html__( 'Prefix', 'elementor-calculator-widget' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);
		
		// Postfix
		$this->add_control(
			'postfix_text',
			[
				'label' => esc_html__( 'Postfix', 'elementor-calculator-widget' ),
				'type' => Controls_Manager::TEXT,
				'default' => '%',
			]
		);
		
		// HTML Tag
		$this->add_control(
			'html_tag',
			[
				'label' => esc_html__( 'HTML Tag', 'elementor-calculator-widget' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'p' => 'p',
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
					'div' => 'div',
					'span' => 'span',
				],
				'default' => 'span',
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Style', 'elementor-calculator-widget' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Color control
		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Color', 'elementor-calculator-widget' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .calculator-widget' => 'color: {{VALUE}};',
				],
			]
		);

		// Typography control
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .calculator-widget',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
	
		$regular_price = floatval($settings['regular_price']);
		$sale_price = floatval($settings['sale_price']);
	
		$prefix = $settings['prefix_text'];
		$postfix = $settings['postfix_text'];
	
		$html_tag = tag_escape($settings['html_tag']);
	
		if ($regular_price > 0 && $sale_price < $regular_price) {
			$savings = round((($regular_price - $sale_price) / $regular_price) * 100);
			$output = $prefix . $savings . $postfix;
		} else {
			$output = 'No savings';
		}
	
		echo "<{$html_tag} class='calculator-widget'>{$output}</{$html_tag}>";
	}
	
}