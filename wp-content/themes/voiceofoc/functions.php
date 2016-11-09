<?php

/**
 * Includes
 */
$includes = array(
	'/inc/sidebars.php', 
	'/inc/widgets.php',
	'/inc/mobile.php',
	'/inc/misc.php',
	'/homepages/layouts/VoiceOfOC.php'
);
// Perform load
foreach ( $includes as $include ) {
	require_once( get_stylesheet_directory() . $include );
}


/**
* Register Voice of OC custom image sizes
*/
function voiceofoc_image_sizes() {
	// In Case You Missed It section images
	// 240 pixels wide by 135 pixels tall, hard crop mode
	add_image_size( 'missed-it', 240, 135, true );
	// Small Rectangular Thumbnail
	// Used recent posts widget
	// 120 pixels wide by 80 pixels tall, hard crop mode
	add_image_size( 'small-rect', 120, 80, true );
	// Medium Rectangular Thumbnail
	// Used on homepage Top Stories section
	// 180 pixels wide by 120 pixels tall, hard crop mode
	add_image_size( 'med-rect', 180, 120, true );
	// Register additional sidebars
}
add_action('init', 'voiceofoc_image_sizes', 20);


/**
 * Enqueue the stylesheet
 * @since Largo 0.4
 */
function voiceofoc_stylesheet() {
	$suffix = (LARGO_DEBUG)? '' : '.min';

	wp_dequeue_style( 'largo-child-styles' );
	wp_enqueue_style( 'voiceofoc', get_stylesheet_directory_uri().'/css/style' . $suffix . '.css' );
}
add_action( 'wp_enqueue_scripts', 'voiceofoc_stylesheet', 20 );