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

// Define Paths
define( 'DBNH_TOOLKIT_PATH', __DIR__ );
define('DBNH_TOOLKIT_WIDGET_PATH', __DIR__ . '/includes/widgets/');
define('DBNH_TOOLKIT_INCLUDES', __DIR__ . '/includes/');

// Load widgets
require_once( DBNH_TOOLKIT_INCLUDES . 'dbnh_widget_loader.php');

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