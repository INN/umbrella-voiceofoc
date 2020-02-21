<?php
/**
 * Add the top term as a class on the post_class output
 *
 * @filter post_class
 * @param array $classes An array of classes on the post
 * @return array
 */
function voiceofoc_deep_dive_class( $classes ) {
	global $post;
	if ( ! is_singular() && ! is_home() ) {
		return $classes;
	}
	$top_term = get_post_meta( $post->ID, 'top_term', TRUE );
	$term = get_term_by('id', $top_term, 'post_tag');

	$classes[] = 'top-term-' . $term->taxonomy . '-' . $term->slug;

	return $classes;
}
add_filter( 'post_class', 'voiceofoc_deep_dive_class' );

/**
 * Ignore homepage-featured formatting in archives and on the homepage
 * @since Largo 0.5.5.3
 * @since February 2017
 */
function voiceofoc_largo_content_partial_arguments( $args, $context ) {
	$args['featured'] = false;
	return $args;
}
add_filter( 'largo_content_partial_arguments', 'voiceofoc_largo_content_partial_arguments', 10, 2 );
