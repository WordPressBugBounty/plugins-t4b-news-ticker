<?php
/**
 * Class T4BNT_Help
 *
 * This file contains the help page for the "T4B News Ticker" plugin
 * in the admin panel. The help page provides YouTube video instructions, and
 * assistance to administrators on how to use shortcode of the plugin.
 *
 * @package T4B News Ticker v1.4.1 - 25 May, 2025
 * @link https://www.realwebcare.com/
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'T4BNT_Help' ) ) {
	class T4BNT_Help {

		/**
		 * Render the help page.
		 */
		public function render_t4bnt_help_page() { ?>
			<div class="t4bnt_settings_area">
				<div class="wrap t4bnt_settings">
					<h1 class="main-header">
						<?php esc_html_e('T4B News Ticker Guide', 't4b-news-ticker'); ?>
					</h1>
					<?php $this->render_t4bnt_help_content(); ?>
					<?php $this->render_t4bnt_dashboard_guide(); ?>
				</div>
				<?php $this->render_sidebar(); ?>
			</div>
			<?php
		}

		/**
		 * Render YouTube Video and Documentation
		 */
		public function render_t4bnt_help_content() {
			?>
			<div class="t4bnt-help-info">
				<p class="get-instructed">
					<?php
					printf(
						esc_html__(
						'Watch the Tutorial Video:',
						't4b-news-ticker'
					));
					?>
				</p>
				<p>
					<?php
					printf(
						/* translators: 1: Opening strong tag, 2: Closing strong tag */
						esc_html__('To help you get started with the T4B News Ticker plugin, we\'ve prepared a detailed tutorial video. This video is %1$s5 minutes and 42 seconds%2$s long and covers everything you need to know about how the plugin works, including setup, configuration, and advanced features.', 't4b-news-ticker'),
						'<strong>', '</strong>'
					); ?>
				</p>
				<p><?php esc_html_e( 'We highly recommend watching this video to make the most out of the T4B News Ticker plugin. If you have any questions after watching, feel free to reach out to our support team.', 't4b-news-ticker'); ?></p>
				<div class="getting-started_video">
					<p><iframe width="620" height="350" src="https://www.youtube-nocookie.com/embed/CX72IvU51SY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></p>
				</div>
			</div>
			<?php
		}

		/**
		 * Render instructions for creating a new user front-end dashboard.
		 */
		public function render_t4bnt_dashboard_guide() {
			?>
			<div class="t4bnt-help-info">
				<h3 class="get-instructed">
					<?php
					printf(
						esc_html__(
							'Code Usage Instruction in the Theme',
							't4b-news-ticker'
						));
					?>
				</h3>
				<ol class="t4bnt-help-instructions">
					<li>
						<?php
						printf(
							/* translators: 1: Opening strong tag, 2: Closing strong tag */
							esc_html__('To display a news ticker shortcode in a WordPress theme file, you can use the %1$sdo_shortcode%2$s function:', 't4b-news-ticker'), 
							'<strong>', '</strong>'
						); 
						?>
					</li>
					<li>
						<?php
						printf(
							/* translators: %s: Example of do_shortcode usage in a PHP code block */
							esc_html__('Example of shortcode usage in PHP: %s', 't4b-news-ticker'), 
							'<pre><code><span>&lt;?php</span> <span class="t4bnt-keyword">echo</span> <span class="t4bnt-function">do_shortcode</span>(<span class="t4bnt-string">\'[t4b-ticker]\'</span>); <span>?&gt;</span></code></pre>'
						);
						?>
					</li>
					<li>
						<?php
						printf(
							esc_html__('You can place this code anywhere in your theme file where you want the news ticker to appear. For example, you could place it in the template file for a specific page of your site.', 't4b-news-ticker')
						); 
						?>
					</li>
					<li>
						<?php
						printf(
							/* translators: 1: Opening strong tag, 2: Closing strong tag */
							esc_html__('Keep in mind that if you are making changes directly to your theme files, those changes will be overwritten if you update the theme. To avoid this, you can create a child theme and make your changes there instead.', 't4b-news-ticker'), 
							'<strong>', '</strong>'
						); 
						?>
					</li>
				</ol>
			</div>
			<?php
		}

		/**
		 * Render the sidebar.
		 */
		private function render_sidebar() {
			if (class_exists('T4BNT_Sidebar')) {
				$t4bnt_sidebar = T4BNT_Sidebar::get_instances();

				if ( method_exists( $t4bnt_sidebar, 't4bnt_sidebar' ) ) {
					// Render sidebar content
					$sidebar_content = $t4bnt_sidebar->t4bnt_sidebar( true, false, true );

					if ( $sidebar_content !== null ) {
						echo wp_kses_post( $sidebar_content );
					} else {
						// Fallback for null content
						echo ''; // or provide alternative content if needed
					}
				}
			}
		}
    }
}