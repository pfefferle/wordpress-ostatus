<?php
/*
Plugin Name: OStatus for WordPress
Plugin URI: http://wordpress.org/tags/ostatus-for-wordpress
Description: A bundle of plugins that turn your blog into your private federated social network.
Author: Matthias Pfefferle
Version: 1.1
Author URI: http://notizblog.org/
*/

add_action('webfinger_xrd', array('Ostatus', 'addWebfingerLinks'), 10, 1);
add_action('host_meta_xrd', array('Ostatus', 'addHostMetaLinks'));
add_action('loop_start', array('Ostatus', 'authorProfileHtml'));
add_action('wp_print_styles', array('Ostatus', 'authorProfileCss'));

if (function_exists('publish_to_hub')) {
  add_action('publish_post', array('Ostatus', 'publishToHub'));
}

// Pre-2.6 compatibility
if ( ! defined( 'WP_CONTENT_URL' ) )
    define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
    define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
    define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
    define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
if ( ! defined( 'WP_ADMIN_URL' ) ) 
    define( 'WP_ADMIN_URL', get_option('siteurl') . '/wp-admin' );

include_once('admin-pages.php');

/**
 * ostatus class
 * 
 * @author Matthias Pfefferle
 * @see http://ostatus.org
 */
class Ostatus {
  /**
   * adds the the atom links to the webfinger-xrd-file
   */
  function addWebfingerLinks($user) {
    $link = get_author_feed_link( $user->ID, 'atom' );
    echo '<Link rel="http://schemas.google.com/g/2010#updates-from" href="'.$link.'" type="application/atom+xml"/>';
  }
  
  /**
   * adds the the atom links to the host-meta-xrd-file
   */
  function addHostMetaLinks() {
    $link = get_feed_link( 'atom' );
    echo '<Link rel="http://schemas.google.com/g/2010#updates-from" href="'.$link.'" type="application/atom+xml"/>';
  }
  
  /**
   * ping hubs
   * 
   * @param int $post_id
   */
  function publishToHub($post_id) {    
    $post = get_post($post_id);
    $feeds = array();
    $feeds[] = get_author_feed_link( $post->post_author, 'atom' );

    publish_to_hub($post_id, $feeds);
  }
  
  /**
   * adds admin profile url
   */
  function authorProfileHtml() {
    global $wp_query;
    $settings = get_option('ostatus_settings');
    if (get_query_var('ostatus_printed_author_profile') || !is_author() || is_feed() || !$settings['show_author_profile']) {
      return false;
    }
    
    $author = $wp_query->get_queried_object();
    
    if (function_exists('extended_profile')) {
      extended_profile($author->user_login);
    } else {
      if ($author->user_url) {
        $url = $author->user_url;
      } else {
        $url = get_bloginfo( 'url' );
      }
        
      echo '<div class="vcard ostatus-vcard clearfix">';
      echo '  '.get_avatar( $author->user_email, $size = '80', null, $author->display_name);
      echo '  <h4 class="ostatus-author">Author: <a href="'.get_author_posts_url($author->ID, $author->user_nicename).'" class="url" rel="me">';   
      echo '    <span class="fn">'.$author->display_name.'</span>';
      echo '  </a></h4>'; 
      echo '  <div class="note ostatus-note">'.$author->description.'</div>';
      echo '</div>';
    }
    
    // twentyten loop fixture
    set_query_var('ostatus_printed_author_profile', true);
  }
  
  /**
   * include stylesheet for displaying admin profile.
   */
  function authorProfileCss() {
    $settings = get_option('ostatus_settings');
    if (is_author() && !is_feed() && $settings['show_author_profile']) {
      wp_enqueue_style('ostatus-profile', plugins_url('ostatus-for-wordpress/static/profile.css'), array(), false, 'all');
    }
  }
}