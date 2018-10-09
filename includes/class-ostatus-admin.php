<?php
/**
 * OStatus Admin Class
 */
class Ostatus_Admin {
	/**
	 * Add admin menu entry
	 */
	public static function admin_menu() {
		$settings_page = add_menu_page(
			'OStatus',
			'OStatus',
			'manage_options',
			'ostatus',
			array( 'Ostatus_Admin', 'settings_page' ),
			plugins_url( 'static/ostatus_icon.png', dirname( __FILE__ ) )
		);

		$dependencies_page = add_submenu_page(
			'ostatus',
			__( 'Dependencies', 'ostatus-for-wordpress' ),
			__( 'Dependencies', 'ostatus-for-wordpress' ),
			'manage_options',
			'ostatus-dependencies',
			array( 'Ostatus_Admin', 'dependencies_page' )
		);

		add_action( 'load-' . $settings_page, array( 'Ostatus_Admin', 'add_help_tab' ) );
	}

	/**
	 * Load settings page
	 */
	public static function settings_page() {
		load_template( dirname( __FILE__ ) . '/../templates/settings-page.php' );
	}

	/**
	 * Load settings page
	 */
	public static function dependencies_page() {
		require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
		wp_enqueue_style( 'plugin-install' );
		wp_enqueue_script( 'plugin-install' );
		add_thickbox();
		$GLOBALS['tab'] = 'custom';

		load_template( dirname( __FILE__ ) . '/../templates/dependencies-page.php' );
	}

	/**
	 * Register PubSubHubbub settings
	 */
	public static function register_settings() {
		register_setting( 'ostatus', 'ostatus_feed_use_excerpt' );
	}

	public static function add_help_tab() {
		get_current_screen()->add_help_tab(
			array(
				'id'      => 'overview',
				'title'   => __( 'Overview', 'ostatus-for-wordpress' ),
				'content' =>
					'<p>' . __( 'OStatus lets people on different social networks follow each other. It applies a group of related protocols (PubSubHubbub, ActivityStreams, Salmon, Portable Contacts, and Webfinger) to this problem in what we believe is a simple and obvious way.', 'ostatus-for-wordpress' ) . '</p>' .
					'<p>' . __( 'OStatus is a minimal specification for distributed status updates or microblogging. Many social applications can be modelled with status updates, however. Practically any software that generates RSS or Atom feeds could be OStatus-enabled. Travel networks, event invitation systems, wikis, photo-sharing systems, social news sites, social music sites, podcasting servers, blogs, version control systems, and general purpose social networks would all be candidates for OStatus use.', 'ostatus-for-wordpress' ) . '</p>',
			)
		);

		get_current_screen()->set_help_sidebar(
			'<p><strong>' . __( 'For more information:', 'ostatus-for-wordpress' ) . '</strong></p>' .
			'<p>' . __( '<a href="https://www.w3.org/community/ostatus/">W3C community page</a>', 'ostatus-for-wordpress' ) . '</p>' .
			'<p>' . __( '<a href="https://www.w3.org/community/ostatus/wiki/Howto">How to OStatus-enable Your Application</a>', 'ostatus-for-wordpress' ) . '</p>' .
			'<p>' . __( '<a href="https://github.com/pfefferle/wordpress-ostatus/issues">Give us feedback</a>', 'ostatus-for-wordpress' ) . '</p>' .
			'<hr />' .
			'<p>' . __( '<a href="https://notiz.blog/donate">Donate</a>', 'ostatus-for-wordpress' ) . '</p>'
		);
	}
}
