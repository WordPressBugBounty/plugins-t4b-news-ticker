<?php
/*
 *  T4B News Ticker v1.3.4 - 31 January, 2025
 *  By @realwebcare - https://www.realwebcare.com/
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 't4bnt_show_news_ticker' ) ) {
	function t4bnt_show_news_ticker( $atts ) {
		// Sanitize and validate shortcode attributes
		$atts = shortcode_atts( array(
			'orderby' => 'date', // Default orderby
			'order'   => 'DESC', // Default order
			'id'      => 1
		), $atts, 't4b-ticker' );

		$orderby = sanitize_text_field( $atts['orderby'] );
		$order   = in_array( strtoupper( $atts['order'] ), array( 'ASC', 'DESC' ) ) ? strtoupper( $atts['order'] ) : 'DESC';

		// Get ticker settings with proper sanitization
		$ticker_news   = sanitize_text_field( t4bnt_get_option( 'ticker_news', 't4bnt_general', 'on' ) );
		$ticker_home   = sanitize_text_field( t4bnt_get_option( 'ticker_home', 't4bnt_general', 'off' ) );
		$ticker_ntab   = sanitize_text_field( t4bnt_get_option( 'ticker_ntab', 't4bnt_general', 'off' ) );

		if ( $ticker_news == 'on' && ( $ticker_home == 'off' || ( $ticker_home == 'on' && is_front_page() ) ) ) :

			$ticker_taxon  = sanitize_text_field( t4bnt_get_option( 'ticker_taxon', 't4bnt_general', 'off' ) );
			$ticker_type   = sanitize_text_field( t4bnt_get_option( 'ticker_type', 't4bnt_general', 'category' ) );
			$ticker_cat    = sanitize_text_field( t4bnt_get_option( 'ticker_cat', 't4bnt_general', '' ) );
			$ticker_tag    = sanitize_text_field( t4bnt_get_option( 'ticker_tag', 't4bnt_general', '' ) );
			$ticker_title  = sanitize_text_field( t4bnt_get_option( 'ticker_title', 't4bnt_general', 'Trending Now' ) );

			$ticker_postno = t4bnt_get_option( 'ticker_postno', 't4bnt_general', -1 );
			$ticker_postno = filter_var( $ticker_postno, FILTER_VALIDATE_INT, ['options' => ['min_range' => -1]] );

			if ( false === $ticker_postno ) {
				$ticker_postno = -1; // Default to -1 if the value is invalid
			}

			$ticker_effect = sanitize_text_field( t4bnt_get_option( 'ticker_effect', 't4bnt_general', 'scroll' ) );
			$timeout       = absint( t4bnt_get_option( 'ticker_fadetime', 't4bnt_general', 2000 ) );
			$scroll_control = sanitize_text_field( t4bnt_get_option( 'scroll_control', 't4bnt_general', 'off' ) );
			$scroll_speed  = floatval( t4bnt_get_option( 'scroll_speed', 't4bnt_general', 0.05 ) );
			$reveal_speed  = floatval( t4bnt_get_option( 'reveal_speed', 't4bnt_general', 0.10 ) );
			$order_by      = sanitize_text_field( t4bnt_get_option( 'ticker_order_by', 't4bnt_general', $orderby ) );
			$ticker_order  = sanitize_text_field( t4bnt_get_option( 'ticker_order', 't4bnt_general', $order ) );
			$ticker_custom = wp_kses_post( t4bnt_get_option( 'ticker_custom', 't4bnt_general', '' ) );

			if ( $ticker_effect == 'ticker' ) {
				$ticker_effect = 'reveal';
			}

			if ( $ticker_effect == 'scroll' ) :
				$data = array(
					'speed'		=> $scroll_speed,
					'control'	=> $scroll_control,
				);
			else :
				$data = array(
					'effect'	=> $ticker_effect,
					'speed'		=> $reveal_speed,
					'title'		=> $ticker_title,
					'timeout'	=> $timeout,
				);
			endif;

			global $post;
			$orig_post = $post;
			
			$args = array(
				'post_type'      => 'post',
				'posts_per_page' => $ticker_postno,
				'orderby'        => $order_by,
				'order'          => $ticker_order,
			);

			if ( $ticker_type === 'tag' ) {
				$tag_slugs = array();
				$tag_lists = array_map( 'trim', explode( ',', $ticker_tag ) );

				foreach ( $tag_lists as $tag ) {
					$term = get_term_by( 'name', $tag, 'post_tag' );
					if ( $term ) {
						$tag_slugs[] = $term->slug;
					}
				}

				if ( ! empty( $tag_slugs ) ) {
					$args['tag_slug__in'] = $tag_slugs;
				}
			} elseif ( $ticker_type === 'category' && ! empty( $ticker_cat ) ) {
				$args['cat'] = intval( $ticker_cat );
			}

			// Check if the ticker should be disabled on category or tag pages
			if ( $ticker_taxon == 'on' ) {
				// Fetch posts only if not on category or tag pages
				if ( ! is_category() && ! is_tag() ) {
					$ticker_query = new WP_Query( $args );
				}
			} else {
				// Fetch posts without restriction on category or tag pages
				$ticker_query = new WP_Query( $args );
			}

			ob_start();
			?>

			<div class="ticker-news"><?php
				if ( $ticker_effect == 'scroll' ) : ?>
					<span><?php echo esc_html( $ticker_title ); ?></span><?php
				endif;

				if ( $ticker_type != 'custom' ) : ?>
					<div class='tickercontainer'>
						<div class='ticker-mask'>
							<ul id="ticker" class="js-hidden"><?php
								if ( isset( $ticker_query ) && $ticker_query->have_posts() ) :
									while ( $ticker_query->have_posts() ) :
										$ticker_query->the_post();
										$target_attr = ( $ticker_ntab === 'on' ) ? ' target="_blank"' : ''; ?>
										<li>
											<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"<?php echo esc_attr( $target_attr ); ?>><?php echo esc_html( get_the_title() ); ?></a>
										</li><?php
									endwhile;
									wp_reset_postdata();
									$post = $orig_post;
								endif; ?>
							</ul>
						</div>
					</div><?php
				else :
					if ( $ticker_custom ) :
						$all_custom_texts = explode( "\n", $ticker_custom ); ?>

						<div class='tickercontainer'>
							<div class='ticker-mask'>
								<ul id="ticker"><?php
									foreach ( $all_custom_texts as $custom_text ) : ?>
										<li><?php echo wp_kses_post( $custom_text ); ?></li><?php
									endforeach; ?>
								</ul>
							</div>
						</div>
						<?php
					endif;
				endif;

				if ( $ticker_effect == 'scroll' ) :
					wp_add_inline_script( 't4bnt-liscroll', t4bnt_scroll_ticker_script( $data ) );
				else :
					wp_add_inline_script( 't4bnt-ticker', t4bnt_non_scroll_switch( $data ) );
				endif;
				?>
			</div>
			<!-- .ticker-news -->
			<?php
		else :
			// If ticker news is not enabled or home settings don't match, display a message or take an action
			if ( $ticker_news != 'on' ) { ?>
				<span style="background: #dd3737;color:#fff;text-align:center"><?php echo esc_html__( 'Ticker news is disabled.', 't4b-news-ticker' ); ?></span><?php
			} else {
				if ( $ticker_home == 'on' && ! is_front_page() ) { ?>
				<span style="background: #dd3737;color:#fff;text-align:center"><?php echo esc_html__( 'Ticker news is only displayed on the front page.', 't4b-news-ticker' ); ?></span><?php
				}

				if ( $ticker_home == 'off' ) { ?>
				<span style="background: #dd3737;color:#fff;text-align:center"><?php echo esc_html__( 'Ticker news is disabled on the homepage.', 't4b-news-ticker' ); ?></span><?php
				}
			}
		endif;

		return ob_get_clean();
	}
}
add_shortcode( 't4b-ticker','t4bnt_show_news_ticker' );