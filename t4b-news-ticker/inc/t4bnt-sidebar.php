<?php
/**
 * Handles the display of the plugin sidebar content.
 *
 * The T4BNT_Sidebar class is responsible for rendering the plugin's shortcode usage 
 * instructions and additional plugin information in the admin dashboard sidebar. 
 * It provides flexibility to control the visibility of notes, plugin info, 
 * and allows for custom CSS class inclusion for styling.
 * 
 * @package T4B News Ticker v1.4.3 - 16 November, 2025
 * @link https://www.realwebcare.com/
 */
if (!defined('ABSPATH'))
    exit;

if (!class_exists('T4BNT_Sidebar')) {
    class T4BNT_Sidebar
    {
        private static $instance;

        private function __construct()
        {
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
         * Renders the plugin sidebar with shortcode usage and plugin information.
         *
         * @param mixed $show_promo Determines whether to display the pro version promotion. Default is true.
         * @param mixed $show_note Determines whether to display the shortcode usage instructions. Default is true.
         * @param mixed $show_info Determines whether to display the plugin information. Default is true.
         * @param mixed $class Optional. Custom CSS class for the sidebar container. Default is an empty string.
         * @return string
         */
        public function t4bnt_sidebar($show_promo = true, $show_note = true, $show_info = true, $class = '')
        {
            // Initialize content
            $content = '';

            // Add class if provided
            if (!empty($class)) {
                $class = ' ' . esc_attr($class);
            }

            $content .= '<div id="t4bnt-sidebar" class="postbox-container' . $class . '">';

            // Instruction section
            if ($show_note) {
                $content .= '<div id="t4bntusage-shortcode" class="t4bntusage-sidebar">
                    <h3>' . esc_html__('[/] Shortcode Usage Instruction', 't4b-news-ticker') . '</h3>
                    <div class="t4bnt">
                        <p class="t4bnt-first">' . esc_html__('To display a news ticker shortcode in a WordPress post or page, you need to access the post or page editor in the WordPress dashboard. Here\'s how:', 't4b-news-ticker') . '</p>
                        <ol>
                            <li>' . esc_html__('Go to Posts or Pages, depending on where you want to display the news ticker.', 't4b-news-ticker') . '</li>
                            <li>' . esc_html__('Either create a new post or page, or edit an existing one.', 't4b-news-ticker') . '</li>
                            <li>' . esc_html__('Switch to the visual editor if it\'s not already active.', 't4b-news-ticker') . '</li>
                            <li>' . esc_html__('Locate the spot in the post or page where you want to display the news ticker.', 't4b-news-ticker') . '</li>
                            <li class="t4b-scode">
                                ' . esc_html__('Paste the following shortcode into the editor:', 't4b-news-ticker') . '
                                <pre><code>[t4b-ticker]</code></pre>
                                <span class="copy-tooltip" id="t4bntTooltip">' . esc_html__('Click to Copy Shortcode!', 't4b-news-ticker') . '</span>
                            </li>
                            <li>' . esc_html__('Save or publish the post or page.', 't4b-news-ticker') . '</li>
                        </ol>
                        <p>' . esc_html__('Once you\'ve saved or published the post or page, the news ticker shortcode will be processed and the news ticker will be displayed on the front end of your site.', 't4b-news-ticker') . '</p>
                        <p><a class="btn-demo btn-top" href="' . esc_url('https://sandbox.realwebcare.com/sandbox-demo-creator-t4b-news-ticker/') . '" target="_blank">Test Drive Pro</a></p>
                    </div>
                </div>';
            }

            // Promotion section
            if ($show_promo) {
                $content .= '<div id="t4bntusage-features" class="t4bntusage-sidebar">' .
                    sprintf(
                        /* translators: 
                        %1s: URL for the Pro version image.
                        %2s: URL for the T4B News Ticker Pro product page.
                        %3s: URL for the demo page of T4B News Ticker Pro.
                        */
                        __(
                            '<div class="t4bntusage-feature-header">
                                <img src="%1$s" alt="T4BNT Pro">
                            </div>
                            <div class="t4bntusage-feature-body">
                                <h3>T4B News Ticker Pro Features</h3>
                                <div class="t4bnt">Pro version has been developed to present News Ticker more proficiently. Some of the most notable features are:</div>
                                <a class="btn-demo btn-top" href="%2$s" target="_blank">Test Drive Pro</a>
                                <ul class="t4bntusage-list">
                                    <li>Customization Made Effortless.</li>
                                    <li>7 impressive animation effects.</li>
                                    <li>Instant Creation with 12 Pre-made Designs.</li>
                                    <li>Continuous Scroll Without Interruption.</li>
                                    <li>Import/Export (Backup) news ticker.</li>
                                    <li>Make a copy of a ticker instantly.</li>
                                    <li>Choose ticker contents from multiple categories.</li>
                                    <li>RSS Feed and JSON Display.</li>
                                    <li>Fix the ticker at the top or bottom of the page.</li>
                                    <li>RTL (Right to Left) Language Support.</li>
                                    <li>Google Fonts and Font Awesome Support.</li>
                                    <li>Click <a href="%3$s" target="_blank">here</a> to learn more...</li>
                                </ul>
                                <a class="btn-demo" href="%4$s" target="_blank">Pro Demo</a>
                            </div>',
                            't4b-news-ticker'
                        ),
                        esc_url(T4BNT_PLUGIN_URL . 'assets/images/template-pro.png'),
                        esc_url('https://sandbox.realwebcare.com/sandbox-demo-creator-t4b-news-ticker/'),
                        esc_url('https://www.realwebcare.com/item/t4b-news-ticker-pro-best-scrolling-news-ticker/'),
                        esc_url('https://www.realwebcare.com/demo/?product_id=t4b-news-ticker-pro')
                    ) . '</div>';
            }

            // Plugin Info section
            if ($show_info) {
                $content .= '<div id="t4bntusage-info" class="t4bntusage-sidebar">' .
                    sprintf(
                        /* translators: %1$s: URL for Realwebcare website, %2$s: URL for Realwebcare Facebook page, %3$s: URL for plugin support page, %4$s: URL for plugin review page */
                        __(
                            '<h3>Plugin Info</h3>
                            <ul class="t4bntusage-list">
                                <li>T4B News Ticker</li>
                                <li>Version: 1.4.3</li>
                                <li>Scripts: PHP + CSS + JS</li>
                                <li>Requires: WordPress 5.4+</li>
                                <li>First release: 29 December, 2014</li>
                                <li>Last Update: 16 November, 2025</li>
                                <li>By: <a href="%1$s" target="_blank">Realwebcare</a></li>
                                <li>Facebook Page: <a href="%2$s" target="_blank">Realwebcare</a></li>
                                <li>Need Help? <a href="%3$s" target="_blank">Support</a> | <a href="%4$s" target="_blank">Dedicated Support</a></li>
                                <li>Like it? Please leave us a <a target="_blank" href="%5$s">★★★★★</a> rating. We highly appreciate your support!</li>
                            </ul>',
                            't4b-news-ticker'
                        ),
                        esc_url('https://www.realwebcare.com/'),
                        esc_url('https://www.facebook.com/realwebcare'),
                        esc_url('https://wordpress.org/support/plugin/t4b-news-ticker/'),
                        esc_url('https://www.realwebcare.com/billing/submitticket.php?step=2&deptid=6'),
                        esc_url('https://wordpress.org/support/plugin/t4b-news-ticker/reviews/?filter=5/#new-post')
                    ) . '</div>';
            }

            $content .= '</div>';

            return wp_kses_post($content);
        }
    }
}
