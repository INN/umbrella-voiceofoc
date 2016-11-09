<?php
/**
 * The template for displaying content in the single.php template
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'hnews item' ); ?> itemscope itemtype="http://schema.org/Article">

	<?php do_action('largo_before_post_header'); ?>

	<header>

		<h5 class="top-tag"><?php largo_top_term(); ?></h5>

		<h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
		<?php if ( $subtitle = get_post_meta( $post->ID, 'subtitle', true ) )
			echo '<h2 class="subtitle">' . $subtitle . '</h2>';
		?>

		<?php largo_post_metadata( $post->ID ); ?>

	</header><!-- / entry header -->
	
	<?php
		do_action('largo_after_post_header');

		largo_hero(null,'span12');

		do_action('largo_after_hero');
	?>
	
	<?php //get_sidebar(); ?>

	<section class="entry-content clearfix" itemprop="articleBody">
		
		<h5 class="byline"><?php largo_byline( true, false ); ?></h5>

		<?php
			if ( !of_get_option( 'single_social_icons' ) == false ) {
				largo_post_social_links( true, false );
			}
		?>
		
		<?php largo_entry_content( $post ); ?>
		
	</section>

	<?php do_action('largo_after_post_content'); ?>

</article>
