=== T4B News Ticker - Responsive News Scroller, Slider, and Animations ===
Contributors: realwebcare
Tags: news ticker, scroll, ticker, breaking news, trending
Requires at least: 5.2
Tested up to: 6.9
Stable Tag: 1.4.5
Requires PHP: 7.4
Donate link: https://www.realwebcare.com/billing/store/support/donation
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Display breaking news, trending posts, or custom text with this fast WordPress news ticker plugin. Grab attention using 4 scrolling animations.

== Description ==
### Grab Attention with a Scrolling News Ticker
**T4B News Ticker** makes it incredibly easy to add a breaking news bar or scrolling text to your website. It is the perfect tool to highlight your latest updates, special announcements, or trending posts. You can keep your visitors engaged by choosing from four smooth animation styles: fade, slide, ticker, and scroll.

[FREE VERSION DEMO](https://www.realwebcare.com/demo/t4b-news-ticker-responsive-news-scroller-slider-and-animations/) | [PRO VERSION DEMO](https://www.realwebcare.com/demo/?product_id=t4b-news-ticker-pro) | [EXPLORE PRO](https://www.realwebcare.com/item/wp-news-ticker-t4b-news-ticker-pro-dynamic-scrolling-plugin/) | [TEST DRIVE PRO](https://sandbox.realwebcare.com/sandbox-demo-creator-t4b-news-ticker/)

= Watch Free Version Video Walkthrough =
https://youtu.be/CX72IvU51SY

### Show Any Content You Want
You have full control over what scrolls across the screen. Display your recent blog posts based on specific categories or tags. If you want to promote a sale or a custom link, you can easily type your own custom text messages right from your WordPress dashboard. This flexibility helps you direct traffic exactly where you want it.

### Easy Design Control and Setup
Make the news slider match your website perfectly. You can easily change the scrolling speed, font colors, and text sizes from the plugin settings. Once you are happy with the design, just copy the provided shortcode and paste it into any page, post, or widget area to display your custom news ticker.

<blockquote>
<h3>Get More Power with Premium</h3>
<p>Need more features? T4B News Ticker Pro gives you advanced controls, custom styling options, and premium support to build the ultimate news slider for your visitors.</p>
<p><strong>Premium features include:</strong></p>
<ul>
<li>Save time with 12 ready-to-use design templates.</li>
<li>Get 7 beautiful animation effects to stand out.</li>
<li>Pull scrolling text data automatically from RSS feeds or JSON.</li>
<li>Continuous smooth scrolling without any breaks.</li>
<li>Export and import your custom ticker settings between websites.</li>
<li>Build and display multiple different news tickers on the same page.</li>
<li>Duplicate existing tickers with one click.</li>
<li>Full support for Right-to-Left (RTL) languages.</li>
</ul>
<p><a href="https://www.realwebcare.com/item/wp-news-ticker-t4b-news-ticker-pro-dynamic-scrolling-plugin/">Explore Premium features</a></p>
</blockquote>

[**Click to Watch Pro Version Walkthrough**](https://www.youtube.com/watch?v=IR-K0KuQ8Fc)


== Key Features ==
* **Quick Setup:** Create a horizontal news ticker in just a few minutes.
* **Multiple Animations:** Choose from fade, slide, standard ticker, or scroll styles.
* **Flexible Content:** Show your latest posts by category, tag, or display custom text links.
* **Speed Control:** Adjust how fast the scrolling text moves to ensure easy reading.
* **Smart Ordering:** Control exactly how many posts to show and in what order.
* **Visitor Controls:** Let users pause, play, or skip the news items (available in scroll mode).
* **Simple Shortcode:** Place your news slider anywhere on your site using a simple shortcode.


== Installation ==
T4B News Ticker can be installed in two convenient ways: manually or directly from the WordPress plugin directory.

**Manual Installation:**
1. Log in to your WordPress admin dashboard.
2. Navigate to "Plugins" in the left menu and click "Add New."
3. Click "Upload Plugin" and choose the t4b-news-ticker.zip file. Click "Install Now."
4. Once installed, activate the plugin.
5. Configure the ticker settings under "Settings" >> "Ticker Settings."

**Installation from WordPress Plugin Directory:**
1. Log in to your WordPress admin dashboard.
2. In the left menu, click "Plugins," then select "Add New."
3. In the search field, type "T4B News Ticker" and press Enter.
4. Locate the plugin in the search results and click the "Install Now" button.
5. After installation, activate the plugin.
6. Configure the ticker settings under "Settings" >> "Ticker Settings."


== Upgrade Notice ==

= 1.4.5 =
* Important maintenance update: removed outdated legacy migration routine to prevent unintended settings reset after updates and preserve custom ticker text.

== Changelog ==

= 1.4.5 (9 May, 2026) =
* `Fixed:` Removed outdated one-time migration execution from plugin load process to prevent custom text and content settings from being overwritten during updates.
* `Improved:` Preserved existing saved ticker options reliably across version updates without changing ticker runtime behavior.
* Ensure scripts and styles only load on the plugin's own admin pages.

= 1.4.4 (7 March, 2026) =
* `Fixed:` Resolved an issue where settings admin links did not work due to JavaScript localStorage key conflict with other plugins like Elementor or Astra.
* `Fixed:` A minor JS issue.

= 1.4.3 (16 November, 2025) =
* `Improved:` Backend CSS for a cleaner and more professional look.
* `Added:` Guidance on how to add the ticker shortcode to all pages.
* `Tested:` Full compatibility with WordPress 6.8.3.
* `Routine:` General maintenance and minor enhancements.

= 1.4.2 (30 May, 2025) =
* `Improved:` Inline script handling to ensure reliable initialization across all themes.
* `Fixed:` An issue where the ticker might not initialize if shortcode rendering occurred after script registration.
* `Enhanced:` Compatibility with WordPress default themes by adjusting script registration and fallback handlers.

= 1.4.1 (25 May, 2025) =
* Fixed news ticker not initializing in block themes like Twenty Twenty-Four and Twenty Twenty-Five, ensuring reliable animation.
* Optimized script/style enqueuing to load only when shortcode is used.
* Fixed settings validation and sidebar return type.

= 1.4.0 (10 February, 2025) =
* Major update with complete Object-Oriented Programming (OOP) implementation.
* Added `rand` option in post order settings to display content randomly.
* Added option to remove plugin settings from the database on uninstallation.
* Introduced maximum length setting for ticker content.
* Ensured full compliance with WordPress coding standards.
* Moved the News Ticker settings from `Settings >> Ticker Settings` to the `T4B Ticker` menu in the main WordPress admin.
* Improved the admin interface for a more modern and user-friendly experience.
* Added a Help page with plugin features and usage instructions.

= 1.3.4 (31 January, 2025) =
* Added option to disable the ticker on tag/category archive pages via plugin settings.
* Refined the conditional logic for showing the ticker on the homepage and category/tag pages for better control over where the ticker appears.

= 1.3.3 (13 December, 2024) =
* Fixed issue with ticker display logic when "Show in Homepage only" option is enabled.
* Resolved issue where ticker was not displaying on tag and category archive pages (reported by client David).

= 1.3.2 (1 December, 2024) =  
* Updated code to meet WordPress coding standards.
* Fixed a minor CSS issue.

= 1.3.1 (31 July, 2024) =
* Fixed a small bug
* Make compatible with WP version 6.6.1

= 1.3 (8 May, 2024) =
* Fixed few URL related bugs 
* Make compatible with WP version 6.5.2

= 1.2.9 (23 November, 2023) =
* 12th release.
* Fixed full width issue for slide, fade and ticker typography effect.
* Fixed the issue of Internationalization.
* Modified the Text domain with the plugin's slug.
* Improved the translation escaping process.

= 1.2.8 (15 August, 2023) =
* 11th release.
* Introducing new feature: Control ticker scrolling using pause, play, next, and prev buttons.
* Addressed ticker scrolling JavaScript bug.
* Ensured compatibility with the latest WordPress version (6.3).

= 1.2.7 (11 February, 2023) =
* 10th release.
* Full width issue for fade, slide or ticker animatation effect are solved.
* Make compatible with the latest version of WordPress.

= 1.2.6 (15 August, 2022) =
* 9th release.
* Fixed the loading time of the scrolling information.

= 1.2.5 (17 December, 2021) =
* 8th release.
* Fixed a jQuery bug

= 1.2.4 (20 July, 2021) =
* 7th release.
* Fixed 10 seconds Gap between Loops
* Fixed wrap text issue in slide and fade animation

= 1.2.3 (12 August, 2020) =
* 6th release.
* Fixed some jQuery issues to make compatible with WP 5.5

= 1.2.2 (12 February, 2020) = 
* 5th release.
* Open in new tab option added.
* Fixed some bugs.

= 1.2.1 (17 JUne, 2019) = 
* 4th release.
* Increased ticker height.
* Released the pro version.

= 1.2 (22 May, 2019) = 
* 3rd release.
* Change the option page structure to make it more user friendly.
* Post order and order by added.

= 1.1 (9 October, 2018) = 
* 2nd release.
* Make the plugin compatible with the latest WordPress version.
* Fixed some bugs.

= 1.0 (29 December, 2014) = 
* 1st release.


== Frequently Asked Questions ==

= What types of content can I display in the ticker? =  
You can display content from specific post categories or tags with associated links. The plugin also supports custom content that you can compose using the WordPress post editor.

= How do I customize the ticker's appearance? =  
You can adjust the ticker's scrolling speed, set the time between fades, and customize the typography to match your website's design. Additional customization options are available in the premium version.

= What animation effects are available in the free version? =  
The free version offers four animation effects: fade, slide, ticker, and scroll. These can be selected to suit your website's style.

= How do I use the shortcode to display the ticker? =  
After creating a ticker, copy the generated shortcode and paste it into any post, page, or theme file where you want the ticker to appear.

= Is the plugin compatible with Right-to-Left (RTL) languages? =  
RTL language support is available in the premium version of the plugin.

= Can I display news from external sources like RSS feeds or JSON data? =  
This feature is available in the premium version. You can display tickers using RSS feeds or JSON data for dynamic content updates.

= What should I do if the ticker is not displaying correctly? =  
Ensure that the shortcode is correctly placed and the plugin is active. If the issue persists, check for conflicts with other plugins or themes. For further assistance, visit the support forum or contact us directly.


= Credits =

* jQuery liScroll
* jQuery News Ticker
* Developed By: [Realwebcare](https://www.realwebcare.com/)
* [Facebook Page](https://www.facebook.com/realwebcare/)


== License ==

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA


== Screenshots ==
1. T4B News Ticker Demo.
2. T4B News Ticker General Settings Tab.
3. T4B News Ticker Content Settings Tab.
4. T4B News Ticker Content Settings Using Custom Texts.
5. T4B News Ticker Advance Settings Tab.