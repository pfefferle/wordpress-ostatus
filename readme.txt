=== OStatus ===
Contributors: pepijndevos, pfefferle
Tags: ostatus, federated, mastodon, social, gnusocial, statusnet
Donate link: https://notiz.blog/donate/
Requires at least: 4.5
Tested up to: 5.2.2
Stable tag: 2.5.5
License: MIT
License URI: https://opensource.org/licenses/MIT

A bundle of plugins that turns your blog into your private federated social network.

== Description ==

OStatus for Wordpress turns your blog into a federated social network. This means you can share and talk to everyone using the OStatus protocol, including users of Status.net/Identi.ca, gnu.social, Friendica and Mastodon.

For more information about OStatus visit the [OStatus Community Group](https://www.w3.org/community/ostatus/)

This plugin bundles a few other plugins it requires to work, theses are installed automatically unless you have them already installed.

Compatibility:

* GNU.social
* Mastodon
* Friendica

Plugin requirements:

* the `WebSub/PubSubHubbub`-plugin: <https://wordpress.org/plugins/pubsubhubbub/>
* the `host-meta`-plugin: <https://wordpress.org/plugins/host-meta/>
* the `WebFinger`-plugin: <https://wordpress.org/plugins/webfinger/>
* the `Salmon`-plugin: <https://wordpress.org/plugins/salmon/>
* the `ActivityStreams`-plugin: <https://wordpress.org/plugins/activitystream-extension/>

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the \'Plugins\' menu in WordPress
1. Check all the needed plugins are there and activated through the settings-page

== Frequently Asked Questions ==

= can I help you? =

You can help!

This plugin bundles a few plugins theta implement parts of the OStatus specification.

If you are the author of a relevant plugin, or are planning one, contact us to get it included in this bundle.

== Changelog ==

= 2.5.5 =

* update requirements

= 2.5.4 =

* Add NodeInfo support

= 2.5.3 =

* Fixed GNU.social compatibility

= 2.5.2 =

* Fixed Altenate-URL (feed)

= 2.5.1 =

* Fixed feed-ids

= 2.5.0 =

* fixed "flush rewrite rules"
* optimized admin pages (still work in progress)

= 2.4.1 =

* fixed donation link

= 2.4.0 =

* complete refactoring
* better text encoding

= 2.3.2 =

* updated WebSub support

= 2.3.1 =

* htmlspecialchars instead of htmlentities

= 2.3.0 =

* nicer feeds
* enable/disable the feed summary in the settings

= 2.2.3 =

* add main OStatus feed URL

= 2.2.2 =

* support the legacy WebFinger specs

= 2.2.1 =

* WordPress.org seems to ignore v2.0.0

= 2.2.0 =

* better compatibility with mastodon

= 2.1.0 =

* some small tweaks
* added header image support
* new pubsubhubbub filters

= 2.0.1 =

* some small improvements
* fixed webfinger discovery
* better i18n handling (thanks @hinaloe)

= 2.0.0 =

* Mastodon and gnu.social support
* PHP 7 compatibility
* small changes

= 1.2 =

* WordPress 3.1 support

= 1.1 =

* added functionality

= 1.0 =

* initial version

== Installation ==

Follow the normal instructions for [installing WordPress plugins](https://codex.wordpress.org/Managing_Plugins#Installing_Plugins).

= Automatic Plugin Installation =

To add a WordPress Plugin using the [built-in plugin installer](https://codex.wordpress.org/Administration_Screens#Add_New_Plugins):

1. Go to [Plugins](https://codex.wordpress.org/Administration_Screens#Plugins) > [Add New](https://codex.wordpress.org/Plugins_Add_New_Screen).
1. Type "`ostatus`" into the **Search Plugins** box.
1. Find the WordPress Plugin you wish to install.
    1. Click **Details** for more information about the Plugin and instructions you may wish to print or save to help setup the Plugin.
    1. Click **Install Now** to install the WordPress Plugin.
1. The resulting installation screen will list the installation as successful or note any problems during the install.
1. If successful, click **Activate Plugin** to activate it, or **Return to Plugin Installer** for further actions.

= Manual Plugin Installation =

There are a few cases when manually installing a WordPress Plugin is appropriate.

* If you wish to control the placement and the process of installing a WordPress Plugin.
* If your server does not permit automatic installation of a WordPress Plugin.
* If you want to try the [latest development version](https://github.com/pfefferle/wordpress-ostatus).

Installation of a WordPress Plugin manually requires FTP familiarity and the awareness that you may put your site at risk if you install a WordPress Plugin incompatible with the current version or from an unreliable source.

Backup your site completely before proceeding.

To install a WordPress Plugin manually:

* Download your WordPress Plugin to your desktop.
    * Download from [the WordPress directory](https://wordpress.org/plugins/ostatus/)
    * Download from [GitHub](https://github.com/pfefferle/wordpress-ostatus/releases)
* If downloaded as a zip archive, extract the Plugin folder to your desktop.
* With your FTP program, upload the Plugin folder to the `wp-content/plugins` folder in your WordPress directory online.
* Go to [Plugins screen](https://codex.wordpress.org/Administration_Screens#Plugins) and find the newly uploaded Plugin in the list.
* Click **Activate** to activate it.
