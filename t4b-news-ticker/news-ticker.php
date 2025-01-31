<?php
/*
 * Plugin Name:       T4B News Ticker
 * Plugin URI:        http://wordpress.org/plugins/t4b-news-ticker/
 * Description:       T4B News Ticker is a flexible and easy to use WordPress plugin that allow you to make horizontal News Ticker.
 * Version:           1.3.4
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Realwebcare
 * Author URI:        https://www.realwebcare.com/
 * Text Domain:       t4b-news-ticker
 * Domain Path:       /languages
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Main plugin file that initializes and manages the "T4B News Ticker" plugin.
 * @package T4B News Ticker v1.3.4 - 31 January, 2025
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'T4BNT_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'T4BNT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'T4BNT_AUF', __FILE__ );

require_once T4BNT_PLUGIN_PATH . 'inc/ticker-admin.php';

/* Internationalization */
if ( !function_exists('t4bnt_textdomain') ) {
	function t4bnt_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 't4b-news-ticker' );
		load_textdomain( 't4b-news-ticker', trailingslashit( WP_PLUGIN_DIR ) . 't4b-news-ticker/languages/t4b-news-ticker-' . $locale . '.mo' );
		load_plugin_textdomain( 't4b-news-ticker', false, plugin_dir_path( __FILE__ ) . 'languages' );
	}
}
add_action( 'init', 't4bnt_textdomain' );

/* Add plugin action links */
if (!function_exists('t4bnt_plugin_actions')) {
	function t4bnt_plugin_actions( $links ) {
        $create_ticker_url = esc_url( menu_page_url('t4bnt-settings', false) );
        $create_ticker_url = wp_nonce_url( $create_ticker_url, 't4bnt_create_ticker_action' );

        $support_url = esc_url("https://wordpress.org/support/plugin/t4b-news-ticker");

        $links[] = '<a href="'. $create_ticker_url .'">'. esc_html__( 'Settings', 't4b-news-ticker' ) .'</a>';
        $links[] = '<a href="'. $support_url .'" target="_blank">'. esc_html__( 'Support', 't4b-news-ticker' ) .'</a>';

		return $links;
	}
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 't4bnt_plugin_actions' );

/* Enqueue CSS & JS For Admin */
if (!function_exists('t4bnt_admin_adding_style')) {
	function t4bnt_admin_adding_style() {
		wp_enqueue_script( 't4bnt-admin', T4BNT_PLUGIN_URL . 'assets/js/t4bnt_admin.js', array('jquery'), '1.3.4', true );
		wp_enqueue_style( 't4bnt-admin-style', T4BNT_PLUGIN_URL . 'assets/css/t4bnt_admin.css', '', '1.3.4' );
	}
}
add_action( 'admin_enqueue_scripts', 't4bnt_admin_adding_style' );

/* Registering plugin activation hooks */
register_activation_hook( __FILE__, 't4bnt_set_activation_time' );

/* Enqueue front js and css files */
if ( !function_exists('t4bnt_enqueue_scripts') ) {
	function t4bnt_enqueue_scripts() {
		$t4bnt_enable = t4bnt_get_option( 'ticker_news', 't4bnt_general', 'yes' );		
		$ticker_effect = t4bnt_get_option( 'ticker_effect', 't4bnt_general', 'scroll' );

		if ( $t4bnt_enable == 'on' ) {
			if ( $ticker_effect == 'scroll' ) {
				wp_enqueue_script( 't4bnt-liscroll', T4BNT_PLUGIN_URL . 'assets/js/jquery.liscroll.js', array('jquery'), '1.3.4', true );
			} else {
				wp_enqueue_script( 't4bnt-ticker', T4BNT_PLUGIN_URL . 'assets/js/jquery.ticker.js', array('jquery'), '1.3.4', true );
			}
			if ( $ticker_effect == 'scroll' ) {
				wp_enqueue_style( 't4bnewsticker', T4BNT_PLUGIN_URL . 'assets/css/t4bnewsticker.css', '', '1.3.4' );
			} else {
				wp_enqueue_style( 'tickerstyle', T4BNT_PLUGIN_URL . 'assets/css/ticker-style.css', '', '1.3.4' );
			}
		}
	}
}
add_action( 'wp_enqueue_scripts', 't4bnt_enqueue_scripts' );

/**
 * Modifies the main query for news ticker posts.
 * This function ensures that the ticker posts query is not modified on category and tag pages.
 * It is hooked into the 'pre_get_posts' action to filter the query before it's executed.
 *
 * @param WP_Query $query The query object that is being modified.
 * @return void
 */
function t4bnt_modify_ticker_query( $query ) {
    // Check if it's not the admin area, it's the main query, and the page is either a category or tag page
    if ( ! is_admin() && $query->is_main_query() && ( $query->is_category() || $query->is_tag() ) ) {
        return; // Do not alter the main query on category and tag pages
    }
}
add_action( 'pre_get_posts', 't4bnt_modify_ticker_query' );

/**
 * Generates the JavaScript for the scroll effect of the news ticker.
 *
 * @param array $settings An associative array of settings for the ticker. Default settings include:
 * 		- 'speed' (scroll speed)
 *      - 'control' (whether to show scroll controls)
 * @return string The JavaScript code to enable the scroll effect.
 */
function t4bnt_scroll_ticker_script( $settings = array() ) {
	$script  = 'jQuery(function($) {';
	$script .= '$("#ticker").liScroll({';
	$script .= 'travelocity: '. esc_js( $settings['speed'] ) . ',';
	if ( isset( $settings['control'] ) && $settings['control'] == 'on' ) {
		$script .= 'showControls: true';
	}
	$script .= '});';
	$script .= '});';

	return $script;
}

/**
 * Generates the JavaScript for the non-scroll (ticker) effect of the news ticker.
 *
 * @param array $settings An associative array of settings for the ticker. Default settings include:
 *		- 'speed' (ticker animation speed)
 *      - 'title' (ticker title text)
 *      - 'effect' (type of animation effect)
 *      - 'timeout' (pause duration between items)
 * @return string The JavaScript code to enable the ticker effect.
 */
function t4bnt_non_scroll_switch( $settings = array() ) {
	$script  = 'jQuery(function($) {';
	$script .= '$("#ticker").ticker({';
	$script .= 'speed: '. esc_js( $settings['speed'] ) . ',';
	$script .= 'titleText: "'. esc_js( $settings['title'] ) . '",';
	$script .= 'displayType: "'. esc_js( $settings['effect'] ) . '",';
	$script .= 'pauseOnItems: '. esc_js( $settings['timeout'] ) . ',';
	$script .= '});';
	$script .= '});';

	return $script;
}
