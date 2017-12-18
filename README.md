# OStatus #
**Contributors:** pepijndevos, pfefferle  
**Tags:** ostatus, federated, mastodon, social, gnusocial, statusnet  
**Donate link:** http://14101978.de  
**Requires at least:** 4.5  
**Tested up to:** 4.9.1  
**Stable tag:** 2.3.1  
**License:** MIT  
**License URI:** https://opensource.org/licenses/MIT  

A bundle of plugins that turns your blog into your private federated social network.

## Description ##

OStatus for Wordpress turns your blog into a federated social network. This means you can share and talk to everyone using the OStatus protocol, including users of Status.net/Identi.ca, gnu.social, Friendica and Mastodon.

For more information about OStatus visit the [OStatus Community Group](https://www.w3.org/community/ostatus/)

This plugin bundles a few other plugins it requires to work, theses are installed automatically unless you have them already installed.

Compatibility:

* GNU.social
	* [x] Follow blog
	* [ ] Follow GNU.social
	* [x] Share blog-posts
	* [ ] Share GNU.social-posts
	* [x] Share GNU.social-comments
	* [ ] Share blog-comments
* Mastodon
	* [x] Follow blog
	* [ ] Follow Mastodon
	* [x] Share blog-posts
	* [ ] Share Mastodon-posts
	* [x] Share Mastodon-comments
	* [ ] Share blog-comments
* Friendica
	* not tested yet

Plugin requirements:

* the `WebSub/PubSubHubbub`-plugin: http://wordpress.org/plugins/pubsubhubbub/
* the `host-meta`-plugin: http://wordpress.org/plugins/host-meta/
* the `WebFinger`-plugin: http://wordpress.org/plugins/webfinger/
* the `Salmon`-plugin: http://wordpress.org/plugins/salmon/
* the `ActivityStreams`-plugin: http://wordpress.org/plugins/activitystream-extension/

## Installation ##

1. Upload the plugin folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the \'Plugins\' menu in WordPress
1. Check all the needed plugins are there and activated through the settings-page

## Frequently Asked Questions ##

### can I help you? ###

You can help!

This plugin bundles a few plugins theta implement parts of the OStatus specification.

If you are the author of a relevant plugin, or are planning one, contact us to get it included in this bundle.

## Changelog ##

### 2.3.0 ###

* nicer feeds
* enable/disable the feed summary in the settings

### 2.2.3 ###

* add main OStatus feed URL

### 2.2.2 ###

* support the legacy WebFinger specs

### 2.2.1 ###

* WordPress.org seems to ignore v2.0.0

### 2.2.0 ###

* better compatibility with mastodon

### 2.1.0 ###

* some small tweaks
* added header image support
* new pubsubhubbub filters

### 2.0.1 ###

* some small improvements
* fixed webfinger discovery
* better i18n handling (thanks @hinaloe)

### 2.0.0 ###

* Mastodon and gnu.social support
* PHP 7 compatibility
* small changes

### 1.2 ###

* WordPress 3.1 support

### 1.1 ###

* added functionality

### 1.0 ###

* initial version
