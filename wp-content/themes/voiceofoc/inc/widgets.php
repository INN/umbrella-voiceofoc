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

/**
 * Register a widget area that shall appear in the headers of certain term archives.
 *
 * @see Helpscout conversation 1222
 */
function voiceofoc_widget_header_area_register() {
	register_sidebar( array(
		'name' => __( 'Widget Header Area', 'voiceofoc' ),
		'id' => 'widget-header-area',
		'description' => __( '', 'voiceofoc' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5 class="widgettitle">',
		'after_title' => '</h5>'
	) );
}
add_action( 'widgets_init', 'voiceofoc_widget_header_area_register', 11 );

/**
 * Check if the widget header area is enabled
 *
 * For now this is just a dummy function, but part of the task is to add a term meta option
 * @see partials/widget-header-area.php
 */
function voiceofoc_widget_header_area_enabled() {
	return true;
}

/**
 * Apply per-term widget sizing classes to the widget-header-area widget area.
 *
 * @see voiceofoc_widget_header_area_enabled
 * @see voiceofoc_widget_header_area_register
 */
function voiceofoc_widget_header_area_classes( $params ) {
	#error_log(var_export( $params[0]['id'], true));
	if ( $params[0]['id'] === 'widget-header-area' ) {
		error_log(var_export( $params[0]['class'], true));
	}
	return $params;
}
add_filter( 'dynamic_sidebar_params', 'voiceofoc_widget_header_area_classes' );
