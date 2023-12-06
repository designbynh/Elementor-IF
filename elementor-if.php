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

function elementor_if_widget_check_update($transient) {
	if (empty($transient->checked)) {
		return $transient;
	}

	$repository = 'designbynh/elementor-if'; // Replace with your GitHub repository
	$slug = 'elementor-if/elementor-if.php'; // Replace with your plugin slug and main file

	// GitHub API URL for the latest release
	$api_url = 'https://api.github.com/repos/' . $repository . '/releases/latest';
	$response = wp_remote_get($api_url, array(
		'headers' => array(
			'Accept' => 'application/vnd.github.v3+json'
		)
	));

	if (is_wp_error($response)) {
		return $transient;
	}

	$release = json_decode(wp_remote_retrieve_body($response));

	if (isset($release->tag_name) && version_compare($release->tag_name, $transient->checked[$slug], '>')) {
		// The URL to download the zip file of the release
		$package = $release->zipball_url;

		$transient->response[$slug] = array(
			'slug'        => $slug,
			'plugin'      => $slug,
			'new_version' => $release->tag_name,
			'package'     => $package,
		);
	}

	return $transient;
}

add_filter('site_transient_update_plugins', 'elementor_if_widget_check_update');
