<?php
/**
 * Plugin Name: DBNH Elementor Kit
 * Description: A Tool Kit for Elementor.
 * Version:     1.0.4
 * Author:      Design by NH
 */
// This is a test, another test.
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Register the Elementor IF Widget
function register_elementor_if_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/if-widget.php' );

	$widgets_manager->register( new \Elementor_IF_Widget() );

}
add_action( 'elementor/widgets/register', 'register_elementor_if_widget' );

// Auto Update Feature
require 'includes/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/designbynh/elementor-if/',
	__FILE__,
	'elementor-if'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');