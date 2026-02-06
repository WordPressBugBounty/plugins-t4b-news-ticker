<?php
/*
 * Plugin Name:       T4B News Ticker
 * Plugin URI:        http://wordpress.org/plugins/t4b-news-ticker/
 * Description:       T4B News Ticker is a flexible and easy to use WordPress plugin that allow you to make horizontal News Ticker.
 * Version:           1.4.3
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
            add_action( 'plugins_loaded', array( $this, 't4bnt_check_version' ) );

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
         * Checks and updates plugin options if the installed version is lower than the required version.
         *
         * This function runs when the plugin is loaded. If the stored plugin version is older than
         * the specified version (1.4.0), it migrates existing options to the new format and updates
         * the version in the database to prevent re-running the migration in future updates.
         *
         * @return void
         */
        public function t4bnt_check_version() {
            $current_version = '1.4.3'; // Set to the version that requires updates
            $saved_version = get_option( 't4bnt_plugin_version', '' ); // Handle missing option
        
            // Run only for users below 1.4.0
            if ( empty($saved_version) || version_compare($saved_version, '1.4.3', '<') ) {
                // Perform required option updates (only needed once)
                $old_version_options = get_option( 't4bnt_general' );

                $t4bnt_general = array(
                    'ticker_news' => '', 'ticker_home' => '', 'ticker_taxon' => '', 'ticker_title' => '', 'ticker_ntab' => '', 'hide_notice' => '',
                );

                $t4bnt_content = array(
                    'ticker_type' => '', 'ticker_cat' => '', 'ticker_tag' => '', 'ticker_postno' => '', 'ticker_order' => '', 'ticker_order_by' => '', 'ticker_custom' => '',
                );

                $t4bnt_advance = array(
                    'ticker_effect' => '', 'ticker_fadetime' => '', 'scroll_control' => '', 'scroll_speed' => '', 'reveal_speed' => '',
                );

                if ( is_array( $old_version_options ) ) {
                    foreach ( $old_version_options as $key => $value ) :
                        if ( array_key_exists( $key, $t4bnt_general ) ) {
                            $t4bnt_general[$key] = $value;
                        } elseif ( array_key_exists( $key, $t4bnt_content ) ) {
                            $t4bnt_content[$key] = $value;
                        } else {
                            $t4bnt_advance[$key] = $value;
                        }
                    endforeach;
                }

                // Save the old options in the new version way
                update_option( 't4bnt_general', $t4bnt_general );
                update_option( 't4bnt_content', $t4bnt_content );
                update_option( 't4bnt_advance', $t4bnt_advance );
        
                // Save the new version to prevent running this again
                update_option('t4bnt_plugin_version', $current_version);
            }
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
