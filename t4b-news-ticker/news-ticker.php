<?php
/*
 * Plugin Name:       T4B News Ticker
 * Plugin URI:        http://wordpress.org/plugins/t4b-news-ticker/
 * Description:       T4B News Ticker is a flexible and easy to use WordPress plugin that allow you to make horizontal News Ticker.
 * Version:           1.4.5
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Realwebcare
 * Author URI:        https://www.realwebcare.com/
 * Text Domain:       t4b-news-ticker
 * Domain Path:       /languages
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists('T4BNT_Index') ) {
    class T4BNT_Index {

        private static $instance;

        private function __construct() {
            // Define plugin-specific constants.
            $this->define_constants();

            // Load necessary required files.
            $this->required_files();
        }

        public static function get_instances() {
            if ( self::$instance ) {
                return self::$instance;
            }

            self::$instance = new self();

            return self::$instance;
        }

        /**
         * Defines essential plugin constants.
         *
         * This method sets up constants that are used throughout the plugin for easy access 
         * to important paths and URLs, ensuring a consistent and maintainable structure.
         *
         * Constants defined:
         * - `T4BNT_PLUGIN_PATH`: Absolute path to the plugin directory.
         * - `T4BNT_PLUGIN_URL`: URL to the plugin directory.
         * - `T4BNT_AUF`: Absolute path to the main plugin file.
         *
         * @return void
         */
        private function define_constants() {
			define( 'T4BNT_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
			define( 'T4BNT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			define( 'T4BNT_AUF', __FILE__ );
        }

        /**
         * Includes initialized files for the plugin.
         *
         * @return void
         */
        private function required_files() {
            // Initialize the plugin
            require_once T4BNT_PLUGIN_PATH . 'inc/init-t4bnt.php';
        }
    }
}

T4BNT_Index::get_instances();
