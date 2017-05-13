<?php
/**
 * check if user has an account (WebFinger)
 *
 * @param int $user_id
 *
 * @return boolean
 */
function ostatus_has_acct( $user_id ) {
	return (boolean) ostatus_get_acct( $user_id );
}

/**
 * Returns the user account (WebFinger)
 *
 * @param int $user_id
 *
 * @return string the account or the email
 */
function ostatus_get_acct( $user_id ) {
	$user = get_user_by( 'id', $user_id );

	if ( $user ) {
		return $user->user_login . '@' . parse_url( home_url(), PHP_URL_HOST );
	} else {
		return '';
	}
}
