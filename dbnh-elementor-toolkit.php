<?php
/**
 * Plugin Name: DBNH Elementor Kit
 * Description: A Tool Kit for Elementor.
 * Version:     1.0.5
 * Author:      Design by NH
 */
// This is a test, another test.
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Register the Elementor IF Widget
function register_elementor_if_widget( $widgets_manager ) {

	require_once( __DIR__ . '/includes/widgets/DBNH_Elementor_IF_Widget.php' );

	$widgets_manager->register( new \DBNH_Elementor_IF_Widget() );

}
add_action( 'elementor/widgets/register', 'register_elementor_if_widget' );

// Register the Elementor Calculator Widget
function register_elementor_calculator_widget( $widgets_manager ) {

	require_once( __DIR__ . '/includes/widgets/DBNH_Elementor_Calculator_Widget.php' );

	$widgets_manager->register( new \DBNH_Elementor_Calculator_Widget() );

}
add_action( 'elementor/widgets/register', 'register_elementor_calculator_widget' );

// Auto Update Feature
require 'includes/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/designbynh/dbnh-elementor-toolkit/',
	__FILE__,
	'dbnh-elementor-toolkit'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('master');