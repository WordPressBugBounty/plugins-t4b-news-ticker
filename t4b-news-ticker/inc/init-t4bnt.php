<?php
/**
 * Class T4BNT_Init
 *
 * This file contains functions that play a crucial role in the initial setup
 * of the "T4B News Ticker" plugin. These functions handle tasks such as
 * text domain setup for translations, adding action links to the plugin settings,
 * and various other essential tasks needed when the plugin is live at the front-end.
 *
 * @package T4B News Ticker v1.4.3 - 16 November, 2025
 * @link https://www.realwebcare.com/
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('T4BNT_Init')) {
    class T4BNT_Init
    {

        private static $instance;

        public function __construct()
        {
            // Load necessary required files.
            $this->required_files();

            /// Load plugin text domain
            add_action('plugins_loaded', array($this, 't4bnt_textdomain'));

            // Init admin notice for review
            add_action('admin_init', array($this, 't4bnt_check_i10n_date'));

            // Init to remove admin notice
            add_action('admin_init', array($this, 't4bnt_review_nt'), 5);

            // This filter allows us to modify the action links displayed on the Plugins page
            add_filter('plugin_action_links_' . plugin_basename(T4BNT_AUF), array($this, 't4bnt_plugin_actions'));
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
         * Includes required files for the plugin's functionality.
         *
         * This method loads the necessary PHP files that provide core functionality for the plugin. 
         * By requiring these files, the plugin ensures that all actions, options, and shortcodes 
         * are properly initialized and available.
         *
         * @return void
         */
        private function required_files()
        {
            // Handles the enqueueing of scripts and styles.
            require_once T4BNT_PLUGIN_PATH . 'inc/t4bnt-enqueue.php';

            // Initializes any additional functions required by the plugin.
            require_once T4BNT_PLUGIN_PATH . 'actions/t4bnt-functions.php';

            // Help file of the plugin
            require_once T4BNT_PLUGIN_PATH . 'inc/t4bnt-help.php';

            // Sidebar of the plugin
            require_once T4BNT_PLUGIN_PATH . 'inc/t4bnt-sidebar.php';

            // Contains options and settings logic for the plugin.
            require_once T4BNT_PLUGIN_PATH . 'settings/ticker-settings.php';

            // Manages shortcodes for user interactions.
            require_once T4BNT_PLUGIN_PATH . 'actions/ticker-shortcode.php';
        }

        /**
         * Load the plugin text domain for translation.
         *
         * This function loads the `.mo` files for translating the plugin
         * into the user's current locale.
         *
         * @return void
         */
        public function t4bnt_textdomain()
        {
            $locale = apply_filters('plugin_locale', get_locale(), 't4b-news-ticker');
            load_textdomain('t4b-news-ticker', T4BNT_PLUGIN_PATH . 't4b-news-ticker/languages/t4b-news-ticker-' . $locale . '.mo');
        }

        /* Add plugin action links */
        public function t4bnt_plugin_actions($links)
        {
            $create_ticker_url = esc_url(menu_page_url('t4bnt-settings', false));
            $create_ticker_url = wp_nonce_url($create_ticker_url, 't4bnt_create_ticker_action');

            $support_url = esc_url("https://wordpress.org/support/plugin/t4b-news-ticker");

            $links[] = '<a href="' . $create_ticker_url . '">' . esc_html__('Settings', 't4b-news-ticker') . '</a>';
            $links[] = '<a href="' . $support_url . '" target="_blank">' . esc_html__('Support', 't4b-news-ticker') . '</a>';

            return $links;
        }

        /**
         * Check date on admin initiation and add to admin notice if it was over 7 days ago.
         * @return null
         */
        public function t4bnt_check_i10n_date()
        {
            // Retrieve the 'review_nt' option
            $review_nt = get_option('t4bnt_review_nt', false);

            // Proceed only if 'review_nt' is not set
            if (!$review_nt) {
                // Retrieve the 'i10n_date' option and set a default value if not found
                $i10n_date = get_option('t4bnt_activation_time', false);

                // Calculate the past date for the threshold (7 days in seconds: 7 * 24 * 60 * 60)
                $past_date = strtotime('-7 days');

                // Validate the 'i10n_date' and compare it with the threshold
                if ($i10n_date && is_numeric($i10n_date) && $i10n_date < $past_date) {
                    // If the condition is met, display the admin notice
                    add_action('admin_notices', array($this, 't4bnt_display_admin_notice'));
                } else {
                    // Otherwise, store the current timestamp as the activation time
                    $current_time = time(); // Current timestamp
                    update_option('t4bnt_activation_time', $current_time);
                }
            }
        }

        /**
         * Display Admin Notice, asking for a review
         **/
        public function t4bnt_display_admin_notice()
        {
            // WordPress global variable
            global $pagenow;

            // Validate current admin page and query parameters
            if (is_admin() && $pagenow === 'admin.php' && isset($_GET['page']) && sanitize_text_field(wp_unslash($_GET['page'])) === 't4bnt-settings') {

                // Generate URLs with proper escaping
                $dont_disturb = esc_url_raw(admin_url('admin.php?page=t4bnt-settings&review_nt=1'));
                $dont_disturb = wp_nonce_url($dont_disturb, 't4bnt_disturb_action');

                // Retrieve plugin data securely
                $plugin_info = get_plugin_data(T4BNT_AUF, true, true);

                // Validate and sanitize plugin data
                $plugin_name = esc_html__('T4B News Ticker', 't4b-news-ticker');
                $text_domain = !empty($plugin_info['TextDomain']) ? sanitize_title($plugin_info['TextDomain']) : 't4b-news-ticker';

                // Construct the review URL securely
                $review_url = 'https://wordpress.org/support/plugin/' . $text_domain . '/reviews/';
                $review_url = wp_nonce_url($review_url, 't4bnt_review_action');

                // Output the notice with proper escaping
                printf(
                    '<div id="t4bnt-review" class="notice notice-success is-dismissible">
                        <p>%1$s</p>
                        <p>%2$s</p>
                        <div class="t4bnt-review-btn">
                            <a href="%3$s" class="button button-primary" target="_blank">%4$s</a>
                            <a href="%5$s" class="t4bnt-grid-review-done button button-secondary">%6$s</a>
                        </div>
                    </div>',
                    esc_html__( 'It\'s been 7 days since your last update or installation of the latest version of ', 't4b-news-ticker' ) . '<b>' . esc_html( $plugin_name ) . '</b>' . esc_html__( '! We hope you\'ve had a positive experience so far.', 't4b-news-ticker' ),
                    esc_html__( 'Your feedback is important to us and can help us improve. If you enjoy our plugin, please leave a quick review!', 't4b-news-ticker' ),
                    esc_url( $review_url ),
                    esc_html__( 'Leave a Review', 't4b-news-ticker' ),
                    esc_url( $dont_disturb ),
                    esc_html__( 'Already Left a Review', 't4b-news-ticker' )
                );
            }
        }

        /**
         * remove the notice for the user if review already done or if the user does not want to
         **/
        public function t4bnt_review_nt()
        {
            // Check if 'review_nt' parameter is set and not empty
            if (isset($_GET['review_nt']) && !empty($_GET['review_nt'])) {
                // Sanitize the input value to ensure it is safe to use
                $review_nt = sanitize_text_field(wp_unslash($_GET['review_nt']));

                // Validate the value to check if it is the expected value
                if ($review_nt === '1') {
                    // Add the 't4bnt_review_nt' option with a boolean value
                    add_option('t4bnt_review_nt', true);
                }
            }
        }
    }
}

T4BNT_Init::get_instances();