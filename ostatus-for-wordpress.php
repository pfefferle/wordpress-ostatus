<?php
/**
 * Plugin Name: OStatus
 * Plugin URI: https://github.com/pfefferle/wordpress-ostatus
 * Description: A bundle of plugins that turn your blog into your private federated social network.
 * Author: Matthias Pfefferle
 * Author URI: http://notiz.blog/
 * License: MIT
 * License URI: http://opensource.org/licenses/MIT
 * Version: 2.2.1
 * Text Domain: ostatus-for-wordpress
 * Domain Path: /languages
 */

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

		add_action( 'atom_ns', array( 'Ostatus', 'atom_add_namespaces' ) );
		add_action( 'atom_head', array( 'Ostatus', 'atom_add_global_author' ) );
		add_action( 'atom_author', array( 'Ostatus', 'atom_add_entry_author' ) );

		add_feed( 'ostatus', array( 'Ostatus', 'do_feed_ostatus' ) );
		add_action( 'do_feed_ostatus', array( 'Ostatus', 'do_feed_ostatus' ), 10, 1 );

		add_filter( 'pubsubhubbub_feed_urls', array( 'Ostatus', 'pubsubhubbub_feed_urls' ), 10, 2 );

		add_action( 'admin_init', array( 'Ostatus', 'text_domain' ) );
		add_action( 'admin_menu', array( 'Ostatus', 'admin_menu' ) );
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

		return $feeds;
	}

	/**
	 * Added PortableContacts namespace
	 */
	public static function atom_add_namespaces() {
		if ( is_author() && is_feed( 'ostatus' ) ) {
			echo 'xmlns:poco="http://portablecontacts.net/spec/1.0/"' . PHP_EOL;
			echo 'xmlns:media="http://purl.org/syndication/atommedia/"' . PHP_EOL;
			echo 'xmlns:ostatus="http://ostatus.org/schema/1.0/"' . PHP_EOL;
		}
	}

	/**
	 * Add global author area to the OStatus Atom feed
	 */
	public static function atom_add_global_author() {
		if ( is_author() && is_feed( 'ostatus' ) ) {
			load_template( dirname( __FILE__ ) . '/templates/feed-ostatus-author.php' );
		}
	}

	/**
	 * Extend entry author of the OStatus Atom feed
	 */
	public static function atom_add_entry_author() {
		if ( is_author() && is_feed( 'ostatus' ) ) {
			load_template( dirname( __FILE__ ) . '/templates/feed-ostatus-entry-author.php' );
		}
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
			load_template( ABSPATH . WPINC . '/feed-atom-comments.php' );
		} else {
			load_template( ABSPATH . WPINC . '/feed-atom.php' );
		}
	}
}
