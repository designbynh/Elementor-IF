<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class DBNH_Elementor_IF_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'elementor_if';
	}

	public function get_title() {
		return esc_html__( 'Elementor IF', 'elementor-if-widget' );
	}

	public function get_icon() {
		return 'eicon-code'; // Choose an appropriate icon.
	}

	public function get_categories() {
		return [ 'general' ]; // Category to place the widget in.
	}

	protected function register_controls() {
		$this->start_controls_section(
			'input_section',
			[
				'label' => esc_html__( 'Settings', 'elementor-if-widget' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
	
		$this->add_control(
			'field_1',
			[
				'label' => esc_html__( 'Field 1', 'elementor-if-widget' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => ['active' => true],
				'placeholder' => esc_html__( 'Enter first value', 'elementor-if-widget' ),
			]
		);
		
		$this->add_control(
			'operator',
			[
				'label' => esc_html__( 'Comparison Operator', 'elementor-if-widget' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'equal' => esc_html__( 'Equals', 'elementor-if-widget' ),
					'greater_than' => esc_html__( 'Greater Than', 'elementor-if-widget' ),
					'less_than' => esc_html__( 'Less Than', 'elementor-if-widget' ),
				],
				'default' => 'equal',
			]
		);
		
	
		$this->add_control(
			'field_2',
			[
				'label' => esc_html__( 'Field 2', 'elementor-if-widget' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => ['active' => true],
				'placeholder' => esc_html__( 'Enter second value', 'elementor-if-widget' ),
			]
		);
		
		
		// Add a divider
		$this->add_control(
			'section_divider',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);
	
	
		$this->add_control(
			'output_true',
			[
				'label' => esc_html__( 'Output If True', 'elementor-if-widget' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => ['active' => true],
				'placeholder' => esc_html__( 'Displayed if condition is true', 'elementor-if-widget' ),
			]
		);
		
		$this->add_control(
			'hide_output_false',
			[
				'label' => esc_html__( 'Hide Output If False', 'elementor-if-widget' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Hide', 'elementor-if-widget' ),
				'label_off' => esc_html__( 'Show', 'elementor-if-widget' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
	
		$this->add_control(
			'output_false',
			[
				'label' => esc_html__( 'Output If False', 'elementor-if-widget' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'dynamic' => ['active' => true],
				'placeholder' => esc_html__( 'Displayed if condition is false', 'elementor-if-widget' ),
				'condition' => [
					'hide_output_false!' => 'yes', // Show this control only if hide_output_false is not 'yes'
				],
			]
		);
		
		$this->add_control(
			'output_tag',
			[
				'label' => esc_html__( 'Output HTML Tag', 'elementor-if-widget' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'p' => 'Paragraph <p>',
					'h1' => 'Heading 1 <h1>',
					'h2' => 'Heading 2 <h2>',
					'h3' => 'Heading 3 <h3>',
					'h4' => 'Heading 4 <h4>',
					'h5' => 'Heading 5 <h5>',
					'h6' => 'Heading 6 <h6>',
					'div' => 'Div <div>',
				],
				'default' => 'p',
			]
		);
	
		$this->end_controls_section();
		
		// Start styling section
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Style', 'elementor-if-widget' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		
		// Text color control
		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'elementor-if-widget' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-if-widget-output' => 'color: {{VALUE}};',
				],
			]
		);
		
		// Typography control
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .elementor-if-widget-output',
			]
		);
		
		// Additional styling controls can be added here (e.g., text alignment, etc.)
		
		// End styling section
		$this->end_controls_section();
	}



	protected function render() {
		$settings = $this->get_settings_for_display();
	
		// Retrieve values from settings
		$field_1 = $settings['field_1'];
		$field_2 = $settings['field_2'];
		$operator = $settings['operator'];
		$output_true = $settings['output_true'];
		$output_false = $settings['output_false'];
		$hide_output_false = $settings['hide_output_false'] === 'yes';
		$output_tag = tag_escape($settings['output_tag']); // Ensure the tag is safe to use
	
		// Perform comparison based on the operator
		$result = false;
		switch ($operator) {
			case 'equal':
				$result = ($field_1 == $field_2);
				break;
			case 'greater_than':
				$result = ($field_1 > $field_2);
				break;
			case 'less_than':
				$result = ($field_1 < $field_2);
				break;
		}
	
		// Output the result wrapped in the selected HTML tag
		echo "<{$output_tag} class='elementor-if-widget-output'>";
		if ($result) {
			echo $output_true; // Output if true
		} elseif (!$hide_output_false) {
			echo $output_false; // Output if false, and not hidden
		}
		echo "</{$output_tag}>";
	}

}

