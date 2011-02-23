<?php
// register
if (isset($wp_version)) {
  // admin panel
  add_action('admin_menu', array('OstatusAdminPages', 'addMenuItem'));
}

if (is_admin() && $_GET['page'] == 'ostatus') {
  require_once(ABSPATH . 'wp-admin/admin.php');
  require_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
  wp_enqueue_style( 'plugin-install' );
  wp_enqueue_script( 'plugin-install' );
  add_thickbox();
}

/**
 * yiid admin panels
 *
 * @author Matthias Pfefferle
 */
class OstatusAdminPages {
  /**
   * adds the yiid-items to the admin-menu
   */
  function addMenuItem() {
    add_options_page('OStatus', 'OStatus', 10, 'ostatus', array('OstatusAdminPages', 'showSettings'));

    add_menu_page('OStatus',  'OStatus', 1, 'ostatus', '', WP_PLUGIN_URL.'/ostatus-for-wordpress/static/ostatus_icon.png');
    add_submenu_page( 'ostatus', 'OStatus', 'OStatus', 'manage_options', 'ostatus', array('OstatusAdminPages', 'showSettings'));
  }

  /**
   * displays the yiid settings page
   */
  function showSettings() {
    if ( $_POST['Submit'] ) {
      check_admin_referer('ostatus-update-services');
      update_option('ostatus_settings', $_POST['ostatus_settings']);
    }
    
    $ostatus_settings = get_option('ostatus_settings');
    if (empty($ostatus_settings)) {
      $ostatus_settings = array();
    }
?>
  <div class="wrap">
    <img src="<?php echo WP_PLUGIN_URL ?>/ostatus-for-wordpress/static/ostatus_logo.png" alt="OSstatus for WordPress" class="icon32" />
    
    <h2>OStatus</h2>
    
    <p><strong>OStatus for WordPress turns your blog into a federated social network.
    This means you can share and talk to everyone using the OStatus protocol, 
    including users of Status.net and Identi.ca</strong></p>
    
    <p>Some Links: [<a href="http://ostatus.org" target="_blank">OStatus.org</a>],
                   [<a href="http://ostatus.org/2010/10/04/how-ostatus-enable-your-application" target="_blank">How to OStatus-enable Your Application</a>],
                   [<a href="http://wordpress.org/tags/ostatus-for-wordpress" target="_blank">Give us feedback</a>]
    </p>

    <h3>Dependencies</h3>
    
    <p>OStatus is like a <em>Best of OpenWeb Standards</em> and so is this plugin.
    If there is a plugin available that already implements one of these standards, we will use/support it.
    If we are missing one, <a href="http://wordpress.org/tags/ostatus-for-wordpress" target="_blank">please let us know</a>.
    The installation is a bit painful, but we think it's much more <em>open style</em> ;)</p>
<?php
    $plugins = array();
    $plugins[] = plugins_api('plugin_information', array('slug' => 'activitystream-extension'));
    $plugins[] = plugins_api('plugin_information', array('slug' => 'host-meta'));
    //$plugins[] = plugins_api('plugin_information', array('slug' => 'portable-contacts'));
    $plugins[] = plugins_api('plugin_information', array('slug' => 'pubsubhubbub'));
    $plugins[] = plugins_api('plugin_information', array('slug' => 'salmon'));
    $plugins[] = plugins_api('plugin_information', array('slug' => 'webfinger'));
    $plugins[] = plugins_api('plugin_information', array('slug' => 'well-known'));
    
    // check wordpress version
    if (get_bloginfo('version') <= 3.0) {
      display_plugins_table($plugins);
    } else {
      $wp_list_table = _get_list_table('WP_Plugin_Install_List_Table');
      $wp_list_table->items = $plugins;
      $wp_list_table->display();
    }
?>
    <h3>Settings</h3>
    <form method="post" action="?page=<?php echo $_REQUEST['page'] ?>">
      <?php wp_nonce_field('ostatus-update-services'); ?>
      <table class="form-table">
        <tr valign="top">
          <th scope="row">Show Author Profile</th>
          <td>
            <fieldset><legend class="screen-reader-text"><span>Show Author Profile</span></legend><label for="users_can_register">
            <input name="ostatus_settings[show_author_profile]" type="checkbox" id="users_can_register" value="1" <?php if (array_key_exists('show_author_profile', $ostatus_settings)) echo "checked='checked'" ?> />
            Adds a small profile-hCard (<a href="http://microformats.org/wiki/hcard" target="_blank">more info</a>)
            on top of an authors page (see "<a href="http://ostatus.org/sites/default/files/ostatus-1.0-draft-2-specification.html#rfc.section.7" target=_blank>User representation</a>"
            in OStatus Spec)</label></fieldset>
          </td>
        </tr>
      </table>
      <p class="submit">
      <input type="submit" name="Submit" class="button-primary" value="Save Changes" />
    </form> 
  </div>    
<?php
  }
}
?>