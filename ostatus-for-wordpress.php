<?php
/*
Plugin Name: OStatus for WordPress
Plugin URI: http://pepijndevos.nl/
Description: A bundle of plugins that turn your blog into your private federated social network.
Author: Pepijn de Vos
Version: 1.0
Author URI: http://pepijndevos.nl/
*/

//echo __FILE__;
register_activation_hook(__FILE__, 'ostatus_activate');

function ostatus_activate() {
	$plugin_name = basename(dirname(__FILE__));
	var_dump(get_option('active_plugins'));
	activate_plugin($plugin_name . '/plugins/portable-contacts/PortableContacts.php');
}
