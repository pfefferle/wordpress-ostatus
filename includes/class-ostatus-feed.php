<?php
/**
 * OStatus Feed Class
 */
class Ostatus_Feed {
	/**
	 * Adds OStatus Feed
	 */
	public static function add_ostatus_feed() {
		add_feed( 'ostatus', array( 'Ostatus_Feed', 'do_feed_ostatus' ) );
	}

	/**
	 * Ping hubs
	 *
	 * @param int $post_id
	 *
	 * @return int;
	 */
	public static function pubsubhubbub_feed_urls( $feeds, $post_id ) {
		$post = get_post( $post_id );

		$feeds[] = get_author_feed_link( $post->post_author, 'ostatus' );
		$feeds[] = get_feed_link( 'ostatus' );

		return $feeds;
	}

	/**
	 * Enable discovery
	 *
	 * @return boolean;
	 */
	public static function pubsubhubbub_show_discovery( $show_discovery ) {
		global $withcomments;

		if ( ! $withcomments ) {
			$withcomments = 0;
		}

		if ( is_feed( 'ostatus' ) && ( ( ! is_archive() && ! is_singular() && 0 == $withcomments ) || is_author() ) ) {
			$show_discovery = true;
		}

		return $show_discovery;
	}

	/**
	 * Register new atom feed
	 */
	public static function do_feed_ostatus( $for_comments ) {
		if ( $for_comments ) {
			load_template( dirname( __FILE__ ) . '/../templates/feed-ostatus-comments.php' );
		} else {
			load_template( dirname( __FILE__ ) . '/../templates/feed-ostatus.php' );
		}
	}

	public static function the_feed_content( $output ) {
		if ( is_feed( 'ostatus' ) ) {
			return htmlspecialchars( html_entity_decode( $output ), ENT_COMPAT | ENT_HTML401, 'UTF-8', false );
		}

		return $output;
	}
}
