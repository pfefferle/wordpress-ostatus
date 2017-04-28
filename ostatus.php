<?php
/**
 * Plugin Name: OStatus for WordPress
 * Plugin URI: http://wordpress.org/tags/ostatus-for-wordpress
 * Description: A bundle of plugins that turn your blog into your private federated social network.
 * Author: Matthias Pfefferle
 * Version: 2.0.0-dev
 * Author URI: http://notiz.blog/
 */

add_action( 'init', array( 'Ostatus', 'init' ) );

/**
 * ostatus class
 *
 * @author Matthias Pfefferle
 * @see http://ostatus.org
 */
class Ostatus {
	public static function init() {
		add_action( 'webfinger', array( 'Ostatus', 'webfinger' ), 10, 2 );
		add_action( 'host_meta', array( 'Ostatus', 'host_meta' ) );

		add_action( 'atom_ns', array( 'Ostatus', 'add_poco_namespace' ) );
		add_action( 'atom_head', array( 'Ostatus', 'add_global_author' ) );
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
	 * adds the the atom links to the host-meta-xrd-file
	 */
	function host_meta( $array ) {
		$array['links'][] = array(
			'rel' => 'http://schemas.google.com/g/2010#updates-from',
			'href' => get_feed_link( 'ostatus' ),
			'type' => 'application/atom+xml',
		);

		$array['links'][] = array(
			'rel' => 'http://ostatus.org/schema/1.0/subscribe',
			'template' => site_url( '/?profile={uri}' ),
		);

		return $array;
	}

	/**
	 * ping hubs
	 *
	 * @param int $post_id
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

	public static function add_poco_namespace() {
		if ( is_author() && is_feed( 'ostatus' ) ) {
			echo 'xmlns:poco="http://portablecontacts.net/spec/1.0"' . PHP_EOL;
			echo 'xmlns:media="http://purl.org/syndication/atommedia"' . PHP_EOL;
			echo 'xmlns:ostatus="http://ostatus.org/schema/1.0"' . PHP_EOL;
		}
	}

	public static function add_global_author() {
		if ( is_author() && is_feed( 'ostatus' ) ) {
			load_template( dirname( __FILE__ ) . '/templates/atom-author.php' );
		}
	}

	public static function admin_menu() {
		add_options_page(
			'OStatus',
			'OStatus',
			'manage_options',
			'ostatus',
			array( 'Ostatus', 'settings_page' )
		);
	}

	public static function settings_page() {
		load_template( dirname( __FILE__ ) . '/templates/admin.php' );
	}

	public static function do_feed_ostatus( $for_comments ) {
		if ( $for_comments ) {
			load_template( ABSPATH . WPINC . '/feed-atom-comments.php' );
		} else {
			load_template( ABSPATH . WPINC . '/feed-atom.php' );
		}
	}
}
