<?php
require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
wp_enqueue_style( 'plugin-install' );
wp_enqueue_script( 'plugin-install' );
add_thickbox();
$GLOBALS['tab'] = 'custom';

?>
<div class="wrap">
	<h2>OStatus</h2>

	<p><strong>OStatus for WordPress turns your blog into a federated social network.
	This means you can share and talk to everyone using the OStatus protocol,
	including users of Status.net and Identi.ca</strong></p>

	<p>Some Links:
		<ul>
			<li><a href="http://ostatus.org" target="_blank">OStatus.org</a></li>
			<li><a href="http://ostatus.org/2010/10/04/how-ostatus-enable-your-application" target="_blank">How to OStatus-enable Your Application</a></li>
			<li><a href="http://wordpress.org/tags/ostatus-for-wordpress" target="_blank">Give us feedback</a></li>
		</ul>
	</p>

	<h3>Dependencies</h3>

	<p>OStatus is like a <em>Best of OpenWeb Standards</em> and so is this plugin.
	If there is a plugin available that already implements one of these standards, we will use/support it.
	If we are missing one, <a href="http://wordpress.org/tags/ostatus-for-wordpress" target="_blank">please let us know</a>.
	The installation is a bit painful, but we think it's much more <em>open style</em> ;)</p>
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
