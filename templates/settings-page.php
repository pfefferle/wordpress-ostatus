<?php
require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
wp_enqueue_style( 'plugin-install' );
wp_enqueue_script( 'plugin-install' );
add_thickbox();
$GLOBALS['tab'] = 'custom';

?>
<div class="wrap">
	<h2><?php esc_html_e( 'OStatus', 'ostatus-for-wordpress' ); ?></h2>

	<p><strong><?php esc_html_e( 'OStatus for WordPress turns your blog into a federated social network.
	This means you can share and talk to everyone using the OStatus protocol,
	including users of Status.net, Identi.ca and Mastodon', 'ostatus-for-wordpress' ); ?></strong></p>

	<h3><?php esc_html_e( 'Settings', 'ostatus-for-wordpress' ); ?></h3>

	<form method="post" action="options.php">
	<!-- starting -->
	<?php settings_fields( 'ostatus' ); ?>
	<?php do_settings_sections( 'ostatus' ); ?>
	<!-- ending -->

	<fieldset id="webmention">
		<label for="ostatus_feed_use_excerpt">
			<input type="checkbox" name="ostatus_feed_use_excerpt" id="ostatus_feed_use_excerpt" value="1" <?php
				echo checked( true, get_option( 'ostatus_feed_use_excerpt' ) );  ?> />
			<?php _e( 'Show feed summary', 'ostatus-for-wordpress' ) ?>
		</label>
	</fieldset>

	<?php submit_button(); ?>

	</form>

	<h3><?php esc_html_e( 'Dependencies', 'ostatus-for-wordpress' ); ?></h3>

	<p><?php _e( 'OStatus is like a <em>Best of OpenWeb Standards</em> and so is this plugin.
	If there is a plugin available that already implements one of these standards, we will use/support it.
	If we are missing one, <a href="https://github.com/pfefferle/wordpress-ostatus/issues" target="_blank">please let us know</a>.
	The installation is a bit painful, but we think it\'s much more <em>open style</em> ;)', 'ostatus-for-wordpress' ); ?></p>
<?php
$plugins = array();

$required_plugins = apply_filters( 'ostatus_required_plugins', array(
	'activitystream-extension',
	'host-meta',
	'pubsubhubbub',
	'salmon',
	'webfinger',
) );

foreach ( $required_plugins as $plugin ) {
	$plugins[] = plugins_api( 'plugin_information', array(
		'slug' => $plugin,
		'fields' => array(
			'icons' => true,
			'active_installs' => true,
			'short_description' => true,
		),
	) );
}

// check wordpress version
$wp_list_table = _get_list_table( 'WP_Plugin_Install_List_Table' );
$wp_list_table->items = $plugins;
$wp_list_table->display();
?>

	<h3><?php esc_html_e( 'Further readings', 'ostatus-for-wordpress' ); ?></h3>
	<ul>
		<li><a href="https://www.w3.org/community/ostatus/" target="_blank"><?php esc_html_e( 'w3.org community page', 'ostatus-for-wordpress' ); ?></a></li>
		<li><a href="https://www.w3.org/community/ostatus/wiki/Howto" target="_blank"><?php esc_html_e( 'How to OStatus-enable Your Application', 'ostatus-for-wordpress' ); ?></a></li>
		<li><a href="https://github.com/pfefferle/wordpress-ostatus/issues" target="_blank"><?php esc_html_e( 'Give us feedback', 'ostatus-for-wordpress' ); ?></a></li>
	</ul>
</div>
