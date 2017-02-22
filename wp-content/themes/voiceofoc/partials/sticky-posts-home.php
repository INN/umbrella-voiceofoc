<?php
/**
 * Copied from Largo 0.5.5.3 to make changes for the Voice of OC homepage layout, which uses the
 * sticky post as a homepage featured.
 *
 * @since Largo 0.5.5.3
 * @since February 2017
 */
global $shown_ids;

$sticky = get_option( 'sticky_posts' );
if (empty($sticky))
	return;

$args = array(
	'posts_per_page' => 1,
	'post__in'  => $sticky,
	'ignore_sticky_posts' => 1
);
$query = new WP_Query( $args );

if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		$shown_ids[] = get_the_ID();

		if ( $sticky && $sticky[0] && ! is_paged() ) { ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix sticky entry-content '); ?>>

			<div class="sticky-solo">


				<?php // if we have a thumbnail image, show it
				if ( has_post_thumbnail() ) { ?>
					<div class="image-wrap hidden-phone <?php largo_hero_class(get_the_ID()); ?>">
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
					</div>
				<?php } // end thumbnail ?>

				<div class="">

					<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<h5 class="byline"><?php largo_byline(); ?></h5>

					<div class="entry-content">
					<?php
						largo_excerpt( $post, 2 );
						$shown_ids[] = get_the_ID();
					?>

					</div>
				</div>
			</div> <!-- end sticky-solo or sticky-related -->
		</article>
	<?php } // is_paged
	}
}
