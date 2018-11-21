<?php
/**
 * Atom Feed Template for displaying Atom Posts feed.
 *
 * @package WordPress
 */

header( 'Content-Type: ' . feed_content_type( 'atom' ) . '; charset=' . get_option( 'blog_charset' ), true );
$more = 1;

echo '<?xml version="1.0" encoding="' . get_option( 'blog_charset' ) . '"?' . '>';

/** This action is documented in wp-includes/feed-rss2.php */
do_action( 'rss_tag_pre', 'atom' );
?>
<feed
	xmlns="http://www.w3.org/2005/Atom"
	xmlns:thr="http://purl.org/syndication/thread/1.0"
	xml:lang="<?php bloginfo_rss( 'language' ); ?>"
	xml:base="<?php bloginfo_rss( 'url' ); ?>/wp-atom.php"
	xmlns:poco="http://portablecontacts.net/spec/1.0"
	xmlns:media="http://purl.org/syndication/atommedia"
	xmlns:ostatus="http://ostatus.org/schema/1.0"
	<?php
	/**
	 * Fires at end of the Atom feed root to add namespaces.
	 *
	 * @since 2.0.0
	 */
	do_action( 'atom_ns' );
	?>
>
	<title type="text"><?php wp_title_rss(); ?></title>
	<subtitle type="text"><?php bloginfo_rss( 'description' ); ?></subtitle>

	<updated><?php
		$date = get_lastpostmodified( 'GMT' );
		echo $date ? mysql2date( 'Y-m-d\TH:i:s\Z', $date, false ) : date( 'Y-m-d\TH:i:s\Z' );
	?></updated>

	<id><?php self_link(); ?></id>
	<link rel="self" type="application/atom+xml" href="<?php self_link(); ?>" />

	<?php if ( is_author() ) : ?>
	<link rel="alternate" type="<?php bloginfo_rss( 'html_type' ); ?>" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?>" />

	<author>
		<activity:object-type>http://activitystrea.ms/schema/1.0/person</activity:object-type>
		<name><?php the_author() ?></name>
		<summary type="html"><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></summary>
		<id><?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?></id>
		<uri><?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?></uri>
		<email><?php echo esc_html( ostatus_get_acct( get_the_author_meta( 'ID' ) ) ); ?></email>
		<link rel="alternate" type="text/html" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?>" />
		<link rel="avatar" media:width="120" media:height="120" href="<?php echo esc_url( get_avatar_url( get_the_author_meta( 'ID' ), array( 'size' => 120 ) ) ); ?>" />
		<?php if ( has_header_image() ) { ?>
		<link rel="header" href="<?php echo get_header_image(); ?>" />
		<?php } ?>
		<poco:preferredUsername><?php the_author_meta( 'login' ); ?></poco:preferredUsername>
		<poco:displayName><?php the_author() ?></poco:displayName>
		<poco:note><?php echo wp_strip_all_tags( get_the_author_meta( 'description' ) ); ?></poco:note>
	</author>
	<?php else: ?>
	<link rel="alternate" type="<?php bloginfo_rss( 'html_type' ); ?>" href="<?php bloginfo_rss( 'url' ); ?>" />
	<?php endif; ?>

	<?php
	/**
	 * Fires just before the first Atom feed entry.
	 *
	 * @since 2.0.0
	 */
	do_action( 'atom_head' );

	while ( have_posts() ) :
		the_post();
	?>
	<entry>
		<author>
			<name><?php the_author(); ?></name>
			<?php $author_url = get_the_author_meta( 'url' ); if ( ! empty( $author_url ) ) : ?>
			<uri><?php the_author_meta( 'url' ); ?></uri>
			<?php
			endif;

			/**
			 * Fires at the end of each Atom feed author entry.
			 *
			 * @since 3.2.0
			 */
			do_action( 'atom_author' );
			?>
			<summary type="html"><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></summary>
			<uri><?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?></uri>
			<email><?php echo esc_html( ostatus_get_acct( get_the_author_meta( 'ID' ) ) ); ?></email>
			<link rel="alternate" type="text/html" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?>" />
			<link rel="avatar" media:width="120" media:height="120" href="<?php echo esc_url( get_avatar_url( get_the_author_meta( 'ID' ), array( 'size' => 120 ) ) ); ?>" />
			<?php if ( has_header_image() ) { ?>
				<link rel="header" href="<?php echo get_header_image(); ?>" />
			<?php } ?>
			<poco:preferredUsername><?php the_author_meta( 'login' ); ?></poco:preferredUsername>
			<poco:displayName><?php the_author() ?></poco:displayName>
			<poco:note><?php echo wp_strip_all_tags( get_the_author_meta( 'description' ) ); ?></poco:note>
		</author>
		<title type="<?php html_type_rss(); ?>"><?php the_title_rss(); ?></title>
		<link rel="alternate" type="<?php bloginfo_rss( 'html_type' ); ?>" href="<?php the_permalink_rss(); ?>" />
		<id><?php the_guid(); ?></id>
		<updated><?php echo get_post_modified_time( 'Y-m-d\TH:i:s\Z', true ); ?></updated>
		<published><?php echo get_post_time( 'Y-m-d\TH:i:s\Z', true ); ?></published>
		<?php the_category_rss( 'atom' ); ?>
<?php if ( get_option( 'ostatus_feed_use_excerpt', false ) ) : ?>
		<summary type="<?php html_type_rss(); ?>"><?php the_excerpt_rss(); ?></summary>
<?php endif; ?>
		<content type="<?php html_type_rss(); ?>" xml:base="<?php the_permalink_rss(); ?>"><?php the_content_feed( 'atom' ); ?></content>
	<?php
	atom_enclosure();
	/**
	 * Fires at the end of each Atom feed item.
	 *
	 * @since 2.0.0
	 */
	do_action( 'atom_entry' );

	if ( get_comments_number() || comments_open() ) :
		?>
		<link rel="replies" type="<?php bloginfo_rss( 'html_type' ); ?>" href="<?php the_permalink_rss(); ?>#comments" thr:count="<?php echo get_comments_number(); ?>"/>
		<link rel="replies" type="application/atom+xml" href="<?php echo esc_url( get_post_comments_feed_link( 0, 'ostatus' ) ); ?>" thr:count="<?php echo get_comments_number(); ?>"/>
		<thr:total><?php echo get_comments_number(); ?></thr:total>
	<?php endif; ?>
	</entry>
	<?php endwhile; ?>
</feed>
