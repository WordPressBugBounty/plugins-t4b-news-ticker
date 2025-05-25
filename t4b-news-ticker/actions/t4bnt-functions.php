<?php
/**
 * Class T4BNT_Functions
 *
 * This class handles various functionalities for the T4B News Ticker plugin.
 * It includes methods for modifying the ticker query, retrieving post categories,
 * and generating JavaScript for ticker effects.
 *
 * @package T4B News Ticker v1.4.1 - 25 May, 2025
 * @link https://www.realwebcare.com/
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('T4BNT_Functions')) {
    class T4BNT_Functions
    {

        private static $instance;

        private function __construct()
        {
            add_action('pre_get_posts', array($this, 't4bnt_modify_ticker_query'));
        }

        public static function get_instances()
        {
            if (self::$instance) {
                return self::$instance;
            }

            self::$instance = new self();

            return self::$instance;
        }

        /**
         * Modifies the main query for news ticker posts.
         * This function ensures that the ticker posts query is not modified on category and tag pages.
         * It is hooked into the 'pre_get_posts' action to filter the query before it's executed.
         *
         * @param WP_Query $query The query object that is being modified.
         * @return void
         */
        function t4bnt_modify_ticker_query($query)
        {
            // Check if it's not the admin area, it's the main query, and the page is either a category or tag page
            if (!is_admin() && $query->is_main_query() && ($query->is_category() || $query->is_tag())) {
                return; // Do not alter the main query on category and tag pages
            }
        }

        public function t4bnt_sanitize_float($value, $option)
        {
            $value = floatval($value);
            $min = isset($option['min']) ? floatval($option['min']) : 0.01;
            $max = isset($option['max']) ? floatval($option['max']) : 1;
            $default = isset($option['default']) ? floatval($option['default']) : 0.05;

            // Ensure value is within min/max range, fallback to default if invalid
            if ($value < $min || $value > $max) {
                return $default;
            }
            return $value;
        }

        /**
         * Retrieves and displays the post categories.
         *
         * This method fetches the categories of posts based on specific order criteria.
         * It can be used to display a checklist of categories in the ticker settings.
         *
         * @param string $orderby The parameter to order categories by (defaults to 'name').
         * @param string $order The direction of the ordering, either 'asc' or 'desc'. Defaults to 'desc'.
         * @return array The list of categories based on the specified parameters.
         */
        public function t4bnt_render_category_checklist()
        {
            $args = array(
                'orderby' => 'name',
                'order' => 'DESC',
            );

            $post_categories = get_categories($args);
            $categories = array("Select a category");

            foreach ($post_categories as $category) {
                $categories[$category->cat_ID] = $category->name;
            }

            return $categories;
        }

        /**
         * Generates the JavaScript for the scroll effect of the news ticker.
         *
         * @param array $settings An associative array of settings for the ticker. Default settings include:
         * 		- 'speed' (scroll speed)
         *      - 'control' (whether to show scroll controls)
         * @return string The JavaScript code to enable the scroll effect.
         */
        function t4bnt_scroll_ticker_script($settings = array())
        {
            $script = 'jQuery(function($) {';
            $script .= '$("#ticker").liScroll({';
            $script .= 'travelocity: ' . esc_js($settings['speed']) . ',';
            if (isset($settings['control']) && $settings['control'] == 'on') {
                $script .= 'showControls: true';
            }
            $script .= '});';
            $script .= '});';

            // error_log('T4BNT: Scroll ticker script generated: ' . $script);
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
        function t4bnt_non_scroll_switch($settings = array())
        {
            $script = 'jQuery(function($) {';
            $script .= '$("#ticker").ticker({';
            $script .= 'speed: ' . esc_js($settings['speed']) . ',';
            $script .= 'titleText: "' . esc_js($settings['title']) . '",';
            $script .= 'displayType: "' . esc_js($settings['effect']) . '",';
            $script .= 'pauseOnItems: ' . esc_js($settings['timeout']) . ',';
            $script .= '});';
            $script .= '});';

            // error_log('T4BNT: Non-scroll ticker script generated: ' . $script);
            return $script;
        }
    }
}

// T4BNT_Functions::get_instances();