<?php
/**
 * Class T4BNT_Settings_Config
 *
 * This class handles the plugin's settings configuration in the WordPress admin dashboard. 
 * It utilizes the Settings API to create and manage settings sections, fields, and pages.
 * It also includes functionality for displaying a help page, adding menu items, and retrieving pages.
 * 
 * @package T4B News Ticker v1.4.1 - 25 May, 2025
 * @link https://www.realwebcare.com/
 */
if (!defined('ABSPATH'))
	exit;

if (!class_exists('T4BNT_Settings_Config')):
	class T4BNT_Settings_Config
	{

		private $settings_api;
		private $get_functions;
		private $sidebar_info;

		public function __construct()
		{
			// Load necessary required files.
			$this->required_files();

			// Access the Settings API
			$this->settings_api = new T4BNT_WeDevs_Settings_API;

			// Access the Functions
			$this->get_functions = T4BNT_Functions::get_instances();

			// Access the Sidebar
			$this->sidebar_info = T4BNT_Sidebar::get_instances();

			// Sets up the settings sections and fields
			add_action('admin_init', array($this, 'admin_init'));

			// Plugin's menu and submenu
			add_action('admin_menu', array($this, 'admin_menu'));
		}

		/**
		 * Includes necessary files for the settings API and sidebar classes.
		 *
		 * This method ensures that the required dependencies for the settings API and 
		 * sidebar functionalities are properly loaded.
		 *
		 * @return void
		 */
		private function required_files()
		{
			// Settings API wrapper class
			require_once T4BNT_PLUGIN_PATH . 'settings/t4bnt-class.settings-api.php';
		}


		/**
		 * Initializes the plugin's settings sections and fields.
		 *
		 * This method sets up the settings sections and fields using the settings API
		 * and registers them for use in the admin panel.
		 *
		 * @return void
		 */
		public function admin_init()
		{
			//set the settings
			$this->settings_api->set_sections($this->get_settings_sections());
			$this->settings_api->set_fields($this->get_settings_fields());

			//initialize settings
			$this->settings_api->admin_init();
		}

		public function admin_menu()
		{
			add_menu_page(
				esc_html__('T4B News Ticker', 't4b-news-ticker'),
				esc_html__('T4B Ticker', 't4b-news-ticker'),
				'administrator',
				't4bnt-settings',
				array($this, 't4bnt_options_page'),
				'dashicons-align-left',
				66
			);

			// Options
			add_submenu_page(
				't4bnt-settings',
				esc_html__('T4B News Ticker Options', 't4b-news-ticker'),
				esc_html__('T4B News Ticker', 't4b-news-ticker'),
				'administrator',
				't4bnt-settings',
				array($this, 't4bnt_options_page')
			);

			// Help
			add_submenu_page(
				't4bnt-settings',
				esc_html__('T4B News Ticker Guide', 't4b-news-ticker'),
				esc_html__('Help', 't4b-news-ticker'),
				'administrator',
				't4bnt-help',
				array($this, 't4bnt_help_page')
			);
		}

		/**
		 * Retrieves all the settings sections for the plugin.
		 *
		 * This method defines and returns the sections used in the plugin's settings page.
		 * Each section contains a unique ID and a title, which are displayed in the settings interface.
		 *
		 * @return array Array of settings sections with their IDs and titles.
		 */
		public function get_settings_sections()
		{
			$sections = array(
				array(
					'id' => 't4bnt_general',
					'title' => __('General Settings', 't4b-news-ticker')
				),
				array(
					'id' => 't4bnt_content',
					'title' => __('Ticker Contents', 't4b-news-ticker')
				),
				array(
					'id' => 't4bnt_advance',
					'title' => __('Advance Settings', 't4b-news-ticker')
				)
			);
			return $sections;
		}

		/**
		 * Retrieves all the settings fields from the settings API class.
		 *
		 * This method provides the list of settings fields configured in the plugin's settings API.
		 *
		 * @return array Array of settings fields.
		 */
		public function get_settings_fields()
		{
			$settings_fields = array(
				't4bnt_general' => array(
					array(
						'name' => 'ticker_news',
						'label' => __('Enable Ticker', 't4b-news-ticker'),
						'desc' => __('Mark if you want to show News Ticker.', 't4b-news-ticker'),
						'type' => 'checkbox',
						'default' => 'on',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name' => 'ticker_home',
						'label' => __('Show in Homepage Only', 't4b-news-ticker'),
						'desc' => __('Select if you want to show the News Ticker only in homepage.', 't4b-news-ticker'),
						'type' => 'checkbox',
						'default' => 'off',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name' => 'ticker_taxon',
						'label' => __('Disable on Tag/Category Page', 't4b-news-ticker'),
						'desc' => __('Select if you want to hide the ticker on tags and category archive page', 't4b-news-ticker'),
						'type' => 'checkbox',
						'default' => 'off',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name' => 'ticker_title',
						'label' => __('Enter Ticker Title', 't4b-news-ticker'),
						'desc' => __('Enter a title for the News Ticker', 't4b-news-ticker'),
						'placeholder' => __('News Ticker', 't4b-news-ticker'),
						'type' => 'text',
						'default' => 'Trending Now',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name' => 'ticker_ntab',
						'label' => __('Open in New Tab', 't4b-news-ticker'),
						'desc' => __('Select if you want to open link in new tab.', 't4b-news-ticker'),
						'type' => 'checkbox',
						'default' => 'off',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name' => 'hide_notice',
						'label' => __('Hide Disabled Ticker Notification', 't4b-news-ticker'),
						'desc' => __('Enable this option to hide the notification when the ticker is disabled or set to display only on the homepage but is not active there.', 't4b-news-ticker'),
						'type' => 'checkbox',
						'default' => 'on',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name' => 't4bnt_delall',
						'label' => __('Delete All on Uninstall:', 't4b-news-ticker'),
						'desc' => __('Check this box to delete all plugin data upon uninstall.', 't4b-news-ticker'),
						'type' => 'checkbox',
						'default' => 'off',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name' => 't4bnt_caution',
						'desc' => __('<h5>Caution: Deleting Plugin Data on Uninstall</h5><p>Enabling the <strong>Delete All on Uninstall</strong> option will permanently erase all <strong>plugin-related settings</strong> and <strong>user metadata</strong> when the plugin is uninstalled.</p><p>This action is irreversible. Ensure you back up important data before enabling this option. If you are unsure, we recommend leaving this option unchecked to preserve your data.</p>', 't4b-news-ticker'),
						'type' => 'html',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name' => 't4bnt_gapgen',
						'desc' => '',
						'type' => 'html'
					),
				),
				't4bnt_content' => array(
					array(
						'name' => 'ticker_type',
						'label' => __('Show News Ticker By', 't4b-news-ticker'),
						'desc' => '',
						'type' => 'radio',
						'default' => 'category',
						'options' => array(
							'category' => 'Categories',
							'tag' => 'Tags',
							'custom' => 'Custom Text'
						),
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name' => 'ticker_cat',
						'label' => __('News Ticker Categories', 't4b-news-ticker'),
						'desc' => __('Select a category for News Ticker to show.', 't4b-news-ticker'),
						'type' => 'select',
						'default' => 0,
						'options' => $this->get_functions->t4bnt_render_category_checklist(),
						'sanitize_callback' => 'absint'
					),
					array(
						'name' => 'ticker_tag',
						'label' => __('Select News Ticker Tags', 't4b-news-ticker'),
						'desc' => __('Select tag names seprated by comma.', 't4b-news-ticker'),
						'placeholder' => '',
						'type' => 'textarea',
						'sanitize_callback' => 'sanitize_textarea_field'
					),
					array(
						'name' => 'ticker_postno',
						'label' => __('Number of Post', 't4b-news-ticker'),
						'desc' => __('Number of post to show. Default -1, means show all.', 't4b-news-ticker'),
						'placeholder' => __('10', 't4b-news-ticker'),
						'min' => -1,
						'max' => 100,
						'type' => 'number',
						'default' => -1,
						'sanitize_callback' => 'intval'
					),
					array(
						'name' => 'ticker_order',
						'label' => __('Select Post Order', 't4b-news-ticker'),
						'desc' => '',
						'type' => 'select',
						'default' => 'DESC',
						'options' => array(
							'ASC' => __('Ascending', 't4b-news-ticker'),
							'DESC' => __('Descending', 't4b-news-ticker')
						),
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name' => 'ticker_order_by',
						'label' => __('Select Post Order By', 't4b-news-ticker'),
						'desc' => '',
						'type' => 'select',
						'default' => 'date',
						'options' => array(
							'none' => __('No Order', 't4b-news-ticker'),
							'ID' => __('Post ID', 't4b-news-ticker'),
							'name' => __('Post Name (post slug)', 't4b-news-ticker'),
							'date' => __('Post Date', 't4b-news-ticker'),
							'rand' => __('Random', 't4b-news-ticker')
						),
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name' => 'title_length',
						'label' => __('Post Title Max. Length', 't4b-news-ticker'),
						'desc' => __('Set the maximum length of the post title. Use -1/0 for no limit.', 't4b-news-ticker'),
						'placeholder' => __('40', 't4b-news-ticker'),
						'min' => -1,
						'max' => 200,
						'type' => 'number',
						'default' => -1,
						'sanitize_callback' => 'intval'
					),
					array(
						'name' => 'ticker_custom',
						'label' => __('News Ticker Custom Text', 't4b-news-ticker'),
						'desc' => __('Enter custom text for your news ticker. One sentence with or without link per line.', 't4b-news-ticker'),
						'type' => 'wysiwyg',
						'default' => ''
					),
					array(
						'name' => 't4bnt_gapcon',
						'desc' => '',
						'type' => 'html'
					),
				),
				't4bnt_advance' => array(
					array(
						'name' => 'ticker_effect',
						'label' => __('Ticker Animation Type', 't4b-news-ticker'),
						'desc' => __('Select type of animation (Default: \'scroll\').', 't4b-news-ticker'),
						'type' => 'select',
						'default' => 'scroll',
						'options' => array(
							'slide' => 'Slide',
							'fade' => 'Fade',
							'ticker' => 'Ticker',
							'scroll' => 'Scroll'
						),
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name' => 'ticker_fadetime',
						'label' => __('Timeout', 't4b-news-ticker'),
						'desc' => __('Time between the fades in milliseconds (Default: \'2000\', means 2 seconds)', 't4b-news-ticker'),
						'placeholder' => __('2000', 't4b-news-ticker'),
						'min' => 100,
						'max' => 20000,
						'step' => '1',
						'type' => 'number',
						'default' => '2000',
						'sanitize_callback' => 'absint'
					),
					array(
						'name' => 'scroll_control',
						'label' => __('Scrolling Control', 't4b-news-ticker'),
						'desc' => __('Mark if you want to show the News Ticker control buttons.', 't4b-news-ticker'),
						'type' => 'checkbox',
						'default' => 'off',
						'sanitize_callback' => 'sanitize_text_field'
					),
					array(
						'name' => 'scroll_speed',
						'label' => __('Speed of Scrolling', 't4b-news-ticker'),
						'desc' => __('Scrolling speed of the ticker.', 't4b-news-ticker'),
						'placeholder' => __('0.05', 't4b-news-ticker'),
						'min' => 0.01,
						'max' => 0.2,
						'step' => '0.01',
						'type' => 'number',
						'default' => 0.05,
						'sanitize_callback' => function ($value) {
							return $this->get_functions->t4bnt_sanitize_float($value, array(
								'min' => 0.01,
								'max' => 0.2,
								'default' => 0.05
							));
						}
					),
					array(
						'name' => 'reveal_speed',
						'label' => __('Speed of Ticker', 't4b-news-ticker'),
						'desc' => __('Revealing speed of the ticker.', 't4b-news-ticker'),
						'placeholder' => __('0.10', 't4b-news-ticker'),
						'min' => 0.01,
						'max' => 0.9,
						'step' => '0.01',
						'type' => 'number',
						'default' => '0.10',
						'sanitize_callback' => function ($value) {
							return $this->get_functions->t4bnt_sanitize_float($value, array(
								'min' => 0.01,
								'max' => 0.9,
								'default' => 0.10
							));
						}
					),
					array(
						'name' => 't4bnt_gapadv',
						'desc' => '',
						'type' => 'html'
					),
				)
			);
			return $settings_fields;
		}

		/**
		 * Wraps the settings page for display.
		 *
		 * This method outputs the HTML for the settings page and sidebar content,
		 * providing a container for the settings fields and sidebar to be displayed.
		 *
		 * @return void
		 */
		function t4bnt_options_page()
		{ ?>
			<div class="t4bnt_settings_area">
				<div class="wrap t4bnt_settings">
					<h1 class="main-header"><?php esc_html_e('T4B News Ticker Options', 't4b-news-ticker'); ?></h1>
					<?php
					$this->settings_api->show_navigation();
					$this->settings_api->show_forms();
					$this->t4bnt_admin_footer_note();
					?>
				</div>
				<?php
				$sidebar_content = $this->sidebar_info->t4bnt_sidebar(false, true, false, 't4bnt-main');
				echo wp_kses_post($sidebar_content); ?>
			</div>
			<?php
		}

		/**
		 * Includes the help page for the plugin.
		 *
		 * This method loads the HTML or template for the plugin's help page, providing 
		 * users with instructions or support information.
		 *
		 * @return void
		 */
		public function t4bnt_help_page()
		{
			if (!current_user_can('manage_options')) {
				wp_die(esc_html__('You do not have sufficient permissions to access this page.', 't4b-news-ticker'));
			}

			$t4bnt_help = new T4BNT_Help();
			$t4bnt_help->render_t4bnt_help_page();
		}

		/**
		 * Adds a custom footer note below the settings panel.
		 *
		 * This method appends a footer message to the settings page, typically used 
		 * for branding or providing additional information.
		 *
		 * @return void
		 */
		public function t4bnt_admin_footer_note()
		{
			?>
			<div id="t4bnt-narration" class="postbox-container">
				<div id="t4bntusage-note" class="t4bntusage-maincontent">
					<div class="t4bnt"><?php
					printf(
						/* translators: %1$s: Opening HTML tag for heading, %2$s: Closing HTML tag for heading, %3$s: Opening paragraph tag, %4$s: Link to the YouTube video, %5$s: Contact Us link, %6$s: Closing paragraph tag, %7$s: Opening paragraph tag for feedback request, %8$s: Link to leave a review */
						esc_html__('
								%1$sWatch Our YouTube Tutorial for Easy Setup!%2$s
								%3$sThere is a %4$s available that explains how the User Front-End plugin works. If you have any trouble understanding, feel free to %5$s at any time.%6$s
								%7$sWe greatly value your feedback! Please spare a moment to rate your recent experience with our plugin. Your input is highly appreciated and helps us improve. Thank you for your support!%8$s',
							't4b-news-ticker'
						),
						'<h3>',
						'</h3>',
						'<p>',
						'<a href="' . esc_url(admin_url("admin.php?page=t4bnt-help")) . '"> YouTube video</a>',
						'<a href="' . esc_url("https://wordpress.org/support/plugin/t4b-news-ticker/") . '" target="_blank">Contact Us</a>',
						'</p>',
						'<p class="likeit">',
						'<a target="_blank" href="' . esc_url("https://wordpress.org/support/plugin/t4b-news-ticker/reviews/?filter=5/#new-post") . '">&#9733;&#9733;&#9733;&#9733;&#9733;</a></p>',
					); ?>
					</div>
				</div>
			</div>
			<?php
		}

		/**
		 * Retrieves a list of pages from the WordPress site.
		 *
		 * This method fetches the pages available on the site and returns them as an 
		 * associative array with the page ID as the key and the page title as the value.
		 *
		 * @return array Array of page names with key-value pairs.
		 */
		function get_pages()
		{
			$pages = get_pages();
			$pages_options = array();
			if ($pages) {
				foreach ($pages as $page) {
					$pages_options[$page->ID] = $page->post_title;
				}
			}
			return $pages_options;
		}
	}
endif;

$t4bnt_Settings_Config = new T4BNT_Settings_Config();

/**
 * Retrieves the value of a settings field.
 *
 * This function fetches a specific option from the WordPress options table.
 * If the option is not found, it falls back to the specified default value.
 *
 * @param string $option The name of the settings field.
 * @param string $section The section name the field belongs to.
 * @param string $default The default value to return if the option is not found.
 *
 * @return mixed The value of the option or the default value.
 */
if (!function_exists('t4bnt_get_option')) {
	function t4bnt_get_option($option, $section, $default = '')
	{

		$options = get_option($section);

		if (isset($options[$option])) {
			return $options[$option];
		}

		return $default;
	}
}