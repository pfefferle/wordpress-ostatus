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
