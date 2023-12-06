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

