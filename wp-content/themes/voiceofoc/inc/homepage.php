<?php

/**
 * filter LMP query on homepage by changing the config that is output for the LMP button
 *
 * This is the easiest way to affect what is loaded by the LMP button on the homepage.
 * The other option would be filtering largo_lmp_args, on the WP_Query that LMP runs, but that lacks
 * context that we have here.
 *
 * @see partials/home-post-list.php
 * @since Largo 0.5.5.3
 * @since February 2017
 * @filter largo_load_more_posts_json
 * @see largo_load_more_posts_data
 */
function voiceofoc_homepage_largo_load_more_posts_json( $config ) {
	if ( is_home() ) {
		$config['query']['tax_query'] = voiceofoc_homepage_tax_query();
	}
	return $config;
}
add_filter( 'largo_load_more_posts_json', 'voiceofoc_homepage_largo_load_more_posts_json' );

/**
 * define the homepage excluded taxonomies in one place
 * @return Array meant to be used in a tax_query
 * @since February 2017
 * @since Largo 0.5.5.3
 */
function voiceofoc_homepage_tax_query() {
	return array(
		array(
			'taxonomy' => 'category',
			'field' => 'slug',
			'terms' => array( 'communications', 'press-releases', 'opinion', 'news-brief' ),
			'operator' => 'NOT IN',
		),
		// for transition planning
		array(
			'taxonomy' => 'post_tag',
			'terms' => array( 'opinion', 'partner-media' ),
			'field' => 'slug',
			'operator' => 'NOT IN',
		)
	);
}
