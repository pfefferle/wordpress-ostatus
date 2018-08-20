<?php
/**
 * OStatus Discovery Class
 */
class Ostatus_Discovery {
	/**
	 * adds the the atom links to the webfinger-xrd-file
	 */
	public static function webfinger( $array, $resource, $user ) {
		$array['links'][] = array(
			'rel' => 'http://schemas.google.com/g/2010#updates-from',
			'href' => get_author_feed_link( $user->ID, 'ostatus' ),
			'type' => 'application/atom+xml',
		);

		$array['links'][] = array(
			'rel' => 'http://ostatus.org/schema/1.0/subscribe',
			'template' => site_url( '/?profile={uri}' ),
		);

		return $array;
	}

	/**
	 * Adds the the atom links to the host-meta-xrd-file
	 */
	public static function host_meta( $array ) {
		$array['links'][] = array(
			'rel' => 'http://schemas.google.com/g/2010#updates-from',
			'href' => get_feed_link( 'ostatus' ),
			'type' => 'application/atom+xml',
		);

		$array['links'][] = array(
			'rel' => 'http://ostatus.org/schema/1.0/subscribe',
			'template' => site_url( '/?profile={uri}' ),
		);

		return $array;
	}
}
