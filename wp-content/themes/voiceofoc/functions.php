<?php

// This site is an INN Member
if ( ! defined( 'INN_MEMBER' ) ) {
        define( 'INN_MEMBER', true );
}
// This site is hosted by INN
if ( ! defined( 'INN_HOSTED' ) ) {
        define( 'INN_HOSTED', true );
}

/**
 * Includes
 */
$includes = array(
	'/inc/sidebars.php',
	'/inc/homepage.php',
	'/inc/widgets.php',
	'/inc/misc.php',
);
// Perform load
foreach ( $includes as $include ) {
	require_once( get_stylesheet_directory() . $include );
}


/**
* Register Voice of OC custom image sizes
*/
function voiceofoc_image_sizes() {
	// Small Rectangular Thumbnail
	// Used recent posts widget
	// 120 pixels wide by 80 pixels tall, hard crop mode
	add_image_size( 'small-rect', 120, 80, true );
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

/**
 * Typekit fonts
 */
function voiceofoc_typekit() {
	?>
		<script src="https://use.typekit.net/xyq0vny.js"></script>
		<script>try{Typekit.load({ async: true });}catch(e){}</script>
	<?php
}
add_action( 'wp_head', 'voiceofoc_typekit' );

/**
 * Added by reques
 * @since Largo 0.5.5.3
 * @since February 20, 2017
 */
function voiceofoc_adsbygoogle() {
	?>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({
		google_ad_client: "ca-pub-1576598093855162",
		enable_page_level_ads: true
		});
		</script>
	<?php
}
add_action( 'wp_head', 'voiceofoc_adsbygoogle' );
