<div class="wrap">
	<div class="notice notice-info">
		<p><?php printf (
				__( 'Be sure to install all OStatus <a href="%1$s" target_"blank">plugin-dependencies</a>.', 'ostatus-for-wordpress' ),
				admin_url( '/admin.php?page=ostatus-dependencies' )
			); ?></p>
	</div>

	<h1><?php esc_html_e( 'OStatus Settings', 'ostatus-for-wordpress' ); ?></h1>

	<p><?php esc_html_e( 'OStatus for WordPress turns your blog into a federated social network. This means you can share and talk to everyone using the OStatus protocol, including users of Status.net, Identi.ca and Mastodon.', 'ostatus-for-wordpress' ); ?></p>

	<form method="post" action="options.php">
		<?php settings_fields( 'ostatus' ); ?>

		<h2><?php esc_html_e( 'Feed', 'ostatus-for-wordpress' ); ?></h2>

		<p><?php esc_html_e( 'Feeds are the base of OStatus, here you find all feed related settings.', 'ostatus-for-wordpress' ); ?></p>

		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="ostatus_feed_use_excerpt"><?php _e( 'Show summary', 'ostatus-for-wordpress' ) ?></label>
					</th>
					<td>
						<input type="checkbox" name="ostatus_feed_use_excerpt" id="ostatus_feed_use_excerpt" value="1" <?php
							echo checked( true, get_option( 'ostatus_feed_use_excerpt' ) );  ?> />
						<?php _e( 'Enable the <code>&lt;summary&gt;</code>, for the OStatus feed', 'ostatus-for-wordpress' ) ?>
					</td>
				</tr>
			</tbody>
		</table>

		<?php do_settings_fields( 'ostatus', 'feed' ); ?>

		<h2><?php esc_html_e( 'Profile', 'ostatus-for-wordpress' ); ?></h2>

		<p><?php esc_html_e( 'All profile related settings.', 'ostatus-for-wordpress' ); ?></p>

		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label><?php _e( 'Profile identifier', 'ostatus-for-wordpress' ) ?></label>
					</th>
					<td>
						<?php if ( function_exists( 'get_webfinger_resource' ) ) : ?>
						<?php $resource = get_webfinger_resource( wp_get_current_user(), false ); ?>
						<p><code><?php echo $resource ?></code></p>
						<p class="description"><?php printf( __( 'Try "@%s" in the mastodon/gnu.social search field.', 'ostatus-for-wordpress' ), $resource ); ?></p>
						<?php else: ?>
						<?php printf (
							__( 'You need to install the <a href="%1$s" target_"blank">WebFinger plugin</a> to generate the identifier.', 'ostatus-for-wordpress' ),
							admin_url( '/admin.php?page=ostatus-dependencies' )
						); ?>
						<?php endif; ?>
					</td>
				</tr>
			</tbody>
		</table>

		<?php do_settings_fields( 'ostatus', 'profile' ); ?>

		<?php do_settings_sections( 'ostatus' ); ?>

		<?php submit_button(); ?>
	</form>

	<p>
		<small><?php _e( 'If you like this plugin, what about a small <a href="https://notiz.blog/donate">donation</a>?', 'ostatus-for-wordpress' ); ?></small>
	</p>
</div>
