<?php
/**
 * Class T4BNT_WP_Enqueue
 *
 * This class is responsible for enqueuing front-end styles and scripts.
 *
 * Methods:
 * - t4bnt_enqueue_script(): Enqueues the necessary CSS and JS files for the front-end.
 *
 * @package T4B News Ticker v1.4.0 - 10 February, 2025
 * @link https://www.realwebcare.com/
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'T4BNT_WP_Enqueue' ) ) {
    class T4BNT_WP_Enqueue {

        // Hold the single instance of the class.
        private static $instance;

        // Constructor is private to enforce the Singleton pattern.
        private function __construct() {
            // Hook to enqueue styles for the plugin.
            add_action( 'wp_enqueue_scripts', array( $this, 't4bnt_enqueue_script' ) );
        }

        // Public static method to retrieve the singleton instance.
        public static function get_instances() {
            if ( self::$instance ) {
                return self::$instance;
            }

            self::$instance = new self();

            return self::$instance;
        }

        // Enqueue styles for the plugin.
        public function t4bnt_enqueue_script() {
            $t4bnt_enable = sanitize_text_field( t4bnt_get_option( 'ticker_news', 't4bnt_general', 'on' ) );
            $ticker_effect = sanitize_text_field( t4bnt_get_option( 'ticker_effect', 't4bnt_advance', 'scroll' ) );
    
            if ( $t4bnt_enable == 'on' ) {
                if ( $ticker_effect == 'scroll' ) {
                    wp_enqueue_script( 't4bnt-script', T4BNT_PLUGIN_URL . 'assets/js/t4bnt.liscroll.js', array('jquery'), '1.4.0', true );
                } else {
                    wp_enqueue_script( 't4bnt-script', T4BNT_PLUGIN_URL . 'assets/js/t4bnt.atickers.js', array('jquery'), '1.4.0', true );
                }
                if ( $ticker_effect == 'scroll' ) {
                    wp_enqueue_style( 't4bnt-style', T4BNT_PLUGIN_URL . 'assets/css/t4bnt-styles.css', '', '1.4.0' );
                } else {
                    wp_enqueue_style( 't4bnt-style', T4BNT_PLUGIN_URL . 'assets/css/t4bnt-scroll.css', '', '1.4.0' );
                }
            }
        }
    }
}

// Instantiate the plugin class.
T4BNT_WP_Enqueue::get_instances();