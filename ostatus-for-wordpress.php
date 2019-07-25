<?php
/**
 * Plugin Name: OStatus
 * Plugin URI: https://github.com/pfefferle/wordpress-ostatus
 * Description: A bundle of plugins that turn your blog into your private federated social network.
 * Author: Matthias Pfefferle
 * Author URI: https://notiz.blog/
 * License: MIT
 * License URI: http://opensource.org/licenses/MIT
 * Version: 2.5.5
 * Text Domain: ostatus-for-wordpress
 * Domain Path: /languages
 */

// support the legacy WebFinger specs
define( 'WEBFINGER_LEGACY', true );

// flush rewrite rules
register_activation_hook( __FILE__, 'ostatus_flush_rewrite_rules' );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );

/**
 * Initialize the plugin, registering WordPress hooks.
 */
function ostatus_init() {
	require_once dirname( __FILE__ ) . '/includes/functions.php';

	load_plugin_textdomain( 'ostatus-for-wordpress' );

	require_once dirname( __FILE__ ) . '/includes/class-ostatus-admin.php';
	add_action( 'admin_menu', array( 'Ostatus_Admin', 'admin_menu' ) );
	add_action( 'admin_init', array( 'Ostatus_Admin', 'register_settings' ) );

	require_once dirname( __FILE__ ) . '/includes/class-ostatus-discovery.php';
	add_filter( 'webfinger_user_data', array( 'Ostatus_Discovery', 'webfinger' ), 10, 3 );
	add_filter( 'host_meta', array( 'Ostatus_Discovery', 'host_meta' ) );
	add_filter( 'nodeinfo_data', array( 'Ostatus_Discovery', 'nodeinfo' ), 10, 2 );
	add_filter( 'nodeinfo2_data', array( 'Ostatus_Discovery', 'nodeinfo2' ), 10 );

	require_once dirname( __FILE__ ) . '/includes/class-ostatus-feed.php';
	add_action( 'init', array( 'Ostatus_Feed', 'add_ostatus_feed' ) );
	add_action( 'do_feed_ostatus', array( 'Ostatus_Feed', 'do_feed_ostatus' ), 10, 1 );

	add_filter( 'pubsubhubbub_feed_urls', array( 'Ostatus_Feed', 'pubsubhubbub_feed_urls' ), 10, 2 );
	add_filter( 'pubsubhubbub_show_discovery', array( 'Ostatus_Feed', 'pubsubhubbub_show_discovery' ), 12 );

	add_filter( 'the_excerpt_rss', array( 'Ostatus_Feed', 'the_feed_content' ), 99 );
	add_filter( 'the_title_rss', array( 'Ostatus_Feed', 'the_feed_content' ), 99 );
	add_filter( 'the_content_feed', array( 'Ostatus_Feed', 'the_feed_content' ), 99 );
	add_filter( 'comment_text', array( 'Ostatus_Feed', 'the_feed_content' ), 99 );
}
add_action( 'plugins_loaded', 'ostatus_init' );

/**
 * Flush rewrite rules
 */
function ostatus_flush_rewrite_rules() {
	require_once dirname( __FILE__ ) . '/includes/class-ostatus-feed.php';
	Ostatus_Feed::add_ostatus_feed();
	flush_rewrite_rules();
}
