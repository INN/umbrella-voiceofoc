<?php 
	
/**
 * Set up the Voice of OC custom widgets
 *
 * @package voiceofoc
 * @since 1.0
 */
function voiceofoc_widgets() {
	$unregister = array(
		'largo_donate_widget',
	);
	foreach ( $unregister as $widget ) {
		unregister_widget( $widget );
	}
	$register = array(
		'voiceofoc_donate_widget'			=> '/inc/widgets/voiceofoc-donate.php',
		'voiceofoc_recent_posts_widget'		=> '/inc/widgets/voiceofoc-recent-posts.php',
	);
	foreach ( $register as $classname => $path ) {
		require_once( get_stylesheet_directory() . $path );
		register_widget( $classname );
	}
}
// Largo runs at priority 10. Run right after.
add_action( 'widgets_init', 'voiceofoc_widgets', 11 );


/**
 * Add the voiceofoc-header-left widget area to the header
 * @link http://jira.inn.org/browse/VO-22
 */
function voiceofoc_header_widget_left() {
	dynamic_sidebar( 'voiceofoc-header-left' );
}
add_action( 'largo_header_before_largo_header', 'voiceofoc_header_widget_left' );