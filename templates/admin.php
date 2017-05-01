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
	including users of Status.net and Identi.ca', 'ostatus-for-wordpress' ); ?></strong></p>

	<p><?php esc_html_e( 'Some Links:', 'ostatus-for-wordpress' ); ?>
		<ul>
			<li><a href="https://www.w3.org/community/ostatus/" target="_blank"><?php esc_html_e( 'w3.org community page', 'ostatus-for-wordpress' ); ?></a></li>
			<li><a href="https://www.w3.org/community/ostatus/wiki/Howto" target="_blank"><?php esc_html_e( 'How to OStatus-enable Your Application', 'ostatus-for-wordpress' ); ?></a></li>
			<li><a href="https://github.com/pfefferle/wordpress-ostatus/issues" target="_blank"><?php esc_html_e( 'Give us feedback', 'ostatus-for-wordpress' ); ?></a></li>
		</ul>
	</p>

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
</div>
