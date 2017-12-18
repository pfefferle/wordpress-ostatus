<?php
/**
 * Plugin Name: OStatus
 * Plugin URI: https://github.com/pfefferle/wordpress-ostatus
 * Description: A bundle of plugins that turn your blog into your private federated social network.
 * Author: Matthias Pfefferle
 * Author URI: https://notiz.blog/
 * License: MIT
 * License URI: http://opensource.org/licenses/MIT
 * Version: 2.3.1
 * Text Domain: ostatus-for-wordpress
 * Domain Path: /languages
 */

// support the legacy WebFinger specs
define( 'WEBFINGER_LEGACY', true );

add_action( 'init', array( 'Ostatus', 'init' ) );

/**
 * Ostatus class
 *
 * @author Matthias Pfefferle
 * @see https://www.w3.org/community/ostatus/
 */
class Ostatus {

	/**
	 * Initialize the plugin, registering WordPress hooks.
	 */
	public static function init() {
		require_once dirname( __FILE__ ) . '/includes/functions.php';

		add_filter( 'webfinger_user_data', array( 'Ostatus', 'webfinger' ), 10, 3 );
		add_filter( 'host_meta', array( 'Ostatus', 'host_meta' ) );

		add_feed( 'ostatus', array( 'Ostatus', 'do_feed_ostatus' ) );
		add_action( 'do_feed_ostatus', array( 'Ostatus', 'do_feed_ostatus' ), 10, 1 );

		add_filter( 'pubsubhubbub_feed_urls', array( 'Ostatus', 'pubsubhubbub_feed_urls' ), 10, 2 );

		add_action( 'admin_init', array( 'Ostatus', 'text_domain' ) );
		add_action( 'admin_menu', array( 'Ostatus', 'admin_menu' ) );
		add_action( 'admin_init', array( 'Ostatus', 'register_settings' ) );

		add_filter( 'the_excerpt_rss', array( 'Ostatus', 'the_feed_content' ), 99 );
		add_filter( 'the_title_rss', array( 'Ostatus', 'the_feed_content' ), 99 );
		add_filter( 'the_content_feed', array( 'Ostatus', 'the_feed_content' ), 99 );
		add_filter( 'comment_text', array( 'Ostatus', 'the_feed_content' ), 99 );
	}

	/**
	 * adds the the atom links to the webfinger-xrd-file
	 */
	public static function webfinger( $array, $resource, $user ) {
		$array['links'][] = array(
			'rel' => 'http://schemas.google.com/g/2010#updates-from',
			'href' => get_author_feed_link( $user->ID, 'ostatus' ),
			'type' => 'application/atom+xml',
		);

		$array['links'][] = array(
			'rel' => 'http://ostatus.org/schema/1.0/subscribe',
			'template' => site_url( '/?profile={uri}' ),
		);

		return $array;
	}

	/**
	 * Adds the the atom links to the host-meta-xrd-file
	 */
	public static function host_meta( $array ) {
		$array['links'][] = array(
			'rel' => 'http://schemas.google.com/g/2010#updates-from',
			'href' => get_feed_link( 'ostatus' ),
			'type' => 'application/atom+xml',
		);

		$array['links'][] = array(
			'rel' => 'http://ostatus.org/schema/1.0/subscribe',
			'template' => site_url( '/?profile={uri}' ),
		);

		// add lrdd links if legacy plugin does not exists
		if ( class_exists( 'WebFingerPlugin' ) && ! class_exists( 'WebFingerLegacy_Plugin' ) ) {
			$array['links'][] = array(
				'rel' => 'lrdd',
				'template' => site_url( '/.well-known/webfinger?resource={uri}' ),
				'type' => 'application/jrd+json',
			);

			$array['links'][] = array(
				'rel' => 'lrdd',
				'template' => site_url( '/.well-known/webfinger?resource={uri}' ),
				'type' => 'application/json',
			);
		}

		return $array;
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
	 * Load plugin text domain
	 */
	public static function text_domain() {
		load_plugin_textdomain( 'ostatus-for-wordpress' );
	}

	/**
	 * Add admin menu entry
	 */
	public static function admin_menu() {
		add_options_page(
			'OStatus',
			'OStatus',
			'manage_options',
			'ostatus',
			array( 'Ostatus', 'settings_page' )
		);
	}

	/**
	 * Load settings page
	 */
	public static function settings_page() {
		load_template( dirname( __FILE__ ) . '/templates/settings-page.php' );
	}

	/**
	 * Register new atom feed
	 */
	public static function do_feed_ostatus( $for_comments ) {
		if ( $for_comments ) {
			load_template( dirname( __FILE__ ) . '/templates/feed-ostatus-comments.php' );
		} else {
			load_template( dirname( __FILE__ ) . '/templates/feed-ostatus.php' );
		}
	}

	public static function the_feed_content( $output ) {
		if ( is_feed( 'ostatus' ) ) {
			return htmlspecialchars( $output );
		}

		return $output;
	}

	/**
	 * Register PubSubHubbub settings
	 */
	public static function register_settings() {
		register_setting( 'ostatus', 'ostatus_feed_use_excerpt' );
	}
}
