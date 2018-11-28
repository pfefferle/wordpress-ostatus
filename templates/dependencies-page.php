<div class="wrap">
	<h1><?php esc_html_e( 'OStatus Dependencies', 'ostatus-for-wordpress' ); ?></h1>

	<p><?php _e( 'OStatus is like a <em>Best of OpenWeb Standards</em> and so is this plugin. If there is a plugin available that already implements one of these standards, we will use/support it. If we are missing one, <a href="https://github.com/pfefferle/wordpress-ostatus/issues" target="_blank">please let us know</a>. The installation is a bit painful, but we think it\'s much more <em>open style</em> ;)', 'ostatus-for-wordpress' ); ?></p>
	<?php
	$plugins = array();

	$required_plugins = apply_filters( 'ostatus_required_plugins', array(
		'activitystream-extension',
		'host-meta',
		'pubsubhubbub',
		'salmon',
		'webfinger',
		'nodeinfo',
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

	// check WordPress version
	$wp_list_table = _get_list_table( 'WP_Plugin_Install_List_Table' );
	$wp_list_table->items = $plugins;
	$wp_list_table->display();
	?>
</div>
