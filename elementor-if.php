<?php
/**
 * Plugin Name: Elementor IF Widget
 * Description: Conditional IF widget for Elementor.
 * Version:     1.0.0
 * Author:      Your Name
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function register_elementor_if_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/if-widget.php' );

	$widgets_manager->register( new \Elementor_IF_Widget() );

}
add_action( 'elementor/widgets/register', 'register_elementor_if_widget' );

require 'includes/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/designbynh/elementor-if/',
	__FILE__,
	'elementor-if'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');

//Optional: If you're using a private repository, specify the access token like this:
$myUpdateChecker->setAuthentication('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');