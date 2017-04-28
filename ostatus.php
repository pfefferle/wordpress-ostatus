<?php
/**
 * Plugin Name: OStatus
 * Plugin URI: http://wordpress.org/tags/ostatus-for-wordpress
 * Description: A bundle of plugins that turn your blog into your private federated social network.
 * Author: Matthias Pfefferle
 * Author URI: http://notiz.blog/
 * License: MIT
 * License URI: http://opensource.org/licenses/MIT
 * Version: 2.0.0
 * Text Domain: ostatus
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
		add_filter( 'webfinger', array( 'Ostatus', 'webfinger' ), 10, 2 );
		add_filter( 'host_meta', array( 'Ostatus', 'host_meta' ) );

		add_action( 'atom_ns', array( 'Ostatus', 'atom_add_poco_namespace' ) );
		add_action( 'atom_head', array( 'Ostatus', 'atom_add_global_author' ) );
		add_feed( 'ostatus', array( 'Ostatus', 'do_feed_ostatus' ) );
		add_action( 'do_feed_ostatus', array( 'Ostatus', 'do_feed_ostatus' ), 10, 1 );

		add_action( 'publish_post', array( 'Ostatus', 'publish_to_hub' ) );

		add_action( 'admin_menu', array( 'Ostatus', 'admin_menu' ) );
	}

	/**
	 * adds the the atom links to the webfinger-xrd-file
	 */
	public static function webfinger( $array, $user ) {
		$array['links'][] = array(
			'rel' => 'http://schemas.google.com/g/2010#updates-from',
			'href' => get_author_feed_link( $user->ID, 'ostatus' ),
			'type' => 'application/atom+xml',
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
	public static function publish_to_hub( $feed ) {
		if ( function_exists( 'publish_to_hub' ) ) {
			$post = get_post( $post_id );
			$feeds = array();
			$feeds[] = get_author_feed_link( $post->post_author, 'atom' );

			publish_to_hub( null, $feeds );
		}

		return $post_id;
	}

	/**
	 * Added PortableContacts namespace
	 */
	public static function atom_add_poco_namespace() {
		if ( is_author() && is_feed( 'ostatus' ) ) {
			echo 'xmlns:poco="http://portablecontacts.net/spec/1.0"' . PHP_EOL;
			echo 'xmlns:media="http://purl.org/syndication/atommedia"' . PHP_EOL;
			echo 'xmlns:ostatus="http://ostatus.org/schema/1.0"' . PHP_EOL;
		}
	}

	/**
	 * Add global author area to the OStatus Atom feed
	 */
	public static function atom_add_global_author() {
		if ( is_author() && is_feed( 'ostatus' ) ) {
			load_template( dirname( __FILE__ ) . '/templates/atom-author.php' );
		}
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
		load_template( dirname( __FILE__ ) . '/templates/admin.php' );
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
