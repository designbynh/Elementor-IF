<?php
namespace DBNHToolKit\Includes\DBNHWidgetLoader;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!class_exists('DBNH_Widget_Loader')) {

	class DBNH_Widget_Loader {

		private static $instance = null;

		public $localize_data = array();
		
		public function init() {
			add_action('elementor/widgets/register', array($this, 'add_widgets'));
		}
		
		public function add_widgets($widgets_manager) {
			// Define an array with widget class names
			// The values are the relative paths from the base path
			$widgets = [
				'DBNH_Elementor_Calculator_Widget' => 'DBNH_Elementor_Calculator_Widget',
				'DBNH_Elementor_IF_Widget' => 'DBNH_Elementor_IF_Widget',
				// Add more widget file names (without .php extension) here in the future
			];
		
			// Loop through the array and register each widget
			foreach ($widgets as $class => $filename) {
				$filepath = DBNH_TOOLKIT_WIDGET_PATH . $filename . '.php';
				if (file_exists($filepath)) {
					include_once $filepath;
					if (class_exists($class)) {
						$widgets_manager->register(new $class());
					}
				}
			}
		}



		public static function get_instance() {
			if (null == self::$instance) {
				self::$instance = new self();
			}
			return self::$instance;
		}
	}
}

function dbnh_widgets_include() {
	return DBNH_Widget_Loader::get_instance();
}

// Initialize the widget loader
dbnh_widgets_include()->init();
