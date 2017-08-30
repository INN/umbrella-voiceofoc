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
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
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
	if ( ! is_archive() ) {
		return false;
	}
	$queried_object = get_queried_object();
	$whether = get_term_meta( $queried_object->term_id, HEADER_WIDGET_AREA_META_NAME, true );
	return ! empty ( $whether );
}

/**
 * What bootstrap column-size class should be used?
 */
function voiceofoc_widget_header_area_classname() {
	return 'span6';
}

/**
 * Apply per-term widget sizing classes to the widget-header-area widget area.
 *
 * @see voiceofoc_widget_header_area_enabled
 * @see voiceofoc_widget_header_area_register
 */
function voiceofoc_widget_header_area_classes( $params ) {
	if ( $params[0]['id'] === 'widget-header-area' ) {
		$params[0]['before_widget'] = str_replace(
			'class="widget',
			'class="widget ' . voiceofoc_widget_header_area_classname(),
			$params[0]['before_widget']
		);
	}
	return $params;
}
add_filter( 'dynamic_sidebar_params', 'voiceofoc_widget_header_area_classes' );
