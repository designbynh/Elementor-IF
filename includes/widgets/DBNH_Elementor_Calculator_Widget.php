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
			'value1',
			[
				'label' => esc_html__( 'Value 1', 'elementor-calculator-widget' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		
		// Operation Type
		$this->add_control(
			'operation_type',
			[
				'label' => esc_html__( 'Operation Type', 'elementor-calculator-widget' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'add' => esc_html__( 'Add', 'elementor-calculator-widget' ),
					'subtract' => esc_html__( 'Subtract', 'elementor-calculator-widget' ),
					'multiply' => esc_html__( 'Multiply', 'elementor-calculator-widget' ),
					'percentage' => esc_html__( 'Percentage', 'elementor-calculator-widget' ),
				],
				'default' => 'percentage',
			]
		);
		
		// Sale Price
		$this->add_control(
			'value2',
			[
				'label' => esc_html__( 'Value 2', 'elementor-calculator-widget' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		
		// Add a divider
		$this->add_control(
			'section_divider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
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
		
		// Add a divider
		$this->add_control(
			'section_divider_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
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
	
		$value1 = floatval($settings['value1']);
		$value2 = floatval($settings['value2']);
		$operation_type = $settings['operation_type'];
	
		$prefix = $settings['prefix_text'];
		$postfix = $settings['postfix_text'];
		$html_tag = tag_escape($settings['html_tag']);
		$output = '';
	
		switch ($operation_type) {
			case 'percentage':
				if ($value1 > 0 && $value2 < $value1) {
					$percentage = round((($value1 - $value2) / $value1) * 100);
					$output = $prefix . $percentage . $postfix;
				} else {
					$output = 'No savings';
				}
				break;
	
			case 'add':
				$result = $value1 + $value2;
				$output = $prefix . $result . $postfix;
				break;
	
			case 'subtract':
				$result = $value1 - $value2;
				$output = $prefix . $result . $postfix;
				break;
	
			case 'multiply':
				$result = $value1 * $value2;
				$output = $prefix . $result . $postfix;
				break;
				
			default:
				$output = "No parameters set.";
				break;
		}
	
		echo "<{$html_tag} class='calculator-widget'>{$output}</{$html_tag}>";
	}

	
}

